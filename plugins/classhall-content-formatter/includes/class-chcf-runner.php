<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Runner {
	private $repository;
	private $formatter;
	private $validator;

	public function __construct() {
		$this->repository = new CHCF_Repository();
		$this->formatter  = new CHCF_Formatter();
		$this->validator  = new CHCF_Validator();
	}

	public function create_run( $settings, $user_id ) {
		return $this->repository->create_run( $settings, $user_id );
	}

	public function process_batch( $run_id ) {
		global $wpdb;

		$run = $this->repository->get_run( $run_id );
		if ( ! $run || 'running' !== $run->status ) {
			return array( 'status' => $run ? $run->status : 'missing' );
		}

		$lock_key = 'chcf_run_lock_' . absint( $run_id );
		if ( get_transient( $lock_key ) ) {
			return array( 'status' => 'locked' );
		}
		set_transient( $lock_key, 1, 5 * MINUTE_IN_SECONDS );

		$settings = is_array( $run->settings ) ? $run->settings : array();
		$last_id  = max( absint( $run->last_processed_post_id ), absint( $settings['start_post_id'] ?? 0 ) );
		$remaining = max( 0, absint( $settings['max_lessons_per_run'] ?? 20 ) - absint( $run->total_scanned ) );
		if ( 0 === $remaining ) {
			$this->repository->update_run_status( $run_id, 'complete' );
			delete_transient( $lock_key );
			return array( 'status' => 'complete', 'last_id' => $last_id, 'counts' => array() );
		}
		$limit    = min( absint( $settings['batch_size'] ?? 10 ), $remaining );
		$posts    = $this->query_posts( $settings, $last_id, $limit );
		$counts   = array( 'scanned' => 0, 'changed' => 0, 'unchanged' => 0, 'flagged' => 0, 'failed' => 0 );
		$max_id   = $last_id;

		foreach ( $posts as $post ) {
			$counts['scanned']++;
			$max_id = max( $max_id, absint( $post->ID ) );

			try {
				$wp_post = get_post( absint( $post->ID ) );
				if ( ! $wp_post ) {
					throw new Exception( 'Post no longer exists.' );
				}
				if ( ! empty( $settings['skip_processed'] ) && $this->repository->has_processed_post( $wp_post->ID, empty( $settings['reprocess_flagged'] ) ) ) {
					$result = 'unchanged';
					$counts[ $result ]++;
					continue;
				}
				$result = $this->process_post( $run_id, $wp_post, $settings );
				$counts[ $result ]++;
			} catch ( Exception $e ) {
				$counts['failed']++;
				$this->repository->insert_change(
					$run_id,
					$post->ID,
					array(
						'block_id'   => 'post',
						'type'       => 'failure',
						'original'   => '',
						'proposed'   => '',
						'confidence' => 0,
						'reason'     => $e->getMessage(),
					),
					'failed',
					array( $e->getMessage() )
				);
			}

			clean_post_cache( $post );
			unset( $post );
		}

		$this->repository->update_run_progress( $run_id, $max_id, $counts );

		if ( count( $posts ) < $limit || ( absint( $run->total_scanned ) + $counts['scanned'] ) >= absint( $settings['max_lessons_per_run'] ?? 20 ) ) {
			$this->repository->update_run_status( $run_id, 'complete' );
		}

		delete_transient( $lock_key );

		return array(
			'status'  => count( $posts ) < $limit ? 'complete' : 'running',
			'last_id' => $max_id,
			'counts'  => $counts,
		);
	}

	private function process_post( $run_id, $post, $settings ) {
		$original = (string) $post->post_content;
		$result   = $this->formatter->format( $original, $post, $settings );
		$updated  = $result['content'];
		$changes  = $result['changes'];
		$errors   = $this->validator->validate( $original, $updated );

		if ( $updated === $original || empty( $changes ) ) {
			return 'unchanged';
		}

		$threshold = (float) ( $settings['confidence_threshold'] ?? 0.92 );
		$low_confidence = false;
		$this->repository->insert_change(
			$run_id,
			$post->ID,
			array(
				'block_id'   => 'post_content',
				'type'       => 'document',
				'original'   => $original,
				'proposed'   => $updated,
				'confidence' => $errors ? 0 : 1,
				'reason'     => 'Full proposed lesson HTML for review and comparison.',
			),
			$errors ? 'flagged' : 'proposed',
			$errors
		);

		foreach ( $changes as $change ) {
			if ( (float) $change['confidence'] < $threshold ) {
				$low_confidence = true;
			}
			$this->repository->insert_change( $run_id, $post->ID, $change, $errors || $low_confidence ? 'flagged' : 'proposed', $errors );
		}

		if ( $errors || $low_confidence || 'automatic' !== ( $settings['mode'] ?? 'dry_run' ) ) {
			return 'flagged';
		}

		$this->repository->store_backup( $run_id, $post->ID, $original, $updated );
		$update = wp_update_post(
			array(
				'ID'           => $post->ID,
				'post_content' => $updated,
			),
			true,
			false
		);

		if ( is_wp_error( $update ) ) {
			throw new Exception( $update->get_error_message() );
		}

		clean_post_cache( $post->ID );
		return 'changed';
	}

	private function query_posts( $settings, $last_id, $limit ) {
		global $wpdb;

		$post_type = sanitize_key( $settings['post_type'] ?? 'lesson' );
		$statuses  = isset( $settings['post_status'] ) ? (array) $settings['post_status'] : array( 'publish', 'draft' );
		$statuses  = array_values( array_filter( array_map( 'sanitize_key', $statuses ) ) );

		if ( ! empty( $settings['specific_post_id'] ) ) {
			$sql = $wpdb->prepare(
				"SELECT ID, post_title, post_content, post_type, post_status FROM {$wpdb->posts} WHERE ID = %d AND post_type = %s LIMIT 1",
				absint( $settings['specific_post_id'] ),
				$post_type
			);
			return $wpdb->get_results( $sql );
		}

		$placeholders = implode( ',', array_fill( 0, count( $statuses ), '%s' ) );
		$params = array_merge( array( $post_type ), $statuses, array( absint( $last_id ) ) );
		$where = "post_type = %s AND post_status IN ({$placeholders}) AND ID > %d";

		if ( ! empty( $settings['end_post_id'] ) ) {
			$where .= ' AND ID <= %d';
			$params[] = absint( $settings['end_post_id'] );
		}

		if ( ! empty( $settings['course_id'] ) ) {
			$where .= " AND ID IN (SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_lesson_course' AND meta_value = %d)";
			$params[] = absint( $settings['course_id'] );
		}

		$params[] = absint( $limit );
		$sql = $wpdb->prepare(
			"SELECT ID, post_title, post_content, post_type, post_status FROM {$wpdb->posts} WHERE {$where} ORDER BY ID ASC LIMIT %d",
			$params
		);

		$posts = $wpdb->get_results( $sql );
		if ( empty( $settings['taxonomy'] ) || empty( $settings['term_id'] ) || ! $posts ) {
			return $posts;
		}

		$taxonomy = sanitize_key( $settings['taxonomy'] );
		$term_id  = absint( $settings['term_id'] );
		return array_values(
			array_filter(
				$posts,
				function ( $post ) use ( $taxonomy, $term_id ) {
					return has_term( $term_id, $taxonomy, $post );
				}
			)
		);
	}
}
