<?php
/**
 * Complete live classes and release related records.
 */

namespace Classhall\LiveClasses\Application;

use Classhall\LiveClasses\Database\Installer;
use Classhall\LiveClasses\Domain\Statuses;
use Classhall\LiveClasses\Infrastructure\Audit_Log;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Class_Completion {
	/**
	 * Mark a class as held/completed and make its paid bookings reviewable.
	 *
	 * @param int    $class_id Class ID.
	 * @param string $source Completion source.
	 * @return array|\WP_Error
	 */
	public static function complete( $class_id, $source = 'admin' ) {
		global $wpdb;

		$tables   = Installer::tables();
		$class_id = absint( $class_id );
		$class    = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE class_id = %d", $class_id ) );
		if ( ! $class || ! empty( $class->deleted_at ) ) {
			return new \WP_Error( 'classhall_live_class_not_found', __( 'The live class could not be found.', 'classhall-live-classes' ) );
		}

		$now = current_time( 'mysql', true );

		$wpdb->update(
			$tables['classes'],
			array(
				'status'     => Statuses::CLASS_COMPLETED,
				'updated_at' => $now,
			),
			array( 'class_id' => $class_id ),
			array( '%s', '%s' ),
			array( '%d' )
		);

		if ( ! empty( $class->product_id ) ) {
			wp_update_post(
				array(
					'ID'          => (int) $class->product_id,
					'post_status' => 'draft',
				)
			);
		}

		$bookings_completed = $wpdb->query(
			$wpdb->prepare(
				"UPDATE {$tables['bookings']}
				SET status = %s, completed_at = %s, updated_at = %s
				WHERE class_id = %d
					AND status = %s
					AND payment_status = 'paid'",
				Statuses::BOOKING_COMPLETED,
				$now,
				$now,
				$class_id,
				Statuses::BOOKING_CONFIRMED
			)
		);

		$earnings_eligible = $wpdb->query(
			$wpdb->prepare(
				"UPDATE {$tables['earnings']}
				SET earning_status = 'eligible', updated_at = %s
				WHERE class_id = %d
					AND earning_status = 'pending'
					AND payout_status = 'unpaid'",
				$now,
				$class_id
			)
		);

		$completed_count = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$tables['classes']} WHERE teacher_user_id = %d AND status = %s AND deleted_at IS NULL",
				(int) $class->teacher_user_id,
				Statuses::CLASS_COMPLETED
			)
		);
		$wpdb->update(
			$tables['teacher_profiles'],
			array(
				'completed_class_count' => $completed_count,
				'updated_at'            => $now,
			),
			array( 'user_id' => (int) $class->teacher_user_id ),
			array( '%d', '%s' ),
			array( '%d' )
		);

		Audit_Log::record(
			'class_marked_held',
			'live_class',
			$class_id,
			$class->status,
			array(
				'status'              => Statuses::CLASS_COMPLETED,
				'source'              => sanitize_key( $source ),
				'bookings_completed'  => (int) $bookings_completed,
				'earnings_eligible'   => (int) $earnings_eligible,
			)
		);

		do_action( 'classhall_live_class_marked_held', $class_id, $source );

		return array(
			'bookings_completed' => (int) $bookings_completed,
			'earnings_eligible'  => (int) $earnings_eligible,
		);
	}
}
