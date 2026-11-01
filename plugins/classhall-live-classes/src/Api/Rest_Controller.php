<?php
/**
 * REST API controller.
 */

namespace Classhall\LiveClasses\Api;

use Classhall\LiveClasses\Database\Installer;
use Classhall\LiveClasses\Domain\Statuses;
use Classhall\LiveClasses\Security\Capabilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Rest_Controller {
	const NAMESPACE = 'classhall-live/v1';

	/**
	 * Register hook.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'rest_api_init', array( $this, 'routes' ) );
	}

	/**
	 * Register routes.
	 *
	 * @return void
	 */
	public function routes() {
		register_rest_route(
			self::NAMESPACE,
			'/classes',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'classes' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'subject' => array( 'sanitize_callback' => 'sanitize_key' ),
					'page'    => array( 'sanitize_callback' => 'absint', 'default' => 1 ),
				),
			)
		);

		register_rest_route(
			self::NAMESPACE,
			'/me/bookings',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'my_bookings' ),
				'permission_callback' => function() {
					return is_user_logged_in();
				},
			)
		);

		register_rest_route(
			self::NAMESPACE,
			'/teacher/classes',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'teacher_classes' ),
				'permission_callback' => function() {
					return current_user_can( Capabilities::VIEW_BOOKINGS );
				},
			)
		);
	}

	/**
	 * Public class search.
	 *
	 * @param \WP_REST_Request $request Request.
	 * @return \WP_REST_Response
	 */
	public function classes( $request ) {
		global $wpdb;
		$tables  = Installer::tables();
		$subject = sanitize_key( $request->get_param( 'subject' ) );
		$page    = max( 1, absint( $request->get_param( 'page' ) ) );
		$offset  = ( $page - 1 ) * 20;

		if ( $subject ) {
			$rows = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT class_id, post_id, teacher_user_id, primary_subject_key, primary_subject_label, class_type, start_at_utc, end_at_utc, capacity, confirmed_seats, price_minor, currency, status FROM {$tables['classes']} WHERE status IN ('approved','published') AND primary_subject_key = %s ORDER BY start_at_utc ASC LIMIT 20 OFFSET %d",
					$subject,
					$offset
				)
			);
		} else {
			$rows = $wpdb->get_results( $wpdb->prepare( "SELECT class_id, post_id, teacher_user_id, primary_subject_key, primary_subject_label, class_type, start_at_utc, end_at_utc, capacity, confirmed_seats, price_minor, currency, status FROM {$tables['classes']} WHERE status IN ('approved','published') ORDER BY start_at_utc ASC LIMIT 20 OFFSET %d", $offset ) );
		}

		return rest_ensure_response(
			array_map(
				function( $row ) {
					return array(
						'id'              => (int) $row->class_id,
						'title'           => get_the_title( $row->post_id ),
						'url'             => get_permalink( $row->post_id ),
						'subject'         => $row->primary_subject_label,
						'class_type'      => $row->class_type,
						'start_at_utc'    => $row->start_at_utc,
						'end_at_utc'      => $row->end_at_utc,
						'seats_remaining' => max( 0, (int) $row->capacity - (int) $row->confirmed_seats ),
						'price_minor'     => (int) $row->price_minor,
						'currency'        => $row->currency,
					);
				},
				$rows
			)
		);
	}

	/**
	 * Current user's bookings without meeting URLs.
	 *
	 * @return \WP_REST_Response
	 */
	public function my_bookings() {
		global $wpdb;
		$tables = Installer::tables();
		$rows   = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT b.booking_id, b.status, b.payment_status, b.class_id, c.post_id, c.start_at_utc, c.end_at_utc, c.primary_subject_label FROM {$tables['bookings']} b INNER JOIN {$tables['classes']} c ON b.class_id = c.class_id WHERE b.student_user_id = %d ORDER BY c.start_at_utc DESC LIMIT 50",
				get_current_user_id()
			)
		);

		return rest_ensure_response( $rows );
	}

	/**
	 * Current teacher classes.
	 *
	 * @return \WP_REST_Response
	 */
	public function teacher_classes() {
		global $wpdb;
		$tables = Installer::tables();
		$rows   = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT class_id, post_id, primary_subject_label, start_at_utc, end_at_utc, capacity, confirmed_seats, status FROM {$tables['classes']} WHERE teacher_user_id = %d ORDER BY start_at_utc DESC LIMIT 50",
				get_current_user_id()
			)
		);

		return rest_ensure_response( $rows );
	}
}

