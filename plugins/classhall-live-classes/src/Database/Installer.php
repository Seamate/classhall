<?php
/**
 * Database migrations.
 */

namespace Classhall\LiveClasses\Database;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Installer {
	/**
	 * Run versioned migrations.
	 *
	 * @return void
	 */
	public static function migrate() {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$charset = $wpdb->get_charset_collate();
		foreach ( self::schema( $wpdb->prefix, $charset ) as $sql ) {
			dbDelta( $sql );
		}

		$tables = self::tables( $wpdb->prefix );
		$wpdb->query( "ALTER TABLE {$tables['reviews']} MODIFY overall_rating DECIMAL(3,1) NOT NULL DEFAULT 0.0" );
		$wpdb->query( "UPDATE {$tables['reviews']} SET overall_rating = ROUND((clarity_rating + punctuality_rating) / 2, 1)" );
		$wpdb->query(
			"UPDATE {$tables['teacher_profiles']} p
			LEFT JOIN (
				SELECT teacher_user_id, COUNT(*) AS rating_count, AVG(overall_rating) AS average_rating
				FROM {$tables['reviews']}
				WHERE status = 'approved'
				GROUP BY teacher_user_id
			) r ON p.user_id = r.teacher_user_id
			SET p.average_rating = COALESCE(ROUND(r.average_rating, 2), 0),
				p.rating_count = COALESCE(r.rating_count, 0)"
		);

		update_option( 'classhall_live_db_version', CLASSHALL_LIVE_DB_VERSION, false );
	}

