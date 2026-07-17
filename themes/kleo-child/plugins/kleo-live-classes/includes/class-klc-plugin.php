<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class KLC_Plugin {

	const OPTION_KEY = 'klc_settings';
	const ENROLMENT_TABLE = 'klc_enrolments';
	const PRODUCT_META_KEY = '_klc_live_class_id';
	const ORDER_ITEM_META_KEY = '_klc_live_class_id';

	/**
	 * @var KLC_Plugin|null
	 */
	private static $instance = null;

	/**
	 * @return KLC_Plugin
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function activate() {
		self::create_tables();
		self::register_post_type();
		flush_rewrite_rules();
	}

	private static function create_tables() {
		global $wpdb;

		$table_name      = $wpdb->prefix . self::ENROLMENT_TABLE;
		$charset_collate = $wpdb->get_charset_collate();
		$sql             = "CREATE TABLE {$table_name} (
			id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
			live_class_id BIGINT UNSIGNED NOT NULL,
			student_id BIGINT UNSIGNED NOT NULL,
			order_id BIGINT UNSIGNED DEFAULT 0 NOT NULL,
			teacher_id BIGINT UNSIGNED NOT NULL,
			amount_paid DECIMAL(12,2) DEFAULT 0.00 NOT NULL,
			platform_fee DECIMAL(12,2) DEFAULT 0.00 NOT NULL,
			teacher_earnings DECIMAL(12,2) DEFAULT 0.00 NOT NULL,
			status VARCHAR(20) NOT NULL DEFAULT 'active',
			created_at DATETIME NOT NULL,
			updated_at DATETIME NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY live_class_student (live_class_id, student_id),
			KEY order_id (order_id),
			KEY teacher_id (teacher_id)
		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	private function __construct() {
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_shortcodes' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'register_settings_page' ) );
		add_action( 'admin_notices', array( $this, 'maybe_render_dependency_notice' ) );
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post_klc_live_class', array( $this, 'save_live_class_meta' ) );
		add_filter( 'the_content', array( $this, 'render_single_class_content' ) );

		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'attach_live_class_to_cart_item' ), 10, 3 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'validate_live_class_add_to_cart' ), 10, 3 );
		add_filter( 'woocommerce_get_item_data', array( $this, 'display_live_class_in_cart' ), 10, 2 );
		add_action( 'woocommerce_before_calculate_totals', array( $this, 'sync_cart_item_price' ) );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'copy_live_class_meta_to_order_item' ), 10, 4 );
		add_action( 'woocommerce_payment_complete', array( $this, 'maybe_create_enrolments_from_order' ) );
		add_action( 'woocommerce_order_status_completed', array( $this, 'maybe_create_enrolments_from_order' ) );
		add_action( 'woocommerce_order_status_processing', array( $this, 'maybe_create_enrolments_from_order' ) );
	}

	public static function register_post_type() {
		register_post_type(
			'klc_live_class',
			array(
				'labels'          => array(
					'name'          => __( 'Live Classes', 'kleo-live-classes' ),
					'singular_name' => __( 'Live Class', 'kleo-live-classes' ),
				),
				'public'          => true,
				'has_archive'     => true,
				'show_in_rest'    => true,
				'menu_icon'       => 'dashicons-video-alt3',
				'supports'        => array( 'title', 'editor', 'author', 'thumbnail' ),
				'rewrite'         => array( 'slug' => 'live-classes' ),
				'capability_type' => 'post',
			)
		);
	}

	public function register_settings() {
		register_setting(
			'klc_settings',
			self::OPTION_KEY,
			array( $this, 'sanitize_settings' )
		);

		add_settings_section(
			'klc_general',
			__( 'General Settings', 'kleo-live-classes' ),
			'__return_false',
			'klc_settings'
		);

		add_settings_field(
			'teacher_role',
			__( 'Teacher Role Slug', 'kleo-live-classes' ),
			array( $this, 'render_teacher_role_field' ),
			'klc_settings',
			'klc_general'
		);

		add_settings_field(
			'platform_fee_percent',
			__( 'Platform Fee (%)', 'kleo-live-classes' ),
			array( $this, 'render_platform_fee_field' ),
			'klc_settings',
			'klc_general'
		);

		add_settings_field(
			'currency_label',
			__( 'Currency Label', 'kleo-live-classes' ),
			array( $this, 'render_currency_label_field' ),
			'klc_settings',
			'klc_general'
		);

	}

	public function register_settings_page() {
		add_options_page(
			__( 'Live Classes', 'kleo-live-classes' ),
			__( 'Live Classes', 'kleo-live-classes' ),
			'manage_options',
			'klc-settings',
			array( $this, 'render_settings_page' )
		);
	}

	public function maybe_render_dependency_notice() {
		if ( ! current_user_can( 'manage_options' ) || class_exists( 'WooCommerce' ) ) {
			return;
		}

		echo '<div class="notice notice-warning"><p>';
		echo esc_html__( 'Kleo Live Classes requires WooCommerce to handle checkout and enrolment payments.', 'kleo-live-classes' );
		echo '</p></div>';
	}

	public function sanitize_settings( $settings ) {
		return array(
			'teacher_role'         => sanitize_key( $settings['teacher_role'] ?? 'teacher' ),
			'platform_fee_percent' => min( 100, max( 0, floatval( $settings['platform_fee_percent'] ?? 10 ) ) ),
			'currency_label'       => sanitize_text_field( $settings['currency_label'] ?? 'NGN' ),
		);
	}

	public function render_teacher_role_field() {
		$settings = $this->get_settings();
		printf(
			'<input type="text" name="%1$s[teacher_role]" value="%2$s" class="regular-text" />',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $settings['teacher_role'] )
		);
	}

	public function render_platform_fee_field() {
		$settings = $this->get_settings();
		printf(
			'<input type="number" name="%1$s[platform_fee_percent]" value="%2$s" min="0" max="100" step="0.01" />',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $settings['platform_fee_percent'] )
		);
	}

	public function render_currency_label_field() {
		$settings = $this->get_settings();
		printf(
			'<input type="text" name="%1$s[currency_label]" value="%2$s" class="regular-text" />',
			esc_attr( self::OPTION_KEY ),
			esc_attr( $settings['currency_label'] )
		);
	}

	public function render_settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Kleo Live Classes Settings', 'kleo-live-classes' ); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'klc_settings' );
				do_settings_sections( 'klc_settings' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	private function get_settings() {
		$defaults = array(
			'teacher_role'         => 'teacher',
			'platform_fee_percent' => 10,
			'currency_label'       => 'NGN',
		);

		return wp_parse_args( get_option( self::OPTION_KEY, array() ), $defaults );
	}

	public function register_meta_boxes() {
		add_meta_box(
			'klc-live-class-details',
			__( 'Live Class Details', 'kleo-live-classes' ),
			array( $this, 'render_live_class_meta_box' ),
			'klc_live_class',
			'normal',
			'high'
		);
	}

	public function render_live_class_meta_box( $post ) {
		wp_nonce_field( 'klc_save_live_class_meta', 'klc_live_class_nonce' );

		$meeting_url    = get_post_meta( $post->ID, '_klc_meeting_url', true );
		$start_datetime = get_post_meta( $post->ID, '_klc_start_datetime', true );
		$duration       = get_post_meta( $post->ID, '_klc_duration_minutes', true );
		$price          = get_post_meta( $post->ID, '_klc_price', true );
		$capacity       = get_post_meta( $post->ID, '_klc_capacity', true );
		$linked_course  = get_post_meta( $post->ID, '_klc_linked_course_id', true );
		?>
		<p>
			<label for="klc_meeting_url"><?php esc_html_e( 'Meeting URL', 'kleo-live-classes' ); ?></label><br />
			<input type="url" name="klc_meeting_url" id="klc_meeting_url" class="widefat" value="<?php echo esc_attr( $meeting_url ); ?>" />
		</p>
		<p>
			<label for="klc_start_datetime"><?php esc_html_e( 'Start Date/Time', 'kleo-live-classes' ); ?></label><br />
			<input type="datetime-local" name="klc_start_datetime" id="klc_start_datetime" value="<?php echo esc_attr( $start_datetime ); ?>" />
		</p>
		<p>
			<label for="klc_duration_minutes"><?php esc_html_e( 'Duration (minutes)', 'kleo-live-classes' ); ?></label><br />
			<input type="number" name="klc_duration_minutes" id="klc_duration_minutes" value="<?php echo esc_attr( $duration ); ?>" min="15" step="15" />
		</p>
		<p>
			<label for="klc_price"><?php esc_html_e( 'Price', 'kleo-live-classes' ); ?></label><br />
			<input type="number" name="klc_price" id="klc_price" value="<?php echo esc_attr( $price ); ?>" min="0" step="0.01" />
		</p>
		<p>
			<label for="klc_capacity"><?php esc_html_e( 'Capacity', 'kleo-live-classes' ); ?></label><br />
			<input type="number" name="klc_capacity" id="klc_capacity" value="<?php echo esc_attr( $capacity ); ?>" min="0" step="1" />
		</p>
		<p>
			<label for="klc_linked_course_id"><?php esc_html_e( 'Linked Sensei Course ID (optional)', 'kleo-live-classes' ); ?></label><br />
			<input type="number" name="klc_linked_course_id" id="klc_linked_course_id" value="<?php echo esc_attr( $linked_course ); ?>" min="0" step="1" />
		</p>
		<?php
	}

	public function save_live_class_meta( $post_id ) {
		if ( ! isset( $_POST['klc_live_class_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['klc_live_class_nonce'] ) ), 'klc_save_live_class_meta' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		update_post_meta( $post_id, '_klc_meeting_url', esc_url_raw( wp_unslash( $_POST['klc_meeting_url'] ?? '' ) ) );
		update_post_meta( $post_id, '_klc_start_datetime', sanitize_text_field( wp_unslash( $_POST['klc_start_datetime'] ?? '' ) ) );
		update_post_meta( $post_id, '_klc_duration_minutes', absint( $_POST['klc_duration_minutes'] ?? 0 ) );
		update_post_meta( $post_id, '_klc_price', $this->format_decimal( wp_unslash( $_POST['klc_price'] ?? 0 ) ) );
		update_post_meta( $post_id, '_klc_capacity', absint( $_POST['klc_capacity'] ?? 0 ) );
		update_post_meta( $post_id, '_klc_linked_course_id', absint( $_POST['klc_linked_course_id'] ?? 0 ) );

		$this->sync_product_for_live_class( $post_id );
	}

	public function register_shortcodes() {
		add_shortcode( 'klc_teacher_dashboard', array( $this, 'render_teacher_dashboard_shortcode' ) );
		add_shortcode( 'klc_live_classes', array( $this, 'render_live_classes_shortcode' ) );
		add_shortcode( 'klc_student_schedule', array( $this, 'render_student_schedule_shortcode' ) );
	}

	public function render_teacher_dashboard_shortcode() {
		if ( ! is_user_logged_in() ) {
			return '<p>' . esc_html__( 'Please log in to manage live classes.', 'kleo-live-classes' ) . '</p>';
		}

		$user = wp_get_current_user();
		if ( ! $this->current_user_is_teacher( $user ) ) {
			return '<p>' . esc_html__( 'Only teachers can create live classes.', 'kleo-live-classes' ) . '</p>';
		}

		$message = $this->handle_teacher_dashboard_submission( $user->ID );
		$editing = isset( $_GET['klc_edit'] ) ? absint( $_GET['klc_edit'] ) : 0;
		$post    = $editing ? get_post( $editing ) : null;

		if ( $post && intval( $post->post_author ) !== $user->ID ) {
			$post = null;
		}

		ob_start();

		if ( $message ) {
			echo '<div class="klc-notice">' . esc_html( $message ) . '</div>';
		}
		?>
		<form method="post" class="klc-teacher-dashboard-form">
			<?php wp_nonce_field( 'klc_frontend_save_live_class', 'klc_frontend_nonce' ); ?>
			<input type="hidden" name="klc_live_class_id" value="<?php echo esc_attr( $post ? $post->ID : 0 ); ?>" />
			<p>
				<label><?php esc_html_e( 'Class Title', 'kleo-live-classes' ); ?></label><br />
				<input type="text" name="klc_title" required class="widefat" value="<?php echo esc_attr( $post ? $post->post_title : '' ); ?>" />
			</p>
			<p>
				<label><?php esc_html_e( 'Description', 'kleo-live-classes' ); ?></label><br />
				<textarea name="klc_description" rows="5" class="widefat"><?php echo esc_textarea( $post ? $post->post_content : '' ); ?></textarea>
			</p>
			<p>
				<label><?php esc_html_e( 'Meeting URL', 'kleo-live-classes' ); ?></label><br />
				<input type="url" name="klc_meeting_url" required class="widefat" value="<?php echo esc_attr( $post ? get_post_meta( $post->ID, '_klc_meeting_url', true ) : '' ); ?>" />
			</p>
			<p>
				<label><?php esc_html_e( 'Start Date/Time', 'kleo-live-classes' ); ?></label><br />
				<input type="datetime-local" name="klc_start_datetime" required value="<?php echo esc_attr( $post ? get_post_meta( $post->ID, '_klc_start_datetime', true ) : '' ); ?>" />
			</p>
			<p>
				<label><?php esc_html_e( 'Duration (minutes)', 'kleo-live-classes' ); ?></label><br />
				<input type="number" name="klc_duration_minutes" min="15" step="15" required value="<?php echo esc_attr( $post ? get_post_meta( $post->ID, '_klc_duration_minutes', true ) : 60 ); ?>" />
			</p>
			<p>
				<label><?php esc_html_e( 'Price', 'kleo-live-classes' ); ?></label><br />
				<input type="number" name="klc_price" min="0" step="0.01" required value="<?php echo esc_attr( $post ? get_post_meta( $post->ID, '_klc_price', true ) : '' ); ?>" />
			</p>
			<p>
				<label><?php esc_html_e( 'Capacity', 'kleo-live-classes' ); ?></label><br />
				<input type="number" name="klc_capacity" min="0" step="1" value="<?php echo esc_attr( $post ? get_post_meta( $post->ID, '_klc_capacity', true ) : 0 ); ?>" />
			</p>
			<p>
				<label><?php esc_html_e( 'Linked Sensei Course ID (optional)', 'kleo-live-classes' ); ?></label><br />
				<input type="number" name="klc_linked_course_id" min="0" step="1" value="<?php echo esc_attr( $post ? get_post_meta( $post->ID, '_klc_linked_course_id', true ) : 0 ); ?>" />
			</p>
			<p>
				<button type="submit" name="klc_save_live_class" value="1"><?php echo esc_html( $post ? __( 'Update Live Class', 'kleo-live-classes' ) : __( 'Create Live Class', 'kleo-live-classes' ) ); ?></button>
			</p>
		</form>
		<?php

		$classes = get_posts(
			array(
				'post_type'      => 'klc_live_class',
				'author'         => $user->ID,
				'posts_per_page' => -1,
				'post_status'    => array( 'publish', 'draft' ),
				'orderby'        => 'meta_value',
				'meta_key'       => '_klc_start_datetime',
				'order'          => 'ASC',
			)
		);

		echo '<h3>' . esc_html__( 'Your Live Classes', 'kleo-live-classes' ) . '</h3>';
		if ( empty( $classes ) ) {
			echo '<p>' . esc_html__( 'You have not created any live classes yet.', 'kleo-live-classes' ) . '</p>';
		} else {
			echo '<ul class="klc-teacher-class-list">';
			foreach ( $classes as $class_post ) {
				$class_link = add_query_arg( 'klc_edit', $class_post->ID, get_permalink() );
				echo '<li>';
				echo '<strong>' . esc_html( get_the_title( $class_post ) ) . '</strong> ';
				echo '(' . esc_html( $this->format_schedule( get_post_meta( $class_post->ID, '_klc_start_datetime', true ) ) ) . ') ';
				echo '<a href="' . esc_url( $class_link ) . '">' . esc_html__( 'Edit', 'kleo-live-classes' ) . '</a> | ';
				echo '<a href="' . esc_url( get_permalink( $class_post ) ) . '">' . esc_html__( 'View', 'kleo-live-classes' ) . '</a>';
				echo '</li>';
			}
			echo '</ul>';
		}

		return ob_get_clean();
	}

	private function handle_teacher_dashboard_submission( $teacher_id ) {
		if ( empty( $_POST['klc_save_live_class'] ) ) {
			return '';
		}

		if ( ! isset( $_POST['klc_frontend_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['klc_frontend_nonce'] ) ), 'klc_frontend_save_live_class' ) ) {
			return __( 'We could not verify your request. Please try again.', 'kleo-live-classes' );
		}

		$live_class_id = absint( $_POST['klc_live_class_id'] ?? 0 );
		$post_data     = array(
			'post_type'    => 'klc_live_class',
			'post_title'   => sanitize_text_field( wp_unslash( $_POST['klc_title'] ?? '' ) ),
			'post_content' => wp_kses_post( wp_unslash( $_POST['klc_description'] ?? '' ) ),
			'post_status'  => 'publish',
			'post_author'  => $teacher_id,
		);

		if ( $live_class_id > 0 ) {
			$existing = get_post( $live_class_id );
			if ( ! $existing || intval( $existing->post_author ) !== $teacher_id ) {
				return __( 'You cannot edit that class.', 'kleo-live-classes' );
			}
			$post_data['ID'] = $live_class_id;
			$live_class_id   = wp_update_post( $post_data, true );
		} else {
			$live_class_id = wp_insert_post( $post_data, true );
		}

		if ( is_wp_error( $live_class_id ) ) {
			return $live_class_id->get_error_message();
		}

		update_post_meta( $live_class_id, '_klc_meeting_url', esc_url_raw( wp_unslash( $_POST['klc_meeting_url'] ?? '' ) ) );
		update_post_meta( $live_class_id, '_klc_start_datetime', sanitize_text_field( wp_unslash( $_POST['klc_start_datetime'] ?? '' ) ) );
		update_post_meta( $live_class_id, '_klc_duration_minutes', absint( $_POST['klc_duration_minutes'] ?? 60 ) );
		update_post_meta( $live_class_id, '_klc_price', $this->format_decimal( wp_unslash( $_POST['klc_price'] ?? 0 ) ) );
		update_post_meta( $live_class_id, '_klc_capacity', absint( $_POST['klc_capacity'] ?? 0 ) );
		update_post_meta( $live_class_id, '_klc_linked_course_id', absint( $_POST['klc_linked_course_id'] ?? 0 ) );

		$this->sync_product_for_live_class( $live_class_id );

		return __( 'Live class saved successfully.', 'kleo-live-classes' );
	}

	public function render_live_classes_shortcode() {
		$classes = get_posts(
			array(
				'post_type'      => 'klc_live_class',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'orderby'        => 'meta_value',
				'meta_key'       => '_klc_start_datetime',
				'order'          => 'ASC',
			)
		);

		if ( empty( $classes ) ) {
			return '<p>' . esc_html__( 'No live classes are available yet.', 'kleo-live-classes' ) . '</p>';
		}

		ob_start();
		echo '<div class="klc-live-classes">';
		foreach ( $classes as $class_post ) {
			$teacher     = get_user_by( 'id', $class_post->post_author );
			$price       = (float) get_post_meta( $class_post->ID, '_klc_price', true );
			$currency    = $this->get_settings()['currency_label'];
			$product_id  = absint( get_post_meta( $class_post->ID, '_klc_product_id', true ) );
			$enrol_url   = $product_id ? add_query_arg( 'add-to-cart', $product_id, wc_get_cart_url() ) : get_permalink( $class_post );

			echo '<article class="klc-live-class-card">';
			echo '<h3><a href="' . esc_url( get_permalink( $class_post ) ) . '">' . esc_html( get_the_title( $class_post ) ) . '</a></h3>';
			echo '<p>' . esc_html( wp_trim_words( wp_strip_all_tags( $class_post->post_content ), 30 ) ) . '</p>';
			echo '<p><strong>' . esc_html__( 'Teacher:', 'kleo-live-classes' ) . '</strong> ' . esc_html( $teacher ? $teacher->display_name : __( 'Unknown', 'kleo-live-classes' ) ) . '</p>';
			echo '<p><strong>' . esc_html__( 'Schedule:', 'kleo-live-classes' ) . '</strong> ' . esc_html( $this->format_schedule( get_post_meta( $class_post->ID, '_klc_start_datetime', true ) ) ) . '</p>';
			echo '<p><strong>' . esc_html__( 'Fee:', 'kleo-live-classes' ) . '</strong> ' . esc_html( $currency . ' ' . number_format_i18n( $price, 2 ) ) . '</p>';
			echo '<p><a class="button" href="' . esc_url( $enrol_url ) . '">' . esc_html__( 'Enrol Now', 'kleo-live-classes' ) . '</a></p>';
			echo '</article>';
		}
		echo '</div>';

		return ob_get_clean();
	}

	public function render_student_schedule_shortcode() {
		if ( ! is_user_logged_in() ) {
			return '<p>' . esc_html__( 'Please log in to view your live class schedule.', 'kleo-live-classes' ) . '</p>';
		}

		global $wpdb;
		$table_name = $wpdb->prefix . self::ENROLMENT_TABLE;
		$rows       = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$table_name} WHERE student_id = %d AND status = %s ORDER BY created_at DESC",
				get_current_user_id(),
				'active'
			)
		);

		if ( empty( $rows ) ) {
			return '<p>' . esc_html__( 'You are not enrolled in any live classes yet.', 'kleo-live-classes' ) . '</p>';
		}

		ob_start();
		echo '<div class="klc-student-schedule">';
		foreach ( $rows as $row ) {
			$class_post = get_post( $row->live_class_id );
			if ( ! $class_post || 'publish' !== $class_post->post_status ) {
				continue;
			}

			$meeting_url    = get_post_meta( $class_post->ID, '_klc_meeting_url', true );
			$start_datetime = get_post_meta( $class_post->ID, '_klc_start_datetime', true );
			$can_join       = $this->can_user_join_now( $class_post->ID );

			echo '<article class="klc-student-class-card">';
			echo '<h3><a href="' . esc_url( get_permalink( $class_post ) ) . '">' . esc_html( get_the_title( $class_post ) ) . '</a></h3>';
			echo '<p><strong>' . esc_html__( 'Schedule:', 'kleo-live-classes' ) . '</strong> ' . esc_html( $this->format_schedule( $start_datetime ) ) . '</p>';
			echo '<p><strong>' . esc_html__( 'Order:', 'kleo-live-classes' ) . '</strong> #' . esc_html( $row->order_id ) . '</p>';
			if ( $can_join && $meeting_url ) {
				echo '<p><a class="button" href="' . esc_url( $meeting_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Join Live Class', 'kleo-live-classes' ) . '</a></p>';
			} else {
				echo '<p>' . esc_html__( 'The join link will become available 30 minutes before the class starts.', 'kleo-live-classes' ) . '</p>';
			}
			echo '</article>';
		}
		echo '</div>';

		return ob_get_clean();
	}

	private function sync_product_for_live_class( $live_class_id ) {
		if ( ! class_exists( 'WC_Product_Simple' ) ) {
			return;
		}

		$live_class = get_post( $live_class_id );
		if ( ! $live_class ) {
			return;
		}

		$product_id = absint( get_post_meta( $live_class_id, '_klc_product_id', true ) );
		$product    = $product_id ? wc_get_product( $product_id ) : new WC_Product_Simple();

		if ( ! $product ) {
			$product = new WC_Product_Simple();
		}

		$product->set_name( $live_class->post_title );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'hidden' );
		$product->set_virtual( true );
		$product->set_sold_individually( true );
		$product->set_regular_price( (string) get_post_meta( $live_class_id, '_klc_price', true ) );
		$product->set_description( $live_class->post_content );
		$product->update_meta_data( self::PRODUCT_META_KEY, $live_class_id );

		$product_id = $product->save();

		update_post_meta( $live_class_id, '_klc_product_id', $product_id );
		update_post_meta( $product_id, self::PRODUCT_META_KEY, $live_class_id );
	}

	public function attach_live_class_to_cart_item( $cart_item_data, $product_id, $variation_id ) {
		$live_class_id = absint( get_post_meta( $product_id, self::PRODUCT_META_KEY, true ) );
		if ( $live_class_id ) {
			$cart_item_data['klc_live_class_id'] = $live_class_id;
			$cart_item_data['unique_key']        = md5( $product_id . '|' . $live_class_id . '|' . get_current_user_id() );
		}

		return $cart_item_data;
	}

	public function validate_live_class_add_to_cart( $passed, $product_id, $quantity ) {
		$live_class_id = absint( get_post_meta( $product_id, self::PRODUCT_META_KEY, true ) );
		if ( ! $live_class_id ) {
			return $passed;
		}

		if ( ! is_user_logged_in() ) {
			wc_add_notice( __( 'Please log in before enrolling in a live class.', 'kleo-live-classes' ), 'error' );
			return false;
		}

		if ( $this->user_has_access_to_class( get_current_user_id(), $live_class_id ) ) {
			wc_add_notice( __( 'You are already enrolled in this live class.', 'kleo-live-classes' ), 'error' );
			return false;
		}

		if ( $this->is_class_full( $live_class_id ) ) {
			wc_add_notice( __( 'This live class is already full.', 'kleo-live-classes' ), 'error' );
			return false;
		}

		return $passed;
	}

	public function display_live_class_in_cart( $item_data, $cart_item ) {
		if ( empty( $cart_item['klc_live_class_id'] ) ) {
			return $item_data;
		}

		$item_data[] = array(
			'key'   => __( 'Live Class', 'kleo-live-classes' ),
			'value' => get_the_title( $cart_item['klc_live_class_id'] ),
		);

		return $item_data;
	}

	public function sync_cart_item_price( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		if ( ! $cart || ! is_a( $cart, 'WC_Cart' ) ) {
			return;
		}

		foreach ( $cart->get_cart() as $cart_item ) {
			if ( empty( $cart_item['klc_live_class_id'] ) ) {
				continue;
			}

			$price = (float) get_post_meta( $cart_item['klc_live_class_id'], '_klc_price', true );
			$cart_item['data']->set_price( $price );
		}
	}

	public function copy_live_class_meta_to_order_item( $item, $cart_item_key, $values, $order ) {
		if ( empty( $values['klc_live_class_id'] ) ) {
			return;
		}

		$live_class_id = absint( $values['klc_live_class_id'] );
		$item->add_meta_data( self::ORDER_ITEM_META_KEY, $live_class_id, true );

		$teacher_id     = (int) get_post_field( 'post_author', $live_class_id );
		$gross_amount   = (float) $item->get_total();
		$platform_fee   = $this->calculate_platform_fee( $gross_amount );
		$teacher_amount = max( 0, $gross_amount - $platform_fee );

		$item->add_meta_data( '_klc_teacher_id', $teacher_id, true );
		$item->add_meta_data( '_klc_platform_fee', $platform_fee, true );
		$item->add_meta_data( '_klc_teacher_earnings', $teacher_amount, true );
	}

	public function maybe_create_enrolments_from_order( $order_id ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}

		if ( $order->get_meta( '_klc_enrolments_created' ) ) {
			return;
		}

		$student_id = $order->get_user_id();
		if ( ! $student_id ) {
			return;
		}

		foreach ( $order->get_items() as $item ) {
			$live_class_id = absint( $item->get_meta( self::ORDER_ITEM_META_KEY, true ) );
			if ( ! $live_class_id ) {
				continue;
			}

			$this->create_or_update_enrolment(
				array(
					'live_class_id'     => $live_class_id,
					'student_id'        => $student_id,
					'order_id'          => $order_id,
					'teacher_id'        => (int) $item->get_meta( '_klc_teacher_id', true ),
					'amount_paid'       => (float) $item->get_total(),
					'platform_fee'      => (float) $item->get_meta( '_klc_platform_fee', true ),
					'teacher_earnings'  => (float) $item->get_meta( '_klc_teacher_earnings', true ),
				)
			);
		}

		$order->update_meta_data( '_klc_enrolments_created', 1 );
		$order->save();
	}

	private function create_or_update_enrolment( $data ) {
		global $wpdb;

		$table_name = $wpdb->prefix . self::ENROLMENT_TABLE;
		$now        = current_time( 'mysql' );

		$existing_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$table_name} WHERE live_class_id = %d AND student_id = %d",
				$data['live_class_id'],
				$data['student_id']
			)
		);

		$row = array(
			'live_class_id'    => $data['live_class_id'],
			'student_id'       => $data['student_id'],
			'order_id'         => $data['order_id'],
			'teacher_id'       => $data['teacher_id'],
			'amount_paid'      => $data['amount_paid'],
			'platform_fee'     => $data['platform_fee'],
			'teacher_earnings' => $data['teacher_earnings'],
			'status'           => 'active',
			'updated_at'       => $now,
		);

		if ( $existing_id ) {
			$wpdb->update( $table_name, $row, array( 'id' => $existing_id ) );
			return;
		}

		$row['created_at'] = $now;
		$wpdb->insert( $table_name, $row );
	}

	private function calculate_platform_fee( $amount ) {
		$settings = $this->get_settings();
		return round( $amount * ( floatval( $settings['platform_fee_percent'] ) / 100 ), 2 );
	}

	private function format_decimal( $value ) {
		if ( function_exists( 'wc_format_decimal' ) ) {
			return wc_format_decimal( $value );
		}

		return number_format( (float) $value, 2, '.', '' );
	}

	private function current_user_is_teacher( $user ) {
		$settings = $this->get_settings();
		return in_array( $settings['teacher_role'], (array) $user->roles, true ) || user_can( $user, 'edit_posts' );
	}

	private function format_schedule( $raw_datetime ) {
		if ( empty( $raw_datetime ) ) {
			return __( 'Schedule not set', 'kleo-live-classes' );
		}

		$timestamp = strtotime( $raw_datetime );
		if ( ! $timestamp ) {
			return $raw_datetime;
		}

		return wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $timestamp );
	}

	private function can_user_join_now( $live_class_id ) {
		$start_datetime = get_post_meta( $live_class_id, '_klc_start_datetime', true );
		$timestamp      = strtotime( $start_datetime );
		if ( ! $timestamp ) {
			return false;
		}

		$open_time  = $timestamp - ( 30 * MINUTE_IN_SECONDS );
		$close_time = $timestamp + ( absint( get_post_meta( $live_class_id, '_klc_duration_minutes', true ) ) * MINUTE_IN_SECONDS );
		$now        = current_time( 'timestamp' );

		return $now >= $open_time && $now <= $close_time;
	}

	private function user_has_access_to_class( $user_id, $live_class_id ) {
		if ( ! $user_id || ! $live_class_id ) {
			return false;
		}

		if ( intval( get_post_field( 'post_author', $live_class_id ) ) === intval( $user_id ) ) {
			return true;
		}

		global $wpdb;
		$table_name = $wpdb->prefix . self::ENROLMENT_TABLE;

		$enrolment_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM {$table_name} WHERE live_class_id = %d AND student_id = %d AND status = %s",
				$live_class_id,
				$user_id,
				'active'
			)
		);

		return ! empty( $enrolment_id );
	}

	private function is_class_full( $live_class_id ) {
		$capacity = absint( get_post_meta( $live_class_id, '_klc_capacity', true ) );
		if ( $capacity < 1 ) {
			return false;
		}

		global $wpdb;
		$table_name = $wpdb->prefix . self::ENROLMENT_TABLE;
		$count      = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$table_name} WHERE live_class_id = %d AND status = %s",
				$live_class_id,
				'active'
			)
		);

		return $count >= $capacity;
	}

	public function render_single_class_content( $content ) {
		if ( ! is_singular( 'klc_live_class' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		global $post;

		$price         = (float) get_post_meta( $post->ID, '_klc_price', true );
		$meeting_url   = get_post_meta( $post->ID, '_klc_meeting_url', true );
		$teacher       = get_user_by( 'id', $post->post_author );
		$product_id    = absint( get_post_meta( $post->ID, '_klc_product_id', true ) );
		$linked_course = absint( get_post_meta( $post->ID, '_klc_linked_course_id', true ) );
		$currency      = $this->get_settings()['currency_label'];
		$user_id       = get_current_user_id();
		$has_access    = $this->user_has_access_to_class( $user_id, $post->ID );

		$details  = '<div class="klc-single-class-meta">';
		$details .= '<p><strong>' . esc_html__( 'Teacher:', 'kleo-live-classes' ) . '</strong> ' . esc_html( $teacher ? $teacher->display_name : __( 'Unknown', 'kleo-live-classes' ) ) . '</p>';
		$details .= '<p><strong>' . esc_html__( 'Schedule:', 'kleo-live-classes' ) . '</strong> ' . esc_html( $this->format_schedule( get_post_meta( $post->ID, '_klc_start_datetime', true ) ) ) . '</p>';
		$details .= '<p><strong>' . esc_html__( 'Duration:', 'kleo-live-classes' ) . '</strong> ' . esc_html( absint( get_post_meta( $post->ID, '_klc_duration_minutes', true ) ) ) . ' ' . esc_html__( 'minutes', 'kleo-live-classes' ) . '</p>';
		$details .= '<p><strong>' . esc_html__( 'Price:', 'kleo-live-classes' ) . '</strong> ' . esc_html( $currency . ' ' . number_format_i18n( $price, 2 ) ) . '</p>';

		if ( $linked_course ) {
			$details .= '<p><strong>' . esc_html__( 'Related Course:', 'kleo-live-classes' ) . '</strong> <a href="' . esc_url( get_permalink( $linked_course ) ) . '">' . esc_html( get_the_title( $linked_course ) ) . '</a></p>';
		}

		if ( $has_access && $meeting_url ) {
			if ( $this->can_user_join_now( $post->ID ) ) {
				$details .= '<p><a class="button" href="' . esc_url( $meeting_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Join Live Class', 'kleo-live-classes' ) . '</a></p>';
			} else {
				$details .= '<p>' . esc_html__( 'You are enrolled. The join link will open 30 minutes before the class starts.', 'kleo-live-classes' ) . '</p>';
			}
		} elseif ( $product_id ) {
			$details .= '<p><a class="button" href="' . esc_url( add_query_arg( 'add-to-cart', $product_id, wc_get_cart_url() ) ) . '">' . esc_html__( 'Pay and Enrol', 'kleo-live-classes' ) . '</a></p>';
		}

		$details .= '</div>';

		return $content . $details;
	}
}
