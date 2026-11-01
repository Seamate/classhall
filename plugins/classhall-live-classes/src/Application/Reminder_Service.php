<?php
/**
 * Live class reminder emails.
 */

namespace Classhall\LiveClasses\Application;

use Classhall\LiveClasses\Database\Installer;
use Classhall\LiveClasses\Domain\Statuses;
use Classhall\LiveClasses\Infrastructure\Audit_Log;
use Classhall\LiveClasses\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Reminder_Service {
	const CRON_HOOK = 'classhall_live_send_class_reminders';

	/**
	 * Register reminder hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_action( self::CRON_HOOK, array( $this, 'send_due_reminders' ) );
	}

	/**
	 * Schedule reminder cron.
	 *
	 * @return void
	 */
	public static function schedule() {
		if ( ! wp_next_scheduled( self::CRON_HOOK ) ) {
			wp_schedule_event( time() + 5 * MINUTE_IN_SECONDS, 'hourly', self::CRON_HOOK );
		}
	}

	/**
	 * Clear reminder cron.
	 *
	 * @return void
	 */
	public static function unschedule() {
		$timestamp = wp_next_scheduled( self::CRON_HOOK );
		while ( $timestamp ) {
			wp_unschedule_event( $timestamp, self::CRON_HOOK );
			$timestamp = wp_next_scheduled( self::CRON_HOOK );
		}
	}

	/**
	 * Send all due reminder emails.
	 *
	 * @return void
	 */
	public function send_due_reminders() {
		global $wpdb;

		$settings = Plugin::settings();
		if ( empty( $settings['reminder_emails_enabled'] ) ) {
			$this->record_last_run( 'disabled', 0, 0 );
			return;
		}

		$windows     = $this->reminder_windows( $settings );
		$batch_limit = max( 1, absint( $settings['reminder_batch_limit'] ?? 100 ) );
		if ( empty( $windows ) ) {
			$this->record_last_run( 'no_windows', 0, 0 );
			return;
		}

		$tables      = Installer::tables();
		$now_ts      = time();
		$now_gmt     = gmdate( 'Y-m-d H:i:s', $now_ts );
		$max_window  = max( array_values( $windows ) );
		$until       = gmdate( 'Y-m-d H:i:s', $now_ts + ( $max_window * MINUTE_IN_SECONDS ) + HOUR_IN_SECONDS );
		$query_limit = max( 25, $batch_limit * 5 );
		$bookings = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT b.*, c.post_id, c.teacher_user_id, c.primary_subject_label, c.class_levels, c.class_type,
					c.start_at_utc, c.end_at_utc, c.duration_minutes
				FROM {$tables['bookings']} b
				INNER JOIN {$tables['classes']} c ON c.class_id = b.class_id
				WHERE b.status = %s
					AND b.payment_status = 'paid'
					AND c.deleted_at IS NULL
					AND (
						(c.start_at_utc > %s AND c.start_at_utc <= %s)
						OR EXISTS (
							SELECT 1 FROM {$tables['sessions']} s
							WHERE s.class_id = b.class_id
								AND s.deleted_at IS NULL
								AND s.start_at_utc > %s
								AND s.start_at_utc <= %s
						)
					)
				ORDER BY c.start_at_utc ASC
				LIMIT %d",
				Statuses::BOOKING_CONFIRMED,
				$now_gmt,
				$until,
				$now_gmt,
				$until,
				$query_limit
			)
		);

		$sent = 0;
		foreach ( $bookings as $booking ) {
			foreach ( $this->booking_sessions( $booking ) as $session ) {
				if ( $sent >= $batch_limit ) {
					$this->record_last_run( 'batch_limit_reached', count( $bookings ), $sent );
					return;
				}

				$start_ts = strtotime( $session->start_at_utc . ' UTC' );
				if ( ! $start_ts || $start_ts <= $now_ts ) {
					continue;
				}

				foreach ( $windows as $window => $minutes ) {
					if ( $sent >= $batch_limit ) {
						$this->record_last_run( 'batch_limit_reached', count( $bookings ), $sent );
						return;
					}
					if ( $this->maybe_send_reminder( $booking, $session, $window, $minutes * MINUTE_IN_SECONDS, $now_ts, $start_ts ) ) {
						$sent++;
					}
				}
			}
		}

		$this->record_last_run( 'complete', count( $bookings ), $sent );
	}

	/**
	 * Send one reminder window if due and not previously sent.
	 *
	 * @param object $booking Booking joined with class.
	 * @param object $session Session object.
	 * @param string $window Reminder window key.
	 * @param int    $offset Offset seconds before start.
	 * @param int    $now_ts Current timestamp.
	 * @param int    $start_ts Session start timestamp.
	 * @return bool
	 */
	private function maybe_send_reminder( $booking, $session, $window, $offset, $now_ts, $start_ts ) {
		if ( $now_ts < ( $start_ts - $offset ) ) {
			return false;
		}

		if ( $offset >= DAY_IN_SECONDS && ( $start_ts - $now_ts ) <= ( 2 * HOUR_IN_SECONDS ) ) {
			return false;
		}

		$marker = $this->sent_marker_key( $booking, $session, $window );
		if ( get_option( $marker ) ) {
			return false;
		}

		$this->send_student_reminder( $booking, $session, $window );
		$this->send_teacher_reminder( $booking, $session, $window );
		add_option( $marker, current_time( 'mysql', true ), '', false );
		Audit_Log::record(
			'class_reminder_sent',
			'booking',
			absint( $booking->booking_id ),
			null,
			array(
				'window'     => $window,
				'session_id' => absint( $session->session_id ),
				'start'      => $session->start_at_utc,
			)
		);

		return true;
	}

	/**
	 * Parse reminder windows from settings.
	 *
	 * @param array $settings Plugin settings.
	 * @return array<string,int>
	 */
	private function reminder_windows( $settings ) {
		$raw     = (string) ( $settings['reminder_windows_minutes'] ?? '1440,60' );
		$windows = array();

		foreach ( preg_split( '/[,\s]+/', $raw ) as $part ) {
			$minutes = absint( $part );
			if ( $minutes > 0 && $minutes <= 10080 ) {
				$windows[ $minutes . 'm' ] = $minutes;
			}
		}

		arsort( $windows, SORT_NUMERIC );
		return $windows;
	}

	/**
	 * Store the last reminder run summary for admin visibility.
	 *
	 * @param string $status Run status.
	 * @param int    $bookings_checked Number of bookings checked.
	 * @param int    $reminders_sent Number of reminder batches sent.
	 * @return void
	 */
	private function record_last_run( $status, $bookings_checked, $reminders_sent ) {
		update_option(
			'classhall_live_reminder_last_run',
			array(
				'ran_at'           => current_time( 'mysql', true ),
				'status'           => sanitize_key( $status ),
				'bookings_checked' => absint( $bookings_checked ),
				'reminders_sent'   => absint( $reminders_sent ),
			),
			false
		);
	}

	/**
	 * Email the student.
	 *
	 * @param object $booking Booking joined with class.
	 * @param object $session Session object.
	 * @param string $window Reminder window key.
	 * @return void
	 */
	private function send_student_reminder( $booking, $session, $window ) {
		$student = get_user_by( 'id', (int) $booking->student_user_id );
		$teacher = get_user_by( 'id', (int) $booking->teacher_user_id );
		if ( ! $student || ! $student->user_email ) {
			return;
		}

		$subject = sprintf(
			/* translators: %s: live class title. */
			__( 'Reminder: %s is coming up', 'classhall-live-classes' ),
			get_the_title( (int) $booking->post_id )
		);
		$message = sprintf(
			/* translators: 1: student name, 2: reminder window, 3: class title, 4: subject, 5: class level, 6: class type, 7: session date, 8: teacher name, 9: dashboard URL. */
			__( "Hello %1\$s,\n\nThis is a %2\$s reminder for your Classhall live class.\n\nClass: %3\$s\nSubject: %4\$s\nClass level: %5\$s\nClass type: %6\$s\nSession time: %7\$s\nTeacher: %8\$s\n\nView your booking from your Classhall live classes dashboard:\n%9\$s\n\nFor security, the meeting link is only shown in your dashboard during the allowed access window.", 'classhall-live-classes' ),
			$student->display_name,
			$this->window_label( $window ),
			get_the_title( (int) $booking->post_id ),
			$booking->primary_subject_label,
			$booking->class_levels ?: '-',
			$this->class_type_label( $booking->class_type ),
			$this->format_utc( $session->start_at_utc ),
			$teacher ? $teacher->display_name : __( 'Classhall teacher', 'classhall-live-classes' ),
			apply_filters( 'classhall_live_student_dashboard_url', home_url( '/my-live-classes/' ), (int) $booking->booking_id, null, $booking )
		);

		wp_mail( $student->user_email, $subject, $message );
	}

	/**
	 * Email the teacher.
	 *
	 * @param object $booking Booking joined with class.
	 * @param object $session Session object.
	 * @param string $window Reminder window key.
	 * @return void
	 */
	private function send_teacher_reminder( $booking, $session, $window ) {
		$student = get_user_by( 'id', (int) $booking->student_user_id );
		$teacher = get_user_by( 'id', (int) $booking->teacher_user_id );
		if ( ! $teacher || ! $teacher->user_email ) {
			return;
		}

		$subject = __( 'Reminder: You have a Classhall live class', 'classhall-live-classes' );
		$message = sprintf(
			/* translators: 1: teacher name, 2: reminder window, 3: class title, 4: class level, 5: class type, 6: session date, 7: student name, 8: dashboard URL. */
			__( "Hello %1\$s,\n\nThis is a %2\$s reminder for your Classhall live class.\n\nClass: %3\$s\nClass level: %4\$s\nClass type: %5\$s\nSession time: %6\$s\nStudent: %7\$s\n\nView your live classes dashboard:\n%8\$s\n\nPlease keep the meeting link private and admit only booked students.", 'classhall-live-classes' ),
			$teacher->display_name,
			$this->window_label( $window ),
			get_the_title( (int) $booking->post_id ),
			$booking->class_levels ?: '-',
			$this->class_type_label( $booking->class_type ),
			$this->format_utc( $session->start_at_utc ),
			$student ? $student->display_name : __( 'Student', 'classhall-live-classes' ),
			apply_filters( 'classhall_live_teacher_dashboard_url', home_url( '/create-a-live-class/' ), (int) $booking->booking_id, $booking )
		);

		wp_mail( $teacher->user_email, $subject, $message );
	}

	/**
	 * Get booking sessions, falling back to the class row for older one-time classes.
	 *
	 * @param object $booking Booking joined with class.
	 * @return array
	 */
	private function booking_sessions( $booking ) {
		global $wpdb;

		$tables   = Installer::tables();
		$sessions = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT session_id, start_at_utc, end_at_utc
				FROM {$tables['sessions']}
				WHERE class_id = %d AND deleted_at IS NULL AND start_at_utc IS NOT NULL
				ORDER BY start_at_utc ASC",
				absint( $booking->class_id )
			)
		);

		if ( ! empty( $sessions ) ) {
			return $sessions;
		}

		return array(
			(object) array(
				'session_id'    => 0,
				'start_at_utc'  => $booking->start_at_utc,
				'end_at_utc'    => $booking->end_at_utc,
			),
		);
	}

	/**
	 * Build a persistent sent marker key.
	 *
	 * @param object $booking Booking object.
	 * @param object $session Session object.
	 * @param string $window Reminder window.
	 * @return string
	 */
	private function sent_marker_key( $booking, $session, $window ) {
		return 'classhall_live_reminder_' . md5( implode( '|', array( $booking->booking_id, $booking->class_id, $session->session_id, $session->start_at_utc, $window ) ) );
	}

	/**
	 * Format reminder window.
	 *
	 * @param string $window Window key.
	 * @return string
	 */
	private function window_label( $window ) {
		$minutes = absint( $window );
		if ( ! $minutes && preg_match( '/^(\d+)m$/', (string) $window, $matches ) ) {
			$minutes = absint( $matches[1] );
		}

		if ( $minutes >= 1440 && 0 === $minutes % 1440 ) {
			return sprintf(
				/* translators: %d: number of days. */
				_n( '%d-day', '%d-day', (int) ( $minutes / 1440 ), 'classhall-live-classes' ),
				(int) ( $minutes / 1440 )
			);
		}

		if ( $minutes >= 60 && 0 === $minutes % 60 ) {
			return sprintf(
				/* translators: %d: number of hours. */
				_n( '%d-hour', '%d-hour', (int) ( $minutes / 60 ), 'classhall-live-classes' ),
				(int) ( $minutes / 60 )
			);
		}

		return sprintf(
			/* translators: %d: number of minutes. */
			_n( '%d-minute', '%d-minute', $minutes, 'classhall-live-classes' ),
			$minutes
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
}