	/**
	 * Build dbDelta-compatible schema SQL.
	 *
	 * @param string $prefix Database prefix.
	 * @param string $charset Charset/collation clause.
	 * @return string[]
	 */
	public static function schema( $prefix, $charset ) {
		$tables = self::tables( $prefix );

		return array(
			"CREATE TABLE {$tables['teacher_profiles']} (
				profile_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				user_id BIGINT UNSIGNED NOT NULL,
				teacher_slug VARCHAR(191) NOT NULL,
				display_name VARCHAR(191) NOT NULL DEFAULT '',
				bio LONGTEXT NULL,
				photo_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				phone VARCHAR(60) NOT NULL DEFAULT '',
				qualifications LONGTEXT NULL,
				experience_years SMALLINT UNSIGNED NOT NULL DEFAULT 0,
				class_levels TEXT NULL,
				exam_specialisations TEXT NULL,
				preferred_formats TEXT NULL,
				bank_name VARCHAR(191) NOT NULL DEFAULT '',
				account_name VARCHAR(191) NOT NULL DEFAULT '',
				account_number VARCHAR(60) NOT NULL DEFAULT '',
				document_refs TEXT NULL,
				terms_accepted_at DATETIME NULL,
				application_status VARCHAR(30) NOT NULL DEFAULT 'draft',
				is_verified TINYINT(1) NOT NULL DEFAULT 0,
				average_rating DECIMAL(4,2) NOT NULL DEFAULT 0.00,
				rating_count INT UNSIGNED NOT NULL DEFAULT 0,
				completed_class_count INT UNSIGNED NOT NULL DEFAULT 0,
				ranking_score DECIMAL(8,4) NOT NULL DEFAULT 0.0000,
				admin_notes LONGTEXT NULL,
				rejection_reason TEXT NULL,
				created_at DATETIME NOT NULL,
				updated_at DATETIME NOT NULL,
				deleted_at DATETIME NULL,
				PRIMARY KEY  (profile_id),
				UNIQUE KEY user_id (user_id),
				UNIQUE KEY teacher_slug (teacher_slug),
				KEY application_status (application_status),
				KEY is_verified (is_verified),
				KEY ranking_score (ranking_score)
			) {$charset};",
			"CREATE TABLE {$tables['teacher_subjects']} (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				teacher_user_id BIGINT UNSIGNED NOT NULL,
				subject_key VARCHAR(100) NOT NULL,
				subject_label VARCHAR(191) NOT NULL,
				class_level_key VARCHAR(100) NOT NULL DEFAULT '',
				class_level_label VARCHAR(191) NOT NULL DEFAULT '',
				curriculum_key VARCHAR(100) NOT NULL DEFAULT 'nigerian',
				exam_key VARCHAR(100) NOT NULL DEFAULT '',
				created_at DATETIME NOT NULL,
				PRIMARY KEY  (id),
				UNIQUE KEY teacher_subject_level (teacher_user_id, subject_key, class_level_key, curriculum_key, exam_key),
				KEY subject_key (subject_key),
				KEY class_level_key (class_level_key)
			) {$charset};",
			"CREATE TABLE {$tables['classes']} (
				class_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				post_id BIGINT UNSIGNED NOT NULL,
				teacher_user_id BIGINT UNSIGNED NOT NULL,
				primary_subject_key VARCHAR(100) NOT NULL,
				primary_subject_label VARCHAR(191) NOT NULL DEFAULT '',
				class_levels TEXT NULL,
				course_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				exam_key VARCHAR(100) NOT NULL DEFAULT '',
				class_type VARCHAR(30) NOT NULL DEFAULT 'group',
				delivery_platform VARCHAR(50) NOT NULL DEFAULT 'google_meet',
				meeting_url TEXT NULL,
				start_at_utc DATETIME NULL,
				end_at_utc DATETIME NULL,
				duration_minutes SMALLINT UNSIGNED NOT NULL DEFAULT 60,
				capacity INT UNSIGNED NOT NULL DEFAULT 1,
				confirmed_seats INT UNSIGNED NOT NULL DEFAULT 0,
				price_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				currency CHAR(3) NOT NULL DEFAULT 'NGN',
				booking_opens_at_utc DATETIME NULL,
				booking_closes_at_utc DATETIME NULL,
				cancellation_policy TEXT NULL,
				status VARCHAR(30) NOT NULL DEFAULT 'draft',
				product_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				admin_notes LONGTEXT NULL,
				created_at DATETIME NOT NULL,
				updated_at DATETIME NOT NULL,
				deleted_at DATETIME NULL,
				PRIMARY KEY  (class_id),
				UNIQUE KEY post_id (post_id),
				KEY teacher_status_start (teacher_user_id, status, start_at_utc),
				KEY subject_status_start (primary_subject_key, status, start_at_utc),
				KEY course_id (course_id),
				KEY product_id (product_id),
				KEY booking_window (booking_opens_at_utc, booking_closes_at_utc)
			) {$charset};",
			"CREATE TABLE {$tables['sessions']} (
				session_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				class_id BIGINT UNSIGNED NOT NULL,
				start_at_utc DATETIME NULL,
				end_at_utc DATETIME NULL,
				capacity INT UNSIGNED NOT NULL DEFAULT 1,
				confirmed_seats INT UNSIGNED NOT NULL DEFAULT 0,
				status VARCHAR(30) NOT NULL DEFAULT 'available',
				created_at DATETIME NOT NULL,
				updated_at DATETIME NOT NULL,
				deleted_at DATETIME NULL,
				PRIMARY KEY  (session_id),
				KEY class_start (class_id, start_at_utc),
				KEY status_start (status, start_at_utc)
			) {$charset};",
			"CREATE TABLE {$tables['bookings']} (
				booking_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				booking_uuid CHAR(36) NOT NULL,
				student_user_id BIGINT UNSIGNED NOT NULL,
				teacher_user_id BIGINT UNSIGNED NOT NULL,
				class_id BIGINT UNSIGNED NOT NULL,
				session_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				order_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				order_item_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				status VARCHAR(30) NOT NULL DEFAULT 'pending_payment',
				payment_status VARCHAR(30) NOT NULL DEFAULT 'pending',
				amount_paid_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				currency CHAR(3) NOT NULL DEFAULT 'NGN',
				seat_quantity INT UNSIGNED NOT NULL DEFAULT 1,
				booking_source VARCHAR(50) NOT NULL DEFAULT 'web',
				referral_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				created_at DATETIME NOT NULL,
				updated_at DATETIME NOT NULL,
				completed_at DATETIME NULL,
				cancelled_at DATETIME NULL,
				refunded_at DATETIME NULL,
				PRIMARY KEY  (booking_id),
				UNIQUE KEY booking_uuid (booking_uuid),
				UNIQUE KEY order_item_booking (order_id, order_item_id),
				KEY student_status (student_user_id, status),
				KEY teacher_status (teacher_user_id, status),
				KEY class_status (class_id, status),
				KEY session_status (session_id, status)
			) {$charset};",
			"CREATE TABLE {$tables['reviews']} (
				review_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				booking_id BIGINT UNSIGNED NOT NULL,
				student_user_id BIGINT UNSIGNED NOT NULL,
				teacher_user_id BIGINT UNSIGNED NOT NULL,
				class_id BIGINT UNSIGNED NOT NULL,
				subject_key VARCHAR(100) NOT NULL DEFAULT '',
				overall_rating DECIMAL(3,1) NOT NULL DEFAULT 0.0,
				clarity_rating TINYINT UNSIGNED NOT NULL,
				knowledge_rating TINYINT UNSIGNED NOT NULL,
				punctuality_rating TINYINT UNSIGNED NOT NULL,
				communication_rating TINYINT UNSIGNED NOT NULL,
				understanding_improved VARCHAR(30) NOT NULL DEFAULT '',
				would_book_again TINYINT(1) NOT NULL DEFAULT 0,
				review_text TEXT NULL,
				status VARCHAR(30) NOT NULL DEFAULT 'pending',
				created_at DATETIME NOT NULL,
				updated_at DATETIME NOT NULL,
				moderated_at DATETIME NULL,
				moderated_by BIGINT UNSIGNED NOT NULL DEFAULT 0,
				PRIMARY KEY  (review_id),
				UNIQUE KEY booking_id (booking_id),
				KEY teacher_status (teacher_user_id, status),
				KEY class_status (class_id, status),
				KEY subject_status (subject_key, status)
			) {$charset};",
			"CREATE TABLE {$tables['earnings']} (
				earning_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				booking_id BIGINT UNSIGNED NOT NULL,
				teacher_user_id BIGINT UNSIGNED NOT NULL,
				class_id BIGINT UNSIGNED NOT NULL,
				gross_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				refund_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				net_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				commission_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				teacher_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				currency CHAR(3) NOT NULL DEFAULT 'NGN',
				earning_status VARCHAR(30) NOT NULL DEFAULT 'pending',
				payout_status VARCHAR(30) NOT NULL DEFAULT 'unpaid',
				created_at DATETIME NOT NULL,
				updated_at DATETIME NOT NULL,
				PRIMARY KEY  (earning_id),
				UNIQUE KEY booking_id (booking_id),
				KEY teacher_status (teacher_user_id, earning_status, payout_status),
				KEY class_id (class_id)
			) {$charset};",
			"CREATE TABLE {$tables['payouts']} (
				payout_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				teacher_user_id BIGINT UNSIGNED NOT NULL,
				currency CHAR(3) NOT NULL DEFAULT 'NGN',
				amount_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				status VARCHAR(30) NOT NULL DEFAULT 'draft',
				reference VARCHAR(191) NOT NULL DEFAULT '',
				notes TEXT NULL,
				created_by BIGINT UNSIGNED NOT NULL DEFAULT 0,
				created_at DATETIME NOT NULL,
				paid_at DATETIME NULL,
				reversed_at DATETIME NULL,
				PRIMARY KEY  (payout_id),
				KEY teacher_status (teacher_user_id, status)
			) {$charset};",
			"CREATE TABLE {$tables['payout_items']} (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				payout_id BIGINT UNSIGNED NOT NULL,
				earning_id BIGINT UNSIGNED NOT NULL,
				amount_minor BIGINT UNSIGNED NOT NULL DEFAULT 0,
				created_at DATETIME NOT NULL,
				PRIMARY KEY  (id),
				UNIQUE KEY earning_id (earning_id),
				KEY payout_id (payout_id)
			) {$charset};",
			"CREATE TABLE {$tables['referrals']} (
				referral_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				referral_code VARCHAR(64) NOT NULL,
				landing_url TEXT NULL,
				platform VARCHAR(50) NOT NULL DEFAULT '',
				referring_teacher_user_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				visitor_hash VARCHAR(191) NOT NULL DEFAULT '',
				first_visit_at DATETIME NOT NULL,
				converted_at DATETIME NULL,
				order_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				booking_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				campaign VARCHAR(100) NOT NULL DEFAULT '',
				PRIMARY KEY  (referral_id),
				KEY referral_code (referral_code),
				KEY teacher (referring_teacher_user_id),
				KEY order_id (order_id),
				KEY booking_id (booking_id)
			) {$charset};",
			"CREATE TABLE {$tables['audit_log']} (
				audit_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				actor_user_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				action VARCHAR(100) NOT NULL,
				entity_type VARCHAR(60) NOT NULL,
				entity_id BIGINT UNSIGNED NOT NULL DEFAULT 0,
				previous_value LONGTEXT NULL,
				new_value LONGTEXT NULL,
				ip_hash VARCHAR(191) NOT NULL DEFAULT '',
				request_id VARCHAR(64) NOT NULL DEFAULT '',
				created_at DATETIME NOT NULL,
				PRIMARY KEY  (audit_id),
				KEY actor_action (actor_user_id, action),
				KEY entity (entity_type, entity_id),
				KEY created_at (created_at)
			) {$charset};",
		);
	}

	/**
	 * Table map.
	 *
	 * @param string|null $prefix Optional prefix.
	 * @return array
	 */
	public static function tables( $prefix = null ) {
		global $wpdb;

		$prefix = null === $prefix ? $wpdb->prefix : $prefix;

		return array(
			'teacher_profiles' => $prefix . 'classhall_live_teacher_profiles',
			'teacher_subjects' => $prefix . 'classhall_live_teacher_subjects',
			'classes'          => $prefix . 'classhall_live_classes',
			'sessions'         => $prefix . 'classhall_live_sessions',
			'bookings'         => $prefix . 'classhall_live_bookings',
			'reviews'          => $prefix . 'classhall_live_reviews',
			'earnings'         => $prefix . 'classhall_live_earnings',
			'payouts'          => $prefix . 'classhall_live_payouts',
			'payout_items'     => $prefix . 'classhall_live_payout_items',
			'referrals'        => $prefix . 'classhall_live_referrals',
			'audit_log'        => $prefix . 'classhall_live_audit_log',
		);
	}

}
