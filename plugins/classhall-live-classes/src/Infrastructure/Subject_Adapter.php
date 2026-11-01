<?php
/**
 * Subject/course discovery adapter.
 */

namespace Classhall\LiveClasses\Infrastructure;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Subject_Adapter {
	/**
	 * Return subject options from Sensei course categories where available.
	 *
	 * @return array
	 */
	public function subjects() {
		$options = array();

		if ( taxonomy_exists( 'course-category' ) ) {
			$terms = get_terms(
				array(
					'taxonomy'   => 'course-category',
					'hide_empty' => false,
					'number'     => 200,
				)
			);

			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$options[ $term->slug ] = $term->name;
				}
			}
		}

		if ( empty( $options ) ) {
			$options = array(
				'mathematics'      => __( 'Mathematics', 'classhall-live-classes' ),
				'english-language' => __( 'English Language', 'classhall-live-classes' ),
				'basic-science'    => __( 'Basic Science', 'classhall-live-classes' ),
				'coding-ai'        => __( 'Coding and AI', 'classhall-live-classes' ),
			);
		}

		return apply_filters( 'classhall_live_subject_options', $options );
	}

	/**
	 * Return class level options.
	 *
	 * @return array
	 */
	public function class_levels() {
		return apply_filters(
			'classhall_live_class_level_options',
			array(
				'primary-1'    => __( 'Primary 1', 'classhall-live-classes' ),
				'primary-2'    => __( 'Primary 2', 'classhall-live-classes' ),
				'primary-3'    => __( 'Primary 3', 'classhall-live-classes' ),
				'primary-4'    => __( 'Primary 4', 'classhall-live-classes' ),
				'primary-5'    => __( 'Primary 5', 'classhall-live-classes' ),
				'primary-6'    => __( 'Primary 6', 'classhall-live-classes' ),
				'jss-1'        => __( 'JSS 1', 'classhall-live-classes' ),
				'jss-2'        => __( 'JSS 2', 'classhall-live-classes' ),
				'jss-3'        => __( 'JSS 3', 'classhall-live-classes' ),
				'sss-1'        => __( 'SSS 1', 'classhall-live-classes' ),
				'sss-2'        => __( 'SSS 2', 'classhall-live-classes' ),
				'sss-3'        => __( 'SSS 3', 'classhall-live-classes' ),
				'waec'         => __( 'WAEC', 'classhall-live-classes' ),
				'neco'         => __( 'NECO', 'classhall-live-classes' ),
				'jamb'         => __( 'JAMB', 'classhall-live-classes' ),
			)
		);
	}

	/**
	 * Return Sensei course options.
	 *
	 * @return array
	 */
	public function courses() {
		if ( ! post_type_exists( 'course' ) ) {
			return array();
		}

		$posts = get_posts(
			array(
				'post_type'      => 'course',
				'post_status'    => 'publish',
				'posts_per_page' => 200,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids',
			)
		);

		$options = array();
		foreach ( $posts as $post_id ) {
			$options[ $post_id ] = get_the_title( $post_id );
		}

		return $options;
	}

	/**
	 * Infer class levels attached to a Sensei course.
	 *
	 * The production site can override this through
	 * `classhall_live_course_class_levels` if Classhall stores levels in a
	 * dedicated taxonomy or custom field.
	 *
	 * @param int $course_id Course post ID.
	 * @return string[]
	 */
	public function course_class_levels( $course_id ) {
		$course_id = absint( $course_id );
		if ( ! $course_id ) {
			return array();
		}

		$haystack = strtolower( get_the_title( $course_id ) );
		foreach ( get_object_taxonomies( 'course' ) as $taxonomy ) {
			$terms = get_the_terms( $course_id, $taxonomy );
			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				continue;
			}

			foreach ( $terms as $term ) {
				$haystack .= ' ' . strtolower( $term->name . ' ' . $term->slug );
			}
		}

		$levels = array();
		foreach ( $this->class_level_matchers() as $level => $patterns ) {
			foreach ( $patterns as $pattern ) {
				if ( preg_match( $pattern, $haystack ) ) {
					$levels[] = $level;
					break;
				}
			}
		}

		return array_values( array_unique( apply_filters( 'classhall_live_course_class_levels', $levels, $course_id ) ) );
	}

	/**
	 * Pattern map for matching common Classhall level labels.
	 *
	 * @return array
	 */
	private function class_level_matchers() {
		return array(
			'primary-1' => array( '/\bprimary[\s-]*1\b/', '/\bpry[\s-]*1\b/' ),
			'primary-2' => array( '/\bprimary[\s-]*2\b/', '/\bpry[\s-]*2\b/' ),
			'primary-3' => array( '/\bprimary[\s-]*3\b/', '/\bpry[\s-]*3\b/' ),
			'primary-4' => array( '/\bprimary[\s-]*4\b/', '/\bpry[\s-]*4\b/' ),
			'primary-5' => array( '/\bprimary[\s-]*5\b/', '/\bpry[\s-]*5\b/' ),
			'primary-6' => array( '/\bprimary[\s-]*6\b/', '/\bpry[\s-]*6\b/' ),
			'jss-1'     => array( '/\bjss[\s-]*1\b/', '/\bjunior[\s-]*secondary[\s-]*1\b/', '/\bupper[\s-]*basic[\s-]*7\b/' ),
			'jss-2'     => array( '/\bjss[\s-]*2\b/', '/\bjunior[\s-]*secondary[\s-]*2\b/', '/\bupper[\s-]*basic[\s-]*8\b/' ),
			'jss-3'     => array( '/\bjss[\s-]*3\b/', '/\bjunior[\s-]*secondary[\s-]*3\b/', '/\bupper[\s-]*basic[\s-]*9\b/' ),
			'ss-1'      => array( '/\bss[\s-]*1\b/', '/\bsss[\s-]*1\b/', '/\bsenior[\s-]*secondary[\s-]*1\b/' ),
			'ss-2'      => array( '/\bss[\s-]*2\b/', '/\bsss[\s-]*2\b/', '/\bsenior[\s-]*secondary[\s-]*2\b/' ),
			'ss-3'      => array( '/\bss[\s-]*3\b/', '/\bsss[\s-]*3\b/', '/\bsenior[\s-]*secondary[\s-]*3\b/' ),
		);
	}

	/**
	 * Resolve subject label from key.
	 *
	 * @param string $key Subject key.
	 * @return string
	 */
	public function subject_label( $key ) {
		$subjects = $this->subjects();
		return isset( $subjects[ $key ] ) ? $subjects[ $key ] : $key;
	}
}
