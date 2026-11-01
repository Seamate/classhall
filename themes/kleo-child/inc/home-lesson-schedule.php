<?php
/** Online class enrolments, timetable, and payment-gated reminders. */
defined( 'ABSPATH' ) || exit;
require_once __DIR__ . '/home-lesson-renewals.php';

function classhall_home_lesson_subjects( $class_key ) {
    if ( in_array( $class_key, array( 'jss1', 'jss2', 'jss3' ), true ) ) {
        return __( 'English, Mathematics, Intermediate Science, Digital Technologies and Business Studies', 'kleo-child' );
    }
    if ( in_array( $class_key, array( 'ss1', 'ss2', 'ss3' ), true ) ) {
        return __( 'English Language, General Mathematics, Biology, Chemistry and Physics', 'kleo-child' );
    }
    return __( 'English, Mathematics, Basic Science and Digital Technology', 'kleo-child' );
}

function classhall_home_lesson_schedule( $class_key ) {
    $groups = array(
        'primary-1' => 1, 'primary-2' => 1,
        'primary-3' => 2, 'primary-4' => 2,
        'primary-5' => 3, 'primary-6' => 3,
        'jss1' => 1, 'ss1' => 1,
        'jss2' => 2, 'ss2' => 2,
        'jss3' => 3, 'ss3' => 3,
    );
    $schedule = array(
        1 => array( array( 1, '16:30', 'Mathematics' ), array( 3, '16:30', 'English' ), array( 4, '16:30', 'Other subjects' ) ),
        2 => array( array( 1, '17:30', 'English' ), array( 2, '16:30', 'Mathematics' ), array( 4, '17:30', 'Other subjects' ) ),
        3 => array( array( 2, '17:30', 'English' ), array( 3, '17:30', 'Other subjects' ), array( 5, '16:30', 'Mathematics' ) ),
    );
    $slots = isset( $groups[ $class_key ] ) ? $schedule[ $groups[ $class_key ] ] : array();
    if ( in_array( $class_key, array( 'ss1', 'ss2', 'ss3' ), true ) ) {
        foreach ( $slots as &$slot ) {
            $slot[2] = strtr( $slot[2], array( 'Mathematics' => 'General Mathematics', 'English' => 'English Language', 'Other subjects' => 'Biology / Chemistry / Physics' ) );
        }
        unset( $slot );
    } elseif ( in_array( $class_key, array( 'jss1', 'jss2', 'jss3' ), true ) ) {
        foreach ( $slots as &$slot ) {
            if ( 'Other subjects' === $slot[2] ) {
                $slot[2] = 'Intermediate Science / Digital Technologies / Business Studies';
            }
        }
        unset( $slot );
    }
    return $slots;
}

