<?php
/**
 * Admin screens and moderation actions.
 */

namespace Classhall\LiveClasses\Admin;

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

final class Admin {
	/**
	 * Subject adapter.
	 *
	 * @var Subject_Adapter
	 */
	private $subjects;

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
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_init', array( $this, 'settings' ) );
		add_action( 'admin_notices', array( $this, 'dependency_notices' ) );
		add_action( 'admin_post_classhall_live_teacher_status', array( $this, 'handle_teacher_status' ) );
		add_action( 'admin_post_classhall_live_teacher_verification', array( $this, 'handle_teacher_verification' ) );
		add_action( 'admin_post_classhall_live_class_status', array( $this, 'handle_class_status' ) );
		add_action( 'admin_post_classhall_live_class_delete', array( $this, 'handle_class_delete' ) );
		add_action( 'admin_post_classhall_live_review_status', array( $this, 'handle_review_status' ) );
		add_action( 'admin_post_classhall_live_create_payout', array( $this, 'handle_create_payout' ) );
		add_action( 'admin_post_classhall_live_payout_status', array( $this, 'handle_payout_status' ) );
	}

	/**
	 * Register admin menu.
	 *
	 * @return void
	 */
	public function menu() {
		add_menu_page(
			__( 'Live Classes', 'classhall-live-classes' ),
			__( 'Live Classes', 'classhall-live-classes' ),
			Capabilities::MANAGE_TEACHERS,
			'classhall-live-classes',
			array( $this, 'render_dashboard' ),
			'dashicons-video-alt3',
			56
		);

		add_submenu_page( 'classhall-live-classes', __( 'Earnings & Payouts', 'classhall-live-classes' ), __( 'Earnings & Payouts', 'classhall-live-classes' ), Capabilities::MANAGE_PAYOUTS, 'classhall-live-payouts', array( $this, 'render_payouts' ) );
		add_submenu_page( 'classhall-live-classes', __( 'Reviews', 'classhall-live-classes' ), __( 'Reviews', 'classhall-live-classes' ), Capabilities::MODERATE_REVIEWS, 'classhall-live-reviews', array( $this, 'render_reviews' ) );
		add_submenu_page( 'classhall-live-classes', __( 'Settings', 'classhall-live-classes' ), __( 'Settings', 'classhall-live-classes' ), Capabilities::MANAGE_SETTINGS, 'classhall-live-settings', array( $this, 'render_settings' ) );
	}

	/**
	 * Register settings.
	 *
	 * @return void
	 */
	public function settings() {
		register_setting( 'classhall_live_settings', Plugin::OPTION_KEY, array( $this, 'sanitize_settings' ) );
	}

	/**
	 * Sanitize settings.
	 *
	 * @param array $raw Raw settings.
	 * @return array
	 */
	public function sanitize_settings( $raw ) {
		$raw = is_array( $raw ) ? $raw : array();

		return array(
			'commission_percent'            => min( 100, max( 0, (float) ( $raw['commission_percent'] ?? 20 ) ) ),
			'currency'                      => strtoupper( sanitize_text_field( $raw['currency'] ?? 'NGN' ) ),
			'minimum_price_minor'           => absint( $raw['minimum_price_minor'] ?? 100000 ),
			'maximum_capacity'              => max( 1, absint( $raw['maximum_capacity'] ?? 100 ) ),
			'booking_close_buffer_minutes'  => absint( $raw['booking_close_buffer_minutes'] ?? 30 ),
			'meeting_access_before_minutes' => absint( $raw['meeting_access_before_minutes'] ?? 30 ),
			'meeting_access_after_minutes'  => absint( $raw['meeting_access_after_minutes'] ?? 120 ),
			'minimum_top_rated_reviews'     => absint( $raw['minimum_top_rated_reviews'] ?? 5 ),
			'minimum_top_rated_completed'   => absint( $raw['minimum_top_rated_completed'] ?? 3 ),
			'reminder_emails_enabled'       => empty( $raw['reminder_emails_enabled'] ) ? 0 : 1,
			'reminder_windows_minutes'      => $this->sanitize_reminder_windows( $raw['reminder_windows_minutes'] ?? '1440,60' ),
			'reminder_batch_limit'          => max( 1, min( 1000, absint( $raw['reminder_batch_limit'] ?? 100 ) ) ),
			'review_moderation'             => empty( $raw['review_moderation'] ) ? 0 : 1,
			'class_approval_required'       => empty( $raw['class_approval_required'] ) ? 0 : 1,
			'debug_logging'                 => empty( $raw['debug_logging'] ) ? 0 : 1,
			'delete_data_on_uninstall'      => empty( $raw['delete_data_on_uninstall'] ) ? 0 : 1,
		);
	}

	/**
	 * Sanitize reminder window setting.
	 *
	 * @param mixed $raw Raw value.
	 * @return string
	 */
	private function sanitize_reminder_windows( $raw ) {
		$raw     = is_array( $raw ) ? implode( ',', $raw ) : (string) $raw;
		$windows = array();

		foreach ( preg_split( '/[,\s]+/', $raw ) as $part ) {
			$minutes = absint( $part );
			if ( $minutes > 0 && $minutes <= 10080 ) {
				$windows[] = $minutes;
			}
		}

		$windows = array_values( array_unique( $windows ) );
		rsort( $windows, SORT_NUMERIC );

		return implode( ',', empty( $windows ) ? array( 1440, 60 ) : $windows );
	}

	/**
	 * Dependency notices.
	 *
	 * @return void
	 */
	public function dependency_notices() {
		if ( ! current_user_can( Capabilities::MANAGE_SETTINGS ) ) {
			return;
		}

		if ( ! class_exists( 'WooCommerce' ) ) {
			echo '<div class="notice notice-warning"><p>' . esc_html__( 'Classhall Live Classes needs WooCommerce active for checkout and booking confirmation.', 'classhall-live-classes' ) . '</p></div>';
		}

		if ( ! post_type_exists( 'course' ) ) {
			echo '<div class="notice notice-info"><p>' . esc_html__( 'Sensei LMS course detection is unavailable. Live classes will still work with subject keys.', 'classhall-live-classes' ) . '</p></div>';
		}
	}

	/**
	 * Render dashboard.
	 *
	 * @return void
	 */
	public function render_dashboard() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MANAGE_TEACHERS ) ) {
			wp_die( esc_html__( 'You do not have permission to manage live classes.', 'classhall-live-classes' ) );
		}

		$tables   = Installer::tables();
		$teachers = $wpdb->get_results( "SELECT * FROM {$tables['teacher_profiles']} WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT 50" );
		$classes  = $wpdb->get_results( "SELECT * FROM {$tables['classes']} WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT 50" );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Classhall Live Classes', 'classhall-live-classes' ); ?></h1>
			<h2><?php esc_html_e( 'Teacher Applications', 'classhall-live-classes' ); ?></h2>
			<?php $this->render_teacher_table( $teachers ); ?>
			<h2><?php esc_html_e( 'Live Classes', 'classhall-live-classes' ); ?></h2>
			<?php $this->render_class_table( $classes ); ?>
		</div>
		<?php
	}

	/**
	 * Render settings screen.
	 *
	 * @return void
	 */
	public function render_settings() {
		if ( ! current_user_can( Capabilities::MANAGE_SETTINGS ) ) {
			wp_die( esc_html__( 'You do not have permission to manage live class settings.', 'classhall-live-classes' ) );
		}

		$settings = Plugin::settings();
		$last_run = get_option( 'classhall_live_reminder_last_run', array() );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Live Classes Settings', 'classhall-live-classes' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'classhall_live_settings' ); ?>
				<table class="form-table" role="presentation">
					<?php
					$fields = array(
						'commission_percent'            => __( 'Classhall commission percentage', 'classhall-live-classes' ),
						'currency'                      => __( 'Currency', 'classhall-live-classes' ),
						'minimum_price_minor'           => __( 'Minimum price in minor units', 'classhall-live-classes' ),
						'maximum_capacity'              => __( 'Maximum class capacity', 'classhall-live-classes' ),
						'booking_close_buffer_minutes'  => __( 'Booking close buffer minutes', 'classhall-live-classes' ),
						'meeting_access_before_minutes' => __( 'Meeting link opens minutes before class', 'classhall-live-classes' ),
						'meeting_access_after_minutes'  => __( 'Meeting link hides minutes after class', 'classhall-live-classes' ),
						'minimum_top_rated_reviews'     => __( 'Minimum Top Rated reviews', 'classhall-live-classes' ),
						'minimum_top_rated_completed'   => __( 'Minimum Top Rated completed classes', 'classhall-live-classes' ),
						'reminder_windows_minutes'      => __( 'Reminder windows in minutes', 'classhall-live-classes' ),
						'reminder_batch_limit'          => __( 'Maximum reminders per cron run', 'classhall-live-classes' ),
					);
					foreach ( $fields as $key => $label ) :
						?>
						<tr>
							<th scope="row"><label for="classhall_live_<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $label ); ?></label></th>
							<td><input id="classhall_live_<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( Plugin::OPTION_KEY . '[' . $key . ']' ); ?>" value="<?php echo esc_attr( $settings[ $key ] ); ?>" class="regular-text"></td>
						</tr>
					<?php endforeach; ?>
					<?php foreach ( array( 'reminder_emails_enabled', 'review_moderation', 'class_approval_required', 'debug_logging', 'delete_data_on_uninstall' ) as $key ) : ?>
						<tr>
							<th scope="row"><?php echo esc_html( ucwords( str_replace( '_', ' ', $key ) ) ); ?></th>
							<td><label><input type="checkbox" name="<?php echo esc_attr( Plugin::OPTION_KEY . '[' . $key . ']' ); ?>" value="1" <?php checked( ! empty( $settings[ $key ] ) ); ?>> <?php esc_html_e( 'Enabled', 'classhall-live-classes' ); ?></label></td>
						</tr>
					<?php endforeach; ?>
					<tr>
						<th scope="row"><?php esc_html_e( 'Reminder last run', 'classhall-live-classes' ); ?></th>
						<td>
							<?php if ( empty( $last_run ) || ! is_array( $last_run ) ) : ?>
								<?php esc_html_e( 'Not run yet.', 'classhall-live-classes' ); ?>
							<?php else : ?>
								<?php
								echo esc_html(
									sprintf(
										/* translators: 1: run time, 2: status, 3: scanned count, 4: sent count. */
										__( '%1$s - %2$s. Checked %3$d bookings and sent %4$d reminder batches.', 'classhall-live-classes' ),
										$last_run['ran_at'] ?? '-',
										$last_run['status'] ?? '-',
										absint( $last_run['bookings_checked'] ?? 0 ),
										absint( $last_run['reminders_sent'] ?? 0 )
									)
								);
								?>
							<?php endif; ?>
							<p class="description"><?php esc_html_e( 'Reminder windows use minutes before class start. Default is 1440,60 for 24 hours and 1 hour.', 'classhall-live-classes' ); ?></p>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Render teacher earnings and payout management.
	 *
	 * @return void
	 */
	public function render_payouts() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MANAGE_PAYOUTS ) ) {
			wp_die( esc_html__( 'You do not have permission to manage live class payouts.', 'classhall-live-classes' ) );
		}

		$tables       = Installer::tables();
		$selected_id  = absint( $_GET['teacher_user_id'] ?? 0 );
		$notice       = sanitize_key( wp_unslash( $_GET['classhall_live_notice'] ?? '' ) );
		$error        = sanitize_key( wp_unslash( $_GET['classhall_live_error'] ?? '' ) );
		$balances     = $wpdb->get_results(
			"SELECT teacher_user_id, currency,
				SUM(CASE WHEN payout_status = 'unpaid' AND earning_status IN ('pending', 'eligible') THEN teacher_minor ELSE 0 END) AS unpaid_minor,
				SUM(CASE WHEN payout_status = 'processing' THEN teacher_minor ELSE 0 END) AS processing_minor,
				SUM(CASE WHEN payout_status = 'paid' THEN teacher_minor ELSE 0 END) AS paid_minor,
				COUNT(*) AS earning_count
			FROM {$tables['earnings']}
			GROUP BY teacher_user_id, currency
			ORDER BY unpaid_minor DESC, teacher_user_id ASC
			LIMIT 100"
		);

		if ( ! $selected_id ) {
			foreach ( $balances as $balance ) {
				if ( (int) $balance->unpaid_minor > 0 ) {
					$selected_id = (int) $balance->teacher_user_id;
					break;
				}
			}
		}

		$earnings = array();
		if ( $selected_id ) {
			$earnings = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT e.*, c.post_id, c.primary_subject_label, c.start_at_utc
					FROM {$tables['earnings']} e
					LEFT JOIN {$tables['classes']} c ON e.class_id = c.class_id
					WHERE e.teacher_user_id = %d
						AND e.payout_status = 'unpaid'
						AND e.earning_status IN ('pending', 'eligible')
					ORDER BY e.created_at ASC
					LIMIT 100",
					$selected_id
				)
			);
		}

		$payouts = $wpdb->get_results( "SELECT * FROM {$tables['payouts']} ORDER BY created_at DESC LIMIT 50" );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Earnings & Payouts', 'classhall-live-classes' ); ?></h1>
			<?php if ( $notice ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php echo esc_html( $this->payout_notice_text( $notice ) ); ?></p></div>
			<?php endif; ?>
			<?php if ( $error ) : ?>
				<div class="notice notice-error is-dismissible"><p><?php echo esc_html( $this->payout_error_text( $error ) ); ?></p></div>
			<?php endif; ?>

			<h2><?php esc_html_e( 'Teacher Balances', 'classhall-live-classes' ); ?></h2>
			<table class="widefat striped">
				<thead><tr><th><?php esc_html_e( 'Teacher', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Unpaid (₦)', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Processing (₦)', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Paid (₦)', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Earnings', 'classhall-live-classes' ); ?></th></tr></thead>
				<tbody>
					<?php if ( empty( $balances ) ) : ?>
						<tr><td colspan="5"><?php esc_html_e( 'No teacher earnings have been recorded yet.', 'classhall-live-classes' ); ?></td></tr>
					<?php endif; ?>
					<?php foreach ( $balances as $balance ) : ?>
						<?php $teacher = get_user_by( 'id', (int) $balance->teacher_user_id ); ?>
						<tr>
							<td><a href="<?php echo esc_url( add_query_arg( 'teacher_user_id', (int) $balance->teacher_user_id, admin_url( 'admin.php?page=classhall-live-payouts' ) ) ); ?>"><?php echo esc_html( $teacher ? $teacher->display_name : sprintf( __( 'User #%d', 'classhall-live-classes' ), (int) $balance->teacher_user_id ) ); ?></a></td>
							<td><?php echo esc_html( $this->format_money_minor( $balance->unpaid_minor, $balance->currency ) ); ?></td>
							<td><?php echo esc_html( $this->format_money_minor( $balance->processing_minor, $balance->currency ) ); ?></td>
							<td><?php echo esc_html( $this->format_money_minor( $balance->paid_minor, $balance->currency ) ); ?></td>
							<td><?php echo esc_html( (int) $balance->earning_count ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<?php if ( $selected_id ) : ?>
				<?php $selected_teacher = get_user_by( 'id', $selected_id ); ?>
				<?php $selected_profile = $wpdb->get_row( $wpdb->prepare( "SELECT bank_name, account_name, account_number FROM {$tables['teacher_profiles']} WHERE user_id = %d AND deleted_at IS NULL LIMIT 1", $selected_id ) ); ?>
				<h2><?php echo esc_html( sprintf( __( 'Create Payout Batch for %s', 'classhall-live-classes' ), $selected_teacher ? $selected_teacher->display_name : sprintf( __( 'User #%d', 'classhall-live-classes' ), $selected_id ) ) ); ?></h2>
				<div class="postbox" style="max-width:720px;padding:12px 16px">
					<h3 style="margin-top:0"><?php esc_html_e( 'Teacher Account Information', 'classhall-live-classes' ); ?></h3>
					<?php if ( $selected_profile && ( $selected_profile->bank_name || $selected_profile->account_name || $selected_profile->account_number ) ) : ?>
						<p><strong><?php esc_html_e( 'Bank name:', 'classhall-live-classes' ); ?></strong> <?php echo esc_html( $selected_profile->bank_name ?: '-' ); ?></p>
						<p><strong><?php esc_html_e( 'Account name:', 'classhall-live-classes' ); ?></strong> <?php echo esc_html( $selected_profile->account_name ?: '-' ); ?></p>
						<p><strong><?php esc_html_e( 'Account number:', 'classhall-live-classes' ); ?></strong> <?php echo esc_html( $selected_profile->account_number ?: '-' ); ?></p>
					<?php else : ?>
						<p><?php esc_html_e( 'No bank account information has been saved for this teacher yet.', 'classhall-live-classes' ); ?></p>
					<?php endif; ?>
				</div>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<?php wp_nonce_field( 'classhall_live_create_payout' ); ?>
					<input type="hidden" name="action" value="classhall_live_create_payout">
					<input type="hidden" name="teacher_user_id" value="<?php echo esc_attr( $selected_id ); ?>">
					<table class="widefat striped">
						<thead><tr><th class="check-column"><input type="checkbox" onclick="document.querySelectorAll('.classhall-live-earning-check').forEach(function(box){box.checked = this.checked;}, this);"></th><th><?php esc_html_e( 'Class', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Booking', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Teacher Amount (₦)', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Status', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Created', 'classhall-live-classes' ); ?></th></tr></thead>
						<tbody>
							<?php if ( empty( $earnings ) ) : ?>
								<tr><td colspan="6"><?php esc_html_e( 'No unpaid eligible earnings for this teacher.', 'classhall-live-classes' ); ?></td></tr>
							<?php endif; ?>
							<?php foreach ( $earnings as $earning ) : ?>
								<tr>
									<th class="check-column"><input class="classhall-live-earning-check" type="checkbox" name="earning_ids[]" value="<?php echo esc_attr( $earning->earning_id ); ?>"></th>
									<td><?php echo esc_html( get_the_title( (int) $earning->post_id ) ?: $earning->primary_subject_label ); ?></td>
									<td>#<?php echo esc_html( (int) $earning->booking_id ); ?></td>
									<td><?php echo esc_html( $this->format_money_minor( $earning->teacher_minor, $earning->currency ) ); ?></td>
									<td><?php echo esc_html( $earning->earning_status ); ?></td>
									<td><?php echo esc_html( get_date_from_gmt( $earning->created_at ) ); ?></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<p><label><?php esc_html_e( 'Payment reference', 'classhall-live-classes' ); ?><br><input type="text" name="reference" class="regular-text" placeholder="<?php esc_attr_e( 'Bank transfer reference or internal note', 'classhall-live-classes' ); ?>"></label></p>
					<p><label><?php esc_html_e( 'Notes', 'classhall-live-classes' ); ?><br><textarea name="notes" class="large-text" rows="3"></textarea></label></p>
					<?php submit_button( __( 'Create payout batch', 'classhall-live-classes' ), 'primary', 'submit', false, empty( $earnings ) ? array( 'disabled' => 'disabled' ) : array() ); ?>
				</form>
			<?php endif; ?>

			<h2><?php esc_html_e( 'Recent Payouts', 'classhall-live-classes' ); ?></h2>
			<table class="widefat striped">
				<thead><tr><th><?php esc_html_e( 'Payout', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Teacher', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Amount (₦)', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Status', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Reference', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Created', 'classhall-live-classes' ); ?></th><th><?php esc_html_e( 'Actions', 'classhall-live-classes' ); ?></th></tr></thead>
				<tbody>
					<?php if ( empty( $payouts ) ) : ?>
						<tr><td colspan="7"><?php esc_html_e( 'No payout batches have been created yet.', 'classhall-live-classes' ); ?></td></tr>
					<?php endif; ?>
					<?php foreach ( $payouts as $payout ) : ?>
						<?php $teacher = get_user_by( 'id', (int) $payout->teacher_user_id ); ?>
						<tr>
							<td>#<?php echo esc_html( (int) $payout->payout_id ); ?></td>
							<td><?php echo esc_html( $teacher ? $teacher->display_name : sprintf( __( 'User #%d', 'classhall-live-classes' ), (int) $payout->teacher_user_id ) ); ?></td>
							<td><?php echo esc_html( $this->format_money_minor( $payout->amount_minor, $payout->currency ) ); ?></td>
							<td><?php echo esc_html( $payout->status ); ?></td>
							<td><?php echo esc_html( $payout->reference ); ?></td>
							<td><?php echo esc_html( get_date_from_gmt( $payout->created_at ) ); ?></td>
							<td>
								<?php if ( 'recorded' === $payout->status ) : ?>
									<?php $this->render_payout_status_button( $payout->payout_id, 'paid', __( 'Mark paid', 'classhall-live-classes' ) ); ?>
								<?php endif; ?>
								<?php if ( 'reversed' !== $payout->status ) : ?>
									<?php $this->render_payout_status_button( $payout->payout_id, 'reversed', __( 'Reverse', 'classhall-live-classes' ), __( 'Reverse this payout batch and return its earnings to unpaid?', 'classhall-live-classes' ) ); ?>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Render review moderation screen.
	 *
	 * @return void
	 */
	public function render_reviews() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MODERATE_REVIEWS ) ) {
			wp_die( esc_html__( 'You do not have permission to moderate reviews.', 'classhall-live-classes' ) );
		}

		$tables  = Installer::tables();
		$status  = sanitize_key( wp_unslash( $_GET['review_status'] ?? Statuses::REVIEW_PENDING ) );
		$allowed = array( Statuses::REVIEW_PENDING, Statuses::REVIEW_APPROVED, Statuses::REVIEW_REJECTED, Statuses::REVIEW_HIDDEN );
		if ( ! in_array( $status, $allowed, true ) ) {
			$status = Statuses::REVIEW_PENDING;
		}

		$reviews = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT r.*, c.post_id, c.primary_subject_label, p.display_name AS teacher_profile_name, p.teacher_slug
				FROM {$tables['reviews']} r
				LEFT JOIN {$tables['classes']} c ON c.class_id = r.class_id
				LEFT JOIN {$tables['teacher_profiles']} p ON p.user_id = r.teacher_user_id AND p.deleted_at IS NULL
				WHERE r.status = %s
				ORDER BY r.created_at DESC
				LIMIT 100",
				$status
			)
		);
		$counts = $wpdb->get_results( "SELECT status, COUNT(*) AS total FROM {$tables['reviews']} GROUP BY status", OBJECT_K );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Live Class Reviews', 'classhall-live-classes' ); ?></h1>
			<nav class="nav-tab-wrapper">
				<?php foreach ( $allowed as $tab ) : ?>
					<a class="nav-tab <?php echo $tab === $status ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( array( 'page' => 'classhall-live-reviews', 'review_status' => $tab ), admin_url( 'admin.php' ) ) ); ?>">
						<?php echo esc_html( ucwords( str_replace( '_', ' ', $tab ) ) ); ?> (<?php echo esc_html( (int) ( $counts[ $tab ]->total ?? 0 ) ); ?>)
					</a>
				<?php endforeach; ?>
			</nav>
			<?php $this->render_review_table( $reviews ); ?>
		</div>
		<?php
	}

	/**
	 * Handle review moderation status changes.
	 *
	 * @return void
	 */
	public function handle_review_status() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MODERATE_REVIEWS ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-live-classes' ) );
		}

		check_admin_referer( 'classhall_live_review_status' );

		$review_id = absint( $_POST['review_id'] ?? 0 );
		$status    = sanitize_key( wp_unslash( $_POST['status'] ?? '' ) );
		$allowed   = array( Statuses::REVIEW_PENDING, Statuses::REVIEW_APPROVED, Statuses::REVIEW_REJECTED, Statuses::REVIEW_HIDDEN );

		if ( ! $review_id || ! in_array( $status, $allowed, true ) ) {
			wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-reviews' ) );
			exit;
		}

		$tables = Installer::tables();
		$review = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['reviews']} WHERE review_id = %d", $review_id ) );
		if ( $review ) {
			$wpdb->update(
				$tables['reviews'],
				array(
					'status'       => $status,
					'updated_at'   => current_time( 'mysql', true ),
					'moderated_at' => current_time( 'mysql', true ),
					'moderated_by' => get_current_user_id(),
				),
				array( 'review_id' => $review_id ),
				array( '%s', '%s', '%s', '%d' ),
				array( '%d' )
			);
			$this->recalculate_teacher_rating( (int) $review->teacher_user_id );
			Audit_Log::record( 'review_status_changed', 'review', $review_id, $review->status, $status );
		}

		wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-reviews' ) );
		exit;
	}

	/**
	 * Handle teacher status changes.
	 *
	 * @return void
	 */
	public function handle_teacher_status() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MANAGE_TEACHERS ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-live-classes' ) );
		}

		check_admin_referer( 'classhall_live_teacher_status' );

		$profile_id = absint( $_POST['profile_id'] ?? 0 );
		$status     = sanitize_key( wp_unslash( $_POST['status'] ?? '' ) );
		$allowed    = array( Statuses::TEACHER_APPROVED, Statuses::TEACHER_REJECTED, Statuses::TEACHER_SUSPENDED, Statuses::TEACHER_UNDER_REVIEW );

		if ( ! $profile_id || ! in_array( $status, $allowed, true ) ) {
			wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
			exit;
		}

		$tables  = Installer::tables();
		$profile = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['teacher_profiles']} WHERE profile_id = %d", $profile_id ) );
		if ( $profile ) {
			$wpdb->update(
				$tables['teacher_profiles'],
				array(
					'application_status' => $status,
					'updated_at'         => current_time( 'mysql', true ),
				),
				array( 'profile_id' => $profile_id ),
				array( '%s', '%s' ),
				array( '%d' )
			);

			if ( Statuses::TEACHER_APPROVED === $status ) {
				Capabilities::grant_teacher_caps( $profile->user_id );
			} elseif ( Statuses::TEACHER_SUSPENDED === $status || Statuses::TEACHER_REJECTED === $status ) {
				Capabilities::revoke_teacher_caps( $profile->user_id );
			}

			Audit_Log::record( 'teacher_status_changed', 'teacher_profile', $profile_id, $profile->application_status, $status );
		}

		wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
		exit;
	}

	/**
	 * Handle teacher verification changes.
	 *
	 * @return void
	 */
	public function handle_teacher_verification() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MANAGE_TEACHERS ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-live-classes' ) );
		}

		check_admin_referer( 'classhall_live_teacher_verification' );

		$profile_id  = absint( $_POST['profile_id'] ?? 0 );
		$is_verified = absint( $_POST['is_verified'] ?? 0 ) ? 1 : 0;
		if ( ! $profile_id ) {
			wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
			exit;
		}

		$tables  = Installer::tables();
		$profile = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['teacher_profiles']} WHERE profile_id = %d", $profile_id ) );
		if ( $profile ) {
			$wpdb->update(
				$tables['teacher_profiles'],
				array(
					'is_verified' => $is_verified,
					'updated_at'  => current_time( 'mysql', true ),
				),
				array( 'profile_id' => $profile_id ),
				array( '%d', '%s' ),
				array( '%d' )
			);
			$this->recalculate_teacher_rating( (int) $profile->user_id );
			Audit_Log::record( 'teacher_verification_changed', 'teacher_profile', $profile_id, (int) $profile->is_verified, $is_verified );
		}

		wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
		exit;
	}

	/**
	 * Handle class status changes.
	 *
	 * @return void
	 */
	public function handle_class_status() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MODERATE_CLASSES ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-live-classes' ) );
		}

		check_admin_referer( 'classhall_live_class_status' );

		$class_id = absint( $_POST['class_id'] ?? 0 );
		$status   = sanitize_key( wp_unslash( $_POST['status'] ?? '' ) );
		$allowed  = array( Statuses::CLASS_APPROVED, Statuses::CLASS_PUBLISHED, Statuses::CLASS_REJECTED, Statuses::CLASS_SUSPENDED, Statuses::CLASS_CANCELLED, Statuses::CLASS_COMPLETED );

		if ( $class_id && in_array( $status, $allowed, true ) ) {
			$tables = Installer::tables();
			$row    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE class_id = %d", $class_id ) );
			if ( $row ) {
				if ( $row->status === $status ) {
					wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
					exit;
				}

				if ( Statuses::CLASS_COMPLETED === $status ) {
					Class_Completion::complete( $class_id, 'admin' );
				} else {
					$wpdb->update( $tables['classes'], array( 'status' => $status, 'updated_at' => current_time( 'mysql', true ) ), array( 'class_id' => $class_id ), array( '%s', '%s' ), array( '%d' ) );
					wp_update_post( array( 'ID' => (int) $row->post_id, 'post_status' => in_array( $status, array( Statuses::CLASS_APPROVED, Statuses::CLASS_PUBLISHED ), true ) ? 'publish' : 'draft' ) );
					Audit_Log::record( 'class_status_changed', 'live_class', $class_id, $row->status, $status );
					do_action( 'classhall_live_class_status_changed', $class_id, $row->status, $status );
				}
			}
		}

		wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
		exit;
	}

	/**
	 * Soft delete a live class from the admin screen.
	 *
	 * @return void
	 */
	public function handle_class_delete() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MODERATE_CLASSES ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-live-classes' ) );
		}

		check_admin_referer( 'classhall_live_class_delete' );

		$class_id = absint( $_POST['class_id'] ?? 0 );
		if ( ! $class_id ) {
			wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
			exit;
		}

		$tables = Installer::tables();
		$row    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE class_id = %d", $class_id ) );
		if ( $row && empty( $row->deleted_at ) ) {
			$now = current_time( 'mysql', true );
			$wpdb->update(
				$tables['classes'],
				array(
					'status'     => Statuses::CLASS_CANCELLED,
					'deleted_at' => $now,
					'updated_at' => $now,
				),
				array( 'class_id' => $class_id ),
				array( '%s', '%s', '%s' ),
				array( '%d' )
			);

			if ( ! empty( $row->post_id ) ) {
				wp_trash_post( (int) $row->post_id );
			}

			if ( ! empty( $row->product_id ) ) {
				wp_update_post(
					array(
						'ID'          => (int) $row->product_id,
						'post_status' => 'draft',
					)
				);
			}

			Audit_Log::record( 'class_deleted', 'live_class', $class_id, $row, array( 'deleted_at' => $now ) );
		}

		wp_safe_redirect( wp_get_referer() ?: admin_url( 'admin.php?page=classhall-live-classes' ) );
		exit;
	}

	/**
	 * Create a manual payout batch from selected earnings.
	 *
	 * @return void
	 */
	public function handle_create_payout() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MANAGE_PAYOUTS ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-live-classes' ) );
		}

		check_admin_referer( 'classhall_live_create_payout' );

		$teacher_id  = absint( $_POST['teacher_user_id'] ?? 0 );
		$earning_ids = array_values( array_filter( array_map( 'absint', (array) ( $_POST['earning_ids'] ?? array() ) ) ) );
		if ( ! $teacher_id || empty( $earning_ids ) ) {
			$this->redirect_payouts( array( 'teacher_user_id' => $teacher_id, 'classhall_live_error' => 'missing_earnings' ) );
		}

		$tables       = Installer::tables();
		$placeholders = implode( ', ', array_fill( 0, count( $earning_ids ), '%d' ) );
		$query_args   = array_merge( array( $teacher_id ), $earning_ids );
		$earnings     = $wpdb->get_results(
			call_user_func_array(
				array( $wpdb, 'prepare' ),
				array_merge(
					array(
						"SELECT * FROM {$tables['earnings']}
						WHERE teacher_user_id = %d
							AND payout_status = 'unpaid'
							AND earning_status IN ('pending', 'eligible')
							AND earning_id IN ({$placeholders})",
					),
					$query_args
				)
			)
		);

		if ( empty( $earnings ) ) {
			$this->redirect_payouts( array( 'teacher_user_id' => $teacher_id, 'classhall_live_error' => 'no_payable_earnings' ) );
		}

		$currency     = strtoupper( $earnings[0]->currency );
		$amount_minor = 0;
		foreach ( $earnings as $earning ) {
			if ( strtoupper( $earning->currency ) !== $currency ) {
				$this->redirect_payouts( array( 'teacher_user_id' => $teacher_id, 'classhall_live_error' => 'mixed_currency' ) );
			}
			$amount_minor += (int) $earning->teacher_minor;
		}

		$now       = current_time( 'mysql', true );
		$reference = sanitize_text_field( wp_unslash( $_POST['reference'] ?? '' ) );
		$notes     = sanitize_textarea_field( wp_unslash( $_POST['notes'] ?? '' ) );
		$created   = $wpdb->insert(
			$tables['payouts'],
			array(
				'teacher_user_id' => $teacher_id,
				'currency'        => $currency,
				'amount_minor'    => $amount_minor,
				'status'          => 'recorded',
				'reference'       => $reference,
				'notes'           => $notes,
				'created_by'      => get_current_user_id(),
				'created_at'      => $now,
			),
			array( '%d', '%s', '%d', '%s', '%s', '%s', '%d', '%s' )
		);

		if ( ! $created ) {
			$this->redirect_payouts( array( 'teacher_user_id' => $teacher_id, 'classhall_live_error' => 'payout_failed' ) );
		}

		$payout_id = (int) $wpdb->insert_id;
		foreach ( $earnings as $earning ) {
			$wpdb->insert(
				$tables['payout_items'],
				array(
					'payout_id'    => $payout_id,
					'earning_id'   => (int) $earning->earning_id,
					'amount_minor' => (int) $earning->teacher_minor,
					'created_at'   => $now,
				),
				array( '%d', '%d', '%d', '%s' )
			);
			$wpdb->update(
				$tables['earnings'],
				array(
					'payout_status' => 'processing',
					'updated_at'     => $now,
				),
				array( 'earning_id' => (int) $earning->earning_id ),
				array( '%s', '%s' ),
				array( '%d' )
			);
		}

		Audit_Log::record(
			'payout_created',
			'payout',
			$payout_id,
			null,
			array(
				'teacher_user_id' => $teacher_id,
				'amount_minor'    => $amount_minor,
				'currency'        => $currency,
				'earning_ids'     => $earning_ids,
			)
		);

		$this->redirect_payouts( array( 'teacher_user_id' => $teacher_id, 'classhall_live_notice' => 'payout_created' ) );
	}

	/**
	 * Mark a payout paid or reverse it.
	 *
	 * @return void
	 */
	public function handle_payout_status() {
		global $wpdb;

		if ( ! current_user_can( Capabilities::MANAGE_PAYOUTS ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-live-classes' ) );
		}

		check_admin_referer( 'classhall_live_payout_status' );

		$payout_id = absint( $_POST['payout_id'] ?? 0 );
		$status    = sanitize_key( wp_unslash( $_POST['status'] ?? '' ) );
		if ( ! $payout_id || ! in_array( $status, array( 'paid', 'reversed' ), true ) ) {
			$this->redirect_payouts( array( 'classhall_live_error' => 'invalid_payout' ) );
		}

		$tables = Installer::tables();
		$payout = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['payouts']} WHERE payout_id = %d", $payout_id ) );
		if ( ! $payout ) {
			$this->redirect_payouts( array( 'classhall_live_error' => 'invalid_payout' ) );
		}
		if ( ( 'paid' === $status && 'recorded' !== $payout->status ) || ( 'reversed' === $status && 'reversed' === $payout->status ) ) {
			$this->redirect_payouts( array( 'teacher_user_id' => (int) $payout->teacher_user_id, 'classhall_live_error' => 'invalid_transition' ) );
		}

		$items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$tables['payout_items']} WHERE payout_id = %d", $payout_id ) );
		if ( empty( $items ) ) {
			$this->redirect_payouts( array( 'teacher_user_id' => (int) $payout->teacher_user_id, 'classhall_live_error' => 'empty_payout' ) );
		}

		$now          = current_time( 'mysql', true );
		$earning_ids  = array();
		foreach ( $items as $item ) {
			$earning_ids[] = (int) $item->earning_id;
		}
		$placeholders = implode( ', ', array_fill( 0, count( $earning_ids ), '%d' ) );

		if ( 'paid' === $status ) {
			$wpdb->update(
				$tables['payouts'],
				array(
					'status'  => 'paid',
					'paid_at' => $now,
				),
				array( 'payout_id' => $payout_id ),
				array( '%s', '%s' ),
				array( '%d' )
			);

			$wpdb->query(
				call_user_func_array(
					array( $wpdb, 'prepare' ),
					array_merge(
						array( "UPDATE {$tables['earnings']} SET earning_status = 'paid', payout_status = 'paid', updated_at = %s WHERE earning_id IN ({$placeholders})" ),
						array_merge( array( $now ), $earning_ids )
					)
				)
			);
		} else {
			$wpdb->update(
				$tables['payouts'],
				array(
					'status'      => 'reversed',
					'reversed_at' => $now,
				),
				array( 'payout_id' => $payout_id ),
				array( '%s', '%s' ),
				array( '%d' )
			);

			$wpdb->query(
				call_user_func_array(
					array( $wpdb, 'prepare' ),
					array_merge(
						array( "UPDATE {$tables['earnings']} SET earning_status = 'eligible', payout_status = 'unpaid', updated_at = %s WHERE earning_id IN ({$placeholders})" ),
						array_merge( array( $now ), $earning_ids )
					)
				)
			);

			$wpdb->delete( $tables['payout_items'], array( 'payout_id' => $payout_id ), array( '%d' ) );
		}

		Audit_Log::record( 'payout_' . $status, 'payout', $payout_id, $payout->status, array( 'status' => $status, 'earning_ids' => $earning_ids ) );
		$this->redirect_payouts( array( 'teacher_user_id' => (int) $payout->teacher_user_id, 'classhall_live_notice' => 'payout_' . $status ) );
	}

	/**
	 * Redirect to payout screen.
	 *
	 * @param array $args Query args.
	 * @return void
	 */
	private function redirect_payouts( $args = array() ) {
		wp_safe_redirect( add_query_arg( $args, admin_url( 'admin.php?page=classhall-live-payouts' ) ) );
		exit;
	}

	/**
	 * Format minor currency units for display.
	 *
	 * @param int|string $minor Minor units.
	 * @param string     $currency Currency code.
	 * @return string
	 */
	private function format_money_minor( $minor, $currency ) {
		unset( $currency );
		return number_format_i18n( (int) $minor / 100, 2 );
	}

	/**
	 * Render a payout status action button.
	 *
	 * @param int         $payout_id Payout ID.
	 * @param string      $status New status.
	 * @param string      $label Button label.
	 * @param string|null $confirm Confirmation message.
	 * @return void
	 */
	private function render_payout_status_button( $payout_id, $status, $label, $confirm = null ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:4px"';
		if ( $confirm ) {
			echo ' onsubmit="return confirm(\'' . esc_js( $confirm ) . '\');"';
		}
		echo '>';
		wp_nonce_field( 'classhall_live_payout_status' );
		echo '<input type="hidden" name="action" value="classhall_live_payout_status"><input type="hidden" name="payout_id" value="' . esc_attr( $payout_id ) . '"><input type="hidden" name="status" value="' . esc_attr( $status ) . '">';
		submit_button( $label, 'small', 'submit', false );
		echo '</form>';
	}

	/**
	 * Human-readable payout notices.
	 *
	 * @param string $notice Notice key.
	 * @return string
	 */
	private function payout_notice_text( $notice ) {
		$messages = array(
			'payout_created'  => __( 'Payout batch created. Pay the teacher outside Classhall, then mark the batch as paid.', 'classhall-live-classes' ),
			'payout_paid'     => __( 'Payout batch marked as paid.', 'classhall-live-classes' ),
			'payout_reversed' => __( 'Payout batch reversed and its earnings returned to unpaid.', 'classhall-live-classes' ),
		);

		return $messages[ $notice ] ?? __( 'Payout updated.', 'classhall-live-classes' );
	}

	/**
	 * Human-readable payout errors.
	 *
	 * @param string $error Error key.
	 * @return string
	 */
	private function payout_error_text( $error ) {
		$messages = array(
			'missing_earnings'     => __( 'Select at least one earning before creating a payout.', 'classhall-live-classes' ),
			'no_payable_earnings'  => __( 'The selected earnings are no longer payable.', 'classhall-live-classes' ),
			'mixed_currency'       => __( 'A payout batch can only contain earnings in one currency.', 'classhall-live-classes' ),
			'payout_failed'        => __( 'The payout batch could not be created.', 'classhall-live-classes' ),
			'invalid_payout'       => __( 'The payout batch could not be found.', 'classhall-live-classes' ),
			'invalid_transition'   => __( 'That payout status change is not available.', 'classhall-live-classes' ),
			'empty_payout'         => __( 'This payout batch has no earnings attached.', 'classhall-live-classes' ),
		);

		return $messages[ $error ] ?? __( 'The payout action could not be completed.', 'classhall-live-classes' );
	}

	/**
	 * Render teacher application table.
	 *
	 * @param array $teachers Teachers.
	 * @return void
	 */
	private function render_teacher_table( $teachers ) {
		echo '<table class="widefat striped"><thead><tr><th>' . esc_html__( 'Teacher', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Status', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Verified', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Actions', 'classhall-live-classes' ) . '</th></tr></thead><tbody>';
		foreach ( $teachers as $teacher ) {
			$user = get_user_by( 'id', $teacher->user_id );
			echo '<tr><td>' . esc_html( $user ? $user->display_name : $teacher->display_name ) . '</td><td>' . esc_html( $teacher->application_status ) . '</td><td>' . esc_html( $teacher->is_verified ? __( 'Yes', 'classhall-live-classes' ) : __( 'No', 'classhall-live-classes' ) ) . '</td><td>';
			foreach ( array( Statuses::TEACHER_APPROVED, Statuses::TEACHER_REJECTED, Statuses::TEACHER_SUSPENDED ) as $status ) {
				echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:4px">';
				wp_nonce_field( 'classhall_live_teacher_status' );
				echo '<input type="hidden" name="action" value="classhall_live_teacher_status"><input type="hidden" name="profile_id" value="' . esc_attr( $teacher->profile_id ) . '"><input type="hidden" name="status" value="' . esc_attr( $status ) . '">';
				submit_button( ucwords( str_replace( '_', ' ', $status ) ), 'small', 'submit', false );
				echo '</form>';
			}
			echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:4px">';
			wp_nonce_field( 'classhall_live_teacher_verification' );
			echo '<input type="hidden" name="action" value="classhall_live_teacher_verification"><input type="hidden" name="profile_id" value="' . esc_attr( $teacher->profile_id ) . '"><input type="hidden" name="is_verified" value="' . esc_attr( $teacher->is_verified ? 0 : 1 ) . '">';
			submit_button( $teacher->is_verified ? __( 'Unverify', 'classhall-live-classes' ) : __( 'Verify', 'classhall-live-classes' ), 'small', 'submit', false );
			echo '</form>';
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}

	/**
	 * Render class table.
	 *
	 * @param array $classes Classes.
	 * @return void
	 */
	private function render_class_table( $classes ) {
		echo '<table class="widefat striped"><thead><tr><th>' . esc_html__( 'Class', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Subject', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Status', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Seats', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Actions', 'classhall-live-classes' ) . '</th></tr></thead><tbody>';
		foreach ( $classes as $class ) {
			echo '<tr><td><a href="' . esc_url( get_edit_post_link( $class->post_id ) ) . '">' . esc_html( get_the_title( $class->post_id ) ) . '</a></td><td>' . esc_html( $class->primary_subject_label ) . '</td><td>' . esc_html( $class->status ) . '</td><td>' . esc_html( $class->confirmed_seats . '/' . $class->capacity ) . '</td><td>';
			foreach ( array( Statuses::CLASS_APPROVED, Statuses::CLASS_REJECTED, Statuses::CLASS_SUSPENDED, Statuses::CLASS_COMPLETED ) as $status ) {
				echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:4px">';
				wp_nonce_field( 'classhall_live_class_status' );
				echo '<input type="hidden" name="action" value="classhall_live_class_status"><input type="hidden" name="class_id" value="' . esc_attr( $class->class_id ) . '"><input type="hidden" name="status" value="' . esc_attr( $status ) . '">';
				submit_button( ucwords( str_replace( '_', ' ', $status ) ), 'small', 'submit', false );
				echo '</form>';
			}
			echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:4px" onsubmit="return confirm(\'' . esc_js( __( 'Delete this live class? Booking and audit records will be preserved.', 'classhall-live-classes' ) ) . '\');">';
			wp_nonce_field( 'classhall_live_class_delete' );
			echo '<input type="hidden" name="action" value="classhall_live_class_delete"><input type="hidden" name="class_id" value="' . esc_attr( $class->class_id ) . '">';
			submit_button( __( 'Delete', 'classhall-live-classes' ), 'small delete', 'submit', false );
			echo '</form>';
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}

	/**
	 * Render review moderation table.
	 *
	 * @param array $reviews Review rows.
	 * @return void
	 */
	private function render_review_table( $reviews ) {
		echo '<table class="widefat striped"><thead><tr><th>' . esc_html__( 'Review', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Class', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Teacher', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Student', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Rating', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Status', 'classhall-live-classes' ) . '</th><th>' . esc_html__( 'Actions', 'classhall-live-classes' ) . '</th></tr></thead><tbody>';
		if ( empty( $reviews ) ) {
			echo '<tr><td colspan="7">' . esc_html__( 'No reviews found.', 'classhall-live-classes' ) . '</td></tr>';
		}
		foreach ( $reviews as $review ) {
			$student = get_user_by( 'id', (int) $review->student_user_id );
			$teacher = $review->teacher_profile_name ?: ( ( $user = get_user_by( 'id', (int) $review->teacher_user_id ) ) ? $user->display_name : sprintf( __( 'User #%d', 'classhall-live-classes' ), (int) $review->teacher_user_id ) );
			echo '<tr><td>';
			echo '<strong>#' . esc_html( (int) $review->review_id ) . '</strong><br>';
			echo esc_html( wp_trim_words( wp_strip_all_tags( (string) $review->review_text ), 24 ) );
			echo '</td><td>';
			if ( $review->post_id ) {
				echo '<a href="' . esc_url( get_edit_post_link( (int) $review->post_id ) ) . '">' . esc_html( get_the_title( (int) $review->post_id ) ?: $review->primary_subject_label ) . '</a>';
			} else {
				echo esc_html( $review->primary_subject_label ?: sprintf( __( 'Class #%d', 'classhall-live-classes' ), (int) $review->class_id ) );
			}
			echo '</td><td>' . esc_html( $teacher ) . '</td><td>' . esc_html( $student ? $student->display_name : sprintf( __( 'User #%d', 'classhall-live-classes' ), (int) $review->student_user_id ) ) . '</td><td>' . esc_html( number_format_i18n( (float) $review->overall_rating, 1 ) ) . '</td><td>' . esc_html( $review->status ) . '</td><td>';
			foreach ( array( Statuses::REVIEW_APPROVED, Statuses::REVIEW_REJECTED, Statuses::REVIEW_HIDDEN, Statuses::REVIEW_PENDING ) as $status ) {
				if ( $status === $review->status ) {
					continue;
				}
				echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin-right:4px">';
				wp_nonce_field( 'classhall_live_review_status' );
				echo '<input type="hidden" name="action" value="classhall_live_review_status"><input type="hidden" name="review_id" value="' . esc_attr( $review->review_id ) . '"><input type="hidden" name="status" value="' . esc_attr( $status ) . '">';
				submit_button( ucwords( str_replace( '_', ' ', $status ) ), 'small', 'submit', false );
				echo '</form>';
			}
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}

	/**
	 * Recalculate public rating aggregates for one teacher.
	 *
	 * @param int $teacher_user_id Teacher user ID.
	 * @return void
	 */
	private function recalculate_teacher_rating( $teacher_user_id ) {
		global $wpdb;
		$tables = Installer::tables();
		$teacher_user_id = absint( $teacher_user_id );
		if ( ! $teacher_user_id ) {
			return;
		}

		$stats = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT COUNT(*) AS rating_count, COALESCE(AVG(overall_rating), 0) AS average_rating
				FROM {$tables['reviews']}
				WHERE teacher_user_id = %d AND status = %s",
				$teacher_user_id,
				Statuses::REVIEW_APPROVED
			)
		);
		$upcoming = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$tables['classes']} WHERE teacher_user_id = %d AND status IN ('approved','published') AND start_at_utc >= %s AND deleted_at IS NULL",
				$teacher_user_id,
				current_time( 'mysql', true )
			)
		);
		$profile = $wpdb->get_row( $wpdb->prepare( "SELECT completed_class_count, is_verified FROM {$tables['teacher_profiles']} WHERE user_id = %d AND deleted_at IS NULL", $teacher_user_id ) );
		$average = round( (float) ( $stats->average_rating ?? 0 ), 2 );
		$count   = absint( $stats->rating_count ?? 0 );
		$score   = ( new Ranking_Service() )->score( $average, $count, absint( $profile->completed_class_count ?? 0 ), $upcoming, ! empty( $profile->is_verified ), 0 );

		$wpdb->update(
			$tables['teacher_profiles'],
			array(
				'average_rating' => $average,
				'rating_count'   => $count,
				'ranking_score'  => $score,
				'updated_at'     => current_time( 'mysql', true ),
			),
			array( 'user_id' => $teacher_user_id ),
			array( '%f', '%d', '%f', '%s' ),
			array( '%d' )
		);
	}
}
