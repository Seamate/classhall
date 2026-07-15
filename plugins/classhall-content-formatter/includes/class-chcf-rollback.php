<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Rollback {
	public function rollback_run( $run_id ) {
		$repository = new CHCF_Repository();
		$backups = $repository->get_backups_for_run( $run_id );
		$result = array( 'restored' => 0, 'conflicts' => 0, 'failed' => 0 );

		foreach ( $backups as $backup ) {
			$post = get_post( absint( $backup->post_id ) );
			if ( ! $post ) {
				$result['failed']++;
				$repository->mark_backup_rolled_back( $backup->backup_id, 'missing' );
				continue;
			}

			if ( hash( 'sha256', (string) $post->post_content ) !== $backup->updated_checksum ) {
				$result['conflicts']++;
				$repository->mark_backup_rolled_back( $backup->backup_id, 'conflict' );
				continue;
			}

			$updated = wp_update_post(
				array(
					'ID'           => $post->ID,
					'post_content' => $backup->original_content,
				),
				true,
				false
			);

			if ( is_wp_error( $updated ) ) {
				$result['failed']++;
				continue;
			}

			$result['restored']++;
			$repository->mark_backup_rolled_back( $backup->backup_id, 'rolled_back' );
		}

		return $result;
	}
}
