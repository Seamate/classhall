<?php
/**
 * Uninstall handler.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$settings = get_option( 'classhall_live_settings', array() );
if ( empty( $settings['delete_data_on_uninstall'] ) ) {
	delete_option( 'classhall_live_db_version' );
	return;
}

global $wpdb;

$tables = array(
	'classhall_live_teacher_profiles',
	'classhall_live_teacher_subjects',
	'classhall_live_classes',
	'classhall_live_sessions',
	'classhall_live_bookings',
	'classhall_live_reviews',
	'classhall_live_earnings',
	'classhall_live_payouts',
	'classhall_live_payout_items',
	'classhall_live_referrals',
	'classhall_live_audit_log',
);

foreach ( $tables as $table ) {
	$wpdb->query( 'DROP TABLE IF EXISTS ' . esc_sql( $wpdb->prefix . $table ) );
}

delete_option( 'classhall_live_settings' );
delete_option( 'classhall_live_db_version' );

