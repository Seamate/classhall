<?php
/** Manual renewals: each paid order item owns one non-overlapping access period. */
defined( 'ABSPATH' ) || exit;

function classhall_home_lesson_root( $order, $item ) {
    $root_order = (int) $item->get_meta( '_chl_root_order', true );
    $root_item = (int) $item->get_meta( '_chl_root_item', true );
    if ( ! $root_order ) {
        return array( $order, $item );
    }
    $order = wc_get_order( $root_order );
    return array( $order, $order ? $order->get_item( $root_item ) : false );
}

function classhall_home_lesson_paid_item( $order, $item ) {
    return $order && $item && $order->is_paid() && $order->get_date_paid()
        && 'yes' === $item->get_meta( '_classhall_home_lesson', true )
        && abs( $order->get_qty_refunded_for_item( $item->get_id() ) ) < $item->get_quantity();
}

function classhall_home_lesson_periods( $order, $item, $exclude_order = 0 ) {
    list( $root_order, $root_item ) = classhall_home_lesson_root( $order, $item );
    if ( ! $root_order || ! $root_item ) {
        return array();
    }
    $periods = array();
    $orders = wc_get_orders( array( 'limit' => -1, 'status' => array( 'processing', 'completed' ), 'meta_key' => '_chl_renewal_root', 'meta_value' => $root_item->get_id() ) );
    array_unshift( $orders, $root_order );
    foreach ( $orders as $candidate ) {
        if ( $candidate->get_id() === (int) $exclude_order ) {
            continue;
        }
        foreach ( $candidate->get_items() as $candidate_item ) {
            $is_root = $candidate->get_id() === $root_order->get_id() && $candidate_item->get_id() === $root_item->get_id();
            if ( ! $is_root && ( (int) $candidate_item->get_meta( '_chl_root_item', true ) !== $root_item->get_id() || (int) $candidate_item->get_meta( '_chl_root_order', true ) !== $root_order->get_id() ) ) {
                continue;
            }
            if ( ! classhall_home_lesson_paid_item( $candidate, $candidate_item ) ) {
                continue;
            }
            $start = (int) $candidate_item->get_meta( '_chl_access_start', true );
            $end = (int) $candidate_item->get_meta( '_chl_access_end', true );
            if ( ! $start && $is_root ) {
                $start = $candidate->get_date_paid()->getTimestamp();
                $end = classhall_home_lesson_period_end( $start );
            }
            if ( $start && $end ) {
                $periods[] = array( 'order' => $candidate, 'item' => $candidate_item, 'start' => $start, 'end' => $end );
            }
        }
    }
    return $periods;
}

function classhall_home_lesson_renewal_start( $paid_at, $periods ) {
    foreach ( $periods as $period ) {
        $paid_at = max( $paid_at, $period['end'] );
    }
    return $paid_at;
}

function classhall_home_lesson_initialise_period( $order, $item ) {
    list( $root_order, $root_item ) = classhall_home_lesson_root( $order, $item );
    if ( ! $root_order || ! $root_item || ! $root_order->get_date_paid() || 'yes' !== $root_item->get_meta( '_classhall_home_lesson', true ) || $root_item->get_meta( '_classhall_home_lesson_class', true ) !== $item->get_meta( '_classhall_home_lesson_class', true ) ) {
        $order->add_order_note( 'Online class renewal could not be linked to its original enrolment. Please review this payment.' );
        return false;
    }
    if ( $root_order->get_id() !== $order->get_id()
        && ! ( $root_order->get_customer_id() && $root_order->get_customer_id() === $order->get_customer_id() )
        && strtolower( trim( $root_order->get_billing_email() ) ) !== strtolower( trim( $order->get_billing_email() ) ) ) {
        $order->add_order_note( 'Online class renewal owner does not match the original enrolment. Please review this payment.' );
        return false;
    }
    $lock = 'chl_enrol_' . $root_item->get_id();
    if ( ! add_option( $lock, time(), '', false ) ) {
        if ( (int) get_option( $lock ) < time() - 600 ) {
            delete_option( $lock );
        }
        classhall_home_lesson_queue( time() + 60, 'classhall_home_lesson_enrol_retry', array( $order->get_id() ) );
        return false;
    }
    try {
        $fresh = wc_get_order( $order->get_id() )->get_item( $item->get_id() );
        if ( $fresh->get_meta( '_chl_access_start', true ) ) {
            return true;
        }
        $start = $order->get_date_paid()->getTimestamp();
        if ( $item->get_meta( '_chl_root_item', true ) ) {
            $start = classhall_home_lesson_renewal_start( $start, classhall_home_lesson_periods( $order, $item, $order->get_id() ) );
        }
        $item->update_meta_data( '_chl_access_start', $start );
        $item->update_meta_data( '_chl_access_end', classhall_home_lesson_period_end( $start ) );
        if ( ! $item->get_meta( '_chl_join_token', true ) ) {
            $item->update_meta_data( '_chl_join_token', wp_generate_password( 40, false, false ) );
        }
        $item->save();
        return true;
    } finally {
        delete_option( $lock );
    }
}
add_action( 'classhall_home_lesson_enrol_retry', 'classhall_home_lesson_enrol_paid_order' );

