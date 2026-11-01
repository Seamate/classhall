<?php
/**
 * Audit logging.
 */

namespace Classhall\LiveClasses\Infrastructure;

use Classhall\LiveClasses\Database\Installer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Audit_Log {
	/**
	 * Record an audit event.
	 *
	 * @param string $action Action key.
	 * @param string $entity_type Entity type.
	 * @param int    $entity_id Entity ID.
	 * @param mixed  $previous Previous value.
	 * @param mixed  $new New value.
	 * @return void
	 */
	public static function record( $action, $entity_type, $entity_id = 0, $previous = null, $new = null ) {
		global $wpdb;

		$tables = Installer::tables();
		$ip     = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

		$wpdb->insert(
			$tables['audit_log'],
			array(
				'actor_user_id' => get_current_user_id(),
				'action'        => sanitize_key( $action ),
				'entity_type'   => sanitize_key( $entity_type ),
				'entity_id'     => absint( $entity_id ),
				'previous_value'=> null === $previous ? null : wp_json_encode( $previous ),
				'new_value'     => null === $new ? null : wp_json_encode( $new ),
				'ip_hash'       => $ip ? wp_hash( $ip ) : '',
				'request_id'    => wp_generate_uuid4(),
				'created_at'    => current_time( 'mysql', true ),
			),
			array( '%d', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s' )
		);
	}
}

