<?php
/**
 * WooCommerce integration.
 */

namespace Classhall\LiveClasses\Integrations;

use Classhall\LiveClasses\Database\Installer;
use Classhall\LiveClasses\Domain\Statuses;
use Classhall\LiveClasses\Infrastructure\Audit_Log;
use Classhall\LiveClasses\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class WooCommerce {
	const PRODUCT_META = '_classhall_live_class_id';
	const ITEM_META    = '_classhall_live_class_id';

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'classhall_live_class_submitted', array( $this, 'maybe_sync_product_for_class' ), 10, 2 );
		add_action( 'classhall_live_class_status_changed', array( $this, 'maybe_sync_product_for_class_status' ), 10, 3 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'validate_add_to_cart' ), 10, 3 );
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'add_cart_item_data' ), 10, 3 );
		add_filter( 'woocommerce_get_item_data', array( $this, 'display_cart_item_data' ), 10, 2 );
		add_action( 'woocommerce_before_calculate_totals', array( $this, 'sync_cart_price' ) );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'copy_order_item_meta' ), 10, 4 );
		add_action( 'woocommerce_payment_complete', array( $this, 'confirm_bookings_from_order' ) );
		add_action( 'woocommerce_order_status_processing', array( $this, 'confirm_bookings_from_order' ) );
		add_action( 'woocommerce_order_status_completed', array( $this, 'confirm_bookings_from_order' ) );
		add_action( 'woocommerce_order_refunded', array( $this, 'mark_refunded' ), 10, 2 );
	}

	/**
	 * Sync product when a class changes to an approved status.
	 *
	 * @param int $class_id Class ID.
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public function maybe_sync_product_for_class( $class_id, $post_id ) {
		unset( $class_id, $post_id );
	}

	/**
	 * Sync product after moderation.
	 *
	 * @param int    $class_id Class ID.
	 * @param string $old Old status.
	 * @param string $new New status.
	 * @return void
	 */
	public function maybe_sync_product_for_class_status( $class_id, $old, $new ) {
		unset( $old );
		if ( in_array( $new, array( Statuses::CLASS_APPROVED, Statuses::CLASS_PUBLISHED ), true ) ) {
			$this->sync_product( absint( $class_id ) );
		}
	}

	/**
	 * Validate add-to-cart.
	 *
	 * @param bool $passed Passed.
	 * @param int  $product_id Product ID.
	 * @param int  $quantity Quantity.
	 * @return bool
	 */
	public function validate_add_to_cart( $passed, $product_id, $quantity ) {
		$class = $this->class_for_product( $product_id );
		if ( ! $class ) {
			return $passed;
		}

		if ( ! is_user_logged_in() ) {
			wc_add_notice( __( 'Please log in before booking a live class.', 'classhall-live-classes' ), 'error' );
			return false;
		}

		if ( (int) $class->teacher_user_id === get_current_user_id() ) {
			wc_add_notice( __( 'Teachers cannot book their own live classes.', 'classhall-live-classes' ), 'error' );
			return false;
		}

		if ( ! in_array( $class->status, array( Statuses::CLASS_APPROVED, Statuses::CLASS_PUBLISHED ), true ) ) {
			wc_add_notice( __( 'This live class is not available for booking.', 'classhall-live-classes' ), 'error' );
			return false;
		}

		if ( $class->booking_closes_at_utc && time() > strtotime( $class->booking_closes_at_utc . ' UTC' ) ) {
			wc_add_notice( __( 'Booking has closed for this live class.', 'classhall-live-classes' ), 'error' );
			return false;
		}

		if ( ( (int) $class->confirmed_seats + absint( $quantity ) ) > (int) $class->capacity ) {
			wc_add_notice( __( 'There are not enough seats left for this live class.', 'classhall-live-classes' ), 'error' );
			return false;
		}

		if ( $this->student_has_active_booking( get_current_user_id(), $class->class_id ) ) {
			wc_add_notice( __( 'You already have a booking for this live class.', 'classhall-live-classes' ), 'error' );
			return false;
		}

		if ( $this->student_has_schedule_conflict( get_current_user_id(), $class ) ) {
			wc_add_notice( __( 'You already have a live class booked for this time. Please book another available class or choose another teacher for this subject.', 'classhall-live-classes' ), 'error' );
			return false;
		}

		return $passed;
	}

	/**
	 * Add live class data to cart.
	 *
	 * @param array $cart_item_data Cart item data.
	 * @param int   $product_id Product ID.
	 * @param int   $variation_id Variation ID.
	 * @return array
	 */
	public function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {
		unset( $variation_id );
		$class = $this->class_for_product( $product_id );
		if ( $class ) {
			$cart_item_data['classhall_live_class_id'] = (int) $class->class_id;
			$cart_item_data['unique_key']              = md5( $product_id . '|' . $class->class_id . '|' . get_current_user_id() );
		}

		return $cart_item_data;
	}

	/**
	 * Display class item data in cart.
	 *
	 * @param array $item_data Item data.
	 * @param array $cart_item Cart item.
	 * @return array
	 */
	public function display_cart_item_data( $item_data, $cart_item ) {
		if ( empty( $cart_item['classhall_live_class_id'] ) ) {
			return $item_data;
		}

		$class = $this->class_by_id( absint( $cart_item['classhall_live_class_id'] ) );
		if ( $class ) {
			$item_data[] = array( 'key' => __( 'Live Class', 'classhall-live-classes' ), 'value' => get_the_title( $class->post_id ) );
			$item_data[] = array( 'key' => __( 'Class type', 'classhall-live-classes' ), 'value' => $this->class_type_label( $class->class_type ) );
			$item_data[] = array( 'key' => __( 'Schedule', 'classhall-live-classes' ), 'value' => $this->class_schedule_summary( $class ) );
			$item_data[] = array( 'key' => __( 'Price covers', 'classhall-live-classes' ), 'value' => $this->class_session_count( $class ) > 1 ? __( '1-month class series', 'classhall-live-classes' ) : __( 'This live class', 'classhall-live-classes' ) );
		}

		return $item_data;
	}

	/**
	 * Sync cart price from class record.
	 *
	 * @param \WC_Cart $cart Cart.
	 * @return void
	 */
	public function sync_cart_price( $cart ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return;
		}

		if ( ! $cart || ! is_a( $cart, 'WC_Cart' ) ) {
			return;
		}

		foreach ( $cart->get_cart() as $cart_item ) {
			if ( empty( $cart_item['classhall_live_class_id'] ) || empty( $cart_item['data'] ) ) {
				continue;
			}

			$class = $this->class_by_id( absint( $cart_item['classhall_live_class_id'] ) );
			if ( $class ) {
				$cart_item['data']->set_price( (string) ( (int) $class->price_minor / 100 ) );
			}
		}
	}

	/**
	 * Copy class metadata to order line item.
	 *
	 * @param \WC_Order_Item_Product $item Item.
	 * @param string                 $cart_item_key Cart item key.
	 * @param array                  $values Cart values.
	 * @param \WC_Order              $order Order.
	 * @return void
	 */
	public function copy_order_item_meta( $item, $cart_item_key, $values, $order ) {
		unset( $cart_item_key, $order );
		if ( empty( $values['classhall_live_class_id'] ) ) {
			return;
		}

		$class = $this->class_by_id( absint( $values['classhall_live_class_id'] ) );
		if ( ! $class ) {
			return;
		}

		$item->add_meta_data( self::ITEM_META, (int) $class->class_id, true );
		$item->add_meta_data( '_classhall_live_teacher_id', (int) $class->teacher_user_id, true );
		$item->add_meta_data( __( 'Live Class', 'classhall-live-classes' ), get_the_title( $class->post_id ), true );
		$item->add_meta_data( __( 'Class type', 'classhall-live-classes' ), $this->class_type_label( $class->class_type ), true );
		$item->add_meta_data( __( 'Schedule', 'classhall-live-classes' ), $this->class_schedule_summary( $class ), true );
		if ( $this->class_session_count( $class ) > 1 ) {
			$item->add_meta_data( __( 'Price covers', 'classhall-live-classes' ), __( '1-month class series', 'classhall-live-classes' ), true );
		}
	}

	/**
	 * Confirm bookings from paid order.
	 *
	 * @param int $order_id Order ID.
	 * @return void
	 */
	public function confirm_bookings_from_order( $order_id ) {
		if ( ! function_exists( 'wc_get_order' ) ) {
			return;
		}

		$order = wc_get_order( $order_id );
		if ( ! $order || ! $order->get_user_id() ) {
			return;
		}

		foreach ( $order->get_items() as $item_id => $item ) {
			$class_id = absint( $item->get_meta( self::ITEM_META, true ) );
			if ( ! $class_id ) {
				continue;
			}

			$this->confirm_booking_for_item( $order, absint( $item_id ), $item, $class_id );
		}
	}

	/**
	 * Mark booking/earnings refunded.
	 *
	 * @param int $order_id Order ID.
	 * @param int $refund_id Refund ID.
	 * @return void
	 */
	public function mark_refunded( $order_id, $refund_id ) {
		global $wpdb;
		$tables = Installer::tables();
		$now    = current_time( 'mysql', true );
		$ids    = $wpdb->get_col( $wpdb->prepare( "SELECT booking_id FROM {$tables['bookings']} WHERE order_id = %d", absint( $order_id ) ) );

		$wpdb->update(
			$tables['bookings'],
			array( 'status' => Statuses::BOOKING_REFUNDED, 'payment_status' => 'refunded', 'refunded_at' => $now, 'updated_at' => $now ),
			array( 'order_id' => absint( $order_id ) ),
			array( '%s', '%s', '%s', '%s' ),
			array( '%d' )
		);
		foreach ( $ids as $booking_id ) {
			$wpdb->update(
				$tables['earnings'],
				array( 'earning_status' => 'reversed', 'payout_status' => 'reversed', 'updated_at' => $now ),
				array( 'booking_id' => absint( $booking_id ) ),
				array( '%s', '%s', '%s' ),
				array( '%d' )
			);
		}
		Audit_Log::record( 'booking_refunded', 'order', absint( $order_id ), null, array( 'refund_id' => absint( $refund_id ) ) );
	}

	/**
	 * Sync WooCommerce product for a class.
	 *
	 * @param int $class_id Class ID.
	 * @return int
	 */
	public function sync_product( $class_id ) {
		if ( ! class_exists( 'WC_Product_Simple' ) ) {
			return 0;
		}

		global $wpdb;
		$tables = Installer::tables();
		$class  = $this->class_by_id( $class_id );
		if ( ! $class ) {
			return 0;
		}

		$product_id = absint( $class->product_id );
		$product    = $product_id ? wc_get_product( $product_id ) : null;
		if ( ! $product ) {
			$product = new \WC_Product_Simple();
		}

		$product->set_name( get_the_title( $class->post_id ) );
		$product->set_status( 'publish' );
		$product->set_catalog_visibility( 'hidden' );
		$product->set_virtual( true );
		$product->set_sold_individually( 'one_on_one' === $class->class_type );
		$product->set_manage_stock( true );
		$product->set_stock_quantity( max( 0, (int) $class->capacity - (int) $class->confirmed_seats ) );
		$product->set_regular_price( (string) ( (int) $class->price_minor / 100 ) );
		$product->update_meta_data( self::PRODUCT_META, $class_id );

		$product_id = $product->save();

		$wpdb->update( $tables['classes'], array( 'product_id' => $product_id, 'updated_at' => current_time( 'mysql', true ) ), array( 'class_id' => $class_id ), array( '%d', '%s' ), array( '%d' ) );
		update_post_meta( $product_id, self::PRODUCT_META, $class_id );

		return $product_id;
	}

	/**
	 * Confirm one order item idempotently.
	 *
	 * @param \WC_Order              $order Order.
	 * @param int                    $item_id Item ID.
	 * @param \WC_Order_Item_Product $item Item.
	 * @param int                    $class_id Class ID.
	 * @return void
	 */
	private function confirm_booking_for_item( $order, $item_id, $item, $class_id ) {
		global $wpdb;

		$tables = Installer::tables();
		$exists = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT booking_id FROM {$tables['bookings']} WHERE order_id = %d AND order_item_id = %d",
				$order->get_id(),
				$item_id
			)
		);
		if ( $exists ) {
			return;
		}

		$class = $this->class_by_id( $class_id );
		if ( ! $class || ! in_array( $class->status, array( Statuses::CLASS_APPROVED, Statuses::CLASS_PUBLISHED ), true ) ) {
			$order->add_order_note( __( 'Live class booking was not created because the class is no longer bookable.', 'classhall-live-classes' ) );
			return;
		}

		if ( (int) $class->teacher_user_id === (int) $order->get_user_id() || $this->student_has_active_booking( $order->get_user_id(), $class_id ) ) {
			$order->add_order_note( __( 'Live class booking was skipped because it would duplicate or self-book.', 'classhall-live-classes' ) );
			return;
		}

		if ( $this->student_has_schedule_conflict( $order->get_user_id(), $class ) ) {
			$order->add_order_note( __( 'Live class booking was skipped because the student already has a live class at this time.', 'classhall-live-classes' ) );
			return;
		}

		$quantity = max( 1, absint( $item->get_quantity() ) );
		$claimed  = $wpdb->query(
			$wpdb->prepare(
				"UPDATE {$tables['classes']} SET confirmed_seats = confirmed_seats + %d, updated_at = %s WHERE class_id = %d AND status IN ('approved','published') AND confirmed_seats + %d <= capacity",
				$quantity,
				current_time( 'mysql', true ),
				$class_id,
				$quantity
			)
		);

		if ( 1 !== (int) $claimed ) {
			$order->add_order_note( __( 'Live class booking could not be confirmed because capacity was no longer available.', 'classhall-live-classes' ) );
			return;
		}

		$amount_minor = (int) round( (float) $item->get_total() * 100 );
		$now          = current_time( 'mysql', true );
		$booking_uuid = wp_generate_uuid4();

		$inserted = $wpdb->insert(
			$tables['bookings'],
			array(
				'booking_uuid'      => $booking_uuid,
				'student_user_id'   => (int) $order->get_user_id(),
				'teacher_user_id'   => (int) $class->teacher_user_id,
				'class_id'          => $class_id,
				'session_id'        => 0,
				'order_id'          => (int) $order->get_id(),
				'order_item_id'     => $item_id,
				'status'            => Statuses::BOOKING_CONFIRMED,
				'payment_status'    => 'paid',
				'amount_paid_minor' => $amount_minor,
				'currency'          => $order->get_currency(),
				'seat_quantity'     => $quantity,
				'booking_source'    => 'woocommerce',
				'created_at'        => $now,
				'updated_at'        => $now,
			)
		);

		if ( ! $inserted ) {
			$wpdb->query( $wpdb->prepare( "UPDATE {$tables['classes']} SET confirmed_seats = GREATEST(0, confirmed_seats - %d) WHERE class_id = %d", $quantity, $class_id ) );
			return;
		}

		$booking_id = absint( $wpdb->insert_id );
		$this->create_earning( $booking_id, $class, $amount_minor, $order->get_currency() );
		$this->sync_product( $class_id );
		$this->send_booking_notifications( $booking_id, $order, $class );
		Audit_Log::record( 'booking_confirmed', 'booking', $booking_id );
		do_action( 'classhall_live_booking_confirmed', $booking_id, $order->get_id() );
	}

	/**
	 * Send booking-confirmed emails to the student and teacher.
	 *
	 * @param int       $booking_id Booking ID.
	 * @param \WC_Order $order WooCommerce order.
	 * @param object    $class Class row.
	 * @return void
	 */
	private function send_booking_notifications( $booking_id, $order, $class ) {
		$student = get_user_by( 'id', (int) $order->get_user_id() );
		$teacher = get_user_by( 'id', (int) $class->teacher_user_id );
		$title   = get_the_title( $class->post_id );
		$schedule = $this->class_schedule_summary( $class );
		$class_type = $this->class_type_label( $class->class_type );
		$dashboard_url = apply_filters( 'classhall_live_student_dashboard_url', home_url( '/my-live-classes/' ), $booking_id, $order, $class );

		if ( $student && $student->user_email ) {
			$subject = sprintf(
				/* translators: %s: class title. */
				__( 'Your Classhall live class is booked: %s', 'classhall-live-classes' ),
				$title
			);
			$message = sprintf(
				/* translators: 1: student name, 2: class title, 3: subject, 4: date, 5: teacher name, 6: dashboard URL. */
				__( "Hello %1\$s,\n\nYour live class booking is confirmed.\n\nClass: %2\$s\nSubject: %3\$s\nClass type: %4\$s\nSchedule: %5\$s\nTeacher: %6\$s\n\nYou can view this booking from your Classhall live classes dashboard:\n%7\$s\n\nFor security, the meeting link is only shown in your dashboard during the allowed access window.", 'classhall-live-classes' ),
				$student->display_name,
				$title,
				$class->primary_subject_label,
				$class_type,
				$schedule,
				$teacher ? $teacher->display_name : __( 'Classhall teacher', 'classhall-live-classes' ),
				$dashboard_url
			);
			wp_mail( $student->user_email, $subject, $message );
		}

		if ( $teacher && $teacher->user_email ) {
			$subject = sprintf(
				/* translators: %s: class title. */
				__( 'New Classhall live class booking: %s', 'classhall-live-classes' ),
				$title
			);
			$message = sprintf(
				/* translators: 1: teacher name, 2: class title, 3: date, 4: student name, 5: order number. */
				__( "Hello %1\$s,\n\nA student has booked your live class.\n\nClass: %2\$s\nClass type: %3\$s\nSchedule: %4\$s\nStudent: %5\$s\nOrder: #%6\$s\n\nPlease keep the meeting link private and admit only booked students.", 'classhall-live-classes' ),
				$teacher->display_name,
				$title,
				$class_type,
				$schedule,
				$student ? $student->display_name : __( 'Student', 'classhall-live-classes' ),
				$order->get_order_number()
			);
			wp_mail( $teacher->user_email, $subject, $message );
		}
	}

	/**
	 * Create earning ledger row.
	 *
	 * @param int    $booking_id Booking ID.
	 * @param object $class Class row.
	 * @param int    $gross_minor Gross.
	 * @param string $currency Currency.
	 * @return void
	 */
	private function create_earning( $booking_id, $class, $gross_minor, $currency ) {
		global $wpdb;
		$tables     = Installer::tables();
		$commission = (int) round( $gross_minor * ( (float) Plugin::settings()['commission_percent'] / 100 ) );
		$teacher    = max( 0, $gross_minor - $commission );
		$now        = current_time( 'mysql', true );

		$wpdb->insert(
			$tables['earnings'],
			array(
				'booking_id'      => $booking_id,
				'teacher_user_id' => (int) $class->teacher_user_id,
				'class_id'        => (int) $class->class_id,
				'gross_minor'     => $gross_minor,
				'net_minor'       => $gross_minor,
				'commission_minor'=> $commission,
				'teacher_minor'   => $teacher,
				'currency'        => $currency,
				'earning_status'  => 'pending',
				'payout_status'   => 'unpaid',
				'created_at'      => $now,
				'updated_at'      => $now,
			)
		);
	}

	/**
	 * Format UTC datetime in site timezone.
	 *
	 * @param string|null $utc UTC datetime.
	 * @return string
	 */
	private function format_utc( $utc ) {
		if ( empty( $utc ) ) {
			return __( 'Schedule pending', 'classhall-live-classes' );
		}

		return wp_date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $utc . ' UTC' ) );
	}

	/**
	 * Render the schedule shown in cart, order, and booking emails.
	 *
	 * @param object $class Class row.
	 * @return string
	 */
	private function class_schedule_summary( $class ) {
		global $wpdb;

		$tables   = Installer::tables();
		$sessions = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT start_at_utc FROM {$tables['sessions']} WHERE class_id = %d AND deleted_at IS NULL ORDER BY start_at_utc ASC",
				absint( $class->class_id )
			)
		);

		if ( count( $sessions ) <= 1 ) {
			return $this->format_utc( $class->start_at_utc );
		}

		$first      = $sessions[0]->start_at_utc;
		$last       = $sessions[ count( $sessions ) - 1 ]->start_at_utc;
		$recurrence = (string) get_post_meta( (int) $class->post_id, '_classhall_live_recurrence_type', true );
		$label      = 'multiple_days' === $recurrence ? __( 'Multiple days weekly', 'classhall-live-classes' ) : __( 'Weekly', 'classhall-live-classes' );

		return sprintf(
			/* translators: 1: recurrence label, 2: number of sessions, 3: first date, 4: last date, 5: time. */
			__( '%1$s | %2$d sessions | %3$s - %4$s | %5$s', 'classhall-live-classes' ),
			$label,
			count( $sessions ),
			wp_date( get_option( 'date_format' ), strtotime( $first . ' UTC' ) ),
			wp_date( get_option( 'date_format' ), strtotime( $last . ' UTC' ) ),
			wp_date( get_option( 'time_format' ), strtotime( $first . ' UTC' ) )
		);
	}

	/**
	 * Count saved sessions for a class.
	 *
	 * @param object $class Class row.
	 * @return int
	 */
	private function class_session_count( $class ) {
		global $wpdb;

		$tables = Installer::tables();
		$count  = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$tables['sessions']} WHERE class_id = %d AND deleted_at IS NULL",
				absint( $class->class_id )
			)
		);

		return max( 1, absint( $count ) );
	}

	/**
	 * Human-readable class type label.
	 *
	 * @param string $class_type Raw class type.
	 * @return string
	 */
	private function class_type_label( $class_type ) {
		return 'one_on_one' === $class_type ? __( 'One-on-one', 'classhall-live-classes' ) : __( 'Group', 'classhall-live-classes' );
	}

	/**
	 * Return the class time ranges that should be checked for clashes.
	 *
	 * @param object $class Class row.
	 * @return array<int,array{start:int,end:int}>
	 */
	private function class_time_ranges( $class ) {
		global $wpdb;

		$tables   = Installer::tables();
		$sessions = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT start_at_utc, end_at_utc FROM {$tables['sessions']} WHERE class_id = %d AND deleted_at IS NULL ORDER BY start_at_utc ASC",
				absint( $class->class_id )
			)
		);
		$ranges   = array();
		$duration = max( 15, absint( $class->duration_minutes ?? 60 ) );

		if ( empty( $sessions ) ) {
			$sessions = array(
				(object) array(
					'start_at_utc' => $class->start_at_utc,
					'end_at_utc'   => $class->end_at_utc,
				),
			);
		}

		foreach ( $sessions as $session ) {
			if ( empty( $session->start_at_utc ) ) {
				continue;
			}

			$start = strtotime( $session->start_at_utc . ' UTC' );
			$end   = empty( $session->end_at_utc ) ? $start + ( $duration * MINUTE_IN_SECONDS ) : strtotime( $session->end_at_utc . ' UTC' );
			if ( $start && $end && $end > $start ) {
				$ranges[] = array(
					'start' => $start,
					'end'   => $end,
				);
			}
		}

		return $ranges;
	}

	/**
	 * Get class row for product.
	 *
	 * @param int $product_id Product ID.
	 * @return object|null
	 */
	private function class_for_product( $product_id ) {
		$class_id = absint( get_post_meta( $product_id, self::PRODUCT_META, true ) );
		return $class_id ? $this->class_by_id( $class_id ) : null;
	}

	/**
	 * Get class row by ID.
	 *
	 * @param int $class_id Class ID.
	 * @return object|null
	 */
	private function class_by_id( $class_id ) {
		global $wpdb;
		$tables = Installer::tables();
		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$tables['classes']} WHERE class_id = %d", absint( $class_id ) ) );
	}

	/**
	 * Check active student booking.
	 *
	 * @param int $student_id Student ID.
	 * @param int $class_id Class ID.
	 * @return bool
	 */
	private function student_has_active_booking( $student_id, $class_id ) {
		global $wpdb;
		$tables = Installer::tables();
		$count  = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$tables['bookings']} WHERE student_user_id = %d AND class_id = %d AND status IN ('pending_payment','confirmed','completed')",
				absint( $student_id ),
				absint( $class_id )
			)
		);

		return (int) $count > 0;
	}

	/**
	 * Check whether a student already has an active booking at the same time.
	 *
	 * @param int    $student_id Student user ID.
	 * @param object $class New class row.
	 * @return bool
	 */
	private function student_has_schedule_conflict( $student_id, $class ) {
		global $wpdb;

		$new_ranges = $this->class_time_ranges( $class );
		if ( empty( $new_ranges ) ) {
			return false;
		}

		$tables  = Installer::tables();
		$classes = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT c.*
				FROM {$tables['bookings']} b
				INNER JOIN {$tables['classes']} c ON c.class_id = b.class_id
				WHERE b.student_user_id = %d
					AND b.class_id <> %d
					AND b.status IN ('pending_payment','confirmed','completed')
					AND c.deleted_at IS NULL",
				absint( $student_id ),
				absint( $class->class_id )
			)
		);

		foreach ( $classes as $booked_class ) {
			foreach ( $this->class_time_ranges( $booked_class ) as $booked_range ) {
				foreach ( $new_ranges as $new_range ) {
					if ( $new_range['start'] < $booked_range['end'] && $new_range['end'] > $booked_range['start'] ) {
						return true;
					}
				}
			}
		}

		return false;
	}
}