function classhall_home_lesson_renewal_url( $order, $item ) {
    return add_query_arg( array( 'chl_renew' => $order->get_id(), 'chl_item' => $item->get_id(), 'chl_token' => $item->get_meta( '_chl_join_token', true ) ), home_url( '/online-classes/' ) );
}

function classhall_home_lesson_can_renew( $order, $item, $token, $user_id ) {
    if ( ! $order || ! $item || ! $order->get_date_paid() || 'yes' !== $item->get_meta( '_classhall_home_lesson', true ) ) {
        return false;
    }
    return ( $user_id && (int) $order->get_customer_id() === (int) $user_id )
        || ( is_string( $token ) && '' !== $token && hash_equals( (string) $item->get_meta( '_chl_join_token', true ), $token ) );
}

function classhall_home_lesson_renewal_request() {
    if ( ! isset( $_GET['chl_renew'] ) || ! function_exists( 'WC' ) ) {
        return;
    }
    nocache_headers();
    header( 'Referrer-Policy: no-referrer' );
    $order = wc_get_order( absint( $_GET['chl_renew'] ) );
    $item = $order ? $order->get_item( absint( $_GET['chl_item'] ?? 0 ) ) : false;
    $token = isset( $_GET['chl_token'] ) && is_string( $_GET['chl_token'] ) ? wp_unslash( $_GET['chl_token'] ) : '';
    if ( ! classhall_home_lesson_can_renew( $order, $item, $token, 0 ) ) {
        wp_die( 'This renewal link is invalid. Open Online Classes in My Account or use the link in your enrolment email.', 'Online Classes', array( 'response' => 403 ) );
    }
    list( $root_order, $root_item ) = classhall_home_lesson_root( $order, $item );
    if ( ! $root_order || ! $root_item ) {
        wp_die( 'The original enrolment could not be found. Please contact Classhall.' );
    }
    if ( ! WC()->cart || ! WC()->session ) {
        wc_load_cart();
    }
    $product_id = classhall_home_lesson_product_id();
    $class = $root_item->get_meta( '_classhall_home_lesson_class', true );
    if ( ! $product_id || ! classhall_home_lesson_schedule( $class ) ) {
        wp_die( 'Renewal is currently unavailable. Please contact Classhall.' );
    }
    foreach ( WC()->cart->get_cart() as $key => $cart_item ) {
        if ( ! empty( $cart_item['classhall_home_lesson'] ) ) {
            WC()->cart->remove_cart_item( $key );
        }
    }
    $added = WC()->cart->add_to_cart( $product_id, 1, 0, array(), array(
        'classhall_home_lesson' => true,
        'classhall_home_lesson_class' => $class,
        'chl_root_order' => $root_order->get_id(),
        'chl_root_item' => $root_item->get_id(),
        'chl_renewal_proof' => wp_hash( $root_order->get_id() . ':' . $root_item->get_id() ),
        'unique_key' => 'home-renewal-' . $root_item->get_id(),
    ) );
    WC()->cart->calculate_totals();
    WC()->cart->set_session();
    wp_safe_redirect( $added ? wc_get_checkout_url() : home_url( '/online-classes/' ) );
    exit;
}
add_action( 'wp_loaded', 'classhall_home_lesson_renewal_request', 34 );

function classhall_home_lesson_validate_renewal_checkout( $data, $errors ) {
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        if ( empty( $cart_item['chl_root_item'] ) ) {
            continue;
        }
        $order = wc_get_order( $cart_item['chl_root_order'] );
        $item = $order ? $order->get_item( $cart_item['chl_root_item'] ) : false;
        $proof = wp_hash( $cart_item['chl_root_order'] . ':' . $cart_item['chl_root_item'] );
        if ( ! $item || ! hash_equals( $proof, (string) ( $cart_item['chl_renewal_proof'] ?? '' ) ) || $item->get_meta( '_classhall_home_lesson_class', true ) !== $cart_item['classhall_home_lesson_class'] ) {
            $errors->add( 'chl_renewal_invalid', 'Please reopen the renewal link from your enrolment email or My Account.' );
        } elseif ( ! ( get_current_user_id() && (int) $order->get_customer_id() === get_current_user_id() ) && strtolower( trim( $data['billing_email'] ?? '' ) ) !== strtolower( trim( $order->get_billing_email() ) ) ) {
            $errors->add( 'chl_renewal_email', 'Use the billing email from your original online classes enrolment to renew.' );
        }
    }
}
add_action( 'woocommerce_after_checkout_validation', 'classhall_home_lesson_validate_renewal_checkout', 10, 2 );

