<?php
/**
 * Frontend shortcodes and form handlers.
 */

namespace Classhall\LiveClasses\Frontend;

use Classhall\LiveClasses\Application\Class_Completion;
use Classhall\LiveClasses\Application\Ranking_Service;
use Classhall\LiveClasses\Database\Installer;
use Classhall\LiveClasses\Domain\Statuses;
use Classhall\LiveClasses\Infrastructure\Audit_Log;
use Classhall\LiveClasses\Infrastructure\Subject_Adapter;
use Classhall\LiveClasses\Plugin;
use Classhall\LiveClasses\Security\Capabilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Shortcodes {
	/**
	 * Subject adapter.
	 *
	 * @var Subject_Adapter
	 */
	private $subjects;

	/**
	 * Current public teacher profile route.
	 *
	 * @var object|null
	 */
	private $current_teacher_profile = null;

	/**
	 * Whether the current request is the teacher directory route.
	 *
	 * @var bool
	 */
	private $is_teacher_directory = false;

	/**
	 * Constructor.
	 *
	 * @param Subject_Adapter $subjects Subject adapter.
	 */
	public function __construct( Subject_Adapter $subjects ) {
		$this->subjects = $subjects;
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_shortcode( 'classhall_live_classes', array( $this, 'classes' ) );
		add_shortcode( 'classhall_live_teachers', array( $this, 'teachers' ) );
		add_shortcode( 'classhall_live_subject_classes', array( $this, 'subject_classes' ) );
		add_shortcode( 'classhall_live_teacher_application', array( $this, 'teacher_application' ) );
		add_shortcode( 'classhall_live_teacher_dashboard', array( $this, 'teacher_dashboard' ) );
		add_shortcode( 'classhall_live_student_dashboard', array( $this, 'student_dashboard' ) );
		add_shortcode( 'classhall_live_review_form', array( $this, 'review_form' ) );

		add_filter( 'query_vars', array( $this, 'query_vars' ) );
		add_filter( 'pre_get_document_title', array( $this, 'teacher_profile_document_title' ) );
		add_filter( 'document_title_parts', array( $this, 'teacher_profile_document_title_parts' ) );
		add_filter( 'wp_title', array( $this, 'teacher_profile_wp_title' ), 20, 3 );
		add_filter( 'kleo_main_template_classes', array( $this, 'teacher_profile_main_template_classes' ), 999 );
		add_filter( 'the_content', array( $this, 'single_class_content' ) );
		add_action( 'sensei_single_course_content_inside_after', array( $this, 'render_sensei_subject_live_classes_after_lessons' ), 11 );
		add_action( 'template_redirect', array( $this, 'render_teacher_directory_route' ) );
		add_action( 'template_redirect', array( $this, 'render_teacher_profile_route' ) );
		add_action( 'template_redirect', array( $this, 'render_join_route' ) );
		add_action( 'wp_head', array( $this, 'teacher_profile_title_fallback' ), 1 );
		add_action( 'wp_footer', array( $this, 'teacher_profile_title_fallback' ), 999 );
		add_action( 'wp_head', array( $this, 'class_social_meta' ), 5 );
	}

	/**
	 * Register frontend query vars.
	 *
	 * @param array $vars Query vars.
	 * @return array
	 */
	public function query_vars( $vars ) {
		$vars[] = 'classhall_live_teachers_directory';
		$vars[] = 'classhall_live_teacher_slug';
		$vars[] = 'classhall_live_join_uuid';
		return $vars;
	}

	/**
	 * Public teacher directory.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public function teachers( $atts = array() ) {
		wp_enqueue_style( 'classhall-live-classes' );
		wp_enqueue_script( 'classhall-live-classes' );

		$atts   = shortcode_atts( array( 'limit' => 60 ), $atts, 'classhall_live_teachers' );
		$limit  = max( 1, min( 100, absint( $atts['limit'] ) ) );
		$search = sanitize_text_field( wp_unslash( $_GET['live_teacher_search'] ?? '' ) );
		$class_filter_key = sanitize_key( wp_unslash( $_GET['live_teacher_class'] ?? '' ) );
		$class_options    = $this->class_level_options();
		if ( '' !== $search ) {
			$class_filter_key = '';
		}
		if ( ! isset( $class_options[ $class_filter_key ] ) ) {
			$class_filter_key = '';
		}
		$rows   = $this->query_teachers( $search, $class_filter_key, $limit );

		ob_start();
		echo '<div class="chl-teacher-directory">';
		echo '<form class="chl-filters chl-teacher-search" method="get">';
		echo '<select name="live_teacher_class" data-chl-auto-submit aria-label="' . esc_attr__( 'Filter by class', 'classhall-live-classes' ) . '">';
		echo '<option value="">' . esc_html__( 'All classes', 'classhall-live-classes' ) . '</option>';
		foreach ( $class_options as $key => $label ) {
			echo '<option value="' . esc_attr( $key ) . '"' . selected( $class_filter_key, $key, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
		echo '<input name="live_teacher_search" value="' . esc_attr( $search ) . '" aria-label="' . esc_attr__( 'Find a teacher', 'classhall-live-classes' ) . '" placeholder="' . esc_attr__( 'Search by teacher, subject, or class', 'classhall-live-classes' ) . '">';
		echo '<button type="submit" name="live_teacher_search_submit" value="1">' . esc_html__( 'Search', 'classhall-live-classes' ) . '</button></form>';

		if ( empty( $rows ) ) {
			echo '<p class="chl-empty">' . esc_html__( 'No teachers found.', 'classhall-live-classes' ) . '</p>';
			echo '</div>';
			return ob_get_clean();
		}

		echo '<div class="chl-teacher-grid">';
		foreach ( $rows as $teacher ) {
			$this->render_teacher_directory_card( $teacher );
		}
		echo '</div></div>';

		return ob_get_clean();
	}

	/**
	 * Set browser title for teacher profile routes.
	 *
	 * @param string $title Current title.
	 * @return string
	 */
	public function teacher_profile_document_title( $title ) {
		if ( $this->is_teacher_directory_route() ) {
			return __( 'Live Teachers', 'classhall-live-classes' );
		}

		$profile = $this->teacher_profile_for_current_route();
		if ( ! $profile ) {
			return $title;
		}

		return sprintf(
			/* translators: %s: teacher name. */
			__( '%s - Live Class Teacher', 'classhall-live-classes' ),
			$profile->display_name
		);
	}

	/**
	 * Set browser title parts for themes that use title parts.
	 *
	 * @param array $parts Title parts.
	 * @return array
	 */
	public function teacher_profile_document_title_parts( $parts ) {
		if ( $this->is_teacher_directory_route() ) {
			$parts['title'] = __( 'Live Teachers', 'classhall-live-classes' );
			return $parts;
		}

		$profile = $this->teacher_profile_for_current_route();
		if ( ! $profile ) {
			return $parts;
		}

		$parts['title'] = sprintf(
			/* translators: %s: teacher name. */
			__( '%s - Live Class Teacher', 'classhall-live-classes' ),
			$profile->display_name
		);

		return $parts;
	}

	/**
	 * Set browser title for older themes that still use wp_title().
	 *
	 * @param string $title Current title.
	 * @param string $sep Separator.
	 * @param string $seplocation Separator location.
	 * @return string
	 */
	public function teacher_profile_wp_title( $title, $sep = '|', $seplocation = '' ) {
		if ( $this->is_teacher_directory_route() ) {
			$directory_title = __( 'Live Teachers', 'classhall-live-classes' );
			return 'right' === $seplocation ? $directory_title . " $sep " : " $sep " . $directory_title;
		}

		$profile = $this->teacher_profile_for_current_route();
		if ( ! $profile ) {
			return $title;
		}

		$profile_title = sprintf(
			/* translators: %s: teacher name. */
			__( '%s - Live Class Teacher', 'classhall-live-classes' ),
			$profile->display_name
		);

		return 'right' === $seplocation ? $profile_title . " $sep " : " $sep " . $profile_title;
	}

	/**
	 * Make teacher directory/profile routes use the theme content column with an empty sidebar.
	 *
	 * @param string $classes Theme template classes.
	 * @return string
	 */
	public function teacher_profile_main_template_classes( $classes ) {
		if ( ! $this->teacher_profile_for_current_route() && ! $this->is_teacher_directory_route() ) {
			return $classes;
		}

		return 'col-sm-9 tpl-right';
	}

	/**
	 * Render an empty theme sidebar column for teacher directory/profile pages.
	 *
	 * @return void
	 */
	public function render_empty_teacher_profile_sidebar() {
		echo '<aside class="sidebar sidebar-right col-sm-3" aria-hidden="true"><div class="inner-content"></div></aside>';
	}

	/**
	 * Final browser-title fallback for themes that bypass WP title filters.
	 *
	 * @return void
	 */
	public function teacher_profile_title_fallback() {
		if ( $this->is_teacher_directory_route() ) {
			echo '<script>document.title = ' . wp_json_encode( __( 'Live Teachers | Classhall', 'classhall-live-classes' ) ) . ';</script>' . "\n";
			return;
		}

		$profile = $this->teacher_profile_for_current_route();
		if ( ! $profile ) {
			return;
		}

		$title = sprintf(
			/* translators: %s: teacher name. */
			__( '%s - Live Class Teacher | Classhall', 'classhall-live-classes' ),
			$profile->display_name
		);

		echo '<script>document.title = ' . wp_json_encode( $title ) . ';</script>' . "\n";
	}

	/**
	 * Live class listing.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public function classes( $atts = array() ) {
		wp_enqueue_style( 'classhall-live-classes' );
		wp_enqueue_script( 'classhall-live-classes' );

		$atts    = shortcode_atts( array( 'subject' => '', 'limit' => 12 ), $atts, 'classhall_live_classes' );
		$classes = $this->query_classes( sanitize_key( $atts['subject'] ), absint( $atts['limit'] ) );

		ob_start();
		echo '<div class="chl-listing">';
		echo '<form class="chl-filters" method="get"><label>' . esc_html__( 'Search live classes', 'classhall-live-classes' ) . '<input name="live_class_search" value="' . esc_attr( sanitize_text_field( wp_unslash( $_GET['live_class_search'] ?? '' ) ) ) . '"></label><button type="submit">' . esc_html__( 'Search', 'classhall-live-classes' ) . '</button></form>';
		if ( empty( $classes ) ) {
			echo '<p class="chl-empty">' . esc_html__( 'No live classes are available yet.', 'classhall-live-classes' ) . '</p>';
		}
		foreach ( $classes as $class ) {
			$this->render_class_card( $class );
		}
		echo '</div>';
		return ob_get_clean();
	}

	/**
	 * Subject-specific class listing.
	 *
	 * @param array $atts Attributes.
	 * @return string
	 */
	public function subject_classes( $atts = array() ) {
		$atts = shortcode_atts( array( 'subject' => '' ), $atts, 'classhall_live_subject_classes' );
		return $this->classes( array( 'subject' => sanitize_key( $atts['subject'] ), 'limit' => 6 ) );
	}

	/**
	 * Automatically append subject live-class CTA/listing to Sensei subject pages.
	 *
	 * @param string $content Page content.
	 * @return string
	 */
	public function single_sensei_subject_live_classes( $content ) {
		if ( is_admin() || ! is_singular( 'course' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		if ( has_shortcode( $content, 'classhall_live_subject_classes' ) || false !== strpos( $content, 'chl-sensei-subject-live-classes' ) ) {
			return $content;
		}

		$course_id = get_the_ID();
		if ( ! $course_id ) {
			return $content;
		}

		static $rendered_course_ids = array();
		if ( isset( $rendered_course_ids[ $course_id ] ) ) {
			return $content;
		}

		$subject_key = 'course-' . absint( $course_id );
		$block       = $this->render_sensei_subject_live_classes_block( $course_id, $subject_key );
		if ( $block ) {
			$rendered_course_ids[ $course_id ] = true;
		}

		return $block ? $content . $block : $content;
	}

	/**
	 * Render subject live-class CTA/listing after Sensei lessons and before related subject links.
	 *
	 * @return void
	 */
	public function render_sensei_subject_live_classes_after_lessons() {
		if ( is_admin() || ! is_singular( 'course' ) ) {
			return;
		}

		$course_id = get_the_ID();
		if ( ! $course_id ) {
			return;
		}

		$content = get_post_field( 'post_content', $course_id );
		if ( has_shortcode( $content, 'classhall_live_subject_classes' ) || false !== strpos( $content, 'chl-sensei-subject-live-classes' ) ) {
			return;
		}

		static $rendered_course_ids = array();
		if ( isset( $rendered_course_ids[ $course_id ] ) ) {
			return;
		}

		$subject_key = 'course-' . absint( $course_id );
		$block       = $this->render_sensei_subject_live_classes_block( $course_id, $subject_key );
		if ( ! $block ) {
			return;
		}

		$rendered_course_ids[ $course_id ] = true;
		echo $block; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render the automatic live-class CTA/listing block for a Sensei subject.
	 *
	 * @param int    $course_id Sensei course ID.
	 * @param string $subject_key Live-class subject key.
	 * @return string
	 */
	private function render_sensei_subject_live_classes_block( $course_id, $subject_key ) {
		wp_enqueue_style( 'classhall-live-classes' );
		wp_enqueue_script( 'classhall-live-classes' );

		$subject_label = $this->clean_teacher_subject_title_label( get_the_title( $course_id ) );
		$subject_label = $subject_label ?: get_the_title( $course_id );
		$this->consolidate_legacy_recurring_classes( $subject_key );
		$classes       = $this->featured_subject_classes( $subject_key );
		$role          = $this->current_user_role_context();
		$can_create    = is_user_logged_in() && current_user_can( Capabilities::CREATE_CLASSES );
		$list_id       = 'chl-sensei-subject-classes-list';
		$info_text     = '';

		if ( $can_create ) {
			$button_label = __( 'Create a Live Class', 'classhall-live-classes' );
			$button_url   = apply_filters( 'classhall_live_teacher_dashboard_url', home_url( '/create-a-live-class/' ), $course_id, $subject_key );
			$description  = sprintf(
				/* translators: %s: subject name. */
				__( 'Earn extra income by creating live classes for %s students who need help with this subject.', 'classhall-live-classes' ),
				$subject_label
			);
			$info_text = sprintf(
				/* translators: %s: subject name. */
				__( 'Create an online live class for %s, set your schedule and price, and earn from students who need extra help with this subject.', 'classhall-live-classes' ),
				$subject_label
			);
		} elseif ( 'teacher' === $role ) {
			$button_label = __( 'Apply to Teach this Subject', 'classhall-live-classes' );
			$button_url   = apply_filters( 'classhall_live_teacher_application_url', home_url( '/live-teacher-application/' ), $course_id, $subject_key );
			$description  = sprintf(
				/* translators: %s: subject name. */
				__( 'Earn extra income by teaching %s online for students who need help with this subject.', 'classhall-live-classes' ),
				$subject_label
			);
			$info_text = sprintf(
				/* translators: %s: subject name. */
				__( 'Apply to become a verified Classhall live teacher for %s and earn extra income by helping students online.', 'classhall-live-classes' ),
				$subject_label
			);
		} elseif ( in_array( $role, array( 'student', 'parent' ), true ) ) {
			$button_label = __( 'Book a Live Class for this Subject', 'classhall-live-classes' );
			$button_url   = '#' . $list_id;
			$description  = sprintf(
				/* translators: %s: subject name. */
				__( 'Need help with %s? Book a live teacher for extra explanation when classes are available.', 'classhall-live-classes' ),
				$subject_label
			);
			$info_text = sprintf(
				/* translators: %s: subject name. */
				__( 'Book a Classhall live teacher for %s when available and get extra explanation online.', 'classhall-live-classes' ),
				$subject_label
			);
		} else {
			$button_label = __( 'Explore Live Classes', 'classhall-live-classes' );
			$button_url   = '#' . $list_id;
			$description  = sprintf(
				/* translators: %s: subject name. */
				__( 'Students can now book live classes for %s, and teachers can apply to teach this subject online.', 'classhall-live-classes' ),
				$subject_label
			);
		}

		ob_start();
		echo '<section class="chl-sensei-subject-live-classes" aria-labelledby="chl-sensei-subject-live-classes-title">';
		echo '<div class="chl-sensei-subject-live-classes-head">';
		echo '<div><h2 id="chl-sensei-subject-live-classes-title">' . esc_html(
			sprintf(
				/* translators: %s: subject name. */
				__( 'Live Classes for %s', 'classhall-live-classes' ),
				$subject_label
			)
		) . '</h2>';
		echo '<p>' . esc_html( $description ) . '</p></div>';
		echo '<div class="chl-subject-cta-actions"><a class="chl-button" href="' . esc_url( $button_url ) . '">' . esc_html( $button_label ) . '</a>';
		if ( $info_text ) {
			echo '<span class="chl-info-icon" tabindex="0" role="img" aria-label="' . esc_attr( $info_text ) . '" title="' . esc_attr( $info_text ) . '">i</span>';
		}
		echo '</div>';
		echo '</div>';

		if ( ! empty( $classes ) || ( ! $can_create && 'teacher' !== $role ) ) {
			echo '<div id="' . esc_attr( $list_id ) . '" class="chl-sensei-subject-live-classes-list">';
			if ( empty( $classes ) ) {
				echo '<p class="chl-empty">' . esc_html__( 'No live classes are available for this subject yet.', 'classhall-live-classes' ) . '</p>';
			} else {
				echo '<div class="chl-related-grid chl-related-grid-featured">';
				foreach ( $classes as $class ) {
					$this->render_class_card( $class, true );
				}
				echo '</div>';
			}
			echo '</div>';
		}
		echo '</section>';

		return ob_get_clean();
	}

	/**
	 * Teacher application form.
	 *
	 * @return string
	 */
	public function teacher_application() {
		if ( ! is_user_logged_in() ) {
			return '<p>' . esc_html__( 'Please log in to apply as a live-class teacher.', 'classhall-live-classes' ) . '</p>';
		}

		$message = $this->handle_teacher_application();
		wp_enqueue_style( 'classhall-live-classes' );

		ob_start();
		if ( $message ) {
			echo '<div class="chl-notice">' . esc_html( $message ) . '</div>';
		}
		?>
		<form class="chl-form" method="post">
			<?php wp_nonce_field( 'classhall_live_teacher_application', 'classhall_live_nonce' ); ?>
			<input type="hidden" name="classhall_live_action" value="teacher_application">
			<section class="chl-form-section">
				<h3><?php esc_html_e( 'Profile', 'classhall-live-classes' ); ?></h3>
				<label><?php esc_html_e( 'Display name', 'classhall-live-classes' ); ?><input name="display_name" required value="<?php echo esc_attr( wp_get_current_user()->display_name ); ?>"></label>
				<label><?php esc_html_e( 'Professional biography', 'classhall-live-classes' ); ?><textarea name="bio" rows="5" required></textarea></label>
				<label><?php esc_html_e( 'Qualifications', 'classhall-live-classes' ); ?><textarea name="qualifications" rows="4"></textarea></label>
				<label><?php esc_html_e( 'Teaching experience in years', 'classhall-live-classes' ); ?><input name="experience_years" type="number" min="0" step="1"></label>
			</section>
			<section class="chl-form-section">
				<h3><?php esc_html_e( 'Teaching Details', 'classhall-live-classes' ); ?></h3>
				<label><?php esc_html_e( 'Subjects taught', 'classhall-live-classes' ); ?><input name="subjects" placeholder="<?php esc_attr_e( 'Mathematics, English Language', 'classhall-live-classes' ); ?>"></label>
				<fieldset class="chl-checkbox-grid">
					<legend><?php esc_html_e( 'Classes taught', 'classhall-live-classes' ); ?></legend>
					<?php foreach ( $this->class_level_options() as $key => $label ) : ?>
						<label><input type="checkbox" name="class_levels[]" value="<?php echo esc_attr( $label ); ?>"> <?php echo esc_html( $label ); ?></label>
					<?php endforeach; ?>
				</fieldset>
				<label><?php esc_html_e( 'Examination specialisations', 'classhall-live-classes' ); ?><input name="exam_specialisations" placeholder="<?php esc_attr_e( 'WAEC, NECO, JAMB', 'classhall-live-classes' ); ?>"></label>
			</section>
			<section class="chl-form-section">
				<h3><?php esc_html_e( 'Payment Details', 'classhall-live-classes' ); ?></h3>
				<label><?php esc_html_e( 'Bank name', 'classhall-live-classes' ); ?><input name="bank_name" required></label>
				<label><?php esc_html_e( 'Account name', 'classhall-live-classes' ); ?><input name="account_name" required></label>
				<label><?php esc_html_e( 'Account number', 'classhall-live-classes' ); ?><input name="account_number" inputmode="numeric" pattern="[0-9 ]+" required></label>
			</section>
			<label class="chl-checkbox-inline"><input type="checkbox" name="terms" value="1" required> <span><?php echo wp_kses_post( sprintf(
				/* translators: %s: teacher terms URL. */
				__( 'I confirm that the information provided is accurate and I accept the <a href="%s" target="_blank" rel="noopener">live-class teacher terms and conditions</a>.', 'classhall-live-classes' ),
				esc_url( $this->teacher_terms_url() )
			) ); ?></span></label>
			<button type="submit"><?php esc_html_e( 'Submit Application', 'classhall-live-classes' ); ?></button>
		</form>
		<?php
		return ob_get_clean();
	}

	/**
	 * Teacher dashboard shortcode.
	 *
	 * @return string
	 */
	public function teacher_dashboard() {
		if ( ! is_user_logged_in() ) {
			return '<p>' . esc_html__( 'Please log in to manage live classes.', 'classhall-live-classes' ) . '</p>';
		}

		if ( ! current_user_can( Capabilities::CREATE_CLASSES ) ) {
			return '<p>' . esc_html__( 'Your live-class teacher profile must be approved before you can create classes.', 'classhall-live-classes' ) . '</p>';
		}

		$message = $this->handle_class_held_submission();
		if ( ! $message ) {
			$message = $this->handle_class_submission();
		}
		if ( ! $message && ! empty( $_GET['classhall_live_message'] ) ) {
			$message = sanitize_text_field( wp_unslash( $_GET['classhall_live_message'] ) );
		}
		wp_enqueue_style( 'classhall-live-classes' );
		wp_enqueue_script( 'classhall-live-classes' );

		ob_start();
		if ( $message ) {
			echo '<div class="chl-notice">' . esc_html( $message ) . '</div>';
		}
		$this->render_class_form();
		$this->render_teacher_classes();
		$this->render_teacher_earnings();
		return ob_get_clean();
	}

	/**
	 * Student dashboard shortcode.
	 *
	 * @return string
	 */
	public function student_dashboard() {
		if ( ! is_user_logged_in() ) {
			return '<p>' . esc_html__( 'Please log in to view your live classes.', 'classhall-live-classes' ) . '</p>';
		}

		$message = $this->handle_student_class_held_submission();
		global $wpdb;
		$tables   = Installer::tables();
		$bookings = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT b.*, c.post_id, c.start_at_utc, c.end_at_utc, c.primary_subject_label, c.class_type, c.meeting_url, c.status AS class_status, r.review_id
				FROM {$tables['bookings']} b
				INNER JOIN {$tables['classes']} c ON b.class_id = c.class_id
				LEFT JOIN {$tables['reviews']} r ON r.booking_id = b.booking_id
				WHERE b.student_user_id = %d
				ORDER BY c.start_at_utc DESC
				LIMIT 50",
				get_current_user_id()
			)
		);

		wp_enqueue_style( 'classhall-live-classes' );
		ob_start();
		echo '<div class="chl-dashboard">';
		if ( $message ) {
			echo '<div class="chl-notice">' . esc_html( $message ) . '</div>';
		}
		if ( ! empty( $_GET['booking_id'] ) || ( ! empty( $_POST['classhall_live_action'] ) && 'review' === $_POST['classhall_live_action'] ) ) {
			echo $this->review_form();
		}
		if ( empty( $bookings ) ) {
			echo '<p class="chl-empty">' . esc_html__( 'You do not have live-class bookings yet.', 'classhall-live-classes' ) . '</p>';
		}
		foreach ( $bookings as $booking ) {
			echo '<article class="chl-card"><h3><a href="' . esc_url( get_permalink( $booking->post_id ) ) . '">' . esc_html( get_the_title( $booking->post_id ) ) . '</a></h3>';
			echo '<p>' . esc_html__( 'Class held on', 'classhall-live-classes' ) . ' ' . esc_html( $this->format_utc( $booking->start_at_utc ) ) . '</p>';
			echo '<p>' . esc_html__( 'Class type:', 'classhall-live-classes' ) . ' ' . esc_html( $this->class_type_label( $booking->class_type ) ) . '</p>';
			echo '<p>' . esc_html__( 'Booking:', 'classhall-live-classes' ) . ' ' . esc_html( $booking->status ) . ' &middot; ' . esc_html__( 'Payment:', 'classhall-live-classes' ) . ' ' . esc_html( $booking->payment_status ) . '</p>';
			$this->render_join_area( $booking );
			$this->render_student_completion_area( $booking );
			if ( Statuses::BOOKING_COMPLETED === $booking->status ) {
				$review_label = ! empty( $booking->review_id ) ? __( 'Update Review', 'classhall-live-classes' ) : __( 'Review class', 'classhall-live-classes' );
				echo '<p><a class="chl-button" href="' . esc_url( add_query_arg( 'booking_id', absint( $booking->booking_id ), get_permalink() ) ) . '">' . esc_html( $review_label ) . '</a></p>';
			}
			echo '</article>';
		}
		echo '</div>';
		return ob_get_clean();
	}

	/**
	 * Review form shortcode.
	 *
	 * @return string
	 */
	public function review_form() {
		if ( ! is_user_logged_in() ) {
			return '<p>' . esc_html__( 'Please log in to review a class.', 'classhall-live-classes' ) . '</p>';
		}

		wp_enqueue_style( 'classhall-live-classes' );
		wp_enqueue_script( 'classhall-live-classes' );

		$message    = $this->handle_review_submission();
		$booking_id = absint( $_GET['booking_id'] ?? 0 );
		if ( ! $booking_id ) {
			return $this->render_review_booking_picker( $message );
		}

		$booking = $this->reviewable_booking( $booking_id );
		if ( ! $booking ) {
			return '<p>' . esc_html__( 'Only completed paid bookings can be reviewed.', 'classhall-live-classes' ) . '</p>';
		}

		ob_start();
		if ( $message ) {
			echo '<div class="chl-notice">' . esc_html( $message ) . '</div>';
		}
		$is_editing = ! empty( $booking->review_id );
		$this->render_review_context( $booking );
		if ( $is_editing ) {
			echo '<p class="chl-notice">' . esc_html__( 'You have already reviewed this class. Updating this form will edit your existing review, not create a new one.', 'classhall-live-classes' ) . '</p>';
		}
		?>
		<form class="chl-form" method="post">
			<?php wp_nonce_field( 'classhall_live_review', 'classhall_live_nonce' ); ?>
			<input type="hidden" name="classhall_live_action" value="review">
			<input type="hidden" name="booking_id" value="<?php echo esc_attr( $booking->booking_id ); ?>">
			<?php
			foreach (
				array(
					'teaching_quality_rating' => __( 'Teaching quality', 'classhall-live-classes' ),
					'punctuality_rating'   => __( 'Punctuality', 'classhall-live-classes' ),
				) as $field => $label
			) {
				$value = 'punctuality_rating' === $field ? (int) ( $booking->review_punctuality_rating ?? 0 ) : (int) ( $booking->review_teaching_quality_rating ?? 0 );
				$this->render_star_rating_field( $field, $label, $value );
			}
			?>
			<fieldset class="chl-radio-group">
				<legend><?php esc_html_e( 'Would you book this teacher again or recommend them?', 'classhall-live-classes' ); ?></legend>
				<?php $would_book_again = (int) ( $booking->review_would_book_again ?? 1 ); ?>
				<label><input type="radio" name="would_book_again" value="1" <?php checked( ! $is_editing || 1 === $would_book_again ); ?>> <?php esc_html_e( 'Yes', 'classhall-live-classes' ); ?></label>
				<label><input type="radio" name="would_book_again" value="0" <?php checked( $is_editing && 0 === $would_book_again ); ?>> <?php esc_html_e( 'No', 'classhall-live-classes' ); ?></label>
			</fieldset>
			<label><?php esc_html_e( 'Write a review', 'classhall-live-classes' ); ?><textarea name="review_text" rows="5"><?php echo esc_textarea( $booking->review_text ?? '' ); ?></textarea></label>
			<button type="submit"><?php echo esc_html( $is_editing ? __( 'Update Review', 'classhall-live-classes' ) : __( 'Submit Review', 'classhall-live-classes' ) ); ?></button>
		</form>
		<?php
		return ob_get_clean();
	}

	/**
	 * Append public class content.
	 *
	 * @param string $content Content.
	 * @return string
	 */
	public function single_class_content( $content ) {
		if ( ! is_singular( Plugin::CPT ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		global $wpdb, $post;
		$tables = Installer::tables();
		$class  = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE post_id = %d", $post->ID ) );
		if ( ! $class ) {
			return $content;
		}

		wp_enqueue_style( 'classhall-live-classes' );
		wp_enqueue_script( 'classhall-live-classes' );

		$teacher = get_user_by( 'id', $class->teacher_user_id );
		$profile = $this->teacher_profile_by_user_id( $class->teacher_user_id );
		$price   = $this->format_money_number( $class->price_minor );
		$book    = $class->product_id && function_exists( 'wc_get_cart_url' ) ? add_query_arg( 'add-to-cart', absint( $class->product_id ), wc_get_cart_url() ) : '';
		$subject = $this->clean_teacher_subject_title_label( $class->primary_subject_label );
		$class_type = $this->class_type_label( $class->class_type );

		ob_start();
		echo '<section class="chl-single-meta">';
		echo '<div class="chl-single-details">';
		echo '<p><strong>' . esc_html__( 'Subject:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $subject ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Class:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $class->class_levels ?: '-' ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Teacher:', 'classhall-live-classes' ) . '</strong> ';
		if ( $profile ) {
			echo '<a href="' . esc_url( home_url( '/live-teachers/' . $profile->teacher_slug . '/' ) ) . '">' . esc_html( $profile->display_name ) . '</a>';
			echo ' <span class="chl-teacher-inline-meta">(';
			if ( (int) $profile->is_verified ) {
				echo esc_html__( 'Verified', 'classhall-live-classes' ) . ', ';
			}
			echo esc_html( $this->format_teacher_rated_text( $profile->average_rating ) ) . ')</span>';
		} else {
			echo esc_html( $teacher ? $teacher->display_name : __( 'Classhall teacher', 'classhall-live-classes' ) );
		}
		echo '</p>';
		echo '<p><strong>' . esc_html__( 'Class type:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $class_type ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Schedule:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $this->class_schedule_summary( $class ) ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Seats remaining:', 'classhall-live-classes' ) . '</strong> ' . esc_html( max( 0, (int) $class->capacity - (int) $class->confirmed_seats ) ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Price (₦):', 'classhall-live-classes' ) . '</strong> ' . esc_html( $price ) . '</p>';
		echo '</div>';
		if ( $book && in_array( $class->status, array( Statuses::CLASS_APPROVED, Statuses::CLASS_PUBLISHED ), true ) ) {
			echo '<div class="chl-single-actions"><a class="chl-button" href="' . esc_url( $book ) . '">' . esc_html__( 'Book Now', 'classhall-live-classes' ) . '</a></div>';
		}
		$this->render_share_controls( get_permalink( $post ), get_the_title( $post ), $class, $teacher, $subject );
		$this->render_related_subject_classes( $class, $subject );
		echo '</section>';

		return $content . ob_get_clean();
	}

	/**
	 * Render public teacher profile route.
	 *
	 * @return void
	 */
	public function render_teacher_profile_route() {
		$slug = sanitize_title( get_query_var( 'classhall_live_teacher_slug' ) );
		if ( ! $slug ) {
			return;
		}

		$profile = $this->teacher_profile_by_slug( $slug );
		if ( ! $profile || Statuses::TEACHER_APPROVED !== $profile->application_status ) {
			status_header( 404 );
			nocache_headers();
			include get_query_template( '404' );
			exit;
		}

		$this->current_teacher_profile = $profile;
		$teacher_subjects              = $this->teacher_subject_labels( (int) $profile->user_id );
		wp_enqueue_style( 'classhall-live-classes' );
		status_header( 200 );
		get_header();
		remove_action( 'kleo_after_content', 'kleo_sidebar' );
		remove_action( 'kleo_after_content', 'kleo_extra_sidebar' );
		add_action( 'kleo_after_content', array( $this, 'render_empty_teacher_profile_sidebar' ) );
		get_template_part( 'page-parts/general-before-wrap' );
		echo '<main class="chl-profile">';
		echo '<section class="chl-profile-hero">';
		echo '<div class="chl-profile-photo-wrap">';
		if ( $profile->photo_id ) {
			echo wp_get_attachment_image( (int) $profile->photo_id, 'thumbnail', false, array( 'class' => 'chl-avatar' ) );
		} else {
			echo '<div class="chl-avatar chl-avatar-placeholder" aria-hidden="true">' . esc_html( $this->teacher_initials( $profile->display_name ) ) . '</div>';
		}
		if ( (int) $profile->is_verified ) {
			echo '<span class="chl-avatar-verified" aria-label="' . esc_attr__( 'Verified Classhall teacher', 'classhall-live-classes' ) . '">&#10003;</span>';
		}
		echo '</div>';
		echo '<div><h1 class="chl-profile-name">' . esc_html( $profile->display_name ) . ' ';
		echo '<span class="chl-badge ' . ( (int) $profile->is_verified ? 'chl-badge-verified' : 'chl-badge-unverified' ) . '">';
		echo esc_html( (int) $profile->is_verified ? __( 'Verified', 'classhall-live-classes' ) : __( 'Unverified', 'classhall-live-classes' ) );
		echo '</span></h1>';
		if ( ! empty( $teacher_subjects ) ) {
			echo '<p class="chl-profile-teacher-title">' . esc_html( $this->teacher_subject_title( $teacher_subjects ) ) . '</p>';
		}
		echo '<p class="chl-profile-rating">' . esc_html( $this->format_teacher_rating( $profile->average_rating ) ) . ' &middot; ' . esc_html( absint( $profile->rating_count ) ) . ' ' . esc_html__( 'reviews', 'classhall-live-classes' ) . ' &middot; ' . esc_html( absint( $profile->completed_class_count ) ) . ' ' . esc_html__( 'completed classes', 'classhall-live-classes' ) . '</p></div>';
		echo '</section>';
		echo '<div class="chl-profile-layout">';
		echo '<section class="chl-profile-body">';
		echo '<article class="chl-profile-section"><h2>' . esc_html__( 'Bio', 'classhall-live-classes' ) . '</h2>' . wp_kses_post( wpautop( $profile->bio ) ) . '</article>';
		echo '<article class="chl-profile-section"><h2>' . esc_html__( 'Qualifications', 'classhall-live-classes' ) . '</h2>' . wp_kses_post( wpautop( $profile->qualifications ) ) . '</article>';
		echo '<article class="chl-profile-section"><h2>' . esc_html__( 'Teaching Details', 'classhall-live-classes' ) . '</h2>';
		echo '<p><strong>' . esc_html__( 'Experience:', 'classhall-live-classes' ) . '</strong> ' . esc_html( absint( $profile->experience_years ) ) . ' ' . esc_html__( 'years', 'classhall-live-classes' ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Classes taught:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $profile->class_levels ?: '-' ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Exam specialisations:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $profile->exam_specialisations ?: '-' ) . '</p>';
		echo '</article>';
		echo '<article class="chl-profile-section">';
		$this->render_teacher_upcoming_classes( (int) $profile->user_id );
		echo '</article>';
		echo '<article class="chl-profile-section">';
		$this->render_teacher_reviews( (int) $profile->user_id );
		echo '</article>';
		echo '</section>';
		echo '</div></main>';
		get_template_part( 'page-parts/general-after-wrap' );
		get_footer();
		exit;
	}

	/**
	 * Render public teacher directory route.
	 *
	 * @return void
	 */
	public function render_teacher_directory_route() {
		if ( ! $this->is_teacher_directory_route() ) {
			return;
		}

		$this->is_teacher_directory = true;
		wp_enqueue_style( 'classhall-live-classes' );
		status_header( 200 );
		get_header();
		remove_action( 'kleo_after_content', 'kleo_sidebar' );
		remove_action( 'kleo_after_content', 'kleo_extra_sidebar' );
		add_action( 'kleo_after_content', array( $this, 'render_empty_teacher_profile_sidebar' ) );
		get_template_part( 'page-parts/general-before-wrap' );
		echo '<main class="chl-teacher-directory-page">';
		echo '<h1>' . esc_html__( 'Live Teachers', 'classhall-live-classes' ) . '</h1>';
		echo $this->teachers(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</main>';
		get_template_part( 'page-parts/general-after-wrap' );
		get_footer();
		exit;
	}

	/**
	 * Authorize a student before redirecting to the private meeting URL.
	 *
	 * @return void
	 */
	public function render_join_route() {
		$uuid = sanitize_text_field( get_query_var( 'classhall_live_join_uuid' ) );
		if ( ! $uuid ) {
			return;
		}

		if ( ! is_user_logged_in() ) {
			auth_redirect();
		}

		global $wpdb;
		$tables  = Installer::tables();
		$booking = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT b.*, c.post_id, c.start_at_utc, c.end_at_utc, c.meeting_url, c.status AS class_status FROM {$tables['bookings']} b INNER JOIN {$tables['classes']} c ON b.class_id = c.class_id WHERE b.booking_uuid = %s AND b.student_user_id = %d LIMIT 1",
				$uuid,
				get_current_user_id()
			)
		);

		if ( ! $booking || ! $this->can_access_meeting( $booking ) ) {
			status_header( 403 );
			wp_die( esc_html__( 'This class link is not available for your account at this time.', 'classhall-live-classes' ) );
		}

		Audit_Log::record( 'meeting_link_accessed', 'booking', absint( $booking->booking_id ) );
		wp_redirect( esc_url_raw( $booking->meeting_url ) );
		exit;
	}

	/**
	 * Output safe social metadata for public class pages.
	 *
	 * @return void
	 */
	public function class_social_meta() {
		if ( ! is_singular( Plugin::CPT ) ) {
			return;
		}

		global $wpdb, $post;
		$tables = Installer::tables();
		$class  = $wpdb->get_row( $wpdb->prepare( "SELECT class_id, teacher_user_id, primary_subject_label, start_at_utc, price_minor, currency FROM {$tables['classes']} WHERE post_id = %d", $post->ID ) );
		if ( ! $class ) {
			return;
		}

		$teacher      = get_user_by( 'id', $class->teacher_user_id );
		$profile      = $this->teacher_profile_by_user_id( $class->teacher_user_id );
		$subject      = $this->clean_teacher_subject_title_label( $class->primary_subject_label );
		$teacher_name = $profile ? $profile->display_name : ( $teacher ? $teacher->display_name : __( 'a verified teacher', 'classhall-live-classes' ) );
		$title        = $this->format_class_share_text( $subject, $teacher_name );
		$summary      = $title;
		$image        = $profile && $profile->photo_id ? wp_get_attachment_image_url( (int) $profile->photo_id, 'large' ) : '';
		$image        = $image ?: get_the_post_thumbnail_url( $post, 'large' );

		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta property="og:description" content="' . esc_attr( $summary ) . '">' . "\n";
		echo '<meta property="og:type" content="website">' . "\n";
		echo '<meta property="og:url" content="' . esc_url( get_permalink( $post ) ) . '">' . "\n";
		echo '<meta name="twitter:card" content="' . esc_attr( $image ? 'summary_large_image' : 'summary' ) . '">' . "\n";
		echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
		echo '<meta name="twitter:description" content="' . esc_attr( $summary ) . '">' . "\n";
		if ( $image ) {
			echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
			echo '<meta name="twitter:image" content="' . esc_url( $image ) . '">' . "\n";
		}
	}

	/**
	 * Handle teacher application.
	 *
	 * @return string
	 */
	private function handle_teacher_application() {
		if ( empty( $_POST['classhall_live_action'] ) || 'teacher_application' !== $_POST['classhall_live_action'] ) {
			return '';
		}

		if ( ! isset( $_POST['classhall_live_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['classhall_live_nonce'] ) ), 'classhall_live_teacher_application' ) ) {
			return __( 'We could not verify your application. Please try again.', 'classhall-live-classes' );
		}

		if ( empty( $_POST['terms'] ) ) {
			return __( 'Please accept the live-class teacher terms and conditions before submitting your application.', 'classhall-live-classes' );
		}

		global $wpdb;
		$tables  = Installer::tables();
		$user_id = get_current_user_id();
		$now     = current_time( 'mysql', true );
		$name    = sanitize_text_field( wp_unslash( $_POST['display_name'] ?? '' ) );
		$bank_name      = sanitize_text_field( wp_unslash( $_POST['bank_name'] ?? '' ) );
		$account_name   = sanitize_text_field( wp_unslash( $_POST['account_name'] ?? '' ) );
		$account_number = preg_replace( '/[^0-9]/', '', sanitize_text_field( wp_unslash( $_POST['account_number'] ?? '' ) ) );

		if ( '' === $bank_name || '' === $account_name || '' === $account_number ) {
			return __( 'Please provide your bank name, account name, and account number.', 'classhall-live-classes' );
		}

		$row = array(
			'user_id'                => $user_id,
			'teacher_slug'           => sanitize_title( $name . '-' . wp_hash( (string) $user_id ) ),
			'display_name'           => $name,
			'bio'                    => wp_kses_post( wp_unslash( $_POST['bio'] ?? '' ) ),
			'qualifications'         => wp_kses_post( wp_unslash( $_POST['qualifications'] ?? '' ) ),
			'experience_years'       => absint( $_POST['experience_years'] ?? 0 ),
			'class_levels'           => $this->sanitize_class_levels( $_POST['class_levels'] ?? array() ),
			'exam_specialisations'   => sanitize_text_field( wp_unslash( $_POST['exam_specialisations'] ?? '' ) ),
			'preferred_formats'      => sanitize_text_field( wp_unslash( $_POST['preferred_formats'] ?? '' ) ),
			'bank_name'              => $bank_name,
			'account_name'           => $account_name,
			'account_number'         => $account_number,
			'terms_accepted_at'      => $now,
			'application_status'     => Statuses::TEACHER_SUBMITTED,
			'created_at'             => $now,
			'updated_at'             => $now,
		);

		$existing = $wpdb->get_var( $wpdb->prepare( "SELECT profile_id FROM {$tables['teacher_profiles']} WHERE user_id = %d", $user_id ) );
		if ( $existing ) {
			unset( $row['created_at'], $row['teacher_slug'] );
			$wpdb->update( $tables['teacher_profiles'], $row, array( 'profile_id' => absint( $existing ) ) );
		} else {
			$wpdb->insert( $tables['teacher_profiles'], $row );
		}

		Audit_Log::record( 'teacher_application_submitted', 'teacher_profile', $existing ? absint( $existing ) : absint( $wpdb->insert_id ) );
		do_action( 'classhall_live_teacher_application_submitted', $user_id );

		return __( 'Your application has been submitted for review.', 'classhall-live-classes' );
	}

	/**
	 * Teacher terms page URL.
	 *
	 * @return string
	 */
	private function teacher_terms_url() {
		return apply_filters( 'classhall_live_teacher_terms_url', home_url( '/live-class-teacher-terms/' ) );
	}

	/**
	 * Handle class creation.
	 *
	 * @return string
	 */
	private function handle_class_submission() {
		if ( empty( $_POST['classhall_live_action'] ) || 'class_submission' !== $_POST['classhall_live_action'] ) {
			return '';
		}

		if ( ! isset( $_POST['classhall_live_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['classhall_live_nonce'] ) ), 'classhall_live_class_submission' ) ) {
			return __( 'We could not verify your class submission. Please try again.', 'classhall-live-classes' );
		}

		if ( ! current_user_can( Capabilities::CREATE_CLASSES ) ) {
			return __( 'You are not allowed to create live classes.', 'classhall-live-classes' );
		}

		$title   = sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) );
		$content = wp_kses_post( wp_unslash( $_POST['description'] ?? '' ) );
		if ( '' === $title ) {
			return __( 'Class title is required.', 'classhall-live-classes' );
		}

		$fingerprint = $this->class_submission_fingerprint();
		$lock_key    = 'classhall_live_class_submit_' . get_current_user_id() . '_' . $fingerprint;
		if ( get_transient( $lock_key ) ) {
			return __( 'This class submission is already being processed. Please wait a moment before trying again.', 'classhall-live-classes' );
		}
		set_transient( $lock_key, 1, MINUTE_IN_SECONDS );

		$subject_selection = sanitize_text_field( wp_unslash( $_POST['subject_selection'] ?? '' ) );
		$subject_parts     = explode( ':', $subject_selection, 2 );
		$subject_type      = $subject_parts[0] ?? '';
		$subject_value     = $subject_parts[1] ?? '';
		$course_id         = 'course' === $subject_type ? absint( $subject_value ) : 0;
		$subject_key       = 'course' === $subject_type && $course_id ? 'course-' . $course_id : sanitize_key( $subject_value );
		$subject_label     = 'course' === $subject_type && $course_id ? get_the_title( $course_id ) : $this->subjects->subject_label( $subject_key );
		if ( empty( $subject_key ) || empty( $subject_label ) ) {
			delete_transient( $lock_key );
			return __( 'Please select a subject.', 'classhall-live-classes' );
		}

		global $wpdb;
		$tables      = Installer::tables();
		$capacity    = max( 1, absint( $_POST['capacity'] ?? 1 ) );
		$class_type  = sanitize_key( $_POST['class_type'] ?? 'group' );
		if ( 'one_on_one' === $class_type ) {
			$capacity = 1;
		}

		$price_minor = $this->decimal_to_minor( sanitize_text_field( wp_unslash( $_POST['price'] ?? '0' ) ) );
		$now         = current_time( 'mysql', true );
		$start       = $this->local_datetime_to_utc( sanitize_text_field( wp_unslash( $_POST['start_at'] ?? '' ) ) );
		$duration    = max( 15, absint( $_POST['duration_minutes'] ?? 60 ) );
		if ( ! $start ) {
			delete_transient( $lock_key );
			return __( 'Please select a valid start date and time.', 'classhall-live-classes' );
		}

		$recurrence_type = sanitize_key( $_POST['recurrence_type'] ?? 'one_time' );
		$recurrence_days = isset( $_POST['recurrence_days'] ) && is_array( $_POST['recurrence_days'] ) ? array_map( 'absint', wp_unslash( $_POST['recurrence_days'] ) ) : array();
		$starts          = $this->recurring_class_start_times( $start, $recurrence_type, $recurrence_days );
		if ( empty( $starts ) ) {
			delete_transient( $lock_key );
			return __( 'Please select at least one day for recurring classes.', 'classhall-live-classes' );
		}

		$class_level_key = sanitize_key( $_POST['class_levels'] ?? '' );
		$class_levels    = $this->class_level_options();
		$class_level     = isset( $class_levels[ $class_level_key ] ) ? $class_levels[ $class_level_key ] : $class_level_key;
		$post_excerpt    = sanitize_text_field( wp_unslash( $_POST['summary'] ?? '' ) );

		$post_id = wp_insert_post(
			array(
				'post_type'    => Plugin::CPT,
				'post_title'   => $title,
				'post_content' => $content,
				'post_excerpt' => $post_excerpt,
				'post_status'  => 'draft',
				'post_author'  => get_current_user_id(),
			),
			true
		);

		if ( is_wp_error( $post_id ) ) {
			delete_transient( $lock_key );
			return $post_id->get_error_message();
		}

		$first_start = reset( $starts );
		$last_start  = end( $starts );
		$last_end    = gmdate( 'Y-m-d H:i:s', strtotime( $last_start ) + ( $duration * MINUTE_IN_SECONDS ) );

		$inserted = $wpdb->insert(
			$tables['classes'],
			array(
				'post_id'               => $post_id,
				'teacher_user_id'       => get_current_user_id(),
				'primary_subject_key'   => $subject_key,
				'primary_subject_label' => $subject_label,
				'class_levels'          => $class_level,
				'course_id'             => $course_id,
				'exam_key'              => sanitize_key( $_POST['exam_key'] ?? '' ),
				'class_type'            => $class_type,
				'delivery_platform'     => sanitize_key( $_POST['delivery_platform'] ?? 'google_meet' ),
				'meeting_url'           => esc_url_raw( wp_unslash( $_POST['meeting_url'] ?? '' ) ),
				'start_at_utc'          => $first_start,
				'end_at_utc'            => $last_end,
				'duration_minutes'      => $duration,
				'capacity'              => $capacity,
				'price_minor'           => $price_minor,
				'currency'              => strtoupper( sanitize_text_field( Plugin::settings()['currency'] ) ),
				'booking_closes_at_utc' => $first_start,
				'cancellation_policy'   => '',
				'status'                => Statuses::CLASS_SUBMITTED,
				'created_at'            => $now,
				'updated_at'            => $now,
			)
		);

		if ( ! $inserted ) {
			wp_delete_post( $post_id, true );
			delete_transient( $lock_key );
			return __( 'The class could not be saved. Please try again.', 'classhall-live-classes' );
		}

		$class_id = absint( $wpdb->insert_id );
		update_post_meta( $post_id, '_classhall_live_recurrence_type', $recurrence_type );
		update_post_meta( $post_id, '_classhall_live_session_count', count( $starts ) );

		foreach ( $starts as $session_start ) {
			$session_end = gmdate( 'Y-m-d H:i:s', strtotime( $session_start ) + ( $duration * MINUTE_IN_SECONDS ) );
			$session_inserted = $wpdb->insert(
				$tables['sessions'],
				array(
					'class_id'        => $class_id,
					'start_at_utc'    => $session_start,
					'end_at_utc'      => $session_end,
					'capacity'        => $capacity,
					'confirmed_seats' => 0,
					'status'          => 'available',
					'created_at'      => $now,
					'updated_at'      => $now,
				)
			);

			if ( ! $session_inserted ) {
				$wpdb->delete( $tables['classes'], array( 'class_id' => $class_id ), array( '%d' ) );
				$wpdb->delete( $tables['sessions'], array( 'class_id' => $class_id ), array( '%d' ) );
				wp_delete_post( $post_id, true );
				delete_transient( $lock_key );
				return __( 'The class schedule could not be saved. Please try again.', 'classhall-live-classes' );
			}
		}

		Audit_Log::record( 'class_submitted', 'live_class', $class_id );
		do_action( 'classhall_live_class_submitted', $class_id, $post_id );

		wp_safe_redirect(
			add_query_arg(
				'classhall_live_message',
				__( 'Your live class has been submitted for approval.', 'classhall-live-classes' ),
				remove_query_arg( 'classhall_live_message' )
			)
		);
		exit;
	}

	/**
	 * Handle teacher marking a class as held.
	 *
	 * @return string
	 */
	private function handle_class_held_submission() {
		if ( empty( $_POST['classhall_live_action'] ) || 'mark_class_held' !== $_POST['classhall_live_action'] ) {
			return '';
		}

		if ( ! isset( $_POST['classhall_live_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['classhall_live_nonce'] ) ), 'classhall_live_mark_class_held' ) ) {
			return __( 'We could not verify the class completion request. Please try again.', 'classhall-live-classes' );
		}

		if ( ! current_user_can( Capabilities::EDIT_OWN_CLASSES ) ) {
			return __( 'You are not allowed to update this live class.', 'classhall-live-classes' );
		}

		global $wpdb;
		$tables   = Installer::tables();
		$class_id = absint( $_POST['class_id'] ?? 0 );
		$class    = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$tables['classes']} WHERE class_id = %d AND teacher_user_id = %d AND deleted_at IS NULL",
				$class_id,
				get_current_user_id()
			)
		);

		if ( ! $class ) {
			return __( 'The class could not be found for your account.', 'classhall-live-classes' );
		}

		if ( ! $this->can_mark_class_held( $class ) ) {
			return __( 'This class can only be marked as held after its scheduled end time.', 'classhall-live-classes' );
		}

		$result = Class_Completion::complete( $class_id, 'teacher' );
		if ( is_wp_error( $result ) ) {
			return $result->get_error_message();
		}

		return __( 'Class marked as held. Confirmed student bookings can now be reviewed, and unpaid earnings are ready for payout.', 'classhall-live-classes' );
	}

	/**
	 * Handle a student confirming that their booked class held.
	 *
	 * @return string
	 */
	private function handle_student_class_held_submission() {
		if ( empty( $_POST['classhall_live_action'] ) || 'student_confirm_class_held' !== $_POST['classhall_live_action'] ) {
			return '';
		}

		if ( ! isset( $_POST['classhall_live_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['classhall_live_nonce'] ) ), 'classhall_live_student_confirm_class_held' ) ) {
			return __( 'We could not verify the class confirmation request. Please try again.', 'classhall-live-classes' );
		}

		global $wpdb;
		$tables     = Installer::tables();
		$booking_id = absint( $_POST['booking_id'] ?? 0 );
		$booking    = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT b.*, c.end_at_utc, c.teacher_user_id AS class_teacher_user_id
				FROM {$tables['bookings']} b
				INNER JOIN {$tables['classes']} c ON b.class_id = c.class_id
				WHERE b.booking_id = %d AND b.student_user_id = %d
				LIMIT 1",
				$booking_id,
				get_current_user_id()
			)
		);

		if ( ! $booking || Statuses::BOOKING_CONFIRMED !== $booking->status || 'paid' !== $booking->payment_status ) {
			return __( 'Only confirmed paid bookings can be marked as held.', 'classhall-live-classes' );
		}

		if ( ! $this->booking_has_ended( $booking ) ) {
			return __( 'You can confirm this class after its scheduled end time.', 'classhall-live-classes' );
		}

		$now = current_time( 'mysql', true );
		$wpdb->update(
			$tables['bookings'],
			array(
				'status'       => Statuses::BOOKING_COMPLETED,
				'completed_at' => $now,
				'updated_at'   => $now,
			),
			array( 'booking_id' => $booking_id ),
			array( '%s', '%s', '%s' ),
			array( '%d' )
		);
		$wpdb->update(
			$tables['earnings'],
			array(
				'earning_status' => 'eligible',
				'updated_at'     => $now,
			),
			array(
				'booking_id'    => $booking_id,
				'payout_status' => 'unpaid',
			),
			array( '%s', '%s' ),
			array( '%d', '%s' )
		);

		$this->maybe_complete_class_after_student_confirmation( (int) $booking->class_id );
		Audit_Log::record( 'student_confirmed_class_held', 'booking', $booking_id, Statuses::BOOKING_CONFIRMED, Statuses::BOOKING_COMPLETED );

		return __( 'Thanks. Your booking is now marked completed and you can review the class.', 'classhall-live-classes' );
	}

	/**
	 * Handle review submission.
	 *
	 * @return string
	 */
	private function handle_review_submission() {
		if ( empty( $_POST['classhall_live_action'] ) || 'review' !== $_POST['classhall_live_action'] ) {
			return '';
		}

		if ( ! isset( $_POST['classhall_live_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['classhall_live_nonce'] ) ), 'classhall_live_review' ) ) {
			return __( 'We could not verify your review. Please try again.', 'classhall-live-classes' );
		}

		global $wpdb;
		$tables     = Installer::tables();
		$booking_id = absint( $_POST['booking_id'] ?? 0 );
		$booking    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['bookings']} WHERE booking_id = %d AND student_user_id = %d", $booking_id, get_current_user_id() ) );
		if ( ! $booking || Statuses::BOOKING_COMPLETED !== $booking->status ) {
			return __( 'Only completed paid bookings can be reviewed.', 'classhall-live-classes' );
		}

		$class                = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE class_id = %d", $booking->class_id ) );
		$teaching_quality_rating = $this->rating( 'teaching_quality_rating' );
		$clarity_rating       = $teaching_quality_rating;
		$knowledge_rating     = $teaching_quality_rating;
		$punctuality_rating   = $this->rating( 'punctuality_rating' );
		$communication_rating = $teaching_quality_rating;
		$overall_rating       = round( ( $teaching_quality_rating + $punctuality_rating ) / 2, 1 );
		$understanding_improved = $teaching_quality_rating >= 4 ? 'significantly' : ( $teaching_quality_rating >= 3 ? 'somewhat' : 'not_really' );
		$now                  = current_time( 'mysql', true );
		$review_row           = array(
			'student_user_id'        => get_current_user_id(),
			'teacher_user_id'        => $booking->teacher_user_id,
			'class_id'               => $booking->class_id,
			'subject_key'            => $class ? $class->primary_subject_key : '',
			'overall_rating'         => $overall_rating,
			'clarity_rating'         => $clarity_rating,
			'knowledge_rating'       => $knowledge_rating,
			'punctuality_rating'     => $punctuality_rating,
			'communication_rating'   => $communication_rating,
			'understanding_improved' => $understanding_improved,
			'would_book_again'       => empty( $_POST['would_book_again'] ) ? 0 : 1,
			'review_text'            => wp_kses_post( wp_unslash( $_POST['review_text'] ?? '' ) ),
			'status'                 => Plugin::settings()['review_moderation'] ? Statuses::REVIEW_PENDING : Statuses::REVIEW_APPROVED,
			'updated_at'             => $now,
		);
		$existing_review_id   = $this->booking_review_id( $booking_id );

		if ( $existing_review_id ) {
			$wpdb->update( $tables['reviews'], $review_row, array( 'review_id' => $existing_review_id ) );
			$review_id = $existing_review_id;
		} else {
			$review_row['booking_id']      = $booking_id;
			$review_row['created_at']      = $now;
			$wpdb->insert( $tables['reviews'], $review_row );
			$review_id = absint( $wpdb->insert_id );
		}

		if ( $wpdb->last_error ) {
			return __( 'We could not save your review. Please try again.', 'classhall-live-classes' );
		}

		Audit_Log::record( $existing_review_id ? 'review_updated' : 'review_submitted', 'review', $review_id );
		do_action( 'classhall_live_review_submitted', $review_id );
		$this->recalculate_teacher_rating( (int) $booking->teacher_user_id );

		return $existing_review_id ? __( 'Your review has been updated.', 'classhall-live-classes' ) : __( 'Thank you. Your review has been submitted.', 'classhall-live-classes' );
	}

	/**
	 * Render class submission form.
	 *
	 * @return void
	 */
	private function render_class_form() {
		?>
		<form class="chl-form" method="post">
			<?php wp_nonce_field( 'classhall_live_class_submission', 'classhall_live_nonce' ); ?>
			<input type="hidden" name="classhall_live_action" value="class_submission">
			<label><?php esc_html_e( 'Class title', 'classhall-live-classes' ); ?><input name="title" required></label>
			<label><?php esc_html_e( 'Short summary', 'classhall-live-classes' ); ?><input name="summary"></label>
			<label><?php esc_html_e( 'Full description', 'classhall-live-classes' ); ?><textarea name="description" rows="5"></textarea></label>
			<label><?php esc_html_e( 'Class', 'classhall-live-classes' ); ?><select name="class_levels" data-chl-class-level required><?php foreach ( $this->class_level_options() as $key => $label ) : ?><option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></option><?php endforeach; ?></select></label>
			<label><?php esc_html_e( 'Subject', 'classhall-live-classes' ); ?><select name="subject_selection" data-chl-subject required><option value=""><?php esc_html_e( 'Select subject', 'classhall-live-classes' ); ?></option><?php foreach ( $this->subject_options() as $value => $subject ) : ?><option value="<?php echo esc_attr( $value ); ?>" data-class-levels="<?php echo esc_attr( implode( ',', $subject['class_levels'] ) ); ?>" data-subject-source="<?php echo esc_attr( $subject['source'] ); ?>"><?php echo esc_html( $subject['label'] ); ?></option><?php endforeach; ?></select><span class="chl-field-help" data-chl-subject-empty hidden><?php esc_html_e( 'No subjects are mapped to this class yet.', 'classhall-live-classes' ); ?></span></label>
			<label><?php esc_html_e( 'Class type', 'classhall-live-classes' ); ?><select name="class_type" data-chl-class-type><option value="one_on_one" selected><?php esc_html_e( 'One-on-one', 'classhall-live-classes' ); ?></option><option value="group"><?php esc_html_e( 'Group', 'classhall-live-classes' ); ?></option></select></label>
			<label><?php esc_html_e( 'Delivery platform', 'classhall-live-classes' ); ?><select name="delivery_platform" data-chl-platform><option value="google_meet">Google Meet</option><option value="zoom">Zoom</option><option value="microsoft_teams">Microsoft Teams</option><option value="other"><?php esc_html_e( 'Other', 'classhall-live-classes' ); ?></option></select></label>
			<label><?php esc_html_e( 'Private meeting URL', 'classhall-live-classes' ); ?><input name="meeting_url" type="url" required></label>
			<p class="chl-field-help chl-platform-help" data-chl-platform-help>
				<?php esc_html_e( 'Create a meeting link in your selected platform, copy it, and paste it in the Private meeting URL field.', 'classhall-live-classes' ); ?>
				<a data-chl-platform-link href="https://meet.google.com/new" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Open Google Meet', 'classhall-live-classes' ); ?></a>
			</p>
			<label><?php esc_html_e( 'Start date and time', 'classhall-live-classes' ); ?><input name="start_at" type="datetime-local" required></label>
			<fieldset class="chl-fieldset" data-chl-recurrence-wrap>
				<legend><?php esc_html_e( 'Class schedule', 'classhall-live-classes' ); ?></legend>
				<label><input type="radio" name="recurrence_type" value="one_time" data-chl-recurrence checked> <?php esc_html_e( 'One time', 'classhall-live-classes' ); ?></label>
				<label><input type="radio" name="recurrence_type" value="weekly" data-chl-recurrence> <?php esc_html_e( 'Weekly for 1 month', 'classhall-live-classes' ); ?></label>
				<label><input type="radio" name="recurrence_type" value="multiple_days" data-chl-recurrence> <?php esc_html_e( 'Multiple days per week for 1 month', 'classhall-live-classes' ); ?></label>
				<div class="chl-recurring-days" data-chl-recurring-days hidden>
					<span><?php esc_html_e( 'Select days', 'classhall-live-classes' ); ?></span>
					<label><input type="checkbox" name="recurrence_days[]" value="1"> <?php esc_html_e( 'Mon', 'classhall-live-classes' ); ?></label>
					<label><input type="checkbox" name="recurrence_days[]" value="2"> <?php esc_html_e( 'Tue', 'classhall-live-classes' ); ?></label>
					<label><input type="checkbox" name="recurrence_days[]" value="3"> <?php esc_html_e( 'Wed', 'classhall-live-classes' ); ?></label>
					<label><input type="checkbox" name="recurrence_days[]" value="4"> <?php esc_html_e( 'Thu', 'classhall-live-classes' ); ?></label>
					<label><input type="checkbox" name="recurrence_days[]" value="5"> <?php esc_html_e( 'Fri', 'classhall-live-classes' ); ?></label>
					<label><input type="checkbox" name="recurrence_days[]" value="6"> <?php esc_html_e( 'Sat', 'classhall-live-classes' ); ?></label>
					<label><input type="checkbox" name="recurrence_days[]" value="7"> <?php esc_html_e( 'Sun', 'classhall-live-classes' ); ?></label>
				</div>
				<p class="chl-field-help"><?php esc_html_e( 'Recurring classes are shown as one class with multiple session dates for one month.', 'classhall-live-classes' ); ?></p>
			</fieldset>
			<label><?php esc_html_e( 'Duration (in minutes)', 'classhall-live-classes' ); ?><input name="duration_minutes" type="number" min="15" step="15" value="60"></label>
			<label data-chl-capacity-field hidden style="display:none"><?php esc_html_e( 'Seats available', 'classhall-live-classes' ); ?><input name="capacity" type="number" min="1" step="1" value="1" disabled></label>
			<label><?php echo esc_html__( 'Price', 'classhall-live-classes' ) . ' (&#8358;)'; ?><input name="price" type="number" min="0" step="0.01" required><span class="chl-field-help"><?php esc_html_e( 'For recurring classes, this is the price for the 1-month class series.', 'classhall-live-classes' ); ?></span></label>
			<button type="submit"><?php esc_html_e( 'Submit for Approval', 'classhall-live-classes' ); ?></button>
		</form>
		<?php
	}

	/**
	 * Class-level dropdown options for live-class creation.
	 *
	 * @return array
	 */
	private function class_level_options() {
		return array(
			'jss-1'     => __( 'JSS1', 'classhall-live-classes' ),
			'jss-2'     => __( 'JSS2', 'classhall-live-classes' ),
			'jss-3'     => __( 'JSS3', 'classhall-live-classes' ),
			'ss-1'      => __( 'SS1', 'classhall-live-classes' ),
			'ss-2'      => __( 'SS2', 'classhall-live-classes' ),
			'ss-3'      => __( 'SS3', 'classhall-live-classes' ),
		);
	}

	/**
	 * Resolve the current user's Classhall signup role.
	 *
	 * @return string
	 */
	private function current_user_role_context() {
		if ( ! is_user_logged_in() ) {
			return '';
		}

		$raw  = (string) get_user_meta( get_current_user_id(), 'role_of_user', true );
		$role = sanitize_key( str_replace( ' ', '_', strtolower( trim( $raw ) ) ) );

		if ( false !== strpos( $role, 'teacher' ) ) {
			return 'teacher';
		}

		if ( false !== strpos( $role, 'parent' ) ) {
			return 'parent';
		}

		if ( false !== strpos( $role, 'student' ) ) {
			return 'student';
		}

		if ( false !== strpos( $role, 'school_owner' ) ) {
			return 'school_owner';
		}

		if ( false !== strpos( $role, 'school_admin' ) ) {
			return 'school_admin';
		}

		return '';
	}

	/**
	 * Subject dropdown options.
	 *
	 * @return array
	 */
	private function subject_options() {
		$options = array();

		foreach ( $this->subjects->courses() as $id => $title ) {
			if ( ! $this->is_main_subject_label( $title ) ) {
				continue;
			}

			$class_levels = $this->subjects->course_class_levels( $id );
			$options[ 'course:' . absint( $id ) ] = array(
				'label'        => $this->clean_subject_label( $title, $class_levels ),
				'class_levels' => $class_levels,
				'source'       => 'course',
			);
		}

		if ( empty( $options ) ) {
			foreach ( $this->subjects->subjects() as $key => $label ) {
				if ( ! $this->is_main_subject_label( $label ) ) {
					continue;
				}

				$options[ 'subject:' . sanitize_key( $key ) ] = array(
					'label'        => $this->clean_subject_label( $label ),
					'class_levels' => array(),
					'source'       => 'subject',
				);
			}
		}

		uasort(
			$options,
			static function( $a, $b ) {
				return strcasecmp( $a['label'], $b['label'] );
			}
		);

		return $options;
	}

	/**
	 * Sanitize selected class levels from the teacher application form.
	 *
	 * @param mixed $raw Raw POST value.
	 * @return string
	 */
	private function sanitize_class_levels( $raw ) {
		$raw     = is_array( $raw ) ? $raw : array( $raw );
		$allowed = array_values( $this->class_level_options() );
		$levels  = array();

		foreach ( $raw as $value ) {
			$value = sanitize_text_field( wp_unslash( $value ) );
			if ( in_array( $value, $allowed, true ) ) {
				$levels[] = $value;
			}
		}

		return implode( ', ', array_unique( $levels ) );
	}

	/**
	 * Determine whether a course/category label is a main subject.
	 *
	 * @param string $label Raw label.
	 * @return bool
	 */
	private function is_main_subject_label( $label ) {
		$original = (string) $label;
		$blocked = array(
			'assessment',
			'continuous assessment',
			'continuous assessment test',
			'cat',
			'examination',
			'examinations',
			'exam',
			'exams',
			'mock',
			'quiz',
			'quizzes',
			'test',
			'tests',
			'past question',
			'past questions',
			'question bank',
		);
		$label = strtolower( $original );

		foreach ( $blocked as $word ) {
			if ( preg_match( '/\b' . preg_quote( $word, '/' ) . '\b/', $label ) ) {
				return false;
			}
		}

		return (bool) apply_filters( 'classhall_live_is_main_subject_label', true, $original );
	}

	/**
	 * Remove class-level text from subject labels shown in the form.
	 *
	 * @param string $label Subject label.
	 * @param array  $class_levels Matched class levels.
	 * @return string
	 */
	private function clean_subject_label( $label, $class_levels = array() ) {
		$clean = (string) $label;
		$map   = array_merge(
			array(
				'primary-1' => __( 'Primary 1', 'classhall-live-classes' ),
				'primary-2' => __( 'Primary 2', 'classhall-live-classes' ),
				'primary-3' => __( 'Primary 3', 'classhall-live-classes' ),
				'primary-4' => __( 'Primary 4', 'classhall-live-classes' ),
				'primary-5' => __( 'Primary 5', 'classhall-live-classes' ),
				'primary-6' => __( 'Primary 6', 'classhall-live-classes' ),
			),
			$this->class_level_options()
		);

		foreach ( array_keys( $map ) as $key ) {
			$parts = explode( '-', $key, 2 );
			$num   = $parts[1] ?? '';
			if ( 'primary' === $parts[0] ) {
				$clean = preg_replace( '/\bprimary[\s-]*' . preg_quote( $num, '/' ) . '\b/i', '', $clean );
				$clean = preg_replace( '/\bpry[\s-]*' . preg_quote( $num, '/' ) . '\b/i', '', $clean );
			} elseif ( 'jss' === $parts[0] ) {
				$clean = preg_replace( '/\bjss[\s-]*' . preg_quote( $num, '/' ) . '\b/i', '', $clean );
				$clean = preg_replace( '/\bjunior[\s-]*secondary[\s-]*' . preg_quote( $num, '/' ) . '\b/i', '', $clean );
				$upper_basic = (string) ( (int) $num + 6 );
				$clean       = preg_replace( '/\bupper[\s-]*basic[\s-]*' . preg_quote( $upper_basic, '/' ) . '\b/i', '', $clean );
			} elseif ( 'ss' === $parts[0] ) {
				$clean = preg_replace( '/\bss[\s-]*' . preg_quote( $num, '/' ) . '\b/i', '', $clean );
				$clean = preg_replace( '/\bsss[\s-]*' . preg_quote( $num, '/' ) . '\b/i', '', $clean );
				$clean = preg_replace( '/\bsenior[\s-]*secondary[\s-]*' . preg_quote( $num, '/' ) . '\b/i', '', $clean );
			}
		}

		$clean = preg_replace( '/\bupper[\s-]*basic\b/i', '', $clean );
		$clean = preg_replace( '/\bbasic[\s-]*education\b/i', '', $clean );
		$clean = preg_replace( '/\bclass[\s-]*\d+\b/i', '', $clean );
		$clean = preg_replace( '/\bgrade[\s-]*\d+\b/i', '', $clean );
		$clean = preg_replace( '/\(\s*\)/', '', $clean );
		$clean = preg_replace( '/[\x{00A0}\s]*[-\x{2010}-\x{2015}\x{2212}]+[\x{00A0}\s]*(?:\(\s*\))?[\x{00A0}\s]*$/u', '', $clean );
		$clean = preg_replace( '/[\x{2010}-\x{2015}\x{2212}]/u', '-', $clean );
		$clean = trim( preg_replace( '/\s+/', ' ', $clean ) );
		$clean = preg_replace( '/\s*[-|:]+\s*$/', '', $clean );
		$clean = preg_replace( '/^\s*[-|:]+\s*/', '', $clean );
		$clean = trim( preg_replace( '/\s+/', ' ', str_replace( array( '-', '|', ':' ), ' ', $clean ) ) );
		$clean = $this->subject_title_case( $clean );

		return '' === $clean ? (string) $label : apply_filters( 'classhall_live_subject_display_label', $clean, $label, $class_levels );
	}

	/**
	 * Normalise subject title case while preserving common acronyms.
	 *
	 * @param string $label Subject label.
	 * @return string
	 */
	private function subject_title_case( $label ) {
		$lower = function_exists( 'mb_strtolower' ) ? mb_strtolower( $label, 'UTF-8' ) : strtolower( $label );
		$title = function_exists( 'mb_convert_case' ) ? mb_convert_case( $lower, MB_CASE_TITLE, 'UTF-8' ) : ucwords( $lower );
		$acronyms = array( 'Crs' => 'CRS', 'Ict' => 'ICT', 'Gsm' => 'GSM', 'Irs' => 'IRS' );

		return strtr( $title, $acronyms );
	}

	/**
	 * Render teacher-owned classes.
	 *
	 * @return void
	 */
	private function render_teacher_classes() {
		global $wpdb;
		$tables = Installer::tables();
		$rows   = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE teacher_user_id = %d ORDER BY start_at_utc DESC LIMIT 50", get_current_user_id() ) );
		echo '<div class="chl-dashboard"><h2>' . esc_html__( 'Your Live Classes', 'classhall-live-classes' ) . '</h2>';
		foreach ( $rows as $row ) {
			echo '<article class="chl-card"><h3>' . esc_html( get_the_title( $row->post_id ) ) . '</h3><p>' . esc_html( $row->status ) . ' &middot; ' . esc_html( $this->class_type_label( $row->class_type ) ) . ' &middot; ' . esc_html( $this->format_utc( $row->start_at_utc ) ) . '</p><p>' . esc_html__( 'Seats sold:', 'classhall-live-classes' ) . ' ' . esc_html( $row->confirmed_seats ) . '/' . esc_html( $row->capacity ) . '</p>';
			if ( $this->can_mark_class_held( $row ) ) {
				echo '<form class="chl-inline-form" method="post">';
				wp_nonce_field( 'classhall_live_mark_class_held', 'classhall_live_nonce' );
				echo '<input type="hidden" name="classhall_live_action" value="mark_class_held"><input type="hidden" name="class_id" value="' . esc_attr( $row->class_id ) . '"><button type="submit">' . esc_html__( 'Mark as Held', 'classhall-live-classes' ) . '</button></form>';
			}
			echo '</article>';
		}
		echo '</div>';
	}

	/**
	 * Whether a teacher can mark a class as held.
	 *
	 * @param object $class Class row.
	 * @return bool
	 */
	private function can_mark_class_held( $class ) {
		if ( ! in_array( $class->status, array( Statuses::CLASS_APPROVED, Statuses::CLASS_PUBLISHED, Statuses::CLASS_FULL ), true ) ) {
			return false;
		}

		if ( empty( $class->end_at_utc ) ) {
			return false;
		}

		return time() >= strtotime( $class->end_at_utc . ' UTC' );
	}

	/**
	 * Render student class completion action.
	 *
	 * @param object $booking Booking joined with class.
	 * @return void
	 */
	private function render_student_completion_area( $booking ) {
		if ( Statuses::BOOKING_CONFIRMED !== $booking->status || 'paid' !== $booking->payment_status ) {
			return;
		}

		if ( isset( $booking->class_status ) && in_array( $booking->class_status, array( Statuses::CLASS_CANCELLED, Statuses::CLASS_REJECTED, Statuses::CLASS_SUSPENDED ), true ) ) {
			return;
		}

		if ( ! $this->booking_has_ended( $booking ) ) {
			return;
		}

		echo '<form class="chl-inline-form" method="post">';
		wp_nonce_field( 'classhall_live_student_confirm_class_held', 'classhall_live_nonce' );
		echo '<input type="hidden" name="classhall_live_action" value="student_confirm_class_held"><input type="hidden" name="booking_id" value="' . esc_attr( $booking->booking_id ) . '"><button type="submit">' . esc_html__( 'Confirm Class Held', 'classhall-live-classes' ) . '</button></form>';
	}

	/**
	 * Render completed bookings when the review page has no selected booking.
	 *
	 * @param string $message Optional submitted-review message.
	 * @return string
	 */
	private function render_review_booking_picker( $message = '' ) {
		global $wpdb;
		$tables   = Installer::tables();
		$bookings = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT b.*, c.post_id, c.primary_subject_label, c.class_levels, c.start_at_utc, c.end_at_utc, p.display_name AS teacher_profile_name, p.teacher_slug, r.review_id
				FROM {$tables['bookings']} b
				INNER JOIN {$tables['classes']} c ON b.class_id = c.class_id
				LEFT JOIN {$tables['teacher_profiles']} p ON p.user_id = b.teacher_user_id AND p.deleted_at IS NULL
				LEFT JOIN {$tables['reviews']} r ON r.booking_id = b.booking_id
				WHERE b.student_user_id = %d
					AND b.status = %s
					AND b.payment_status = 'paid'
				ORDER BY c.start_at_utc DESC
				LIMIT 25",
				get_current_user_id(),
				Statuses::BOOKING_COMPLETED
			)
		);

		ob_start();
		if ( $message ) {
			echo '<div class="chl-notice">' . esc_html( $message ) . '</div>';
		}
		if ( empty( $bookings ) ) {
			echo '<p>' . esc_html__( 'You do not have any completed classes waiting for review yet.', 'classhall-live-classes' ) . '</p>';
			return ob_get_clean();
		}

		echo '<div class="chl-dashboard">';
		echo '<h2>' . esc_html__( 'Classes Ready for Review', 'classhall-live-classes' ) . '</h2>';
		foreach ( $bookings as $booking ) {
			$teacher = get_user_by( 'id', (int) $booking->teacher_user_id );
			$teacher_name = $booking->teacher_profile_name ?: ( $teacher ? $teacher->display_name : __( 'Classhall teacher', 'classhall-live-classes' ) );
			$teacher_link = ! empty( $booking->teacher_slug ) ? home_url( '/live-teachers/' . $booking->teacher_slug . '/' ) : '';
			echo '<article class="chl-card"><h3><a href="' . esc_url( get_permalink( (int) $booking->post_id ) ) . '">' . esc_html( get_the_title( (int) $booking->post_id ) ) . '</a></h3>';
			echo '<p>' . esc_html__( 'Class held on', 'classhall-live-classes' ) . ' ' . esc_html( $this->format_utc( $booking->start_at_utc ) ) . '</p>';
			echo '<p>' . esc_html__( 'Teacher:', 'classhall-live-classes' ) . ' ';
			if ( $teacher_link ) {
				echo '<a href="' . esc_url( $teacher_link ) . '">' . esc_html( $teacher_name ) . '</a>';
			} else {
				echo esc_html( $teacher_name );
			}
			echo '</p>';
			$action_label = ! empty( $booking->review_id ) ? __( 'Update Review', 'classhall-live-classes' ) : __( 'Review class', 'classhall-live-classes' );
			echo '<p><a class="chl-button" href="' . esc_url( add_query_arg( 'booking_id', absint( $booking->booking_id ), get_permalink() ) ) . '">' . esc_html( $action_label ) . '</a></p></article>';
		}
		echo '</div>';

		return ob_get_clean();
	}

	/**
	 * Get a completed booking with class and teacher context for review.
	 *
	 * @param int $booking_id Booking ID.
	 * @return object|null
	 */
	private function reviewable_booking( $booking_id ) {
		global $wpdb;
		$tables = Installer::tables();

		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT b.*, c.post_id, c.primary_subject_label, c.class_levels, c.start_at_utc, c.end_at_utc, p.display_name AS teacher_profile_name, p.teacher_slug,
					r.review_id, r.clarity_rating AS review_teaching_quality_rating, r.punctuality_rating AS review_punctuality_rating, r.would_book_again AS review_would_book_again, r.review_text
				FROM {$tables['bookings']} b
				INNER JOIN {$tables['classes']} c ON b.class_id = c.class_id
				LEFT JOIN {$tables['teacher_profiles']} p ON p.user_id = b.teacher_user_id AND p.deleted_at IS NULL
				LEFT JOIN {$tables['reviews']} r ON r.booking_id = b.booking_id
				WHERE b.booking_id = %d
					AND b.student_user_id = %d
					AND b.status = %s
					AND b.payment_status = 'paid'
				LIMIT 1",
				absint( $booking_id ),
				get_current_user_id(),
				Statuses::BOOKING_COMPLETED
			)
		);
	}

	/**
	 * Get a booking review ID.
	 *
	 * @param int $booking_id Booking ID.
	 * @return int
	 */
	private function booking_review_id( $booking_id ) {
		global $wpdb;
		$tables = Installer::tables();

		return absint(
			$wpdb->get_var(
				$wpdb->prepare(
					"SELECT review_id FROM {$tables['reviews']} WHERE booking_id = %d LIMIT 1",
					absint( $booking_id )
				)
			)
		);
	}

	/**
	 * Check whether a booking already has a review.
	 *
	 * @param int $booking_id Booking ID.
	 * @return bool
	 */
	private function booking_has_review( $booking_id ) {
		return (bool) $this->booking_review_id( $booking_id );
	}

	/**
	 * Render class and teacher details above the review form.
	 *
	 * @param object $booking Reviewable booking.
	 * @return void
	 */
	private function render_review_context( $booking ) {
		$teacher = get_user_by( 'id', (int) $booking->teacher_user_id );
		$teacher_name = $booking->teacher_profile_name ?: ( $teacher ? $teacher->display_name : __( 'Classhall teacher', 'classhall-live-classes' ) );
		$class_title = get_the_title( (int) $booking->post_id );
		$when = $this->relative_class_time( $booking->end_at_utc ?: $booking->start_at_utc );
		$class_link = get_permalink( (int) $booking->post_id );
		$teacher_link = ! empty( $booking->teacher_slug ) ? home_url( '/live-teachers/' . $booking->teacher_slug . '/' ) : '';

		echo '<section class="chl-review-context">';
		echo '<h2>' . esc_html__( 'You attended', 'classhall-live-classes' ) . ' <a href="' . esc_url( $class_link ) . '">' . esc_html( $class_title ) . '</a> ' . esc_html__( 'taught by', 'classhall-live-classes' ) . ' ';
		if ( $teacher_link ) {
			echo '<a href="' . esc_url( $teacher_link ) . '">' . esc_html( $teacher_name ) . '</a>';
		} else {
			echo esc_html( $teacher_name );
		}
		echo ' ' . esc_html( $when ) . '.</h2>';
		echo '<p class="chl-review-question">' . esc_html__( 'How would you rate the class and teacher?', 'classhall-live-classes' ) . '</p>';
		echo '</section>';
	}

	/**
	 * Format class time as today, yesterday, or relative time.
	 *
	 * @param string|null $utc UTC datetime.
	 * @return string
	 */
	private function relative_class_time( $utc ) {
		if ( empty( $utc ) ) {
			return __( 'recently', 'classhall-live-classes' );
		}

		$timestamp = strtotime( $utc . ' UTC' );
		if ( ! $timestamp ) {
			return __( 'recently', 'classhall-live-classes' );
		}

		$class_day     = wp_date( 'Y-m-d', $timestamp );
		$today         = wp_date( 'Y-m-d' );
		$yesterday     = wp_date( 'Y-m-d', time() - DAY_IN_SECONDS );

		if ( $class_day === $today ) {
			return __( 'today', 'classhall-live-classes' );
		}

		if ( $class_day === $yesterday ) {
			return __( 'yesterday', 'classhall-live-classes' );
		}

		return sprintf(
			/* translators: %s: human-readable relative time. */
			__( '%s ago', 'classhall-live-classes' ),
			human_time_diff( $timestamp, time() )
		);
	}

	/**
	 * Render a five-star rating radio group.
	 *
	 * @param string $field Field name.
	 * @param string $label Field label.
	 * @param int    $selected Selected rating.
	 * @return void
	 */
	private function render_star_rating_field( $field, $label, $selected = 0 ) {
		echo '<fieldset class="chl-star-field"><legend>' . esc_html( $label ) . '</legend><div class="chl-star-rating">';
		for ( $rating = 5; $rating >= 1; $rating-- ) {
			$id = 'chl_' . sanitize_key( $field ) . '_' . $rating;
			echo '<input type="radio" id="' . esc_attr( $id ) . '" name="' . esc_attr( $field ) . '" value="' . esc_attr( $rating ) . '" ' . checked( $selected, $rating, false ) . ' required>';
			echo '<label for="' . esc_attr( $id ) . '" aria-label="' . esc_attr( sprintf( _n( '%d star', '%d stars', $rating, 'classhall-live-classes' ), $rating ) ) . '">&#9733;</label>';
		}
		echo '</div></fieldset>';
	}

	/**
	 * Mark the class completed after all paid confirmed bookings are completed.
	 *
	 * @param int $class_id Class ID.
	 * @return void
	 */
	private function maybe_complete_class_after_student_confirmation( $class_id ) {
		global $wpdb;
		$tables    = Installer::tables();
		$remaining = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$tables['bookings']}
				WHERE class_id = %d
					AND status = %s
					AND payment_status = 'paid'",
				absint( $class_id ),
				Statuses::BOOKING_CONFIRMED
			)
		);

		if ( 0 === $remaining ) {
			Class_Completion::complete( $class_id, 'student' );
		}
	}

	/**
	 * Whether a booking has passed its scheduled end time.
	 *
	 * @param object $booking Booking joined with class.
	 * @return bool
	 */
	private function booking_has_ended( $booking ) {
		if ( empty( $booking->end_at_utc ) ) {
			return false;
		}

		return time() >= strtotime( $booking->end_at_utc . ' UTC' );
	}

	/**
	 * Render teacher-owned earnings and payout history.
	 *
	 * @return void
	 */
	private function render_teacher_earnings() {
		if ( ! current_user_can( Capabilities::VIEW_EARNINGS ) ) {
			return;
		}

		global $wpdb;
		$tables     = Installer::tables();
		$teacher_id = get_current_user_id();
		$balances   = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT currency,
					SUM(teacher_minor) AS total_minor,
					SUM(CASE WHEN payout_status = 'unpaid' AND earning_status IN ('pending', 'eligible') THEN teacher_minor ELSE 0 END) AS unpaid_minor,
					SUM(CASE WHEN payout_status = 'processing' THEN teacher_minor ELSE 0 END) AS processing_minor,
					SUM(CASE WHEN payout_status = 'paid' THEN teacher_minor ELSE 0 END) AS paid_minor
				FROM {$tables['earnings']}
				WHERE teacher_user_id = %d
				GROUP BY currency
				ORDER BY currency ASC",
				$teacher_id
			)
		);
		$earnings   = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT e.*, c.post_id, c.primary_subject_label, c.start_at_utc
				FROM {$tables['earnings']} e
				LEFT JOIN {$tables['classes']} c ON e.class_id = c.class_id
				WHERE e.teacher_user_id = %d
				ORDER BY e.created_at DESC
				LIMIT 50",
				$teacher_id
			)
		);
		$payouts    = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT *
				FROM {$tables['payouts']}
				WHERE teacher_user_id = %d
				ORDER BY created_at DESC
				LIMIT 25",
				$teacher_id
			)
		);

		echo '<section class="chl-dashboard chl-earnings"><h2>' . esc_html__( 'Earnings & Payouts', 'classhall-live-classes' ) . '</h2>';

		if ( empty( $balances ) ) {
			echo '<p class="chl-empty">' . esc_html__( 'No earnings have been recorded yet. Earnings appear here after students pay for your classes.', 'classhall-live-classes' ) . '</p>';
			echo '</section>';
			return;
		}

		echo '<div class="chl-stat-grid">';
		foreach ( $balances as $balance ) {
			$this->render_earning_stat( __( 'Total earned', 'classhall-live-classes' ), $balance->total_minor, $balance->currency );
			$this->render_earning_stat( __( 'Pending payout', 'classhall-live-classes' ), $balance->unpaid_minor, $balance->currency );
			$this->render_earning_stat( __( 'Processing', 'classhall-live-classes' ), $balance->processing_minor, $balance->currency );
			$this->render_earning_stat( __( 'Paid out', 'classhall-live-classes' ), $balance->paid_minor, $balance->currency );
		}
		echo '</div>';

		echo '<h3>' . esc_html__( 'Earnings History', 'classhall-live-classes' ) . '</h3>';
		echo '<div class="chl-table-wrap"><table class="chl-table"><thead><tr><th>' . esc_html__( 'Class', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Booking', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Gross (₦)', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Your amount (₦)', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Status', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Date', 'classhall-live-classes' ) . '</th></tr></thead><tbody>';
		foreach ( $earnings as $earning ) {
			$class_title = get_the_title( (int) $earning->post_id ) ?: $earning->primary_subject_label;
			echo '<tr><td>' . esc_html( $class_title ) . '</td><td>#' . esc_html( (int) $earning->booking_id ) . '</td><td>' . esc_html( $this->format_money_number( $earning->gross_minor ) ) . '</td><td>' . esc_html( $this->format_money_number( $earning->teacher_minor ) ) . '</td><td>' . esc_html( $this->earning_status_label( $earning ) ) . '</td><td>' . esc_html( get_date_from_gmt( $earning->created_at ) ) . '</td></tr>';
		}
		echo '</tbody></table></div>';

		echo '<h3>' . esc_html__( 'Payout History', 'classhall-live-classes' ) . '</h3>';
		if ( empty( $payouts ) ) {
			echo '<p class="chl-empty">' . esc_html__( 'No payout batches have been created yet.', 'classhall-live-classes' ) . '</p>';
		} else {
			echo '<div class="chl-table-wrap"><table class="chl-table"><thead><tr><th>' . esc_html__( 'Payout', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Amount (₦)', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Status', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Reference', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Created', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Paid', 'classhall-live-classes' ) . '</th></tr></thead><tbody>';
			foreach ( $payouts as $payout ) {
				echo '<tr><td>#' . esc_html( (int) $payout->payout_id ) . '</td><td>' . esc_html( $this->format_money_number( $payout->amount_minor ) ) . '</td><td>' . esc_html( $this->payout_status_label( $payout->status ) ) . '</td><td>' . esc_html( $payout->reference ?: '-' ) . '</td><td>' . esc_html( get_date_from_gmt( $payout->created_at ) ) . '</td><td>' . esc_html( $payout->paid_at ? get_date_from_gmt( $payout->paid_at ) : '-' ) . '</td></tr>';
			}
			echo '</tbody></table></div>';
		}

		echo '</section>';
	}

	/**
	 * Render one earnings summary tile.
	 *
	 * @param string $label Label.
	 * @param int    $minor Minor units.
	 * @param string $currency Currency.
	 * @return void
	 */
	private function render_earning_stat( $label, $minor, $currency ) {
		unset( $currency );
		echo '<article class="chl-stat"><span>' . esc_html( $label ) . ' (₦)</span><strong>' . esc_html( $this->format_money_number( $minor ) ) . '</strong></article>';
	}

	/**
	 * Format teacher-facing earning status.
	 *
	 * @param object $earning Earning row.
	 * @return string
	 */
	private function earning_status_label( $earning ) {
		if ( 'paid' === $earning->payout_status ) {
			return __( 'Paid', 'classhall-live-classes' );
		}
		if ( 'processing' === $earning->payout_status ) {
			return __( 'Processing payout', 'classhall-live-classes' );
		}
		if ( 'reversed' === $earning->payout_status || 'reversed' === $earning->earning_status ) {
			return __( 'Reversed', 'classhall-live-classes' );
		}
		if ( 'eligible' === $earning->earning_status ) {
			return __( 'Ready for payout', 'classhall-live-classes' );
		}

		return __( 'Pending', 'classhall-live-classes' );
	}

	/**
	 * Format teacher-facing payout status.
	 *
	 * @param string $status Payout status.
	 * @return string
	 */
	private function payout_status_label( $status ) {
		$labels = array(
			'recorded' => __( 'Processing', 'classhall-live-classes' ),
			'paid'     => __( 'Paid', 'classhall-live-classes' ),
			'reversed' => __( 'Reversed', 'classhall-live-classes' ),
			'draft'    => __( 'Draft', 'classhall-live-classes' ),
		);

		return $labels[ $status ] ?? ucwords( str_replace( '_', ' ', $status ) );
	}

	/**
	 * Render public upcoming classes for a teacher.
	 *
	 * @param int $teacher_user_id Teacher user ID.
	 * @return void
	 */
	private function render_teacher_upcoming_classes( $teacher_user_id ) {
		global $wpdb;
		$tables = Installer::tables();
		$rows   = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$tables['classes']} WHERE teacher_user_id = %d AND status IN ('approved','published') AND start_at_utc >= %s AND deleted_at IS NULL ORDER BY start_at_utc ASC LIMIT 6",
				$teacher_user_id,
				current_time( 'mysql', true )
			)
		);

		echo '<h2>' . esc_html__( 'Upcoming Classes', 'classhall-live-classes' ) . '</h2>';
		if ( empty( $rows ) ) {
			echo '<p class="chl-empty">' . esc_html__( 'No upcoming classes are currently listed.', 'classhall-live-classes' ) . '</p>';
			return;
		}
		foreach ( $rows as $row ) {
			$this->render_class_card( $row );
		}
	}

	/**
	 * Render approved public reviews for a teacher.
	 *
	 * @param int $teacher_user_id Teacher user ID.
	 * @return void
	 */
	private function render_teacher_reviews( $teacher_user_id ) {
		global $wpdb;
		$tables  = Installer::tables();
		$reviews = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT overall_rating, review_text, student_user_id, created_at FROM {$tables['reviews']} WHERE teacher_user_id = %d AND status = 'approved' ORDER BY created_at DESC LIMIT 10",
				$teacher_user_id
			)
		);

		echo '<h2>' . esc_html__( 'Verified Reviews', 'classhall-live-classes' ) . '</h2>';
		if ( empty( $reviews ) ) {
			echo '<p class="chl-empty">' . esc_html__( 'No reviews yet.', 'classhall-live-classes' ) . '</p>';
			return;
		}
		foreach ( $reviews as $review ) {
			$student      = get_user_by( 'id', (int) $review->student_user_id );
			$student_name = $student ? $student->display_name : __( 'Classhall student', 'classhall-live-classes' );
			echo '<article class="chl-card"><p><strong>' . esc_html( number_format_i18n( (float) $review->overall_rating, 1 ) ) . '/5</strong> ' . esc_html( sprintf( __( 'Verified review by %s', 'classhall-live-classes' ), $student_name ) ) . '</p>';
			echo wp_kses_post( wpautop( $review->review_text ) ) . '</article>';
		}
	}

	/**
	 * Refresh the teacher aggregate rating after a review changes.
	 *
	 * @param int $teacher_user_id Teacher user ID.
	 * @return void
	 */
	private function recalculate_teacher_rating( $teacher_user_id ) {
		global $wpdb;

		$tables = Installer::tables();
		$stats  = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT COUNT(*) AS rating_count, COALESCE(AVG(overall_rating), 0) AS average_rating
				FROM {$tables['reviews']}
				WHERE teacher_user_id = %d AND status = %s",
				$teacher_user_id,
				Statuses::REVIEW_APPROVED
			)
		);

		$average = round( (float) ( $stats->average_rating ?? 0 ), 2 );
		$count   = absint( $stats->rating_count ?? 0 );
		$profile = $wpdb->get_row( $wpdb->prepare( "SELECT completed_class_count, is_verified FROM {$tables['teacher_profiles']} WHERE user_id = %d", $teacher_user_id ) );
		$ranking = new Ranking_Service();
		$score   = $ranking->score( $average, $count, absint( $profile->completed_class_count ?? 0 ), 0, ! empty( $profile->is_verified ), 0 );

		$wpdb->update(
			$tables['teacher_profiles'],
			array(
				'average_rating' => $average,
				'rating_count'   => $count,
				'ranking_score'  => $score,
				'updated_at'     => current_time( 'mysql', true ),
			),
			array( 'user_id' => $teacher_user_id )
		);
	}

	/**
	 * Query public classes.
	 *
	 * @param string $subject Subject filter.
	 * @param int    $limit Limit.
	 * @return array
	 */
	private function query_classes( $subject, $limit ) {
		global $wpdb;

		$tables = Installer::tables();
		$limit  = min( 50, max( 1, $limit ) );
		$search = sanitize_text_field( wp_unslash( $_GET['live_class_search'] ?? '' ) );

		if ( $subject ) {
			return $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$tables['classes']} WHERE status IN ('approved','published') AND primary_subject_key = %s AND deleted_at IS NULL ORDER BY start_at_utc ASC LIMIT %d",
					$subject,
					$limit
				)
			);
		}

		if ( $search ) {
			return $wpdb->get_results(
				$wpdb->prepare(
					"SELECT c.* FROM {$tables['classes']} c INNER JOIN {$wpdb->posts} p ON c.post_id = p.ID WHERE c.status IN ('approved','published') AND c.deleted_at IS NULL AND p.post_title LIKE %s ORDER BY c.start_at_utc ASC LIMIT %d",
					'%' . $wpdb->esc_like( $search ) . '%',
					$limit
				)
			);
		}

		return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE status IN ('approved','published') AND deleted_at IS NULL ORDER BY start_at_utc ASC LIMIT %d", $limit ) );
	}

	/**
	 * Fetch the featured live class for a Sensei subject page.
	 *
	 * @param string $subject Subject key.
	 * @return array
	 */
	private function featured_subject_classes( $subject ) {
		if ( ! $subject ) {
			return array();
		}

		global $wpdb;
		$tables = Installer::tables();

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT c.*
				FROM {$tables['classes']} c
				LEFT JOIN {$tables['teacher_profiles']} p ON p.user_id = c.teacher_user_id
				WHERE c.status IN ('approved','published')
					AND c.primary_subject_key = %s
					AND c.deleted_at IS NULL
				ORDER BY COALESCE(p.average_rating, 0) DESC, COALESCE(p.rating_count, 0) DESC, COALESCE(p.completed_class_count, 0) DESC, c.start_at_utc ASC
				LIMIT 1",
				$subject
			)
		);
	}

	/**
	 * Convert accidental repeated class rows from the earlier recurrence draft into one class series.
	 *
	 * @param string $subject Subject key.
	 * @return void
	 */
	private function consolidate_legacy_recurring_classes( $subject ) {
		if ( ! $subject ) {
			return;
		}

		global $wpdb;
		$tables = Installer::tables();
		$rows   = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$tables['classes']} WHERE primary_subject_key = %s AND status IN ('approved','published','submitted') AND deleted_at IS NULL ORDER BY teacher_user_id ASC, start_at_utc ASC",
				$subject
			)
		);

		if ( count( $rows ) < 2 ) {
			return;
		}

		$groups = array();
		foreach ( $rows as $row ) {
			$title = get_the_title( (int) $row->post_id );
			$base  = $this->legacy_recurring_base_title( $title );
			if ( '' === $base || $base === $title ) {
				continue;
			}

			$key = md5(
				implode(
					'|',
					array(
						$base,
						(int) $row->teacher_user_id,
						$row->primary_subject_key,
						$row->class_levels,
						(int) $row->course_id,
						$row->class_type,
						$row->delivery_platform,
						$row->meeting_url,
						(int) $row->duration_minutes,
						(int) $row->capacity,
						(int) $row->price_minor,
						$row->currency,
					)
				)
			);

			if ( ! isset( $groups[ $key ] ) ) {
				$groups[ $key ] = array(
					'base' => $base,
					'rows' => array(),
				);
			}
			$groups[ $key ]['rows'][] = $row;
		}

		foreach ( $groups as $group ) {
			if ( count( $group['rows'] ) < 2 ) {
				continue;
			}

			$has_bookings = false;
			foreach ( $group['rows'] as $row ) {
				if ( (int) $row->confirmed_seats > 0 ) {
					$has_bookings = true;
					break;
				}
			}
			if ( $has_bookings ) {
				continue;
			}

			usort(
				$group['rows'],
				static function( $a, $b ) {
					return strcmp( (string) $a->start_at_utc, (string) $b->start_at_utc );
				}
			);

			$master = $group['rows'][0];
			$now    = current_time( 'mysql', true );
			foreach ( $group['rows'] as $row ) {
				$this->ensure_session_for_class( $master, $row->start_at_utc, $row->end_at_utc ?: null );
			}

			$last     = $group['rows'][ count( $group['rows'] ) - 1 ];
			$last_end = $last->end_at_utc ?: gmdate( 'Y-m-d H:i:s', strtotime( $last->start_at_utc ) + ( (int) $last->duration_minutes * MINUTE_IN_SECONDS ) );
			$wpdb->update(
				$tables['classes'],
				array(
					'start_at_utc' => $master->start_at_utc,
					'end_at_utc'   => $last_end,
					'updated_at'   => $now,
				),
				array( 'class_id' => (int) $master->class_id ),
				array( '%s', '%s', '%s' ),
				array( '%d' )
			);
			wp_update_post(
				array(
					'ID'         => (int) $master->post_id,
					'post_title' => $group['base'],
				)
			);
			update_post_meta( (int) $master->post_id, '_classhall_live_recurrence_type', $this->infer_recurrence_type_from_rows( $group['rows'] ) );
			update_post_meta( (int) $master->post_id, '_classhall_live_session_count', count( $group['rows'] ) );

			foreach ( array_slice( $group['rows'], 1 ) as $duplicate ) {
				$wpdb->update(
					$tables['classes'],
					array(
						'deleted_at' => $now,
						'updated_at' => $now,
					),
					array( 'class_id' => (int) $duplicate->class_id ),
					array( '%s', '%s' ),
					array( '%d' )
				);
				wp_update_post(
					array(
						'ID'          => (int) $duplicate->post_id,
						'post_status' => 'draft',
					)
				);
			}
		}
	}

	/**
	 * Strip the generated date suffix from old recurring class titles.
	 *
	 * @param string $title Post title.
	 * @return string
	 */
	private function legacy_recurring_base_title( $title ) {
		$title = trim( (string) $title );
		if ( ! preg_match( '/^(.+?)\s+-\s+(.+)$/', $title, $matches ) ) {
			return $title;
		}

		$suffix = strtolower( $matches[2] );
		if ( ! preg_match( '/\b(january|february|march|april|may|june|july|august|september|october|november|december)\b|\b\d{4}\b/', $suffix ) ) {
			return $title;
		}

		return trim( $matches[1] );
	}

	/**
	 * Ensure a class session exists for a given date.
	 *
	 * @param object      $class Class row.
	 * @param string|null $start Start UTC.
	 * @param string|null $end End UTC.
	 * @return void
	 */
	private function ensure_session_for_class( $class, $start, $end ) {
		if ( empty( $start ) ) {
			return;
		}

		global $wpdb;
		$tables = Installer::tables();
		$exists = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT session_id FROM {$tables['sessions']} WHERE class_id = %d AND start_at_utc = %s AND deleted_at IS NULL LIMIT 1",
				(int) $class->class_id,
				$start
			)
		);

		if ( $exists ) {
			return;
		}

		$wpdb->insert(
			$tables['sessions'],
			array(
				'class_id'        => (int) $class->class_id,
				'start_at_utc'    => $start,
				'end_at_utc'      => $end ?: gmdate( 'Y-m-d H:i:s', strtotime( $start ) + ( (int) $class->duration_minutes * MINUTE_IN_SECONDS ) ),
				'capacity'        => (int) $class->capacity,
				'confirmed_seats' => 0,
				'status'          => 'available',
				'created_at'      => current_time( 'mysql', true ),
				'updated_at'      => current_time( 'mysql', true ),
			)
		);
	}

	/**
	 * Infer whether legacy rows represent weekly or multiple-days weekly recurrence.
	 *
	 * @param array $rows Class rows.
	 * @return string
	 */
	private function infer_recurrence_type_from_rows( $rows ) {
		$days = array();
		foreach ( $rows as $row ) {
			if ( empty( $row->start_at_utc ) ) {
				continue;
			}
			$days[] = wp_date( 'N', strtotime( $row->start_at_utc . ' UTC' ) );
		}

		return count( array_unique( $days ) ) > 1 ? 'multiple_days' : 'weekly';
	}

	/**
	 * Render class card.
	 *
	 * @param object $class           Class row.
	 * @param bool   $minimal_subject Whether to hide repeated subject/title context.
	 * @return void
	 */
	private function render_class_card( $class, $minimal_subject = false ) {
		$teacher       = get_user_by( 'id', $class->teacher_user_id );
		$profile       = $this->teacher_profile_by_user_id( (int) $class->teacher_user_id );
		$teacher_name  = $profile ? $profile->display_name : ( $teacher ? $teacher->display_name : __( 'Classhall teacher', 'classhall-live-classes' ) );
		$teacher_url   = $profile ? home_url( '/live-teachers/' . $profile->teacher_slug . '/' ) : '';
		$subject_label = $this->clean_teacher_subject_title_label( $class->primary_subject_label );
		$seats_left    = max( 0, (int) $class->capacity - (int) $class->confirmed_seats );
		$schedule      = $this->class_schedule_parts( $class );
		$class_type    = $this->class_type_label( $class->class_type );

		echo '<article class="chl-card chl-class-card' . ( $minimal_subject ? ' chl-class-card-minimal' : '' ) . '">';
		echo '<div class="chl-class-card-main">';
		if ( ! $minimal_subject ) {
			echo '<p class="chl-card-kicker">' . esc_html( $subject_label ) . '</p>';
			echo '<h3 class="chl-card-title"><a href="' . esc_url( get_permalink( $class->post_id ) ) . '">' . esc_html( get_the_title( $class->post_id ) ) . '</a></h3>';
		}
		echo '<div class="chl-card-meta chl-card-schedule"><strong>' . esc_html( $schedule['summary'] ) . '</strong>';
		if ( ! empty( $schedule['details'] ) ) {
			echo '<span>' . esc_html( $schedule['details'] ) . '</span>';
		}
		echo '</div>';
		echo '<p class="chl-card-meta"><strong>' . esc_html__( 'Teacher:', 'classhall-live-classes' ) . '</strong> ';
		if ( $teacher_url ) {
			echo '<a href="' . esc_url( $teacher_url ) . '">' . esc_html( $teacher_name ) . '</a>';
		} else {
			echo esc_html( $teacher_name );
		}
		echo ' <span class="chl-card-type">' . esc_html( $class_type ) . '</span></p>';
		echo '</div>';
		echo '<div class="chl-class-card-side">';
		echo '<p class="chl-card-price"><span>' . esc_html__( 'Price', 'classhall-live-classes' ) . '</span> ' . esc_html( $this->format_money( $class->price_minor, $class->currency ) ) . '</p>';
		echo '<p class="chl-card-meta">' . esc_html( sprintf( _n( '%d seat left', '%d seats left', $seats_left, 'classhall-live-classes' ), $seats_left ) ) . '</p>';
		echo '<a class="chl-button chl-button-small" href="' . esc_url( get_permalink( $class->post_id ) ) . '">' . esc_html__( 'Book Class', 'classhall-live-classes' ) . '</a>';
		echo '</div></article>';
	}

	/**
	 * Render schedule parts for class cards.
	 *
	 * @param object $class Class row.
	 * @return array{summary:string,details:string}
	 */
	private function class_schedule_parts( $class ) {
		$sessions = $this->class_sessions( $class );

		if ( count( $sessions ) <= 1 ) {
			return array(
				'summary' => $this->format_utc( $class->start_at_utc ),
				'details' => '',
			);
		}

		$first      = $sessions[0]->start_at_utc;
		$last       = $sessions[ count( $sessions ) - 1 ]->start_at_utc;
		$recurrence = (string) get_post_meta( (int) $class->post_id, '_classhall_live_recurrence_type', true );
		$label      = 'multiple_days' === $recurrence ? __( 'Multiple days weekly', 'classhall-live-classes' ) : __( 'Weekly', 'classhall-live-classes' );

		return array(
			'summary' => sprintf(
				/* translators: 1: recurrence label, 2: number of sessions. */
				__( '%1$s | %2$d sessions', 'classhall-live-classes' ),
				$label,
				count( $sessions )
			),
			'details' => sprintf(
				/* translators: 1: first date, 2: last date, 3: time. */
				__( '%1$s - %2$s | %3$s', 'classhall-live-classes' ),
				$this->format_utc_date_only( $first ),
				$this->format_utc_date_only( $last ),
				$this->format_utc_time_only( $first )
			),
		);
	}

	/**
	 * Human-readable class type label.
	 *
	 * @param string $class_type Raw class type.
	 * @return string
	 */
	private function class_type_label( $class_type ) {
		return 'one_on_one' === $class_type ? __( 'One-on-one', 'classhall-live-classes' ) : __( 'Group', 'classhall-live-classes' );
	}

	/**
	 * Render a compact one-line schedule summary for a class or class series.
	 *
	 * @param object $class Class row.
	 * @return string
	 */
	private function class_schedule_summary( $class ) {
		$sessions = $this->class_sessions( $class );

		if ( count( $sessions ) <= 1 ) {
			return $this->format_utc( $class->start_at_utc );
		}

		$first      = $sessions[0]->start_at_utc;
		$last       = $sessions[ count( $sessions ) - 1 ]->start_at_utc;
		$recurrence = (string) get_post_meta( (int) $class->post_id, '_classhall_live_recurrence_type', true );
		$label      = 'multiple_days' === $recurrence ? __( 'Multiple days weekly', 'classhall-live-classes' ) : __( 'Weekly', 'classhall-live-classes' );

		return sprintf(
			/* translators: 1: recurrence label, 2: number of sessions, 3: first date, 4: last date, 5: class time. */
			__( '%1$s | %2$d sessions | %3$s - %4$s | %5$s', 'classhall-live-classes' ),
			$label,
			count( $sessions ),
			$this->format_utc_date_only( $first ),
			$this->format_utc_date_only( $last ),
			$this->format_utc_time_only( $first )
		);
	}

	/**
	 * Fetch saved sessions for a class.
	 *
	 * @param object $class Class row.
	 * @return array
	 */
	private function class_sessions( $class ) {
		global $wpdb;

		$tables = Installer::tables();
		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT start_at_utc FROM {$tables['sessions']} WHERE class_id = %d AND deleted_at IS NULL ORDER BY start_at_utc ASC",
				absint( $class->class_id )
			)
		);
	}

	/**
	 * Render other available classes for the same subject/class.
	 *
	 * @param object $class Current class.
	 * @param string $subject Display subject label.
	 * @return void
	 */
	private function render_related_subject_classes( $class, $subject ) {
		global $wpdb;
		$tables = Installer::tables();
		$rows   = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$tables['classes']}
				WHERE class_id <> %d
					AND primary_subject_key = %s
					AND class_levels = %s
					AND status IN ('approved','published')
					AND deleted_at IS NULL
				ORDER BY start_at_utc ASC
				LIMIT 6",
				absint( $class->class_id ),
				$class->primary_subject_key,
				$class->class_levels
			)
		);

		if ( empty( $rows ) ) {
			return;
		}

		echo '<div class="chl-related-classes">';
		echo '<h3>' . esc_html(
			sprintf(
				/* translators: %s: subject label. */
				__( 'Other %s live classes', 'classhall-live-classes' ),
				$subject
			)
		) . '</h3>';
		echo '<div class="chl-related-grid">';
		foreach ( $rows as $row ) {
			$this->render_class_card( $row );
		}
		echo '</div></div>';
	}

	/**
	 * Query approved teachers for the public directory.
	 *
	 * @param string $search Search text.
	 * @param string $class_filter_key Class filter key.
	 * @param int    $limit Result limit.
	 * @return object[]
	 */
	private function query_teachers( $search, $class_filter_key, $limit ) {
		global $wpdb;
		$tables = Installer::tables();

		$class_options = $this->class_level_options();
		$class_label   = isset( $class_options[ $class_filter_key ] ) ? $class_options[ $class_filter_key ] : '';
		$where         = array(
			'p.application_status = %s',
			'p.deleted_at IS NULL',
		);
		$params        = array( Statuses::TEACHER_APPROVED );

		if ( '' !== $search ) {
			$like    = '%' . $wpdb->esc_like( $search ) . '%';
			$where[] = '(
				p.display_name LIKE %s
				OR p.class_levels LIKE %s
				OR p.bio LIKE %s
				OR p.qualifications LIKE %s
				OR EXISTS (
					SELECT 1 FROM ' . $tables['teacher_subjects'] . ' ts
					WHERE ts.teacher_user_id = p.user_id
						AND ts.subject_label LIKE %s
				)
				OR EXISTS (
					SELECT 1 FROM ' . $tables['classes'] . ' c
					LEFT JOIN ' . $wpdb->posts . ' cp ON cp.ID = c.post_id
					WHERE c.teacher_user_id = p.user_id
						AND c.status IN ("approved","published","completed")
						AND c.deleted_at IS NULL
						AND (
							c.primary_subject_label LIKE %s
							OR c.class_levels LIKE %s
							OR cp.post_title LIKE %s
						)
				)
			)';
			array_push( $params, $like, $like, $like, $like, $like, $like, $like, $like );
		}

		if ( '' !== $class_label ) {
			$class_key_compact   = str_replace( '-', '', $class_filter_key );
			$class_label_spaced  = preg_replace( '/^([A-Z]+)([0-9]+)$/', '$1 $2', $class_label );
			$class_pattern       = '(^|[^[:alnum:]])' . preg_quote( $class_label, '/' ) . '([^[:alnum:]]|$)';
			$class_spaced_pattern = '(^|[^[:alnum:]])' . preg_quote( $class_label_spaced, '/' ) . '([^[:alnum:]]|$)';
			$where[]       = '(
				EXISTS (
					SELECT 1 FROM ' . $tables['teacher_subjects'] . ' ts
					WHERE ts.teacher_user_id = p.user_id
						AND (
							ts.class_level_key = %s
							OR ts.class_level_key = %s
							OR ts.class_level_label = %s
							OR ts.subject_label REGEXP %s
							OR ts.subject_label REGEXP %s
						)
				)
				OR EXISTS (
					SELECT 1 FROM ' . $tables['classes'] . ' c
					WHERE c.teacher_user_id = p.user_id
						AND c.status IN ("approved","published","completed")
						AND c.deleted_at IS NULL
						AND (
							c.class_levels = %s
							OR c.class_levels = %s
							OR c.class_levels REGEXP %s
							OR c.primary_subject_label REGEXP %s
							OR c.primary_subject_label REGEXP %s
						)
				)
			)';
			array_push( $params, $class_filter_key, $class_key_compact, $class_label, $class_pattern, $class_spaced_pattern, $class_label, $class_label_spaced, $class_pattern, $class_pattern, $class_spaced_pattern );
		}

		$params[] = $limit;

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT p.*
				FROM {$tables['teacher_profiles']} p
				WHERE " . implode( ' AND ', $where ) . "
				ORDER BY p.ranking_score DESC, p.average_rating DESC, p.rating_count DESC, p.display_name ASC
				LIMIT %d",
				$params
			)
		);
	}

	/**
	 * Render one teacher directory card.
	 *
	 * @param object $teacher Teacher profile row.
	 * @return void
	 */
	private function render_teacher_directory_card( $teacher ) {
		$profile_url = home_url( '/live-teachers/' . $teacher->teacher_slug . '/' );
		$subjects    = $this->teacher_subject_labels( (int) $teacher->user_id );

		echo '<article class="chl-teacher-card">';
		echo '<a class="chl-teacher-card-photo" href="' . esc_url( $profile_url ) . '">';
		if ( $teacher->photo_id ) {
			echo wp_get_attachment_image( (int) $teacher->photo_id, 'thumbnail', false, array( 'class' => 'chl-avatar' ) );
		} else {
			echo '<span class="chl-avatar chl-avatar-placeholder" aria-hidden="true">' . esc_html( $this->teacher_initials( $teacher->display_name ) ) . '</span>';
		}
		if ( (int) $teacher->is_verified ) {
			echo '<span class="chl-avatar-verified" aria-label="' . esc_attr__( 'Verified Classhall teacher', 'classhall-live-classes' ) . '">&#10003;</span>';
		}
		echo '</a>';
		echo '<div class="chl-teacher-card-body">';
		echo '<h3><a href="' . esc_url( $profile_url ) . '">' . esc_html( $teacher->display_name ) . '</a> <span class="chl-badge ' . ( (int) $teacher->is_verified ? 'chl-badge-verified' : 'chl-badge-unverified' ) . '">' . esc_html( (int) $teacher->is_verified ? __( 'Verified', 'classhall-live-classes' ) : __( 'Unverified', 'classhall-live-classes' ) ) . '</span></h3>';
		echo '<p class="chl-teacher-rating">' . esc_html( $this->format_teacher_rating( $teacher->average_rating ) ) . ' &middot; ' . esc_html( absint( $teacher->rating_count ) ) . ' ' . esc_html__( 'reviews', 'classhall-live-classes' ) . ' &middot; ' . esc_html( absint( $teacher->completed_class_count ) ) . ' ' . esc_html__( 'completed classes', 'classhall-live-classes' ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Subjects:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $subjects ? implode( ', ', $subjects ) : __( 'Not listed yet', 'classhall-live-classes' ) ) . '</p>';
		echo '<p><strong>' . esc_html__( 'Classes taught:', 'classhall-live-classes' ) . '</strong> ' . esc_html( $teacher->class_levels ?: '-' ) . '</p>';
		echo '<p><a class="chl-button" href="' . esc_url( $profile_url ) . '">' . esc_html__( 'View Profile', 'classhall-live-classes' ) . '</a></p>';
		echo '</div></article>';
	}

	/**
	 * Get subject labels associated with a teacher.
	 *
	 * @param int $teacher_user_id Teacher user ID.
	 * @return string[]
	 */
	private function teacher_subject_labels( $teacher_user_id ) {
		global $wpdb;
		$tables = Installer::tables();
		$labels = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT DISTINCT subject_label
				FROM {$tables['teacher_subjects']}
				WHERE teacher_user_id = %d AND subject_label <> ''
				ORDER BY subject_label ASC
				LIMIT 12",
				$teacher_user_id
			)
		);

		if ( ! empty( $labels ) ) {
			$labels = array_map( array( $this, 'clean_teacher_subject_title_label' ), $labels );
			$labels = array_values( array_unique( array_filter( array_map( 'trim', $labels ) ) ) );
			sort( $labels, SORT_NATURAL | SORT_FLAG_CASE );
			return $labels;
		}

		$labels = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT DISTINCT primary_subject_label
				FROM {$tables['classes']}
				WHERE teacher_user_id = %d AND status IN ('approved','published','completed') AND deleted_at IS NULL AND primary_subject_label <> ''
				ORDER BY primary_subject_label ASC
				LIMIT 12",
				$teacher_user_id
			)
		);

		$labels = array_map( array( $this, 'clean_teacher_subject_title_label' ), $labels );
		$labels = array_values( array_unique( array_filter( array_map( 'trim', $labels ) ) ) );
		sort( $labels, SORT_NATURAL | SORT_FLAG_CASE );

		return $labels;
	}

	/**
	 * Format teacher subjects as a public teacher title.
	 *
	 * @param string[] $subjects Subject labels.
	 * @return string
	 */
	private function teacher_subject_title( $subjects ) {
		$subjects = array_map( array( $this, 'clean_teacher_subject_title_label' ), $subjects );
		$subjects = array_values( array_unique( array_filter( array_map( 'trim', $subjects ) ) ) );
		$subjects = array_slice( $subjects, 0, 3 );

		if ( empty( $subjects ) ) {
			return '';
		}

		if ( 1 === count( $subjects ) ) {
			return sprintf(
				/* translators: %s: subject name. */
				__( '%s Teacher', 'classhall-live-classes' ),
				$subjects[0]
			);
		}

		$last  = array_pop( $subjects );
		$title = implode( ', ', $subjects ) . ' ' . __( 'and', 'classhall-live-classes' ) . ' ' . $last;

		return sprintf(
			/* translators: %s: subject names. */
			__( '%s Teacher', 'classhall-live-classes' ),
			$title
		);
	}

	/**
	 * Remove class-level suffixes from subject labels used in teacher titles.
	 *
	 * @param string $label Subject label.
	 * @return string
	 */
	private function clean_teacher_subject_title_label( $label ) {
		$label = html_entity_decode( wp_specialchars_decode( (string) $label, ENT_QUOTES ), ENT_QUOTES, 'UTF-8' );
		$label = str_replace( array( '&ndash;', '&mdash;', '&#8211;', '&#8212;' ), '-', $label );
		$label = preg_replace( '/[\x{2010}-\x{2015}\x{2212}]/u', '-', $label );
		$label = preg_replace( '/\s*-.*\b(?:Primary|Basic|JSS|SSS|SS|S)\s*[1-9]\b.*$/iu', '', $label );
		$label = preg_replace( '/\s*\(.*\b(?:Primary|Basic|JSS|SSS|SS|S)\s*[1-9]\b.*\)\s*$/iu', '', $label );

		$clean = $this->clean_subject_label( $label );
		$clean = preg_replace( '/[\x{2010}-\x{2015}\x{2212}]/u', '-', $clean );
		$clean = preg_replace( '/\s*-.*\b(?:Primary|Basic|JSS|SSS|SS|S)\s*[1-9]\b.*$/iu', '', $clean );
		$clean = preg_replace( '/\(\s*\)/', '', $clean );
		$clean = preg_replace( '/\s*[-|:]+\s*$/', '', $clean );
		$clean = preg_replace( '/^\s*[-|:]+\s*/', '', $clean );
		$clean = trim( preg_replace( '/\s+/', ' ', $clean ) );

		return $this->subject_title_case( $clean );
	}

	/**
	 * Normalize subject label case for public teacher titles.
	 *
	 * @param string $label Subject label.
	 * @return string
	 */
	private function title_case_subject_label( $label ) {
		$label = strtolower( trim( (string) $label ) );
		if ( '' === $label ) {
			return '';
		}

		return function_exists( 'mb_convert_case' ) ? mb_convert_case( $label, MB_CASE_TITLE, 'UTF-8' ) : ucwords( $label );
	}

	/**
	 * Format a teacher rating for public display.
	 *
	 * @param mixed $rating Rating value.
	 * @return string
	 */
	private function format_teacher_rating( $rating ) {
		return sprintf(
			/* translators: %s: rating value. */
			__( 'Rating: %s', 'classhall-live-classes' ),
			number_format_i18n( (float) $rating, 1 )
		);
	}

	/**
	 * Format compact teacher rating text for inline metadata.
	 *
	 * @param mixed $rating Rating value.
	 * @return string
	 */
	private function format_teacher_rated_text( $rating ) {
		return sprintf(
			/* translators: %s: rating value. */
			__( 'Rated %s', 'classhall-live-classes' ),
			number_format_i18n( (float) $rating, 1 )
		);
	}

	/**
	 * Render student join state without exposing the raw meeting URL.
	 *
	 * @param object $booking Booking joined with class.
	 * @return void
	 */
	private function render_join_area( $booking ) {
		if ( empty( $booking->meeting_url ) || Statuses::BOOKING_CONFIRMED !== $booking->status || 'paid' !== $booking->payment_status ) {
			return;
		}

		if ( isset( $booking->class_status ) && in_array( $booking->class_status, array( Statuses::CLASS_CANCELLED, Statuses::CLASS_REJECTED, Statuses::CLASS_SUSPENDED ), true ) ) {
			echo '<p class="chl-field-help">' . esc_html__( 'This class is not currently available to join.', 'classhall-live-classes' ) . '</p>';
			return;
		}

		if ( $this->can_access_meeting( $booking ) ) {
			echo '<p><a class="chl-button" href="' . esc_url( $this->join_url( $booking->booking_uuid ) ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Join Class', 'classhall-live-classes' ) . '</a></p>';
			return;
		}

		echo '<p><span class="chl-button chl-button-disabled" aria-disabled="true">' . esc_html__( 'Join Class', 'classhall-live-classes' ) . '</span></p>';
		echo '<p class="chl-field-help">' . esc_html( $this->meeting_access_message( $booking ) ) . '</p>';
	}

	/**
	 * Get teacher profile by slug.
	 *
	 * @param string $slug Teacher slug.
	 * @return object|null
	 */
	private function teacher_profile_by_slug( $slug ) {
		global $wpdb;
		$tables = Installer::tables();
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['teacher_profiles']} WHERE teacher_slug = %s AND deleted_at IS NULL", sanitize_title( $slug ) ) );
	}

	/**
	 * Get approved teacher profile for current public profile route.
	 *
	 * @return object|null
	 */
	private function teacher_profile_for_current_route() {
		if ( $this->current_teacher_profile ) {
			return $this->current_teacher_profile;
		}

		$slug = sanitize_title( get_query_var( 'classhall_live_teacher_slug' ) );
		if ( ! $slug ) {
			return null;
		}

		$profile = $this->teacher_profile_by_slug( $slug );
		if ( ! $profile || Statuses::TEACHER_APPROVED !== $profile->application_status ) {
			return null;
		}

		return $profile;
	}

	/**
	 * Check whether the current request is the public teacher directory.
	 *
	 * @return bool
	 */
	private function is_teacher_directory_route() {
		return $this->is_teacher_directory || (bool) get_query_var( 'classhall_live_teachers_directory' );
	}

	/**
	 * Build initials for teacher avatar placeholders.
	 *
	 * @param string $name Teacher display name.
	 * @return string
	 */
	private function teacher_initials( $name ) {
		$parts    = preg_split( '/\s+/', trim( (string) $name ) );
		$initials = '';

		foreach ( $parts as $part ) {
			if ( '' === $part ) {
				continue;
			}
			$initials .= function_exists( 'mb_substr' ) ? mb_substr( $part, 0, 1, 'UTF-8' ) : substr( $part, 0, 1 );
			if ( strlen( $initials ) >= 2 ) {
				break;
			}
		}

		$initials = $initials ?: 'T';
		return function_exists( 'mb_strtoupper' ) ? mb_strtoupper( $initials, 'UTF-8' ) : strtoupper( $initials );
	}

	/**
	 * Get teacher profile by user ID.
	 *
	 * @param int $user_id User ID.
	 * @return object|null
	 */
	private function teacher_profile_by_user_id( $user_id ) {
		global $wpdb;
		$tables = Installer::tables();
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['teacher_profiles']} WHERE user_id = %d AND deleted_at IS NULL", absint( $user_id ) ) );
	}

	/**
	 * Render share controls.
	 *
	 * @param string      $url URL.
	 * @param string      $title Title.
	 * @param object      $class Class row.
	 * @param \WP_User|false $teacher Teacher.
	 * @param string         $subject Subject display label.
	 * @return void
	 */
	private function render_share_controls( $url, $title, $class, $teacher, $subject = '' ) {
		$subject = '' !== $subject ? $subject : $this->clean_teacher_subject_title_label( $class->primary_subject_label );
		$text    = $this->format_class_share_text(
			$subject,
			$teacher ? $teacher->display_name : __( 'a verified Classhall teacher', 'classhall-live-classes' )
		);
		$encoded_url  = rawurlencode( $url );
		$encoded_text = rawurlencode( $text );
		echo '<div class="chl-share" data-share-title="' . esc_attr( $title ) . '" data-share-text="' . esc_attr( $text ) . '" data-share-url="' . esc_url( $url ) . '">';
		echo '<span class="chl-share-label">' . esc_html__( 'Share on', 'classhall-live-classes' ) . '</span>';
		echo '<a href="' . esc_url( 'https://wa.me/?text=' . $encoded_text . '%20' . $encoded_url ) . '">WhatsApp</a>';
		echo '<a target="_blank" rel="noopener noreferrer" href="' . esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $encoded_url . '&quote=' . $encoded_text ) . '">Facebook</a>';
		echo '<a href="' . esc_url( 'https://www.linkedin.com/sharing/share-offsite/?url=' . $encoded_url ) . '">LinkedIn</a>';
		echo '<a target="_blank" rel="noopener noreferrer" href="' . esc_url( 'https://x.com/intent/post?text=' . rawurlencode( $text . ' ' . $url ) ) . '">X</a>';
		echo '<a href="' . esc_url( 'https://t.me/share/url?url=' . $encoded_url . '&text=' . $encoded_text ) . '">Telegram</a>';
		echo '<button type="button" data-chl-copy>' . esc_html__( 'Copy link', 'classhall-live-classes' ) . '</button>';
		echo '<button type="button" data-chl-native-share>' . esc_html__( 'Share', 'classhall-live-classes' ) . '</button>';
		echo '</div>';
	}

	/**
	 * Format class share copy.
	 *
	 * @param string $subject Subject label.
	 * @param string $teacher_name Teacher name.
	 * @return string
	 */
	private function format_class_share_text( $subject, $teacher_name ) {
		return sprintf(
			/* translators: 1: subject, 2: teacher name. */
			__( 'Learn %1$s with %2$s on Classhall.', 'classhall-live-classes' ),
			$subject,
			$teacher_name
		);
	}

	/**
	 * Can current user access meeting link?
	 *
	 * @param object $booking Booking joined with class.
	 * @return bool
	 */
	private function can_access_meeting( $booking ) {
		if ( empty( $booking->meeting_url ) || Statuses::BOOKING_CONFIRMED !== $booking->status ) {
			return false;
		}

		if ( isset( $booking->class_status ) && in_array( $booking->class_status, array( Statuses::CLASS_CANCELLED, Statuses::CLASS_REJECTED, Statuses::CLASS_SUSPENDED ), true ) ) {
			return false;
		}

		$settings = Plugin::settings();
		$start    = strtotime( $booking->start_at_utc . ' UTC' );
		$end      = strtotime( $booking->end_at_utc . ' UTC' );
		$now      = time();

		return $now >= ( $start - ( absint( $settings['meeting_access_before_minutes'] ) * MINUTE_IN_SECONDS ) )
			&& $now <= ( $end + ( absint( $settings['meeting_access_after_minutes'] ) * MINUTE_IN_SECONDS ) );
	}

	/**
	 * Explain when the join link becomes available.
	 *
	 * @param object $booking Booking joined with class.
	 * @return string
	 */
	private function meeting_access_message( $booking ) {
		$settings = Plugin::settings();
		$start    = strtotime( $booking->start_at_utc . ' UTC' );
		$end      = strtotime( $booking->end_at_utc . ' UTC' );
		$opens    = $start - ( absint( $settings['meeting_access_before_minutes'] ) * MINUTE_IN_SECONDS );
		$closes   = $end + ( absint( $settings['meeting_access_after_minutes'] ) * MINUTE_IN_SECONDS );
		$now      = time();

		if ( $now < $opens ) {
			return sprintf(
				/* translators: %s: access opening date/time. */
				__( 'The join link will become active on %s.', 'classhall-live-classes' ),
				wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $opens )
			);
		}

		if ( $now > $closes ) {
			return __( 'The join window for this class has closed.', 'classhall-live-classes' );
		}

		return __( 'The join link is not available yet.', 'classhall-live-classes' );
	}

	/**
	 * Build the local authorized join URL.
	 *
	 * @param string $booking_uuid Booking UUID.
	 * @return string
	 */
	private function join_url( $booking_uuid ) {
		return home_url( '/live-class-join/' . rawurlencode( $booking_uuid ) . '/' );
	}

	/**
	 * Build a short-lived duplicate-submission fingerprint for class creation.
	 *
	 * @return string
	 */
	private function class_submission_fingerprint() {
		$parts = array(
			sanitize_text_field( wp_unslash( $_POST['title'] ?? '' ) ),
			sanitize_text_field( wp_unslash( $_POST['subject_selection'] ?? '' ) ),
			sanitize_text_field( wp_unslash( $_POST['start_at'] ?? '' ) ),
			sanitize_text_field( wp_unslash( $_POST['price'] ?? '' ) ),
			absint( $_POST['duration_minutes'] ?? 0 ),
			sanitize_key( $_POST['recurrence_type'] ?? 'one_time' ),
			implode( ',', isset( $_POST['recurrence_days'] ) && is_array( $_POST['recurrence_days'] ) ? array_map( 'absint', wp_unslash( $_POST['recurrence_days'] ) ) : array() ),
		);

		return md5( implode( '|', $parts ) );
	}

	/**
	 * Build UTC start times for a one-month recurring class submission.
	 *
	 * @param string $first_start_utc First start datetime in UTC.
	 * @param string $type Recurrence type.
	 * @param array  $days ISO weekday numbers, 1 Monday through 7 Sunday.
	 * @return array
	 */
	private function recurring_class_start_times( $first_start_utc, $type, $days = array() ) {
		if ( empty( $first_start_utc ) ) {
			return array();
		}

		$type    = in_array( $type, array( 'weekly', 'multiple_days' ), true ) ? $type : 'one_time';
		$first   = new \DateTimeImmutable( $first_start_utc . ' UTC' );
		$first   = $first->setTimezone( wp_timezone() );
		$end     = $first->modify( '+1 month' );
		$starts  = array();
		$seen    = array();
		$to_utc  = static function( \DateTimeImmutable $date ) {
			return $date->setTimezone( new \DateTimeZone( 'UTC' ) )->format( 'Y-m-d H:i:s' );
		};

		if ( 'one_time' === $type ) {
			return array( $to_utc( $first ) );
		}

		if ( 'weekly' === $type ) {
			for ( $date = $first; $date <= $end; $date = $date->modify( '+1 week' ) ) {
				$starts[] = $to_utc( $date );
			}

			return $starts;
		}

		$days = array_values(
			array_unique(
				array_filter(
					array_map( 'absint', $days ),
					static function( $day ) {
						return $day >= 1 && $day <= 7;
					}
				)
			)
		);
		sort( $days );

		if ( empty( $days ) ) {
			return array();
		}

		for ( $date = $first; $date <= $end; $date = $date->modify( '+1 day' ) ) {
			if ( ! in_array( (int) $date->format( 'N' ), $days, true ) ) {
				continue;
			}

			$utc = $to_utc( $date );
			if ( isset( $seen[ $utc ] ) ) {
				continue;
			}

			$seen[ $utc ] = true;
			$starts[]     = $utc;
		}

		return $starts;
	}

	/**
	 * Convert local datetime input to UTC.
	 *
	 * @param string $value Local value.
	 * @return string|null
	 */
	private function local_datetime_to_utc( $value ) {
		if ( '' === $value ) {
			return null;
		}

		$timezone = wp_timezone();
		$date     = date_create_from_format( 'Y-m-d\TH:i', $value, $timezone );
		if ( ! $date ) {
			return null;
		}

		$date->setTimezone( new \DateTimeZone( 'UTC' ) );
		return $date->format( 'Y-m-d H:i:s' );
	}

	/**
	 * Format UTC datetime in site timezone.
	 *
	 * @param string|null $utc UTC datetime.
	 * @return string
	 */
	private function format_utc( $utc ) {
		if ( empty( $utc ) ) {
			return __( 'Schedule pending', 'classhall-live-classes' );
		}

		return wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $utc . ' UTC' ) );
	}

	/**
	 * Format a UTC datetime as a short date for generated recurring class titles.
	 *
	 * @param string $utc UTC datetime.
	 * @return string
	 */
	private function format_utc_date_only( $utc ) {
		return wp_date( get_option( 'date_format' ), strtotime( $utc . ' UTC' ) );
	}

	/**
	 * Format a UTC datetime as a time only.
	 *
	 * @param string $utc UTC datetime.
	 * @return string
	 */
	private function format_utc_time_only( $utc ) {
		return wp_date( get_option( 'time_format' ), strtotime( $utc . ' UTC' ) );
	}

	/**
	 * Convert decimal amount to minor units.
	 *
	 * @param string $amount Amount.
	 * @return int
	 */
	private function decimal_to_minor( $amount ) {
		return (int) round( (float) $amount * 100 );
	}

	/**
	 * Format minor amount.
	 *
	 * @param int    $minor Minor units.
	 * @param string $currency Currency.
	 * @return string
	 */
	private function format_money( $minor, $currency ) {
		if ( 'NGN' === strtoupper( $currency ) ) {
			return '₦' . number_format_i18n( (int) $minor / 100, 2 );
		}

		return strtoupper( $currency ) . ' ' . number_format_i18n( (int) $minor / 100, 2 );
	}

	/**
	 * Format a minor amount without a currency label.
	 *
	 * @param int $minor Minor units.
	 * @return string
	 */
	private function format_money_number( $minor ) {
		return number_format_i18n( (int) $minor / 100, 2 );
	}

	/**
	 * Sanitize rating field.
	 *
	 * @param string $field Field name.
	 * @return int
	 */
	private function rating( $field ) {
		return min( 5, max( 1, absint( $_POST[ $field ] ?? 1 ) ) );
	}
}
