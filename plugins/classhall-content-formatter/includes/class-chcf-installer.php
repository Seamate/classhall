<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Installer {
	public static function activate() {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$charset = $wpdb->get_charset_collate();
		$runs    = $wpdb->prefix . 'chcf_runs';
		$changes = $wpdb->prefix . 'chcf_changes';
		$backups = $wpdb->prefix . 'chcf_backups';

		dbDelta(
			"CREATE TABLE {$runs} (
				run_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				mode varchar(20) NOT NULL DEFAULT 'dry_run',
				filters longtext NULL,
				settings longtext NULL,
				status varchar(20) NOT NULL DEFAULT 'pending',
				started_at datetime NULL,
				completed_at datetime NULL,
				last_processed_post_id bigint(20) unsigned NOT NULL DEFAULT 0,
				total_scanned bigint(20) unsigned NOT NULL DEFAULT 0,
				total_changed bigint(20) unsigned NOT NULL DEFAULT 0,
				total_unchanged bigint(20) unsigned NOT NULL DEFAULT 0,
				total_flagged bigint(20) unsigned NOT NULL DEFAULT 0,
				total_failed bigint(20) unsigned NOT NULL DEFAULT 0,
				ai_usage longtext NULL,
				created_by bigint(20) unsigned NOT NULL DEFAULT 0,
				created_at datetime NOT NULL,
				PRIMARY KEY  (run_id),
				KEY status (status),
				KEY last_processed_post_id (last_processed_post_id)
			) {$charset};"
		);

		dbDelta(
			"CREATE TABLE {$changes} (
				change_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				run_id bigint(20) unsigned NOT NULL,
				post_id bigint(20) unsigned NOT NULL,
				block_id varchar(80) NOT NULL DEFAULT '',
				change_type varchar(40) NOT NULL DEFAULT '',
				original_fragment longtext NULL,
				proposed_fragment longtext NULL,
				confidence decimal(5,4) NOT NULL DEFAULT 0,
				reason text NULL,
				status varchar(20) NOT NULL DEFAULT 'proposed',
				validation_errors longtext NULL,
				approved_by bigint(20) unsigned NOT NULL DEFAULT 0,
				approved_at datetime NULL,
				created_at datetime NOT NULL,
				PRIMARY KEY  (change_id),
				KEY run_post (run_id, post_id),
				KEY status (status),
				KEY change_type (change_type)
			) {$charset};"
		);

		dbDelta(
			"CREATE TABLE {$backups} (
				backup_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				run_id bigint(20) unsigned NOT NULL,
				post_id bigint(20) unsigned NOT NULL,
				original_content longblob NOT NULL,
				updated_content longblob NOT NULL,
				original_checksum char(64) NOT NULL,
				updated_checksum char(64) NOT NULL,
				changed_at datetime NOT NULL,
				rollback_status varchar(20) NOT NULL DEFAULT 'available',
				PRIMARY KEY  (backup_id),
				UNIQUE KEY run_post (run_id, post_id),
				KEY post_id (post_id),
				KEY rollback_status (rollback_status)
			) {$charset};"
		);

		add_option( CHCF_Plugin::OPTION_SETTINGS, array(), '', false );
	}
}
