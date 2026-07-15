<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Repository {
	public function tables() {
		global $wpdb;
		return array(
			'runs'    => $wpdb->prefix . 'chcf_runs',
			'changes' => $wpdb->prefix . 'chcf_changes',
			'backups' => $wpdb->prefix . 'chcf_backups',
		);
	}

	public function create_run( $settings, $user_id ) {
		global $wpdb;
		$tables = $this->tables();
		$mode   = isset( $settings['mode'] ) ? $settings['mode'] : 'dry_run';

		$wpdb->insert(
			$tables['runs'],
			array(
				'mode'       => $mode,
				'filters'    => wp_json_encode( $this->run_filters( $settings ) ),
				'settings'   => wp_json_encode( $settings ),
				'status'     => 'running',
				'started_at' => current_time( 'mysql' ),
				'created_by' => absint( $user_id ),
				'created_at' => current_time( 'mysql' ),
			),
			array( '%s', '%s', '%s', '%s', '%s', '%d', '%s' )
		);

		return absint( $wpdb->insert_id );
	}

	public function get_run( $run_id ) {
		global $wpdb;
		$tables = $this->tables();
		$row = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['runs']} WHERE run_id = %d", $run_id ) );
		if ( ! $row ) {
			return null;
		}

		$row->settings = json_decode( $row->settings, true );
		$row->filters  = json_decode( $row->filters, true );
		return $row;
	}

	public function get_recent_runs() {
		global $wpdb;
		$tables = $this->tables();
		return $wpdb->get_results( "SELECT * FROM {$tables['runs']} ORDER BY run_id DESC LIMIT 20" );
	}

	public function get_document_changes_for_run( $run_id, $limit = 20 ) {
		global $wpdb;
		$tables = $this->tables();
		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$tables['changes']} WHERE run_id = %d AND change_type = 'document' ORDER BY change_id ASC LIMIT %d",
				absint( $run_id ),
				max( 1, min( 100, absint( $limit ) ) )
			)
		);
	}

	public function get_fragment_changes_for_post( $run_id, $post_id ) {
		global $wpdb;
		$tables = $this->tables();
		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$tables['changes']} WHERE run_id = %d AND post_id = %d AND change_type <> 'document' ORDER BY change_id ASC LIMIT 200",
				absint( $run_id ),
				absint( $post_id )
			)
		);
	}

	public function update_run_status( $run_id, $status ) {
		global $wpdb;
		$tables = $this->tables();
		$data = array( 'status' => $status );
		if ( in_array( $status, array( 'complete', 'stopped' ), true ) ) {
			$data['completed_at'] = current_time( 'mysql' );
		}
		$wpdb->update( $tables['runs'], $data, array( 'run_id' => absint( $run_id ) ) );
	}

	public function update_run_progress( $run_id, $last_id, $counts ) {
		global $wpdb;
		$tables = $this->tables();
		$sets = array( 'last_processed_post_id' => absint( $last_id ) );
		foreach ( array( 'scanned', 'changed', 'unchanged', 'flagged', 'failed' ) as $key ) {
			if ( isset( $counts[ $key ] ) ) {
				$field = 'total_' . $key;
				$sets[ $field ] = new CHCF_SQL_Increment( absint( $counts[ $key ] ) );
			}
		}
		$this->update_with_increments( $tables['runs'], $sets, array( 'run_id' => absint( $run_id ) ) );
	}

	public function insert_change( $run_id, $post_id, $change, $status, $errors = array() ) {
		global $wpdb;
		$tables = $this->tables();
		$wpdb->insert(
			$tables['changes'],
			array(
				'run_id'             => absint( $run_id ),
				'post_id'            => absint( $post_id ),
				'block_id'           => sanitize_text_field( $change['block_id'] ),
				'change_type'        => sanitize_key( $change['type'] ),
				'original_fragment'  => $change['original'],
				'proposed_fragment'  => $change['proposed'],
				'confidence'         => (float) $change['confidence'],
				'reason'             => sanitize_text_field( $change['reason'] ),
				'status'             => sanitize_key( $status ),
				'validation_errors'  => $errors ? wp_json_encode( $errors ) : null,
				'created_at'         => current_time( 'mysql' ),
			)
		);
	}

	public function store_backup( $run_id, $post_id, $original, $updated ) {
		global $wpdb;
		$tables = $this->tables();
		$wpdb->replace(
			$tables['backups'],
			array(
				'run_id'            => absint( $run_id ),
				'post_id'           => absint( $post_id ),
				'original_content'  => $original,
				'updated_content'   => $updated,
				'original_checksum' => hash( 'sha256', $original ),
				'updated_checksum'  => hash( 'sha256', $updated ),
				'changed_at'        => current_time( 'mysql' ),
				'rollback_status'   => 'available',
			)
		);
	}

	public function set_change_status( $change_id, $status, $user_id ) {
		global $wpdb;
		$tables = $this->tables();
		$wpdb->update(
			$tables['changes'],
			array(
				'status'      => $status,
				'approved_by' => absint( $user_id ),
				'approved_at' => current_time( 'mysql' ),
			),
			array( 'change_id' => absint( $change_id ) )
		);
	}

	public function has_processed_post( $post_id, $include_flagged = false ) {
		global $wpdb;
		$tables = $this->tables();
		$statuses = $include_flagged ? array( 'proposed', 'approved', 'applied', 'flagged' ) : array( 'proposed', 'approved', 'applied' );
		$placeholders = implode( ',', array_fill( 0, count( $statuses ), '%s' ) );
		$params = array_merge( array( absint( $post_id ), 'document' ), $statuses );
		$sql = $wpdb->prepare(
			"SELECT change_id FROM {$tables['changes']} WHERE post_id = %d AND change_type = %s AND status IN ({$placeholders}) LIMIT 1",
			$params
		);

		return (bool) $wpdb->get_var( $sql );
	}

	public function get_backups_for_run( $run_id ) {
		global $wpdb;
		$tables = $this->tables();
		return $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$tables['backups']} WHERE run_id = %d AND rollback_status = 'available'", $run_id ) );
	}

	public function mark_backup_rolled_back( $backup_id, $status ) {
		global $wpdb;
		$tables = $this->tables();
		$wpdb->update( $tables['backups'], array( 'rollback_status' => $status ), array( 'backup_id' => absint( $backup_id ) ) );
	}

	private function run_filters( $settings ) {
		return array_intersect_key(
			$settings,
			array_flip( array( 'post_type', 'post_status', 'taxonomy', 'term_id', 'course_id', 'specific_post_id', 'start_post_id', 'end_post_id' ) )
		);
	}

	private function update_with_increments( $table, $data, $where ) {
		global $wpdb;
		$assignments = array();
		$values = array();
		foreach ( $data as $field => $value ) {
			if ( $value instanceof CHCF_SQL_Increment ) {
				$assignments[] = "{$field} = {$field} + %d";
				$values[] = $value->amount;
			} else {
				$assignments[] = "{$field} = %s";
				$values[] = $value;
			}
		}
		$where_sql = array();
		foreach ( $where as $field => $value ) {
			$where_sql[] = "{$field} = %d";
			$values[] = absint( $value );
		}
		$sql = "UPDATE {$table} SET " . implode( ', ', $assignments ) . ' WHERE ' . implode( ' AND ', $where_sql );
		$wpdb->query( $wpdb->prepare( $sql, $values ) );
	}
}
