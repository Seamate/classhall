<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Request {
	public static function settings_from_request( $source ) {
		$mode = isset( $source['mode'] ) ? sanitize_key( wp_unslash( $source['mode'] ) ) : 'dry_run';
		if ( ! in_array( $mode, array( 'dry_run', 'review', 'automatic' ), true ) ) {
			$mode = 'dry_run';
		}

		$post_status = isset( $source['post_status'] ) ? array_map( 'sanitize_key', (array) wp_unslash( $source['post_status'] ) ) : array( 'publish', 'draft' );
		$post_status = array_values( array_intersect( $post_status, array( 'publish', 'draft', 'private', 'pending', 'future' ) ) );
		$taxonomy = isset( $source['taxonomy'] ) ? sanitize_key( wp_unslash( $source['taxonomy'] ) ) : '';
		$term_id  = isset( $source['term_id'] ) ? absint( $source['term_id'] ) : 0;

		if ( ! empty( $source['taxonomy_term'] ) ) {
			$taxonomy_term = sanitize_text_field( wp_unslash( $source['taxonomy_term'] ) );
			$parts = explode( ':', $taxonomy_term, 2 );
			if ( 2 === count( $parts ) ) {
				$taxonomy = sanitize_key( $parts[0] );
				$term_id = absint( $parts[1] );
			}
		}

		return array(
			'mode'                    => $mode,
			'post_type'               => isset( $source['post_type'] ) ? sanitize_key( wp_unslash( $source['post_type'] ) ) : 'lesson',
			'post_status'             => $post_status ? $post_status : array( 'publish', 'draft' ),
			'taxonomy'                => $taxonomy,
			'term_id'                 => $term_id,
			'course_id'               => isset( $source['course_id'] ) ? absint( $source['course_id'] ) : 0,
			'specific_post_id'        => isset( $source['specific_post_id'] ) ? absint( $source['specific_post_id'] ) : 0,
			'start_post_id'           => isset( $source['start_post_id'] ) ? absint( $source['start_post_id'] ) : 0,
			'end_post_id'             => isset( $source['end_post_id'] ) ? absint( $source['end_post_id'] ) : 0,
			'batch_size'              => min( 50, max( 1, isset( $source['batch_size'] ) ? absint( $source['batch_size'] ) : 10 ) ),
			'max_lessons_per_run'     => min( 500, max( 1, isset( $source['max_lessons_per_run'] ) ? absint( $source['max_lessons_per_run'] ) : 20 ) ),
			'paragraph_formatting'    => ! empty( $source['paragraph_formatting'] ),
			'heading_detection'       => ! empty( $source['heading_detection'] ),
			'latex_conversion'        => ! empty( $source['latex_conversion'] ),
			'empty_paragraph_cleanup' => ! empty( $source['empty_paragraph_cleanup'] ),
			'confidence_threshold'    => min( 1, max( 0, isset( $source['confidence_threshold'] ) ? (float) $source['confidence_threshold'] : 0.92 ) ),
			'skip_processed'          => ! empty( $source['skip_processed'] ),
			'reprocess_flagged'       => ! empty( $source['reprocess_flagged'] ),
			'ai_enabled'              => ! empty( $source['ai_enabled'] ),
		);
	}
}
