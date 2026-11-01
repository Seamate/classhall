<?php
/** Isolated eligibility checks; no WordPress boot or ad requests. */
if ( PHP_SAPI !== 'cli' ) { exit; }
function is_admin() { return $GLOBALS['admin']; }
function is_front_page() { return $GLOBALS['front_page']; }
function is_page_template( $template ) { return $GLOBALS['home_template'] && 'template-classhall-home.php' === $template; }
function wp_get_current_user() { return (object) array( 'roles' => $GLOBALS['roles'] ); }
function classhall_is_home_lessons_route() { return 'online-route' === $GLOBALS['context']; }
function is_page( $slugs ) { return in_array( $GLOBALS['context'], $slugs, true ); }
function is_wc_endpoint_url( $endpoint ) {
    return ( 'home-lessons' === $endpoint && 'online-account' === $GLOBALS['context'] )
        || ( in_array( $endpoint, array( 'order-pay', 'order-received' ), true ) && $endpoint === $GLOBALS['context'] );
}
function is_shop() { return 'shop' === $GLOBALS['context']; }
function is_cart() { return 'cart' === $GLOBALS['context']; }
function is_checkout() { return 'checkout' === $GLOBALS['context']; }

$source = file_get_contents( __DIR__ . '/../themes/kleo-child/functions.php' );
$start = strpos( $source, 'function classhall_can_show_adsense_ads(' );
$end = strpos( $source, 'function classhall_enqueue_adsense_script(' );
if ( false === $start || false === $end ) { throw new RuntimeException( 'Eligibility function not found.' ); }
eval( substr( $source, $start, $end - $start ) );
$start = strpos( $source, 'function classhall_is_frontend_homepage(' );
$end = strpos( $source, 'function classhall_async_homepage_stylesheets(' );
if ( false === $start || false === $end ) { throw new RuntimeException( 'Homepage function not found.' ); }
eval( substr( $source, $start, $end - $start ) );

$cases = array(
    array( array(), true ),
    array( array( 'subscriber' ), true ),
    array( array( 'teacher' ), true ),
    array( array( 'student' ), true ),
    array( array( 'administrator' ), true ),
    array( array( 'customer' ), false ),
    array( array( 'teacher', 'customer' ), false ),
    array( array( 'administrator', 'customer' ), false ),
);
foreach ( array( 'other-page', 'live-classes', 'product', 'online-route', 'online-classes', 'home-lessons', 'online-account', 'shop', 'cart', 'checkout', 'order-pay', 'order-received' ) as $context ) {
foreach ( array( false, true ) as $admin ) {
    foreach ( array( array( false, false ), array( true, false ), array( false, true ), array( true, true ) ) as list( $front_page, $home_template ) ) {
        foreach ( $cases as list( $roles, $eligible ) ) {
            $expected = ! $admin && ! $front_page && ! $home_template && $eligible
                && in_array( $context, array( 'other-page', 'live-classes', 'product' ), true );
            if ( classhall_can_show_adsense_ads() !== $expected ) {
                throw new RuntimeException( 'Unexpected eligibility: ' . json_encode( array( $context, $admin, $front_page, $home_template, $roles ) ) );
            }
        }
    }
}
}
echo "PASS: Homepage, Online Classes, shop, cart, checkout, payment/confirmation pages and customers are excluded.\n";
