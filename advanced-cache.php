<?php
/**
 * Classhall homepage cache drop-in.
 *
 * This file is loaded by WordPress before normal bootstrapping only when
 * WP_CACHE is enabled in wp-config.php. It serves the public homepage cache
 * for logged-out GET/HEAD requests and leaves every other request alone.
 */

if ( defined( 'ABSPATH' ) && ! defined( 'WP_CACHE' ) ) {
    return;
}

$classhall_request_method = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( $_SERVER['REQUEST_METHOD'] ) : '';

if ( ! in_array( $classhall_request_method, array( 'GET', 'HEAD' ), true ) ) {
    return;
}

if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
    return;
}

$classhall_request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '/';
$classhall_path        = parse_url( $classhall_request_uri, PHP_URL_PATH );

if ( '/' !== $classhall_path ) {
    return;
}

$classhall_cookie_header = isset( $_SERVER['HTTP_COOKIE'] ) ? $_SERVER['HTTP_COOKIE'] : '';

if (
    false !== stripos( $classhall_cookie_header, 'wordpress_logged_in_' )
    || false !== stripos( $classhall_cookie_header, 'wordpress_sec_' )
    || false !== stripos( $classhall_cookie_header, 'wp-postpass_' )
    || false !== stripos( $classhall_cookie_header, 'comment_author_' )
    || false !== stripos( $classhall_cookie_header, 'woocommerce_items_in_cart' )
    || false !== stripos( $classhall_cookie_header, 'wp_woocommerce_session_' )
) {
    return;
}

$classhall_cache_file = __DIR__ . '/cache/classhall-homepage-cache/index.html';
$classhall_ttl        = 1800;

if ( ! is_readable( $classhall_cache_file ) || filemtime( $classhall_cache_file ) < ( time() - $classhall_ttl ) ) {
    return;
}

header( 'Content-Type: text/html; charset=UTF-8' );
header( 'Cache-Control: public, max-age=300, stale-while-revalidate=1800' );
header( 'X-Classhall-Cache: HIT' );

if ( 'HEAD' !== $classhall_request_method ) {
    readfile( $classhall_cache_file );
}

exit;