function classhall_home_lesson_schedule_label( $class_key ) {
    $days = array( 1 => 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' );
    $labels = array();
    foreach ( classhall_home_lesson_schedule( $class_key ) as $slot ) {
        $time = '16:30' === $slot[1] ? '4:30 - 5:30 pm' : '5:30 - 6:30 pm';
        $labels[] = $days[ $slot[0] ] . ': ' . $time . ' (' . $slot[2] . ')';
    }
    return implode( '; ', $labels ) . ( $labels ? ' WAT' : '' );
}

function classhall_home_lesson_period_end( $start ) {
    $date = ( new DateTimeImmutable( '@' . $start ) )->setTimezone( new DateTimeZone( 'Africa/Lagos' ) );
    $next = $date->modify( 'first day of next month' );
    return $next->setDate( (int) $next->format( 'Y' ), (int) $next->format( 'm' ), min( (int) $date->format( 'd' ), (int) $next->format( 't' ) ) )->getTimestamp();
}

function classhall_home_lesson_sessions( $class_key, $start, $end ) {
    $day = ( new DateTimeImmutable( '@' . $start ) )->setTimezone( new DateTimeZone( 'Africa/Lagos' ) )->setTime( 0, 0 );
    $sessions = array();
    while ( $day->getTimestamp() < $end ) {
        foreach ( classhall_home_lesson_schedule( $class_key ) as $slot ) {
            if ( (int) $day->format( 'N' ) !== $slot[0] ) {
                continue;
            }
            list( $hour, $minute ) = array_map( 'intval', explode( ':', $slot[1] ) );
            $time = $day->setTime( $hour, $minute )->getTimestamp();
            if ( $time >= $start && $time < $end ) {
                $sessions[ $time ] = $slot[2];
            }
        }
        $day = $day->modify( '+1 day' );
    }
    return $sessions;
}

function classhall_home_lesson_meet_url() {
    return get_option( 'classhall_home_lesson_meet_url', 'https://meet.google.com/kig-bzkt-cnh' );
}

function classhall_home_lesson_validate_meet_url( $value ) {
    $url = esc_url_raw( trim( (string) $value ), array( 'https' ) );
    if ( 'meet.google.com' !== wp_parse_url( $url, PHP_URL_HOST ) || ! preg_match( '~^/[a-z]{3}-[a-z]{4}-[a-z]{3}/?$~', (string) wp_parse_url( $url, PHP_URL_PATH ) ) ) {
        add_settings_error( 'classhall_home_lesson_meet_url', 'invalid_meet', 'Enter a valid Google Meet URL, such as https://meet.google.com/kig-bzkt-cnh.' );
        return classhall_home_lesson_meet_url();
    }
    return $url;
}

function classhall_home_lesson_register_settings() {
    register_setting( 'classhall_home_lessons', 'classhall_home_lesson_meet_url', array( 'sanitize_callback' => 'classhall_home_lesson_validate_meet_url', 'type' => 'string' ) );
}
add_action( 'admin_init', 'classhall_home_lesson_register_settings' );
add_filter( 'option_page_capability_classhall_home_lessons', function () { return 'manage_woocommerce'; } );
add_action( 'admin_menu', function () {
    add_submenu_page( 'woocommerce', 'Online Classes', 'Online Classes', 'manage_woocommerce', 'classhall-home-lessons', 'classhall_home_lesson_settings_page' );
} );

function classhall_home_lesson_settings_page() {
    if ( ! current_user_can( 'manage_woocommerce' ) ) {
        return;
    }
    echo '<div class="wrap"><h1>Online Classes</h1>';
    if ( isset( $_GET['sync'] ) && 'queued' === $_GET['sync'] ) {
        echo '<div class="notice notice-success"><p>Existing paid enrolments have been queued for synchronisation.</p></div>';
    }
    settings_errors( 'classhall_home_lesson_meet_url' );
    echo '<form method="post" action="options.php">';
    settings_fields( 'classhall_home_lessons' );
    echo '<p><label for="chl-meet"><strong>Google Meet joining link</strong></label></p><input class="regular-text" type="url" required id="chl-meet" name="classhall_home_lesson_meet_url" value="' . esc_attr( classhall_home_lesson_meet_url() ) . '">';
    echo '<p>Change this link each month. Existing email join buttons and future reminders will open the current link.</p>';
    submit_button();
    echo '</form><h2>Weekly timetable (Nigeria time / WAT)</h2><ul>';
    foreach ( classhall_home_lesson_classes() as $key => $label ) {
        echo '<li><strong>' . esc_html( $label ) . '</strong>: ' . esc_html( classhall_home_lesson_schedule_label( $key ) ) . '</li>';
    }
    echo '</ul><p>Paid enrolments receive a confirmation and reminders 24 hours and 1 hour before each session. Manual renewal adds a calendar month after the latest paid expiry, or from payment if already expired. Parents receive renewal emails three days before expiry and after expiry. Invalid or refunded payment periods do not grant access.</p>';
    echo '<p>Keep the existing hourly hosting cron. Reminder times are scheduled at 24 hours and 1 hour before class, but hourly execution cannot guarantee those delivery times. Reminders more than one hour late or after class begins are skipped. Monitor jobs under WooCommerce &gt; Status &gt; Scheduled Actions (group: classhall-home-lessons).</p></div>';
    echo '<div class="wrap"><h2>Existing paid enrolments</h2><p>Apply this timetable to recent paid orders. Only enrolments still within one calendar month of payment receive a confirmation and future reminders.</p><form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '">';
    wp_nonce_field( 'classhall_home_lesson_sync' );
    echo '<input type="hidden" name="action" value="classhall_home_lesson_sync">';
    submit_button( 'Sync existing paid enrolments', 'secondary' );
    echo '</form></div>';
}

add_action( 'admin_post_classhall_home_lesson_sync', function () {
    if ( ! current_user_can( 'manage_woocommerce' ) ) {
        wp_die( 'Access denied.', '', array( 'response' => 403 ) );
    }
    check_admin_referer( 'classhall_home_lesson_sync' );
    classhall_home_lesson_queue( time(), 'classhall_home_lesson_sync_batch', array( 1, time() - 32 * DAY_IN_SECONDS ) );
    wp_safe_redirect( admin_url( 'admin.php?page=classhall-home-lessons&sync=queued' ) );
    exit;
} );

function classhall_home_lesson_sync_batch( $page, $since ) {
    $orders = wc_get_orders( array( 'status' => array( 'processing', 'completed' ), 'date_paid' => '>' . $since, 'orderby' => 'ID', 'order' => 'ASC', 'limit' => 25, 'page' => $page, 'paginate' => true ) );
    foreach ( $orders->orders as $order ) {
        classhall_home_lesson_enrol_paid_order( $order->get_id() );
    }
    if ( $page < $orders->max_num_pages ) {
        classhall_home_lesson_queue( time() + 30, 'classhall_home_lesson_sync_batch', array( $page + 1, $since ) );
    }
}
add_action( 'classhall_home_lesson_sync_batch', 'classhall_home_lesson_sync_batch', 10, 2 );

function classhall_home_lesson_queue( $timestamp, $hook, $args ) {
    return as_schedule_single_action( $timestamp, $hook, $args, 'classhall-home-lessons', true );
}

function classhall_home_lesson_reminder_due( $session, $lead, $now ) {
    return in_array( $lead, array( 86400, 3600 ), true )
        && $now >= $session - $lead && $now < $session
        && $now <= $session - $lead + 3600;
}

function classhall_home_lesson_active_item( $order, $item ) {
    return classhall_home_lesson_paid_item( $order, $item )
        && (int) $item->get_meta( '_chl_access_end', true ) > time();
}

function classhall_home_lesson_enrol_paid_order( $order_id ) {
    if ( ! function_exists( 'wc_get_order' ) || ! function_exists( 'as_schedule_single_action' ) ) {
        return;
    }
    $order = wc_get_order( $order_id );
    if ( ! $order || ! $order->is_paid() || ! $order->get_date_paid() ) {
        return;
    }
    foreach ( $order->get_items() as $item_id => $item ) {
        $class = $item->get_meta( '_classhall_home_lesson_class', true );
        if ( 'yes' !== $item->get_meta( '_classhall_home_lesson', true ) || ! classhall_home_lesson_schedule( $class ) ) {
            continue;
        }
        if ( ! $item->get_meta( '_chl_access_start', true ) ) {
            if ( ! classhall_home_lesson_initialise_period( $order, $item ) ) {
                continue;
            }
            $item = wc_get_order( $order_id )->get_item( $item_id );
        }
        if ( ! classhall_home_lesson_active_item( $order, $item ) ) {
            continue;
        }
        $end = (int) $item->get_meta( '_chl_access_end', true );
        classhall_home_lesson_schedule_expiry( $order, $item );
        foreach ( classhall_home_lesson_sessions( $class, (int) $item->get_meta( '_chl_access_start', true ), $end ) as $time => $subject ) {
            foreach ( array( 86400, 3600 ) as $lead ) {
                if ( $time - $lead > time() && ! $item->get_meta( '_chl_sent_' . $time . '_' . $lead, true ) ) {
                    classhall_home_lesson_queue( $time - $lead, 'classhall_home_lesson_email', array( (int) $order_id, (int) $item_id, $time, $lead ) );
                }
            }
        }
        if ( ! $item->get_meta( '_chl_sent_0_0', true ) ) {
            classhall_home_lesson_queue( time(), 'classhall_home_lesson_email', array( (int) $order_id, (int) $item_id, 0, 0 ) );
        }
    }
}
add_action( 'woocommerce_payment_complete', 'classhall_home_lesson_enrol_paid_order', 20 );
add_action( 'woocommerce_order_status_processing', 'classhall_home_lesson_enrol_paid_order', 20 );
add_action( 'woocommerce_order_status_completed', 'classhall_home_lesson_enrol_paid_order', 20 );

function classhall_home_lesson_join_url( $order, $item ) {
    return add_query_arg( array( 'chl_join' => $order->get_id(), 'chl_item' => $item->get_id(), 'chl_token' => $item->get_meta( '_chl_join_token', true ) ), home_url( '/' ) );
}

function classhall_home_lesson_join_redirect() {
    if ( ! isset( $_GET['chl_join'] ) ) {
        return;
    }
    nocache_headers();
    header( 'Referrer-Policy: no-referrer' );
    $order = function_exists( 'wc_get_order' ) ? wc_get_order( absint( $_GET['chl_join'] ) ) : false;
    $item = $order ? $order->get_item( absint( $_GET['chl_item'] ?? 0 ) ) : false;
    $token = isset( $_GET['chl_token'] ) && is_string( $_GET['chl_token'] ) ? wp_unslash( $_GET['chl_token'] ) : '';
    if ( ! $item || ! $token || ! hash_equals( (string) $item->get_meta( '_chl_join_token', true ), $token ) ) {
        wp_die( 'This online classes enrolment link is invalid or has expired. Please contact Classhall for help.', 'Online Classes', array( 'response' => 403 ) );
    }
    $active = false;
    foreach ( classhall_home_lesson_periods( $order, $item ) as $period ) {
        $active = $active || ( $period['start'] <= time() && $period['end'] > time() );
    }
    if ( ! $active ) {
        wp_die( 'This online classes enrolment has expired or has not started yet. Renew from My Account or your enrolment email.', 'Online Classes', array( 'response' => 403 ) );
    }
    // Only the validated Google Meet host is allowed as the external destination.
    $url = classhall_home_lesson_meet_url();
    if ( 'meet.google.com' !== wp_parse_url( $url, PHP_URL_HOST ) || 'https' !== wp_parse_url( $url, PHP_URL_SCHEME ) ) {
        wp_die( 'The meeting link is unavailable. Please contact Classhall.' );
    }
    wp_redirect( $url );
    exit;
}
add_action( 'template_redirect', 'classhall_home_lesson_join_redirect', 0 );

function classhall_home_lesson_send_scheduled_email( $order_id, $item_id, $session, $lead, $attempt = 0 ) {
    $order = wc_get_order( $order_id );
    $item = $order ? $order->get_item( $item_id ) : false;
    if ( ! classhall_home_lesson_active_item( $order, $item ) ) {
        return;
    }
    $class = $item->get_meta( '_classhall_home_lesson_class', true );
    $sessions = classhall_home_lesson_sessions( $class, (int) $item->get_meta( '_chl_access_start', true ), (int) $item->get_meta( '_chl_access_end', true ) );
    // Do not send stale reminders after an outage or after the lesson has started.
    if ( $session && ( ! isset( $sessions[ $session ] ) || ! classhall_home_lesson_reminder_due( $session, $lead, time() ) ) ) {
        return;
    }
    $sent_key = '_chl_sent_' . $session . '_' . $lead;
    if ( $item->get_meta( $sent_key, true ) ) {
        return;
    }
    $lock = 'chl_mail_' . md5( $order_id . ':' . $item_id . ':' . $session . ':' . $lead );
    if ( ! add_option( $lock, time(), '', false ) ) {
        if ( (int) get_option( $lock ) < time() - 600 ) {
            delete_option( $lock );
        }
        if ( $attempt < 10 ) {
            classhall_home_lesson_queue( time() + 60, 'classhall_home_lesson_email', array( $order_id, $item_id, $session, $lead, $attempt + 1 ) );
        }
        return;
    }
    try {
        // Re-read after acquiring the lock in case another worker just sent it.
        $order = wc_get_order( $order_id );
        $item = $order ? $order->get_item( $item_id ) : false;
        if ( ! classhall_home_lesson_active_item( $order, $item ) || $item->get_meta( $sent_key, true ) ) {
            return;
        }
        $classes = classhall_home_lesson_classes();
        $class_label = $classes[ $class ] ?? $class;
        $title = $session ? 'Your online class reminder' : ( $item->get_meta( '_chl_root_item', true ) ? 'Your online classes renewal is confirmed' : 'Your online classes enrolment is confirmed' );
        $join_url = classhall_home_lesson_join_url( $order, $item );
        ob_start();
        include __DIR__ . '/../template-parts/emails/home-lesson.php';
        $body = ob_get_clean();
        if ( wp_mail( $order->get_billing_email(), $title . ' - ' . $class_label, $body, array( 'Content-Type: text/html; charset=UTF-8' ) ) ) {
            $item->update_meta_data( $sent_key, time() );
            $item->save();
        } elseif ( $attempt < 3 ) {
            classhall_home_lesson_queue( time() + 60, 'classhall_home_lesson_email', array( $order_id, $item_id, $session, $lead, $attempt + 1 ) );
        } else {
            $order->add_order_note( 'Online class email could not be sent for item ' . $item_id . '. Check the email service.' );
        }
    } finally {
        delete_option( $lock );
    }
}
add_action( 'classhall_home_lesson_email', 'classhall_home_lesson_send_scheduled_email', 10, 5 );