function classhall_home_lesson_copy_renewal( $item, $cart_item_key, $values, $order ) {
    if ( ! empty( $values['classhall_home_lesson'] ) && ! empty( $values['chl_root_item'] ) ) {
        $item->add_meta_data( '_chl_root_order', absint( $values['chl_root_order'] ), true );
        $item->add_meta_data( '_chl_root_item', absint( $values['chl_root_item'] ), true );
        $item->add_meta_data( 'Enrolment', 'Monthly renewal', true );
        $order->update_meta_data( '_chl_renewal_root', absint( $values['chl_root_item'] ) );
    }
}
add_action( 'woocommerce_checkout_create_order_line_item', 'classhall_home_lesson_copy_renewal', 30, 4 );
add_filter( 'woocommerce_get_item_data', function ( $data, $item ) {
    if ( ! empty( $item['chl_root_item'] ) ) {
        $data[] = array( 'key' => 'Enrolment', 'value' => 'Monthly renewal. No automatic charges.' );
    }
    return $data;
}, 30, 2 );

add_filter( 'woocommerce_get_query_vars', function ( $vars ) { $vars['home-lessons'] = 'home-lessons'; return $vars; } );
add_filter( 'woocommerce_account_menu_items', function ( $items ) {
    $logout = $items['customer-logout'] ?? null;
    unset( $items['customer-logout'] );
    $items['home-lessons'] = 'Online Classes';
    if ( $logout ) { $items['customer-logout'] = $logout; }
    return $items;
} );
add_filter( 'woocommerce_get_endpoint_url', function ( $url, $endpoint, $value, $permalink ) {
    return 'home-lessons' === $endpoint ? add_query_arg( 'home-lessons', '1', $permalink ) : $url;
}, 10, 4 );

function classhall_home_lesson_account() {
    if ( ! is_user_logged_in() ) { return; }
    $page = max( 1, absint( $_GET['chl_page'] ?? 1 ) );
    $result = wc_get_orders( array( 'customer_id' => get_current_user_id(), 'limit' => 20, 'page' => $page, 'paginate' => true, 'orderby' => 'date', 'order' => 'DESC' ) );
    $seen = array();
    echo '<h2>Online Classes</h2><p>Monthly enrolment. Renew manually whenever you need another month.</p><div class="chl-renewals">';
    foreach ( $result->orders as $order ) {
        foreach ( $order->get_items() as $item ) {
            if ( 'yes' !== $item->get_meta( '_classhall_home_lesson', true ) || ! $order->get_date_paid() ) { continue; }
            list( $root_order, $root_item ) = classhall_home_lesson_root( $order, $item );
            if ( ! $root_item || isset( $seen[ $root_item->get_id() ] ) ) { continue; }
            $seen[ $root_item->get_id() ] = true;
            if ( ! $root_item->get_meta( '_chl_join_token', true ) ) {
                $root_item->update_meta_data( '_chl_join_token', wp_generate_password( 40, false, false ) );
                $root_item->save();
            }
            $periods = classhall_home_lesson_periods( $root_order, $root_item );
            $end = 0;
            $active = false;
            foreach ( $periods as $period ) {
                $end = max( $end, $period['end'] );
                $active = $active || ( $period['start'] <= time() && $period['end'] > time() );
            }
            $class = $root_item->get_meta( '_classhall_home_lesson_class', true );
            $classes = classhall_home_lesson_classes();
            echo '<article class="chl-renewal"><h3>' . esc_html( $classes[ $class ] ?? $class ) . ' (Online Classes)</h3>';
            echo '<p><strong>Status:</strong> ' . esc_html( $active ? 'Active' : ( $end > time() ? 'Upcoming' : 'Expired' ) ) . '</p>';
            if ( $end ) {
                echo '<p><strong>Paid through:</strong> ' . esc_html( wp_date( 'j F Y, g:i a', $end, new DateTimeZone( 'Africa/Lagos' ) ) ) . ' WAT</p>';
            }
            echo '<p>' . esc_html( classhall_home_lesson_schedule_label( $class ) ) . '</p><div class="chl-renewal-actions"><a class="button" href="' . esc_url( classhall_home_lesson_renewal_url( $root_order, $root_item ) ) . '">Renew Online Classes</a>';
            if ( $active ) {
                echo '<a class="button" href="' . esc_url( classhall_home_lesson_join_url( $root_order, $root_item ) ) . '">Join class</a>';
            }
            echo '</div></article>';
        }
    }
    if ( ! $seen ) { echo '<p>No paid online classes enrolments on this page.</p>'; }
    echo '</div>';
    $base = wc_get_account_endpoint_url( 'home-lessons' );
    if ( $page > 1 ) { echo '<a href="' . esc_url( add_query_arg( 'chl_page', $page - 1, $base ) ) . '">Newer orders</a> '; }
    if ( $page < $result->max_num_pages ) { echo '<a href="' . esc_url( add_query_arg( 'chl_page', $page + 1, $base ) ) . '">Older orders</a>'; }
}
add_action( 'woocommerce_account_home-lessons_endpoint', 'classhall_home_lesson_account' );
add_action( 'wp_enqueue_scripts', function () {
    if ( function_exists( 'is_account_page' ) && is_account_page() ) {
        wp_enqueue_style( 'classhall-home-renewals', get_stylesheet_directory_uri() . '/assets/css/home-lesson-renewals.css', array(), (string) filemtime( get_stylesheet_directory() . '/assets/css/home-lesson-renewals.css' ) );
    }
}, 30 );

