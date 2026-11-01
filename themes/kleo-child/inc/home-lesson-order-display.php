<?php
/** Presentation-only changes for home lesson order details, not stored order data. */
defined( 'ABSPATH' ) || exit;

function classhall_home_lesson_order_display_item( $item ) {
    return ! empty( $GLOBALS['classhall_home_order_display'] )
        && 'yes' === $item->get_meta( '_classhall_home_lesson', true );
}

add_action( 'woocommerce_order_details_before_order_table', function () {
    $GLOBALS['classhall_home_order_display'] = true;
} );
add_action( 'woocommerce_order_details_after_order_table', function () {
    unset( $GLOBALS['classhall_home_order_display'] );
}, 100 );

add_filter( 'woocommerce_order_item_class', function ( $class, $item ) {
    return classhall_home_lesson_order_display_item( $item ) ? $class . ' chl-home-order-row' : $class;
}, 20, 2 );
add_filter( 'woocommerce_order_item_name', function ( $name, $item ) {
    return classhall_home_lesson_order_display_item( $item ) ? '' : $name;
}, 100, 2 );
add_filter( 'woocommerce_order_item_quantity_html', function ( $quantity, $item ) {
    return classhall_home_lesson_order_display_item( $item ) && 1 === (int) $item->get_quantity() ? '' : $quantity;
}, 100, 2 );

function classhall_home_lesson_order_display_meta( $formatted_meta, $item ) {
    if ( ! classhall_home_lesson_order_display_item( $item ) ) {
        return $formatted_meta;
    }
    foreach ( $formatted_meta as $id => $meta ) {
        $meta = clone $meta;
        if ( in_array( $meta->key, array( 'Location', __( 'Location', 'kleo-child' ) ), true ) ) {
            unset( $formatted_meta[ $id ] );
            continue;
        }
        if ( in_array( $meta->key, array( 'Primary class', __( 'Primary class', 'kleo-child' ) ), true ) ) {
            $meta->display_key = esc_html__( 'Class', 'kleo-child' );
        } elseif ( in_array( $meta->key, array( 'Subjects', 'Subject(s)', __( 'Subjects', 'kleo-child' ) ), true ) ) {
            $meta->display_key = esc_html__( 'Core Subjects', 'kleo-child' );
            $meta->display_value = esc_html( classhall_home_lesson_subjects( $item->get_meta( '_classhall_home_lesson_class', true ) ) );
        } elseif ( in_array( $meta->key, array( 'Time', __( 'Time', 'kleo-child' ) ), true ) ) {
            $meta->display_key = esc_html__( 'Timetable', 'kleo-child' );
            $meta->display_value = implode( '<br>', array_map( 'esc_html', explode( '; ', wp_strip_all_tags( (string) $meta->value ) ) ) );
        }
        $formatted_meta[ $id ] = $meta;
    }
    return $formatted_meta;
}
add_filter( 'woocommerce_order_item_get_formatted_meta_data', 'classhall_home_lesson_order_display_meta', 100, 2 );

add_action( 'wp_enqueue_scripts', function () {
    if ( ( function_exists( 'is_order_received_page' ) && is_order_received_page() ) || ( function_exists( 'is_account_page' ) && is_account_page() ) ) {
        $path = get_stylesheet_directory() . '/assets/css/home-lesson-order.css';
        wp_enqueue_style( 'classhall-home-lesson-order', get_stylesheet_directory_uri() . '/assets/css/home-lesson-order.css', array(), (string) filemtime( $path ) );
    }
}, 30 );
