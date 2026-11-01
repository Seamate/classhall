<?php
/**
 * Development seed data.
 */

namespace Classhall\LiveClasses\Application;

use Classhall\LiveClasses\Database\Installer;
use Classhall\LiveClasses\Domain\Statuses;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Seeder {
	/**
	 * Create demo data.
	 *
	 * @param bool $dry_run Dry run.
	 * @return string[]
	 */
	public function seed( $dry_run = true ) {
		$messages = array();
		if ( $dry_run ) {
			return array(
				'Would create sample approved teachers.',
				'Would create sample Mathematics and English live classes.',
				'Would create sample bookings, reviews, and earnings.',
			);
		}

		global $wpdb;
		$tables = Installer::tables();
		$now    = current_time( 'mysql', true );

		$teacher_id = wp_insert_user(
			array(
				'user_login'   => 'classhall-live-teacher',
				'user_email'   => 'classhall-live-teacher@example.test',
				'display_name' => 'Classhall Demo Teacher',
				'user_pass'    => wp_generate_password( 20 ),
			)
		);

		if ( is_wp_error( $teacher_id ) ) {
			$teacher = get_user_by( 'login', 'classhall-live-teacher' );
			$teacher_id = $teacher ? $teacher->ID : 0;
		}

		if ( $teacher_id ) {
			$wpdb->replace(
				$tables['teacher_profiles'],
				array(
					'user_id'            => $teacher_id,
					'teacher_slug'       => 'classhall-demo-teacher',
					'display_name'       => 'Classhall Demo Teacher',
					'bio'                => 'Development-only sample teacher profile.',
					'application_status' => Statuses::TEACHER_APPROVED,
					'is_verified'        => 1,
					'created_at'         => $now,
					'updated_at'         => $now,
				)
			);
			$messages[] = 'Created or updated sample teacher.';
		}

		return $messages;
	}
}