function classhall_home_lesson_schedule_expiry( $order, $item ) {
    $end = (int) $item->get_meta( '_chl_access_end', true );
    foreach ( array( 'before' => $end - 3 * DAY_IN_SECONDS, 'expired' => $end ) as $kind => $due ) {
        if ( ! $item->get_meta( '_chl_notice_' . $kind, true ) && $end > time() ) {
            classhall_home_lesson_queue( max( time(), $due ), 'classhall_home_lesson_expiry_email', array( $order->get_id(), $item->get_id(), $end, $kind ) );
        }
    }
}

function classhall_home_lesson_send_expiry_email( $order_id, $item_id, $end, $kind, $attempt = 0 ) {
    $order = wc_get_order( $order_id );
    $item = $order ? $order->get_item( $item_id ) : false;
    if ( ! classhall_home_lesson_paid_item( $order, $item ) || ! in_array( $kind, array( 'before', 'expired' ), true ) ) { return; }
    if ( ( 'before' === $kind && ( time() >= $end || time() < $end - 3 * DAY_IN_SECONDS ) ) || ( 'expired' === $kind && time() < $end ) ) { return; }
    if ( classhall_home_lesson_renewal_start( 0, classhall_home_lesson_periods( $order, $item ) ) > $end ) { return; }
    $key = '_chl_notice_' . $kind;
    if ( $item->get_meta( $key, true ) ) { return; }
    $lock = 'chl_expiry_' . $item_id . '_' . $kind;
    if ( ! add_option( $lock, time(), '', false ) ) {
        if ( (int) get_option( $lock ) < time() - 600 ) { delete_option( $lock ); }
        if ( $attempt < 10 ) { classhall_home_lesson_queue( time() + 60, 'classhall_home_lesson_expiry_email', array( $order_id, $item_id, $end, $kind, $attempt + 1 ) ); }
        return;
    }
    try {
        $order = wc_get_order( $order_id );
        $item = $order->get_item( $item_id );
        if ( $item->get_meta( $key, true ) || ! classhall_home_lesson_paid_item( $order, $item ) || classhall_home_lesson_renewal_start( 0, classhall_home_lesson_periods( $order, $item ) ) > $end ) { return; }
        $classes = classhall_home_lesson_classes();
        $class_label = $classes[ $item->get_meta( '_classhall_home_lesson_class', true ) ] ?? 'Online Classes';
        $title = 'expired' === $kind ? 'Your online classes enrolment has expired' : 'Your online classes enrolment expires soon';
        $renewal_url = classhall_home_lesson_renewal_url( $order, $item );
        ob_start();
        include __DIR__ . '/../template-parts/emails/home-lesson-renewal.php';
        $body = ob_get_clean();
        if ( wp_mail( $order->get_billing_email(), $title . ' - ' . $class_label, $body, array( 'Content-Type: text/html; charset=UTF-8' ) ) ) {
            $item->update_meta_data( $key, time() );
            $item->save();
        } elseif ( $attempt < 3 ) {
            classhall_home_lesson_queue( time() + 60, 'classhall_home_lesson_expiry_email', array( $order_id, $item_id, $end, $kind, $attempt + 1 ) );
        } else {
            $order->add_order_note( 'Online class expiry email could not be sent. Check the email service.' );
        }
    } finally { delete_option( $lock ); }
}
add_action( 'classhall_home_lesson_expiry_email', 'classhall_home_lesson_send_expiry_email', 10, 5 );
