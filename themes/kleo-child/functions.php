<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

/**
 * Kleo Child Theme Functions
 */

add_filter( 'big_image_size_threshold', '__return_false' );

function classhall_hide_page_title_breadcrumbs( $args ) {
    $args['show_breadcrumb'] = false;

    return $args;
}
add_filter( 'kleo_title_args', 'classhall_hide_page_title_breadcrumbs', 20 );

function classhall_update_sensei_login_access_text( $translated_text, $text, $domain ) {
    if ( false !== strpos( $translated_text, 'purchased courses' ) ) {
        $translated_text = str_replace( 'purchased courses', 'subjects', $translated_text );
    }

    return $translated_text;
}
add_filter( 'gettext', 'classhall_update_sensei_login_access_text', 20, 3 );

function classhall_is_mathjax_context() {
    $is_learning_content = function_exists( 'is_singular' )
        && is_singular( array( 'lesson', 'question', 'dwqa-question' ) );
    $is_learning_archive = function_exists( 'is_post_type_archive' )
        && is_post_type_archive( array( 'lesson', 'question', 'dwqa-question' ) );
    $is_homepage_preview = (
        function_exists( 'is_front_page' )
        && is_front_page()
    ) || (
        function_exists( 'is_page_template' )
        && is_page_template( 'template-classhall-home.php' )
    );

    return $is_learning_content || $is_learning_archive || $is_homepage_preview;
}

function classhall_enqueue_child_assets() {
    global $wp_styles;

    $source_style_path = get_stylesheet_directory() . '/style.css';
    $source_style_uri  = get_stylesheet_uri();
    $source_style_url  = wp_parse_url( $source_style_uri, PHP_URL_PATH );
    $min_style_path    = get_stylesheet_directory() . '/style.min.css';
    $min_style_uri     = get_stylesheet_directory_uri() . '/style.min.css';
    $use_min_style     = file_exists( $min_style_path )
        && file_exists( $source_style_path )
        && filemtime( $min_style_path ) >= filemtime( $source_style_path );
    $style_path        = $use_min_style ? $min_style_path : $source_style_path;
    $stylesheet_uri    = $use_min_style ? $min_style_uri : $source_style_uri;
    $version           = file_exists( $style_path ) ? filemtime( $style_path ) : wp_get_theme()->get( 'Version' );
    $style_queued      = false;

    if ( $wp_styles instanceof WP_Styles ) {
        foreach ( $wp_styles->queue as $handle ) {
            if ( empty( $wp_styles->registered[ $handle ]->src ) ) {
                continue;
            }

            $queued_url = wp_parse_url( $wp_styles->registered[ $handle ]->src, PHP_URL_PATH );

            if ( $queued_url && $source_style_url && false !== strpos( $queued_url, $source_style_url ) ) {
                $wp_styles->registered[ $handle ]->src = $stylesheet_uri;
                $wp_styles->registered[ $handle ]->ver = $version;
                $style_queued = true;
                break;
            }
        }
    }

    if ( ! $style_queued ) {
        wp_enqueue_style(
            'classhall-child-style',
            $stylesheet_uri,
            array(),
            $version
        );
    }

    if ( classhall_is_mathjax_context() ) {
        wp_enqueue_script(
            'classhall-mathjax',
            'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js',
            array(),
            '3',
            true
        );
        wp_add_inline_script(
            'classhall-mathjax',
            'window.MathJax = window.MathJax || {}; window.MathJax.tex = window.MathJax.tex || {}; window.MathJax.tex.inlineMath = [["\\\\(","\\\\)"], ["$","$"]];',
            'before'
        );
    }
}
add_action( 'wp_enqueue_scripts', 'classhall_enqueue_child_assets', 99 );

function classhall_async_script_tags( $tag, $handle, $src ) {
    if ( 'classhall-mathjax' === $handle ) {
        return '<script async src="' . esc_url( $src ) . '"></script>' . "\n";
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'classhall_async_script_tags', 10, 3 );

function classhall_logout_url() {
    return wp_logout_url( home_url( '/' ) );
}

function classhall_password_reset_url() {
    if ( function_exists( 'um_get_core_page' ) ) {
        $um_password_reset_url = um_get_core_page( 'password-reset' );

        if ( ! empty( $um_password_reset_url ) ) {
            return $um_password_reset_url;
        }
    }

    return home_url( '/password-reset/' );
}

function classhall_use_ultimate_member_password_reset_url( $lostpassword_url = '', $redirect = '' ) {
    $password_reset_url = classhall_password_reset_url();

    if ( ! empty( $redirect ) ) {
        $password_reset_url = add_query_arg( 'redirect_to', $redirect, $password_reset_url );
    }

    return $password_reset_url;
}
add_filter( 'lostpassword_url', 'classhall_use_ultimate_member_password_reset_url', 999, 2 );
add_filter( 'woocommerce_lostpassword_url', 'classhall_use_ultimate_member_password_reset_url', 999, 2 );

function classhall_redirect_default_password_reset_to_um() {
    if ( is_admin() || empty( $_GET['action'] ) ) {
        return;
    }

    $action = sanitize_key( wp_unslash( $_GET['action'] ) );

    if ( ! in_array( $action, array( 'lostpassword', 'retrievepassword' ), true ) ) {
        return;
    }

    wp_safe_redirect( classhall_password_reset_url() );
    exit;
}
add_action( 'login_init', 'classhall_redirect_default_password_reset_to_um', 1 );

function classhall_disable_woocommerce_product_images() {
    remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'kleo_woo_thumb_image', 10 );
    remove_action( 'woocommerce_before_shop_loop_item_title', 'kleo_woo_first_image', 11 );
}
add_action( 'wp', 'classhall_disable_woocommerce_product_images', 20 );

function classhall_empty_woocommerce_cart_thumbnail( $thumbnail = '' ) {
    return '';
}
add_filter( 'woocommerce_cart_item_thumbnail', 'classhall_empty_woocommerce_cart_thumbnail', 20 );

function classhall_hide_cart_dropdown_quantity( $product_quantity = '' ) {
    return '';
}
add_filter( 'woocommerce_cart_item_quantity', 'classhall_hide_cart_dropdown_quantity', 20 );

function classhall_get_summer_classes_product_id() {
    $product = get_page_by_path( 'summer-classes', OBJECT, 'product' );

    if ( ! $product instanceof WP_Post ) {
        return 0;
    }

    return absint( $product->ID );
}

function classhall_get_summer_classes_checkout_url() {
    $product_id = classhall_get_summer_classes_product_id();

    if ( ! $product_id ) {
        return home_url( '/product/summer-classes/' );
    }

    return add_query_arg(
        array(
            'add-to-cart'               => $product_id,
            'classhall_summer_checkout' => '1',
        ),
        home_url( '/' )
    );
}

function classhall_redirect_summer_classes_add_to_cart( $url ) {
    if ( empty( $_GET['classhall_summer_checkout'] ) ) {
        return $url;
    }

    return function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/checkout/' );
}
add_filter( 'woocommerce_add_to_cart_redirect', 'classhall_redirect_summer_classes_add_to_cart', 99 );

function classhall_force_summer_classes_checkout_after_add() {
    if ( empty( $_GET['classhall_summer_checkout'] ) || ! function_exists( 'WC' ) ) {
        return;
    }

    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        return;
    }

    if ( function_exists( 'wc_load_cart' ) && ( ! WC()->cart || ! WC()->session ) ) {
        wc_load_cart();
    }

    $product_id = classhall_get_summer_classes_product_id();

    if ( ! $product_id || ! WC()->cart ) {
        return;
    }

    if ( ! classhall_cart_contains_product( $product_id ) ) {
        WC()->cart->add_to_cart( $product_id, 1 );
    }

    if ( classhall_cart_contains_product( $product_id ) ) {
        WC()->cart->calculate_totals();

        if ( method_exists( WC()->cart, 'set_session' ) ) {
            WC()->cart->set_session();
        }

        wp_safe_redirect( function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : home_url( '/checkout/' ) );
        exit;
    }
}
add_action( 'wp_loaded', 'classhall_force_summer_classes_checkout_after_add', 30 );

function classhall_add_logout_to_auth_menu( $items, $args ) {
    if ( ! is_user_logged_in() ) {
        return $items;
    }

    if ( false === strpos( $items, 'registertop' ) && false === strpos( $items, 'logintop' ) ) {
        return $items;
    }

    if ( false !== strpos( $items, 'classhall-auth-logout' ) ) {
        return $items;
    }

    $items .= sprintf(
        '<li class="menu-item classhall-auth-logout"><a href="%s">%s</a></li>',
        esc_url( classhall_logout_url() ),
        esc_html__( 'Logout', 'kleo-child' )
    );

    return $items;
}
add_filter( 'wp_nav_menu_items', 'classhall_add_logout_to_auth_menu', 250, 2 );

function classhall_class_bundle_pages() {
    return array(
        'jss1-subscription-plans' => 'JSS1',
        'jss2-subscription-plans' => 'JSS2',
        'jss3-subscription-plans' => 'JSS3',
        'ss1-subscription-plans'  => 'SS1',
        'ss2-subscription-plans'  => 'SS2',
        'ss3-subscription-plans'  => 'SS3',
    );
}

function classhall_get_current_bundle_page_config() {
    if ( ! function_exists( 'is_page' ) || ! is_page() ) {
        return null;
    }

    $page_id = get_queried_object_id();

    if ( ! $page_id ) {
        return null;
    }

    $slug  = get_post_field( 'post_name', $page_id );
    $pages = classhall_class_bundle_pages();

    if ( empty( $pages[ $slug ] ) ) {
        return null;
    }

    $class_label = $pages[ $slug ];
    $class_slug  = strtolower( $class_label );

    return array(
        'class_label' => $class_label,
        'class_slug'  => $class_slug,
        'plans'       => array(
            array(
                'name'        => '1 Month Plan',
                'duration'    => $class_label . ' All Subjects Bundle for 1 month',
                'description' => 'Get access to all subjects in this class bundle for 1 month.',
                'key'         => $class_slug . '-one-month-bundle',
                'url'         => home_url( '/' . $class_slug . '-one-month-bundle/' ),
            ),
            array(
                'name'        => '1 Term Plan',
                'duration'    => $class_label . ' All Subjects Bundle for 4 months',
                'description' => 'Get access to all subjects in this class bundle for one full term.',
                'key'         => $class_slug . '-one-term-bundle',
                'url'         => home_url( '/' . $class_slug . '-one-term-bundle/' ),
            ),
            array(
                'name'        => '1 Year Plan',
                'duration'    => $class_label . ' All Subjects Bundle for 12 months',
                'description' => 'Get access to all subjects in this class bundle for a full year.',
                'key'         => $class_slug . '-one-year-bundle',
                'url'         => home_url( '/' . $class_slug . '-one-year-bundle/' ),
            ),
        ),
    );
}

function classhall_get_bundle_plan_by_key( $plan_key ) {
    $plan_key = sanitize_key( $plan_key );

    foreach ( classhall_class_bundle_pages() as $page_slug => $class_label ) {
        $class_slug = strtolower( $class_label );

        $plans = array(
            $class_slug . '-one-month-bundle' => home_url( '/' . $class_slug . '-one-month-bundle/' ),
            $class_slug . '-one-term-bundle'  => home_url( '/' . $class_slug . '-one-term-bundle/' ),
            $class_slug . '-one-year-bundle'  => home_url( '/' . $class_slug . '-one-year-bundle/' ),
        );

        if ( empty( $plans[ $plan_key ] ) ) {
            continue;
        }

        return array(
            'key'         => $plan_key,
            'url'         => $plans[ $plan_key ],
            'class_label' => $class_label,
            'page_slug'   => $page_slug,
        );
    }

    return null;
}

function classhall_get_bundle_plan_add_url( $plan_key ) {
    $plan = classhall_get_bundle_plan_by_key( $plan_key );

    if ( ! $plan ) {
        return '';
    }

    return add_query_arg(
        array(
            'classhall_add_bundle_plan' => $plan['key'],
            'classhall_bundle_token'    => classhall_get_bundle_plan_token( $plan['key'] ),
        ),
        home_url( '/' )
    );
}

function classhall_get_bundle_plan_prepare_login_url( $plan_key ) {
    $plan = classhall_get_bundle_plan_by_key( $plan_key );

    if ( ! $plan ) {
        return '';
    }

    return add_query_arg(
        array(
            'classhall_prepare_bundle_login' => $plan['key'],
            'classhall_bundle_token'         => classhall_get_bundle_plan_token( $plan['key'] ),
        ),
        home_url( '/' )
    );
}

function classhall_get_bundle_plan_token( $plan_key ) {
    return wp_hash( 'classhall_add_bundle_plan|' . sanitize_key( $plan_key ) );
}

function classhall_is_valid_bundle_plan_token( $plan_key, $token ) {
    $expected = classhall_get_bundle_plan_token( $plan_key );
    $token    = is_string( $token ) ? $token : '';

    if ( function_exists( 'hash_equals' ) ) {
        return hash_equals( $expected, $token );
    }

    return $expected === $token;
}

function classhall_get_bundle_plan_page_url( $plan_key ) {
    $plan = classhall_get_bundle_plan_by_key( $plan_key );

    if ( ! $plan || empty( $plan['page_slug'] ) ) {
        return home_url( '/' );
    }

    return home_url( '/' . trim( $plan['page_slug'], '/' ) . '/' );
}

function classhall_get_bundle_plan_resume_url( $plan_key ) {
    $plan_key = sanitize_key( $plan_key );

    return add_query_arg(
        array(
            'classhall_resume_bundle_plan'  => $plan_key,
            'classhall_bundle_resume_token' => classhall_get_bundle_plan_token( $plan_key ),
        ),
        classhall_get_bundle_plan_page_url( $plan_key )
    );
}

function classhall_set_pending_bundle_plan_cookie( $plan_key ) {
    $plan_key = sanitize_key( $plan_key );
    $value    = $plan_key . '|' . classhall_get_bundle_plan_token( $plan_key );

    setcookie(
        'classhall_pending_bundle_plan',
        $value,
        time() + 30 * MINUTE_IN_SECONDS,
        COOKIEPATH ? COOKIEPATH : '/',
        COOKIE_DOMAIN,
        is_ssl(),
        true
    );

    $_COOKIE['classhall_pending_bundle_plan'] = $value;
}

function classhall_clear_pending_bundle_plan_cookie() {
    setcookie(
        'classhall_pending_bundle_plan',
        '',
        time() - HOUR_IN_SECONDS,
        COOKIEPATH ? COOKIEPATH : '/',
        COOKIE_DOMAIN,
        is_ssl(),
        true
    );

    unset( $_COOKIE['classhall_pending_bundle_plan'] );
}

function classhall_get_pending_bundle_plan_from_cookie() {
    if ( empty( $_COOKIE['classhall_pending_bundle_plan'] ) ) {
        return '';
    }

    $cookie = sanitize_text_field( wp_unslash( $_COOKIE['classhall_pending_bundle_plan'] ) );
    $parts  = explode( '|', $cookie, 2 );

    if ( 2 !== count( $parts ) ) {
        return '';
    }

    $plan_key = sanitize_key( $parts[0] );
    $token    = $parts[1];

    if ( ! classhall_get_bundle_plan_by_key( $plan_key ) || ! classhall_is_valid_bundle_plan_token( $plan_key, $token ) ) {
        return '';
    }

    return $plan_key;
}

function classhall_pending_bundle_login_redirect_url( $redirect_to = '' ) {
    $plan_key = classhall_get_pending_bundle_plan_from_cookie();

    if ( ! $plan_key ) {
        return $redirect_to;
    }

    return classhall_get_bundle_plan_resume_url( $plan_key );
}
add_filter( 'login_redirect', 'classhall_pending_bundle_login_redirect_url', 20 );
add_filter( 'woocommerce_login_redirect', 'classhall_pending_bundle_login_redirect_url', 20 );
add_filter( 'um_login_redirect_url', 'classhall_pending_bundle_login_redirect_url', 20 );

function classhall_collect_product_ids_from_text( $text ) {
    if ( ! is_string( $text ) || '' === $text ) {
        return array();
    }

    $ids      = array();
    $patterns = array(
        '/[?&]add-to-cart=(\d+)/i',
        '/data-product_id=["\'](\d+)["\']/i',
        '/data-product-id=["\'](\d+)["\']/i',
        '/name=["\']add-to-cart["\'][^>]*value=["\'](\d+)["\']/i',
        '/value=["\'](\d+)["\'][^>]*name=["\']add-to-cart["\']/i',
        '/"product_id"\s*:\s*"?(\d+)"?/i',
    );

    foreach ( $patterns as $pattern ) {
        if ( preg_match_all( $pattern, $text, $matches ) ) {
            $ids = array_merge( $ids, array_map( 'absint', $matches[1] ) );
        }
    }

    if ( preg_match_all( '/product_ids\s*=\s*(["\']|\\\\")([^"\']+?)\1/i', $text, $matches ) ) {
        foreach ( $matches[2] as $product_ids ) {
            $ids = array_merge( $ids, array_map( 'absint', preg_split( '/[\s,]+/', $product_ids ) ) );
        }
    }

    if ( preg_match_all( '/product_ids["\']?\s*:\s*(["\'])([^"\']+?)\1/i', $text, $matches ) ) {
        foreach ( $matches[2] as $product_ids ) {
            $ids = array_merge( $ids, array_map( 'absint', preg_split( '/[\s,]+/', $product_ids ) ) );
        }
    }

    $ids = array_values( array_unique( array_filter( $ids ) ) );

    return $ids;
}

function classhall_get_bundle_plan_post( $plan ) {
    $path = trim( wp_parse_url( $plan['url'], PHP_URL_PATH ), '/' );

    if ( ! $path ) {
        return null;
    }

    $post = get_page_by_path( $path, OBJECT, array( 'product', 'page' ) );

    return $post instanceof WP_Post ? $post : null;
}

function classhall_get_bundled_item_id( $bundled_item, $fallback_id ) {
    foreach ( array( 'get_id', 'get_bundled_item_id' ) as $method ) {
        if ( is_object( $bundled_item ) && method_exists( $bundled_item, $method ) ) {
            $id = absint( $bundled_item->$method() );

            if ( $id ) {
                return $id;
            }
        }
    }

    return absint( $fallback_id );
}

function classhall_get_bundled_item_product_id( $bundled_item ) {
    if ( is_object( $bundled_item ) && method_exists( $bundled_item, 'get_product_id' ) ) {
        return absint( $bundled_item->get_product_id() );
    }

    if ( is_object( $bundled_item ) && method_exists( $bundled_item, 'get_product' ) ) {
        $product = $bundled_item->get_product();

        if ( $product && method_exists( $product, 'get_id' ) ) {
            return absint( $product->get_id() );
        }
    }

    return 0;
}

function classhall_get_bundled_item_quantity( $bundled_item ) {
    if ( is_object( $bundled_item ) && method_exists( $bundled_item, 'get_quantity' ) ) {
        foreach ( array( 'min', 'default' ) as $context ) {
            $quantity = absint( $bundled_item->get_quantity( $context ) );

            if ( $quantity > 0 ) {
                return $quantity;
            }
        }

        $quantity = absint( $bundled_item->get_quantity() );

        if ( $quantity > 0 ) {
            return $quantity;
        }
    }

    return 1;
}

function classhall_get_bundle_configuration( $bundle_product ) {
    if ( ! is_object( $bundle_product ) || ! method_exists( $bundle_product, 'get_bundled_items' ) ) {
        return array();
    }

    $configuration = array();
    $bundled_items = $bundle_product->get_bundled_items();

    foreach ( $bundled_items as $fallback_id => $bundled_item ) {
        $bundled_item_id = classhall_get_bundled_item_id( $bundled_item, $fallback_id );
        $product_id      = classhall_get_bundled_item_product_id( $bundled_item );

        if ( ! $bundled_item_id || ! $product_id ) {
            continue;
        }

        $configuration[ $bundled_item_id ] = array(
            'product_id'         => $product_id,
            'quantity'           => classhall_get_bundled_item_quantity( $bundled_item ),
            'optional_selected'  => 'yes',
            'optional_selected?' => 'yes',
        );
    }

    return $configuration;
}

function classhall_add_bundle_product_to_cart( $bundle_product_id ) {
    if ( ! function_exists( 'wc_get_product' ) || ! function_exists( 'WC' ) || ! WC()->cart ) {
        return false;
    }

    $bundle_product = wc_get_product( $bundle_product_id );

    if ( ! $bundle_product ) {
        return false;
    }

    $configuration = classhall_get_bundle_configuration( $bundle_product );

    if (
        $configuration
        && function_exists( 'WC_PB' )
        && WC_PB()
        && isset( WC_PB()->cart )
        && method_exists( WC_PB()->cart, 'add_bundle_to_cart' )
    ) {
        return (bool) WC_PB()->cart->add_bundle_to_cart( $bundle_product_id, 1, $configuration );
    }

    return (bool) WC()->cart->add_to_cart( $bundle_product_id, 1 );
}

function classhall_get_bundle_plan_product_ids( $plan ) {
    $ids  = array();
    $post = classhall_get_bundle_plan_post( $plan );

    if ( $post instanceof WP_Post ) {
        $ids = array_merge( $ids, classhall_collect_product_ids_from_text( $post->post_content ) );

        $elementor_data = get_post_meta( $post->ID, '_elementor_data', true );
        $ids            = array_merge( $ids, classhall_collect_product_ids_from_text( $elementor_data ) );
    }

    $response = wp_remote_get(
        $plan['url'],
        array(
            'timeout'     => 8,
            'redirection' => 3,
        )
    );

    if ( ! is_wp_error( $response ) ) {
        $ids = array_merge( $ids, classhall_collect_product_ids_from_text( wp_remote_retrieve_body( $response ) ) );
    }

    $ids = array_values( array_unique( array_filter( array_map( 'absint', $ids ) ) ) );

    if ( ! function_exists( 'wc_get_product' ) ) {
        return $ids;
    }

    return array_values(
        array_filter(
            $ids,
            function ( $product_id ) {
                $product = wc_get_product( $product_id );

                return $product && $product->is_purchasable();
            }
        )
    );
}

function classhall_cart_contains_product( $product_id ) {
    if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
        return false;
    }

    foreach ( WC()->cart->get_cart() as $cart_item ) {
        if ( absint( $cart_item['product_id'] ) === absint( $product_id ) ) {
            return true;
        }
    }

    return false;
}

function classhall_prepare_bundle_login_redirect() {
    if ( empty( $_GET['classhall_prepare_bundle_login'] ) ) {
        return;
    }

    $plan_key = sanitize_key( wp_unslash( $_GET['classhall_prepare_bundle_login'] ) );
    $plan     = classhall_get_bundle_plan_by_key( $plan_key );

    if ( ! $plan ) {
        wp_safe_redirect( home_url( '/' ) );
        exit;
    }

    $token_valid = ! empty( $_GET['classhall_bundle_token'] )
        && classhall_is_valid_bundle_plan_token( $plan_key, sanitize_text_field( wp_unslash( $_GET['classhall_bundle_token'] ) ) );

    if ( ! $token_valid ) {
        wp_safe_redirect( classhall_get_bundle_plan_page_url( $plan_key ) );
        exit;
    }

    classhall_set_pending_bundle_plan_cookie( $plan_key );

    if ( is_user_logged_in() ) {
        wp_safe_redirect( classhall_get_bundle_plan_resume_url( $plan_key ) );
        exit;
    }

    if ( function_exists( 'wc_add_notice' ) ) {
        wc_add_notice( __( 'Please sign in or create an account before adding a full bundle to your cart.', 'kleo-child' ), 'notice' );
    }

    wp_safe_redirect(
        add_query_arg(
            'redirect_to',
            classhall_get_bundle_plan_resume_url( $plan_key ),
            home_url( '/classhall-user-login-protected/' )
        )
    );
    exit;
}
add_action( 'template_redirect', 'classhall_prepare_bundle_login_redirect', 1 );

function classhall_handle_bundle_plan_add_to_cart() {
    if ( empty( $_GET['classhall_add_bundle_plan'] ) ) {
        return;
    }

    $plan_key = sanitize_key( wp_unslash( $_GET['classhall_add_bundle_plan'] ) );
    $plan     = classhall_get_bundle_plan_by_key( $plan_key );

    if ( ! $plan ) {
        wp_safe_redirect( home_url( '/' ) );
        exit;
    }

    $nonce_valid = ! empty( $_GET['_wpnonce'] )
        && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'classhall_add_bundle_plan_' . $plan_key );
    $token_valid = ! empty( $_GET['classhall_bundle_token'] )
        && classhall_is_valid_bundle_plan_token( $plan_key, sanitize_text_field( wp_unslash( $_GET['classhall_bundle_token'] ) ) );

    if ( ! $nonce_valid && ! $token_valid ) {
        wp_safe_redirect( $plan['url'] );
        exit;
    }

    if ( ! is_user_logged_in() ) {
        classhall_set_pending_bundle_plan_cookie( $plan_key );

        if ( function_exists( 'wc_add_notice' ) ) {
            wc_add_notice( __( 'Please sign in or create an account before adding a full bundle to your cart.', 'kleo-child' ), 'notice' );
        }

        wp_safe_redirect(
            add_query_arg(
                'redirect_to',
                classhall_get_bundle_plan_resume_url( $plan_key ),
                home_url( '/classhall-user-login-protected/' )
            )
        );
        exit;
    }

    if ( ! function_exists( 'WC' ) || ! function_exists( 'wc_load_cart' ) ) {
        wp_safe_redirect( $plan['url'] );
        exit;
    }

    classhall_clear_pending_bundle_plan_cookie();

    wc_load_cart();

    if ( ! WC()->cart ) {
        wp_safe_redirect( $plan['url'] );
        exit;
    }

    $plan_post = classhall_get_bundle_plan_post( $plan );

    if ( $plan_post instanceof WP_Post && 'product' === $plan_post->post_type ) {
        if ( classhall_add_bundle_product_to_cart( absint( $plan_post->ID ) ) ) {
            wc_add_notice( __( 'The bundle has been added to your cart.', 'kleo-child' ), 'success' );
            wp_safe_redirect( wc_get_cart_url() );
            exit;
        }
    }

    $product_ids = classhall_get_bundle_plan_product_ids( $plan );

    if ( empty( $product_ids ) ) {
        wc_add_notice( __( 'We could not add this bundle automatically. Please select the subjects on the plan page.', 'kleo-child' ), 'notice' );
        wp_safe_redirect( $plan['url'] );
        exit;
    }

    $added_count = 0;

    foreach ( $product_ids as $product_id ) {
        if ( classhall_cart_contains_product( $product_id ) ) {
            $added_count++;
            continue;
        }

        if ( WC()->cart->add_to_cart( $product_id, 1 ) ) {
            $added_count++;
        }
    }

    if ( $added_count ) {
        wc_add_notice( sprintf( _n( '%d subject has been added to your cart.', '%d subjects have been added to your cart.', $added_count, 'kleo-child' ), $added_count ), 'success' );
        wp_safe_redirect( wc_get_cart_url() );
        exit;
    }

    wp_safe_redirect( $plan['url'] );
    exit;
}
add_action( 'template_redirect', 'classhall_handle_bundle_plan_add_to_cart', 1 );

function classhall_resume_pending_bundle_after_login() {
    if ( is_admin() || ! is_user_logged_in() || ! empty( $_GET['classhall_add_bundle_plan'] ) || ! empty( $_GET['classhall_resume_bundle_plan'] ) ) {
        return;
    }

    $plan_key = classhall_get_pending_bundle_plan_from_cookie();

    if ( ! $plan_key ) {
        return;
    }

    wp_safe_redirect( classhall_get_bundle_plan_resume_url( $plan_key ) );
    exit;
}
add_action( 'template_redirect', 'classhall_resume_pending_bundle_after_login', 2 );

function classhall_use_bundle_page_template( $template ) {
    if ( ! classhall_get_current_bundle_page_config() ) {
        return $template;
    }

    $bundle_template = get_stylesheet_directory() . '/template-parts/classhall-class-bundle-page.php';

    if ( file_exists( $bundle_template ) ) {
        return $bundle_template;
    }

    return $template;
}
add_filter( 'template_include', 'classhall_use_bundle_page_template', 99 );

function classhall_is_summer_classes_request() {
    if ( is_admin() || empty( $_SERVER['REQUEST_URI'] ) ) {
        return false;
    }

    $path = wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH );

    return 'summer-classes' === trim( (string) $path, '/' );
}

function classhall_use_summer_classes_template( $template ) {
    if ( ! classhall_is_summer_classes_request() ) {
        return $template;
    }

    $summer_template = get_stylesheet_directory() . '/template-classhall-summer-classes.php';

    if ( file_exists( $summer_template ) ) {
        return $summer_template;
    }

    return $template;
}
add_filter( 'template_include', 'classhall_use_summer_classes_template', 98 );

function classhall_summer_classes_status_header() {
    if ( ! classhall_is_summer_classes_request() ) {
        return;
    }

    global $wp_query;

    if ( $wp_query instanceof WP_Query ) {
        $wp_query->is_404 = false;
    }

    status_header( 200 );
}
add_action( 'template_redirect', 'classhall_summer_classes_status_header', 0 );

function classhall_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        if ( classhall_is_mathjax_context() ) {
            $urls[] = array(
                'href' => 'https://cdn.jsdelivr.net',
            );
        }

    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'classhall_resource_hints', 10, 2 );

function classhall_current_content_contains_any( $needles ) {
    $post = get_post();

    if ( ! $post || empty( $post->post_content ) ) {
        return false;
    }

    foreach ( (array) $needles as $needle ) {
        if ( false !== stripos( $post->post_content, $needle ) ) {
            return true;
        }
    }

    return false;
}

function classhall_page_needs_mediaelement() {
    return is_singular() && classhall_current_content_contains_any(
        array(
            '[audio',
            '[video',
            '[playlist',
            '<audio',
            '<video',
            'wp-audio-shortcode',
            'wp-video-shortcode',
        )
    );
}

function classhall_safe_frontend_performance_cleanup() {
    if ( is_admin() ) {
        return;
    }

    wp_dequeue_script( 'modernizr' );
    wp_deregister_script( 'modernizr' );
    wp_dequeue_script( 'wp-embed' );
    wp_deregister_script( 'wp-embed' );

    if ( ! is_user_logged_in() ) {
        wp_dequeue_style( 'dashicons' );
    }

    if ( ! classhall_page_needs_mediaelement() ) {
        foreach ( array( 'mediaelement', 'mediaelement-core', 'mediaelement-migrate', 'wp-mediaelement' ) as $script ) {
            wp_dequeue_script( $script );
        }

        foreach ( array( 'mediaelement', 'mediaelement-core', 'wp-mediaelement' ) as $style ) {
            wp_dequeue_style( $style );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'classhall_safe_frontend_performance_cleanup', 1001 );

function classhall_start_adsense_output_filter() {
    if ( is_admin() ) {
        return;
    }

    ob_start( 'classhall_strip_adsense_from_html' );
}
add_action( 'template_redirect', 'classhall_start_adsense_output_filter', 0 );

function classhall_strip_adsense_from_html( $html ) {
    if (
        false === stripos( $html, 'adsbygoogle' )
        && false === stripos( $html, 'pagead2.googlesyndication.com' )
        && false === stripos( $html, 'googlesyndication.com/pagead' )
    ) {
        return $html;
    }

    $html = preg_replace( '#<script\b[^>]*\bsrc=["\'][^"\']*(pagead2\.googlesyndication\.com|googlesyndication\.com/pagead)[^"\']*["\'][^>]*>\s*</script>#is', '', $html );
    $html = preg_replace( '#<script\b[^>]*>.*?(adsbygoogle|pagead2\.googlesyndication\.com|googlesyndication\.com/pagead).*?</script>#is', '', $html );
    $html = preg_replace( '#<ins\b[^>]*class=["\'][^"\']*adsbygoogle[^"\']*["\'][^>]*>.*?</ins>#is', '', $html );

    return $html;
}

function classhall_prioritize_first_content_image( $attr, $attachment, $size ) {
    static $prioritized = false;

    if ( $prioritized || is_admin() || ! is_singular() ) {
        return $attr;
    }

    $prioritized             = true;
    $attr['loading']         = 'eager';
    $attr['fetchpriority']   = 'high';
    $attr['decoding']        = 'async';

    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'classhall_prioritize_first_content_image', 10, 3 );

/**
 * Ultimate Member 2.10.3+ schedules a recurring background migration that
 * backfills missing account_status user meta. On this site the queue can crash
 * the server, so keep it disabled from the child theme until it can be run in
 * a controlled maintenance window.
 */
function classhall_um_status_backfill_is_disabled() {
    return ! ( defined( 'CLASSHALL_ALLOW_UM_STATUS_BACKFILL' ) && CLASSHALL_ALLOW_UM_STATUS_BACKFILL );
}

function classhall_um_skip_empty_status_user_count( $total_users ) {
    if ( classhall_um_status_backfill_is_disabled() ) {
        return 0;
    }

    return $total_users;
}
add_filter( 'um_get_empty_status_users_query_result', 'classhall_um_skip_empty_status_user_count', 1 );

function classhall_um_prevent_status_backfill_async_action( $pre, $hook, $args, $group, $priority, $unique ) {
    if (
        classhall_um_status_backfill_is_disabled()
        && in_array( $hook, array( 'um_schedule_empty_account_status_check', 'um_set_default_account_status' ), true )
    ) {
        return 0;
    }

    return $pre;
}
add_filter( 'pre_as_enqueue_async_action', 'classhall_um_prevent_status_backfill_async_action', 1, 6 );

function classhall_um_prevent_status_backfill_recurring_action( $pre, $timestamp, $interval_in_seconds, $hook, $args, $group, $priority, $unique ) {
    if ( classhall_um_status_backfill_is_disabled() && 'um_schedule_empty_account_status_check' === $hook ) {
        return 0;
    }

    return $pre;
}
add_filter( 'pre_as_schedule_recurring_action', 'classhall_um_prevent_status_backfill_recurring_action', 1, 8 );

function classhall_um_disable_status_backfill_runner() {
    if ( ! classhall_um_status_backfill_is_disabled() ) {
        return;
    }

    delete_option( '_um_log_empty_status_users' );

    if ( function_exists( 'UM' ) ) {
        $um = UM();

        if ( isset( $um->classes['um\common\actions\users'] ) ) {
            $users_actions = $um->classes['um\common\actions\users'];

            remove_action( 'init', array( $users_actions, 'add_recurring_action' ) );
            remove_action( 'um_schedule_empty_account_status_check', array( $users_actions, 'status_check' ) );
            remove_action( 'um_set_default_account_status', array( $users_actions, 'batch_check' ), 10 );
        }

        if ( is_object( $um ) && method_exists( $um, 'maybe_action_scheduler' ) ) {
            try {
                $um->maybe_action_scheduler()->unschedule_all_actions( 'um_schedule_empty_account_status_check' );
                $um->maybe_action_scheduler()->unschedule_all_actions( 'um_set_default_account_status' );
            } catch ( Throwable $e ) {
                return;
            }
        }
    }
}
add_action( 'init', 'classhall_um_disable_status_backfill_runner', 1 );

// Hide sales badge
add_filter('woocommerce_sale_flash', 'hide_sales_badge');
function hide_sales_badge()
{
    return false;
}

// Display user signup notice after excerpt


add_action( 'signup_notice_after_excerpt', array( 'Sensei_Lesson', 'course_signup_link' ), 5 );


// Display classhall features to logged out users
function add_signup_notice_after_excerpt_two() 
{
    if ( !is_user_logged_in() ) {
        echo '<div class="sign-up-notice-after-excerpt-two">You are viewing an excerpt of this lesson. Subscribing to the subject will give you access to the following:<br>
            <ul>
            <li>NEW: <b>Download</b> the entire term\'s content in <b>MS Word</b> document format (1-year plan only)</li>
            <li>The complete lesson note and evaluation questions for this topic</li>
            <li>The complete lessons for the subject and class (First Term, Second Term & Third Term)</li>
            <li>Media-rich, interactive and gamified content</li>
            <li>End-of-lesson objective questions with detailed explanations to force mastery of content</li>
            <li>Simulated termly preparatory examination questions</li>
            <li>Discussion boards on all lessons and subjects</li>
            <li>Guaranteed learning</li>
            </ul>
            </div>';} 
    else{

    }
}
add_action('subscribe_alert','add_signup_notice_after_excerpt_two', 5 );

add_filter('the_excerpt', 'do_shortcode');
add_filter('get_the_excerpt', 'do_shortcode');

add_filter('sensei_lesson_excerpt', 'do_shortcode');


// Beginning of excerpt code
function wpse_allowedtags() {
    // Add custom tags to this string
        return '<a>,<address>,<applet>,<area>,<b>,<base>,<basefont>,<bgsound>,<big>,<blink>,<blockquote>,<body>,<br>,,<caption>,<center>,<cite>,<code>,<colgroup>,<dd>,<del>,<div>,<dl>,<dt>,<em>,<embed>,<fieldset>,<font>,<form>,<frame>,<frameset>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<head>,<hr>,<html>,<i>,<iframe>,<img>,<input>,<ins>,<label>,<legend>,<li>,<link>,<map>,<marquee>,<meta>,<nobr>,<noembed>,<noframes>,<noscript>,<object>,<ol>,<option>,<p>,<param>,<pre>,<q>,<rb>,<rp>,<rt>,<ruby>,<s>,<samp>,<script>,<select>,<small>,<span>,<strike>,<strong>,<style>,<sub>,<sup>,<table>,<tbody>,<td>,<textarea>,<tfoot>,<th>,<thead>,<title>,<tr>,<tt>,<u>,<ul>,<var>,<!-- -->,<!DOCTYPE>'; 
        }

if ( ! function_exists( 'wpse_custom_wp_trim_excerpt' ) ) : 

    function wpse_custom_wp_trim_excerpt($wpse_excerpt) {
    global $post;
    $raw_excerpt = $wpse_excerpt;
        if ( '' == $wpse_excerpt ) {

            $wpse_excerpt = get_the_content('');
            $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
            $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
            $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
            
            //Set the excerpt word count and only break after sentence is complete.
                $excerpt_word_count = 200;
                $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
                $tokens = array();
                $excerptOutput = '';
                $count = 0;

                // Divide the string into tokens; HTML tags, or words, followed by any whitespace
                preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);

                foreach ($tokens[0] as $token) { 

                    if ($count >= $excerpt_word_count && preg_match('/[\?\.\!]\s*$/uS', $token)) { 
                    // Limit reached, continue until ? . or ! occur at the end
                        $excerptOutput .= trim($token);
                        break;
                    }

                    // Add words to complete sentence
                    $count++;

                    // Append what's left of the token
                    $excerptOutput .= $token;
                }

            $wpse_excerpt = trim(force_balance_tags($excerptOutput));

                $excerpt_end = ' <a href="'. esc_url( get_permalink() ) . '">' . '&nbsp;&raquo;&nbsp;' . sprintf(__( 'Read more about: %s &nbsp;&raquo;', 'wpse' ), get_the_title()) . '</a>'; 
                $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end); 

                //$pos = strrpos($wpse_excerpt, '</');
                //if ($pos !== false)
                // Inside last HTML tag
                //$wpse_excerpt = substr_replace($wpse_excerpt, $excerpt_end, $pos, 0); /* Add read more next to last word */
                //else
                // After the content
                //$wpse_excerpt .= $excerpt_end; /*Add read more in new paragraph */

            return $wpse_excerpt;   

        }
        return apply_filters('wpse_custom_wp_trim_excerpt', $wpse_excerpt, $raw_excerpt);
    }

endif; 

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'wpse_custom_wp_trim_excerpt');

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
//remove sitename from email subject
add_filter('wp_mail', 'email_subject_remove_sitename');
function email_subject_remove_sitename($email) {
  $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
  $email['subject'] = str_replace("[".$blogname."] - ", "", $email['subject']);    
  $email['subject'] = str_replace("[".$blogname."]", "", $email['subject']);
  return $email;
}

// Custom Admin footer
function wpexplorer_remove_footer_admin () {
	echo '<span id="footer-thankyou">Copyright &copy; 2026 - Spidaworks Digital</span>';
}
add_filter( 'admin_footer_text', 'wpexplorer_remove_footer_admin' );

function classhall_replace_frontend_copyright_year( $html ) {
    $patterns = array(
        '/(Copyright(?:\s|&nbsp;|<[^>]+>)*(&copy;|\x{00A9})?(?:\s|&nbsp;|<[^>]+>)*)2022/iu',
        '/((&copy;|\x{00A9})(?:\s|&nbsp;|<[^>]+>)*)2022/iu',
    );

    return preg_replace( $patterns, '${1}2026', $html );
}

function classhall_filter_footer_copyright_option( $value ) {
    if ( is_string( $value ) ) {
        return classhall_replace_frontend_copyright_year( $value );
    }

    if ( is_array( $value ) ) {
        array_walk_recursive(
            $value,
            function( &$item ) {
                if ( is_string( $item ) ) {
                    $item = classhall_replace_frontend_copyright_year( $item );
                }
            }
        );
    }

    return $value;
}

add_filter( 'theme_mod_footer_text', 'classhall_filter_footer_copyright_option' );
add_filter( 'theme_mod_copyright_text', 'classhall_filter_footer_copyright_option' );
add_filter( 'option_kleo_options', 'classhall_filter_footer_copyright_option' );
add_filter( 'option_sq_options', 'classhall_filter_footer_copyright_option' );
add_filter( 'option_redux_builder_kleo', 'classhall_filter_footer_copyright_option' );

function classhall_footer_copyright_fallback() {
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!document.body || document.body.textContent.indexOf('2022') === -1) {
                return;
            }

            var walker = document.createTreeWalker(
                document.body,
                NodeFilter.SHOW_TEXT,
                {
                    acceptNode: function (node) {
                        var parent = node.parentNode && node.parentNode.nodeName;

                        return parent === 'SCRIPT' || parent === 'STYLE'
                            ? NodeFilter.FILTER_REJECT
                            : NodeFilter.FILTER_ACCEPT;
                    }
                }
            );
            var nodes = [];
            var node;

            while ((node = walker.nextNode())) {
                nodes.push(node);
            }

            nodes.forEach(function replaceCopyrightYear(textNode) {
                textNode.nodeValue = textNode.nodeValue.replace(
                    /((?:Copyright\s*(?:\u00A9|\(c\))?|\u00A9|\(c\))[^0-9]{0,12})2022/i,
                    function( match, prefix ) {
                        return prefix + '2026';
                    }
                );
            });
        });
    </script>
    <?php
}
add_action( 'wp_footer', 'classhall_footer_copyright_fallback', 99 );

function classhall_quiz_html_fallback() {
    if ( ! is_singular( 'quiz' ) ) {
        return;
    }

    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var quizList = document.getElementById('sensei-quiz-list');

            if (!quizList) {
                return;
            }

            quizList.innerHTML = quizList.innerHTML
                .replace(/&amp;lt;(\/?(?:br|sub|sup|strong|b|em|i|u))&amp;gt;/gi, '<$1>')
                .replace(/&lt;(\/?(?:br|sub|sup|strong|b|em|i|u))&gt;/gi, '<$1>');

            var allowedTags = /(?:&lt;|<)(\/?(?:br|sub|sup|strong|b|em|i|u))(?:&gt;|>)/gi;

            quizList.querySelectorAll('li').forEach(function (question) {
                var walker = document.createTreeWalker(question, NodeFilter.SHOW_TEXT);
                var textNodes = [];
                var node;

                while ((node = walker.nextNode())) {
                    textNodes.push(node);
                }

                textNodes.forEach(function (textNode) {
                    var html = textNode.nodeValue.replace(allowedTags, '<$1>');

                    if (html === textNode.nodeValue) {
                        return;
                    }

                    var span = document.createElement('span');
                    span.innerHTML = html;
                    textNode.parentNode.replaceChild(span, textNode);
                });
            });
        });
    </script>
    <?php
}
add_action( 'wp_footer', 'classhall_quiz_html_fallback', 99 );

function classhall_normalize_question_latex_markup( $text ) {
    if ( ! is_string( $text ) || '' === $text ) {
        return $text;
    }

    $text = html_entity_decode( $text, ENT_QUOTES, get_bloginfo( 'charset' ) );
    $text = preg_replace( '/(?<!\\\\)\btext\s*\{/i', '\\\\text{', $text );

    return preg_replace_callback(
        '/(?<!\\\\)\((\s*\^\{[^()]+\}_[^()]+?)(?<!\\\\)\)/',
        function ( $matches ) {
            $math = trim( $matches[1] );

            if ( preg_match( '/^\\\\\(.+\\\\\)$/', $math ) ) {
                return $matches[0];
            }

            return '\\(' . $math . '\\)';
        },
        $text
    );
}

function classhall_allow_question_title_markup( $title, $post_id = null ) {
    if ( $post_id && 'question' === get_post_type( $post_id ) ) {
        return wp_kses(
            classhall_normalize_question_latex_markup( $title ),
            classhall_question_title_allowed_html()
        );
    }

    return $title;
}
add_filter( 'the_title', 'classhall_allow_question_title_markup', 20, 2 );

function classhall_question_title_allowed_html() {
    return array(
        'br'     => array(),
        'sub'    => array(),
        'sup'    => array(),
        'strong' => array(),
        'b'      => array(),
        'em'     => array(),
        'i'      => array(),
        'u'      => array(),
        'span'   => array(
            'class' => array(),
        ),
    );
}

function classhall_replace_sensei_question_title_renderer() {
    if ( ! class_exists( 'Sensei_Question' ) ) {
        return;
    }

    remove_action( 'sensei_quiz_question_inside_before', array( 'Sensei_Question', 'the_question_title' ), 10 );
    add_action( 'sensei_quiz_question_inside_before', 'classhall_render_sensei_question_title', 10 );
}
add_action( 'wp', 'classhall_replace_sensei_question_title_renderer', 20 );

function classhall_render_sensei_question_title( $question_id ) {
    $question_id = absint( $question_id );

    if ( ! $question_id ) {
        return;
    }

    $title = get_post_field( 'post_title', $question_id );
    $title = apply_filters( 'sensei_question_title', $title );
    $title = apply_filters( 'sensei_single_title', $title, 'question' );
    $title = wp_kses(
        classhall_normalize_question_latex_markup( $title ),
        classhall_question_title_allowed_html()
    );

    $question_grade = (
        function_exists( 'Sensei' )
        && Sensei()
        && isset( Sensei()->question )
        && method_exists( Sensei()->question, 'get_question_grade' )
    ) ? Sensei()->question->get_question_grade( $question_id ) : 0;

    echo '<div class="sensei-lms-question-block__header"><h2 class="question question-title">';

    if ( function_exists( 'sensei_get_the_question_number' ) ) {
        printf(
            '<span>%s. </span>',
            esc_html( sensei_get_the_question_number() )
        );
    }

    echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</h2>';

    if (
        $question_grade > 0
        && function_exists( 'Sensei' )
        && Sensei()
        && isset( Sensei()->view_helper )
        && method_exists( Sensei()->view_helper, 'format_question_points' )
    ) {
        echo wp_kses_post( Sensei()->view_helper->format_question_points( $question_grade ) );
    }

    echo '</div>';
}

function classhall_extract_question_grid_json( $content ) {
    $start = strpos( $content, '[[[' );

    if ( false === $start ) {
        return false;
    }

    $length    = strlen( $content );
    $depth     = 0;
    $in_string = false;
    $escaped   = false;

    for ( $i = $start; $i < $length; $i++ ) {
        $char = $content[ $i ];

        if ( $in_string ) {
            if ( $escaped ) {
                $escaped = false;
                continue;
            }

            if ( '\\' === $char ) {
                $escaped = true;
                continue;
            }

            if ( '"' === $char ) {
                $in_string = false;
            }

            continue;
        }

        if ( '"' === $char ) {
            $in_string = true;
            continue;
        }

        if ( '[' === $char || '{' === $char ) {
            $depth++;
            continue;
        }

        if ( ']' === $char || '}' === $char ) {
            $depth--;

            if ( 0 === $depth ) {
                return array(
                    'start' => $start,
                    'end'   => $i + 1,
                    'json'  => substr( $content, $start, ( $i + 1 ) - $start ),
                );
            }
        }
    }

    return false;
}

function classhall_build_question_grid_table( $json ) {
    $json = wp_specialchars_decode( html_entity_decode( $json, ENT_QUOTES, get_bloginfo( 'charset' ) ), ENT_QUOTES );
    $json = str_replace(
        array( "\xE2\x80\x9C", "\xE2\x80\x9D", "\xE2\x80\x98", "\xE2\x80\x99" ),
        array( '"', '"', "'", "'" ),
        $json
    );

    $table_data = json_decode( $json, true );

    if ( ! is_array( $table_data ) || empty( $table_data[0] ) || ! is_array( $table_data[0] ) ) {
        return false;
    }

    $rows          = $table_data[0];
    $cell_meta     = ! empty( $table_data[1] ) && is_array( $table_data[1] ) ? $table_data[1] : array();
    $visible_rows  = array();
    $visible_cols  = array();

    foreach ( $rows as $row_index => $row ) {
        if ( ! is_array( $row ) ) {
            continue;
        }

        foreach ( $row as $col_index => $cell ) {
            if ( '' !== trim( (string) $cell ) ) {
                $visible_rows[ $row_index ] = true;
                $visible_cols[ $col_index ] = true;
            }
        }
    }

    if ( empty( $visible_rows ) || empty( $visible_cols ) ) {
        return false;
    }

    $meta_by_cell = array();

    foreach ( $cell_meta as $meta ) {
        if ( ! is_array( $meta ) || ! isset( $meta['row'], $meta['col'] ) ) {
            continue;
        }

        $meta_by_cell[ absint( $meta['row'] ) . ':' . absint( $meta['col'] ) ] = $meta;
    }

    $row_indexes = array_keys( $visible_rows );
    $col_indexes = array_keys( $visible_cols );
    sort( $row_indexes );
    sort( $col_indexes );

    $html = '<div class="classhall-question-data-table-wrap"><table class="classhall-question-data-table" style="border-collapse:collapse;border-spacing:0;border:1px solid #1f2937;">';

    foreach ( $row_indexes as $rendered_row_index => $row_index ) {
        $tag   = 0 === $rendered_row_index ? 'th' : 'td';
        $scope = 0 === $rendered_row_index ? ' scope="col"' : '';

        $html .= '<tr>';

        foreach ( $col_indexes as $col_index ) {
            $cell  = isset( $rows[ $row_index ][ $col_index ] ) ? $rows[ $row_index ][ $col_index ] : '';
            $meta  = isset( $meta_by_cell[ $row_index . ':' . $col_index ] ) ? $meta_by_cell[ $row_index . ':' . $col_index ] : array();
            $style = 'border:1px solid #1f2937;padding:10px 14px;text-align:center;vertical-align:middle;';

            if ( ! empty( $meta['className'] ) ) {
                if ( false !== strpos( $meta['className'], 'htCenter' ) ) {
                    $style .= 'text-align:center;';
                } elseif ( false !== strpos( $meta['className'], 'htRight' ) ) {
                    $style .= 'text-align:right;';
                }
            }

            if ( ! empty( $meta['jtcellstyle'] ) && is_array( $meta['jtcellstyle'] ) ) {
                foreach ( array( 'font-weight', 'font-style', 'text-decoration', 'color', 'background', 'background-color' ) as $property ) {
                    if ( ! empty( $meta['jtcellstyle'][ $property ] ) ) {
                        $style .= sanitize_key( $property ) . ':' . esc_attr( $meta['jtcellstyle'][ $property ] ) . ';';
                    }
                }
            }

            $html .= '<' . $tag . $scope . ( $style ? ' style="' . esc_attr( $style ) . '"' : '' ) . '>' . esc_html( (string) $cell ) . '</' . $tag . '>';
        }

        $html .= '</tr>';
    }

    $html .= '</table></div>';

    return $html;
}

function classhall_render_question_grid_data( $content ) {
    if ( false === strpos( $content, 'visualRow' ) && false === strpos( $content, 'jtcellstyle' ) ) {
        return $content;
    }

    $grid = classhall_extract_question_grid_json( $content );

    if ( ! $grid ) {
        return $content;
    }

    $table = classhall_build_question_grid_table( $grid['json'] );

    if ( ! $table ) {
        return $content;
    }

    return substr( $content, 0, $grid['start'] ) . $table . substr( $content, $grid['end'] );
}

function classhall_normalize_question_content_latex_markup( $content ) {
    if ( ! is_singular( 'question' ) ) {
        return $content;
    }

    return classhall_normalize_question_latex_markup( classhall_render_question_grid_data( $content ) );
}
add_filter( 'the_content', 'classhall_normalize_question_content_latex_markup', 8 );

function classhall_single_question_mathjax_refresh() {
    if ( ! is_singular( 'question' ) ) {
        return;
    }
    ?>
    <script>
    (function () {
        function restoreAllowedTitleHtml(root) {
            if (!root) {
                return;
            }

            root.querySelectorAll('.question-title, .classhall-single-question h1').forEach(function (title) {
                title.innerHTML = title.innerHTML
                    .replace(/&amp;lt;(\/?(?:br|sub|sup|strong|b|em|i|u))&amp;gt;/gi, '<$1>')
                    .replace(/&lt;(\/?(?:br|sub|sup|strong|b|em|i|u))&gt;/gi, '<$1>');
            });
        }

        function normalizeQuestionLatex(root) {
            if (!root || !document.createTreeWalker) {
                return;
            }

            var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
            var nodes = [];
            var node;

            while ((node = walker.nextNode())) {
                if (/(\^\{[^)]+\}_[^)]+|\btext\s*\{)/i.test(node.nodeValue)) {
                    nodes.push(node);
                }
            }

            nodes.forEach(function (textNode) {
                var value = textNode.nodeValue
                    .replace(/(^|[^\\])\btext\s*\{/gi, '$1\\text{')
                    .replace(/(^|[^\\])\((\s*\^\{[^()]+\}_[^()]+?)\)/g, '$1\\($2\\)');

                if (value !== textNode.nodeValue) {
                    textNode.nodeValue = value;
                }
            });
        }

        function typesetQuestionMath(attempts) {
            var root = document.body;

            restoreAllowedTitleHtml(root);
            normalizeQuestionLatex(root);

            if (window.MathJax && window.MathJax.typesetPromise) {
                window.MathJax.typesetPromise([root]);
                return;
            }

            if (attempts > 0) {
                window.setTimeout(function () {
                    typesetQuestionMath(attempts - 1);
                }, 250);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            typesetQuestionMath(24);
        });
        window.addEventListener('load', function () {
            typesetQuestionMath(8);
        });
    }());
    </script>
    <?php
}
add_action( 'wp_footer', 'classhall_single_question_mathjax_refresh', 120 );

function cw_remove_quantity_fields( $return, $product ) {
   return true;
}
add_filter( 'woocommerce_is_sold_individually', 'cw_remove_quantity_fields', 10, 2 );

function classhall_normalize_subscription_button_label( $text ) {
    if ( ! is_string( $text ) || '' === $text ) {
        return $text;
    }

    $formatted = html_entity_decode( wp_strip_all_tags( $text ), ENT_QUOTES, get_bloginfo( 'charset' ) );

    if (
        false === stripos( $formatted, 'subscribe' )
        && false === stripos( $formatted, 'month' )
        && false === stripos( $formatted, 'year' )
        && false === stripos( $formatted, 'week' )
        && false === stripos( $formatted, 'day' )
    ) {
        return $text;
    }

    $formatted = preg_replace( '/\bfrom\s*:?\s*/i', 'From ', $formatted );
    $formatted = preg_replace( '/(\d(?:[\d,.]*\d)?)\s*(for)\b/i', '$1 for', $formatted );
    $formatted = preg_replace( '/\s*for\s+(\d+)\s*(month|months|year|years|week|weeks|day|days)\b/i', ' for $1 $2', $formatted );
    $formatted = preg_replace( '/\s*-\s*/', ' - ', $formatted );
    $formatted = preg_replace( '/\s*subscribe\s+now\b/i', ' Subscribe now', $formatted );
    $formatted = preg_replace_callback(
        '/\b(month|months|year|years|week|weeks|day|days)\b/i',
        function ( $matches ) {
            return strtolower( $matches[0] );
        },
        $formatted
    );
    $formatted = preg_replace( '/\s+/', ' ', trim( $formatted ) );

    return $formatted;
}

function classhall_format_subscription_button_text( $text, $product = null ) {
    return classhall_normalize_subscription_button_label( $text );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'classhall_format_subscription_button_text', 99, 2 );
add_filter( 'woocommerce_product_add_to_cart_text', 'classhall_format_subscription_button_text', 99, 2 );
add_filter( 'wc_subscription_product_add_to_cart_text', 'classhall_format_subscription_button_text', 99, 2 );

function classhall_subscription_button_text_fallback() {
    if ( is_admin() ) {
        return;
    }

    if ( function_exists( 'is_checkout' ) && is_checkout() ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var selectors = [
            '.single_add_to_cart_button',
            '.course-container a.button',
            '.course-container button',
            '.course-container input.button',
            '.woocommerce a.button',
            '.woocommerce button.button',
            '.woocommerce input.button'
        ];

        function normalizeButton(button) {
            var isInput = button.matches('input');
            var original = ((isInput ? button.value : button.textContent) || '').replace(/\s+/g, ' ').trim();

            if (!original || (!/subscribe/i.test(original) && !/month|year|week|day/i.test(original))) {
                return;
            }

            var formatted = original
                .replace(/\bfrom\s*:?\s*/i, 'From ')
                .replace(/(\d(?:[\d,.]*\d)?)\s*(for)\b/i, '$1 for')
                .replace(/\s*for\s+(\d+)\s*(month|months|year|years|week|weeks|day|days)\b/i, ' for $1 $2')
                .replace(/\s*-\s*/g, ' - ')
                .replace(/\s*subscribe\s+now\b/i, ' Subscribe now')
                .replace(/\b(month|months|year|years|week|weeks|day|days)\b/gi, function (match) {
                    return match.toLowerCase();
                })
                .replace(/\s+/g, ' ')
                .trim();

            if (formatted && formatted !== original) {
                if (isInput) {
                    button.value = formatted;
                } else {
                    button.textContent = formatted;
                }
            }
        }

        function normalizeButtons() {
            document.querySelectorAll(selectors.join(',')).forEach(normalizeButton);
        }

        normalizeButtons();

        if ('MutationObserver' in window) {
            var observer = new MutationObserver(normalizeButtons);
            observer.observe(document.body, {
                childList: true,
                subtree: true,
                characterData: true
            });
        }
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'classhall_subscription_button_text_fallback', 98 );

function classhall_subject_lesson_list_spacing_fix() {
    if ( is_admin() || ! is_singular( 'course' ) ) {
        return;
    }
    ?>
    <style id="classhall-subject-lesson-spacing-fix">
        .course .module .module-description,
        .sensei .module .module-description {
            margin-bottom: 0 !important;
        }

        .course .module .module-lessons,
        .sensei .module .module-lessons,
        .course .module .module-lessons header,
        .sensei .module .module-lessons header,
        .course .module .module-lessons .lesson-title,
        .sensei .module .module-lessons .lesson-title,
        .course .module .module-lessons ul,
        .sensei .module .module-lessons ul {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .course .module .module-lessons,
        .sensei .module .module-lessons,
        .course .module .module-lessons ul,
        .sensei .module .module-lessons ul {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .course .module .module-lessons ul li:last-child,
        .sensei .module .module-lessons ul li:last-child {
            border-bottom: 0 !important;
            margin-bottom: 0 !important;
        }

        .course .module > header,
        .sensei .module > header {
            padding-top: 18px !important;
            padding-bottom: 18px !important;
        }

        .course .module > header h2,
        .course .module > header h3,
        .sensei .module > header h2,
        .sensei .module > header h3 {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            line-height: 1.2 !important;
        }

        .course .module .module-lessons header,
        .sensei .module .module-lessons header,
        .course .module .module-lessons .lesson-title,
        .sensei .module .module-lessons .lesson-title {
            display: flex !important;
            align-items: center !important;
            min-height: 40px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .course .module .module-lessons header h2,
        .course .module .module-lessons header h3,
        .course .module .module-lessons .lesson-title h2,
        .course .module .module-lessons .lesson-title h3,
        .sensei .module .module-lessons header h2,
        .sensei .module .module-lessons header h3,
        .sensei .module .module-lessons .lesson-title h2,
        .sensei .module .module-lessons .lesson-title h3 {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
            line-height: 1.2 !important;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'classhall_subject_lesson_list_spacing_fix', 999 );

function classhall_subject_lesson_list_spacing_script() {
    if ( is_admin() || ! is_singular( 'course' ) ) {
        return;
    }
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.course .module .module-lessons, .sensei .module .module-lessons').forEach(function (lessonBlock) {
            lessonBlock.style.setProperty('margin-top', '0', 'important');
            lessonBlock.style.setProperty('margin-bottom', '0', 'important');
            lessonBlock.style.setProperty('padding-top', '0', 'important');
            lessonBlock.style.setProperty('padding-bottom', '0', 'important');

            lessonBlock.querySelectorAll('header, .lesson-title, ul').forEach(function (child) {
                child.style.setProperty('margin-top', '0', 'important');
                child.style.setProperty('margin-bottom', '0', 'important');
                child.style.setProperty('padding-bottom', '0', 'important');
            });

            var moduleDescription = lessonBlock.previousElementSibling;
            if (moduleDescription && moduleDescription.classList.contains('module-description')) {
                moduleDescription.style.setProperty('margin-bottom', '0', 'important');
            }

            var lastLesson = lessonBlock.querySelector('ul li:last-child');
            if (lastLesson) {
                lastLesson.style.setProperty('margin-bottom', '0', 'important');
                lastLesson.style.setProperty('border-bottom', '0', 'important');
            }
        });
    });
    </script>
    <?php
}
add_action( 'wp_footer', 'classhall_subject_lesson_list_spacing_script', 100 );

function classhall_mobile_product_grid_width_fix() {
    if ( ! function_exists( 'is_woocommerce' ) || ! is_woocommerce() ) {
        return;
    }
    ?>
    <style id="classhall-mobile-product-grid-width-fix">
    @media (max-width: 782px) {
        body .woocommerce ul.products,
        body.woocommerce-page .woocommerce ul.products,
        body .woocommerce .products.row {
            display: block !important;
            width: 100% !important;
            max-width: none !important;
            margin-right: 0 !important;
            margin-left: 0 !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
            box-sizing: border-box !important;
        }

        body .woocommerce ul.products li.product,
        body.woocommerce-page .woocommerce ul.products li.product,
        body .woocommerce .products.row > .product {
            float: none !important;
            clear: both !important;
            display: flex !important;
            flex-direction: column !important;
            width: 100% !important;
            max-width: none !important;
            min-width: 0 !important;
            margin-right: auto !important;
            margin-bottom: 20px !important;
            margin-left: auto !important;
            box-sizing: border-box !important;
            transform: none !important;
        }
    }
    </style>
    <?php
}
add_action( 'wp_head', 'classhall_mobile_product_grid_width_fix', 1000 );

add_filter( 'woocommerce_checkout_fields' , 'custom_remove_woo_checkout_fields' );
 
function custom_remove_woo_checkout_fields( $fields ) {

    // remove billing fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_city']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_state']);
   
    // remove shipping fields
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_1']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_city']);
	unset($fields['shipping']['shipping_country']);
	unset($fields['shipping']['shipping_state']);

    // remove order comment fields
    unset($fields['order']['order_comments']);
    
    return $fields;
}


add_filter( 'use_widgets_block_editor', '__return_false' );


function custom_sensei_slugs( $args, $post_type ) {
    if ( 'course' === $post_type ) {
        $args['rewrite']['slug'] = 'subject';
    }

    if ( 'quiz' === $post_type ) {
        $args['rewrite']['slug'] = 'test';
    }

    return $args;
}
add_filter( 'register_post_type_args', 'custom_sensei_slugs', 10, 2 );


function classhall_include_lessons_in_core_sitemap( $post_types ) {
    if ( ! isset( $post_types['lesson'] ) && post_type_exists( 'lesson' ) ) {
        $lesson_post_type = get_post_type_object( 'lesson' );

        if ( $lesson_post_type && ! empty( $lesson_post_type->public ) ) {
            $post_types['lesson'] = $lesson_post_type;
        }
    }

    return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'classhall_include_lessons_in_core_sitemap', 99 );

function classhall_include_lessons_in_yoast_sitemap( $is_excluded, $post_type ) {
    if ( 'lesson' === $post_type ) {
        return false;
    }

    return $is_excluded;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'classhall_include_lessons_in_yoast_sitemap', 99, 2 );



add_filter( 'sensei_register_post_type_question', function( $args ) {
    $args['public']              = true;
    $args['publicly_queryable']  = true;
    $args['query_var']           = true;
    $args['has_archive']         = false;
    $args['exclude_from_search'] = true;

    // Make sure rewrite is enabled and has a slug
    $args['rewrite'] = array(
        'slug' => 'question',
        'with_front' => false
    );

    return $args;
});

function classhall_add_sensei_question_rewrite_rule() {
    add_rewrite_rule(
        '^question/([^/]+)/?$',
        'index.php?post_type=question&name=$matches[1]',
        'top'
    );
}
add_action( 'init', 'classhall_add_sensei_question_rewrite_rule', 30 );

function classhall_prefer_sensei_question_for_question_urls( $query_vars ) {
    if ( empty( $query_vars['name'] ) || empty( $_SERVER['REQUEST_URI'] ) ) {
        return $query_vars;
    }

    $path  = trim( (string) wp_parse_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ), PHP_URL_PATH ), '/' );
    $parts = explode( '/', $path );

    if ( 'question' !== reset( $parts ) ) {
        return $query_vars;
    }

    $question = get_page_by_path( sanitize_title_for_query( $query_vars['name'] ), OBJECT, 'question' );

    if ( ! $question instanceof WP_Post ) {
        return $query_vars;
    }

    $query_vars['post_type'] = 'question';
    $query_vars['name']      = $question->post_name;

    unset( $query_vars['dwqa-question'] );

    return $query_vars;
}
add_filter( 'request', 'classhall_prefer_sensei_question_for_question_urls', 999 );

function classhall_flush_question_rewrite_rules_once() {
    $rewrite_version = 'classhall_question_rewrite_20260714_2';

    if ( get_option( 'classhall_question_rewrite_version' ) === $rewrite_version ) {
        return;
    }

    flush_rewrite_rules( false );
    update_option( 'classhall_question_rewrite_version', $rewrite_version, false );
}
add_action( 'init', 'classhall_flush_question_rewrite_rules_once', 99 );

add_filter( 'post_thumbnail_html', 'classhall_replace_sensei_course_thumbnail_with_icon', 20, 5 );
add_filter( 'sensei_course_image_html', 'classhall_replace_sensei_course_image_html_with_icon', 20, 5 );
add_action( 'sensei_single_course_content_inside_before', 'classhall_render_sensei_summer_banner', 1 );
add_action( 'sensei_single_lesson_content_inside_before', 'classhall_render_sensei_summer_banner', 1 );
add_action( 'sensei_single_quiz_content_inside_before', 'classhall_render_sensei_summer_banner', 1 );
add_action( 'sensei_single_course_content_inside_before', 'classhall_open_sensei_course_access_panel', 19 );
add_action( 'sensei_single_course_content_inside_before', 'classhall_close_sensei_course_access_panel', 31 );
add_action( 'sensei_pagination', 'classhall_render_related_subjects_after_back_block', 85 );
add_action( 'sensei_pagination', 'classhall_render_related_lessons_after_back_block', 85 );
add_action( 'sensei_pagination', 'classhall_render_related_quizzes_after_back_block', 85 );

function classhall_move_related_posts_to_manual_positions( $short_circuit, $post, $args ) {
    if (
        is_admin()
        || ! ( $post instanceof WP_Post )
        || ! is_singular( array( 'course', 'lesson', 'quiz', 'post' ) )
        || ! in_array( $post->post_type, array( 'course', 'lesson', 'quiz', 'post' ), true )
    ) {
        return $short_circuit;
    }

    return empty( $args['is_manual'] ) ? true : $short_circuit;
}
add_filter( 'get_crp_short_circuit', 'classhall_move_related_posts_to_manual_positions', 10, 3 );

function classhall_get_manual_related_posts_markup( $post_id, $extra_class = '' ) {
    if ( ! function_exists( 'get_crp' ) ) {
        return '';
    }

    $related_posts = get_crp(
        array(
            'post_id'     => absint( $post_id ),
            'is_manual'   => true,
            'extra_class' => $extra_class,
        )
    );

    return '' !== trim( wp_strip_all_tags( $related_posts, true ) ) ? $related_posts : '';
}

function classhall_render_related_subjects_after_back_block() {
    if ( is_admin() || ! is_singular( 'course' ) ) {
        return;
    }

    $related_posts = classhall_get_manual_related_posts_markup( get_the_ID(), 'classhall-related-subjects-bottom' );

    if ( '' === $related_posts ) {
        return;
    }

    echo '<div class="classhall-related-subjects-bottom-wrap">';
    echo $related_posts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div>';
}

function classhall_render_guest_lesson_related_posts( $lesson_id ) {
    if ( is_admin() || ! is_singular( 'lesson' ) ) {
        return;
    }

    $related_posts = classhall_get_manual_related_posts_markup( $lesson_id, 'classhall-related-lessons-guest' );

    if ( '' === $related_posts ) {
        return;
    }

    echo '<div class="classhall-related-lessons-guest-wrap">';
    echo $related_posts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div>';
}

function classhall_render_related_lessons_after_back_block() {
    if ( is_admin() || ! is_singular( 'lesson' ) ) {
        return;
    }

    $related_posts = classhall_get_manual_related_posts_markup( get_the_ID(), 'classhall-related-lessons-bottom' );

    if ( '' === $related_posts ) {
        return;
    }

    echo '<div class="classhall-related-lessons-bottom-wrap">';
    echo $related_posts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div>';
}

function classhall_render_related_quizzes_after_back_block() {
    if ( is_admin() || ! is_singular( 'quiz' ) ) {
        return;
    }

    $related_posts = classhall_get_manual_related_posts_markup( get_the_ID(), 'classhall-related-quizzes-bottom' );

    if ( '' === $related_posts ) {
        return;
    }

    echo '<div class="classhall-related-quizzes-bottom-wrap">';
    echo $related_posts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo '</div>';
}

function classhall_render_related_posts_after_post_navigation( $post_id, $theme_related_enabled = 1 ) {
    if ( is_admin() || ! is_singular( 'post' ) ) {
        return;
    }

    $related_posts = classhall_get_manual_related_posts_markup( $post_id, 'classhall-related-posts-bottom' );

    if ( '' !== $related_posts ) {
        echo '<div class="classhall-related-posts-bottom-wrap">';
        echo $related_posts; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo '</div>';
        return;
    }

    if ( $theme_related_enabled == 1 ) {
        echo '<div class="classhall-related-posts-bottom-wrap classhall-related-posts-theme-fallback">';
        get_template_part( 'page-parts/posts-related' );
        echo '</div>';
    }
}

function classhall_render_sensei_summer_banner() {
    if ( is_admin() || ! is_singular( array( 'course', 'lesson', 'quiz' ) ) ) {
        return;
    }

    echo '<div class="classhall-sensei-summer-promo">';
    get_template_part( 'template-parts/classhall-summer-banner' );
    echo '</div>';
}

function classhall_open_sensei_course_access_panel() {
    if ( is_admin() || ! is_singular( 'course' ) ) {
        return;
    }

    echo '<div class="classhall-course-access-panel">';
}

function classhall_close_sensei_course_access_panel() {
    if ( is_admin() || ! is_singular( 'course' ) ) {
        return;
    }

    echo '</div>';
}

function classhall_replace_sensei_course_thumbnail_with_icon( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    if ( is_admin() || empty( $post_id ) || 'course' !== get_post_type( $post_id ) ) {
        return $html;
    }

    return classhall_get_sensei_course_icon_markup( $post_id );
}

function classhall_replace_sensei_course_image_html_with_icon( $html, $course_id, $width, $height, $used_placeholder ) {
    if ( is_admin() || empty( $course_id ) || 'course' !== get_post_type( $course_id ) ) {
        return $html;
    }

    return classhall_get_sensei_course_icon_markup( $course_id );
}

function classhall_get_sensei_course_icon_markup( $post_id ) {
    $icon_type = classhall_get_sensei_course_icon_type( $post_id );
    $label     = sprintf( '%s subject icon', wp_strip_all_tags( get_the_title( $post_id ) ) );

    return sprintf(
        '<div class="classhall-course-icon classhall-course-icon--%1$s woo-image thumbnail alignleft" role="img" aria-label="%2$s"><i class="%3$s" aria-hidden="true"></i></div>',
        esc_attr( $icon_type ),
        esc_attr( $label ),
        esc_attr( classhall_get_sensei_course_icon_class( $icon_type ) )
    );
}

function classhall_get_sensei_course_icon_class( $icon_type ) {
    $icons = array(
        'agriculture' => 'icon-leaf',
        'animal'      => 'icon-leaf',
        'arts'        => 'icon-picture',
        'beauty'      => 'icon-heart',
        'business'    => 'icon-briefcase',
        'catering'    => 'icon-food',
        'civic'       => 'icon-flag',
        'commerce'    => 'icon-money',
        'computer'    => 'icon-desktop',
        'data'        => 'icon-keyboard',
        'dyeing'      => 'icon-tint',
        'economics'   => 'icon-chart-bar',
        'fashion'     => 'icon-scissors',
        'finance'     => 'icon-credit-card',
        'geography'   => 'icon-compass',
        'government'  => 'icon-building',
        'hardware'    => 'icon-wrench',
        'health'      => 'icon-stethoscope',
        'history'     => 'icon-book',
        'home'        => 'icon-home',
        'insurance'   => 'icon-shield',
        'language'    => 'icon-font',
        'literature'  => 'icon-book',
        'marketing'   => 'icon-tag',
        'math'        => 'icon-chart-bar',
        'music'       => 'icon-music',
        'office'      => 'icon-briefcase',
        'photography' => 'icon-camera',
        'physical'    => 'icon-heart',
        'religious'   => 'icon-book',
        'repairs'     => 'icon-mobile',
        'science'     => 'icon-beaker',
        'security'    => 'icon-shield',
        'social'      => 'icon-globe',
        'store'       => 'icon-basket',
        'technology'  => 'icon-cog',
        'textile'     => 'icon-scissors',
        'default'     => 'icon-book',
    );

    return isset( $icons[ $icon_type ] ) ? $icons[ $icon_type ] : $icons['default'];
}

function classhall_get_sensei_course_icon_type( $post_id ) {
    $title = strtolower( wp_strip_all_tags( get_the_title( $post_id ) ) );

    $subject_icons = array(
        'hardware'    => array( 'computer hardware', 'hardware' ),
        'repairs'     => array( 'gsm repairs', 'gsm maintenance', 'repairs', 'maintenance' ),
        'data'        => array( 'data processing' ),
        'finance'     => array( 'financial accounting', 'accounting' ),
        'commerce'    => array( 'commerce' ),
        'economics'   => array( 'economics' ),
        'marketing'   => array( 'marketing' ),
        'insurance'   => array( 'insurance' ),
        'store'       => array( 'store keeping', 'storekeeping' ),
        'office'      => array( 'office practice' ),
        'business'    => array( 'business studies', 'business' ),
        'catering'    => array( 'catering', 'foods and nutrition', 'food and nutrition', 'nutrition' ),
        'fashion'     => array( 'fashion design', 'garment', 'clothing' ),
        'textile'     => array( 'textile' ),
        'dyeing'      => array( 'dyeing', 'bleaching' ),
        'beauty'      => array( 'beauty', 'cosmetology' ),
        'health'      => array( 'health education' ),
        'physical'    => array( 'physical and health', 'physical education' ),
        'security'    => array( 'security education', 'security' ),
        'photography' => array( 'photography' ),
        'music'       => array( 'music' ),
        'arts'        => array( 'creative arts', 'cultural and creative', 'art' ),
        'geography'   => array( 'geography' ),
        'government'  => array( 'government' ),
        'civic'       => array( 'civic education', 'civic' ),
        'history'     => array( 'history' ),
        'social'      => array( 'social studies' ),
        'religious'   => array( 'christian religious', 'islamic studies', 'religious', 'c.r.s', 'crs' ),
        'literature'  => array( 'literature' ),
        'language'    => array( 'english language', 'english studies', 'primary english', 'french', 'language', 'english' ),
        'animal'      => array( 'animal husbandry', 'animal' ),
        'agriculture' => array( 'agricultural science', 'agriculture', 'farm', 'crop' ),
        'technology'  => array( 'basic technology', 'technology' ),
        'computer'    => array( 'computer science', 'computer studies', 'computer science/ict', 'ict', 'computer' ),
        'math'        => array( 'general mathematics', 'primary mathematics', 'mathematics', 'math', 'algebra', 'geometry' ),
        'science'     => array( 'primary basic science', 'basic science', 'intermediate science', 'biology', 'chemistry', 'physics', 'science', 'laboratory' ),
        'home'        => array( 'home economics' ),
    );

    foreach ( $subject_icons as $icon_type => $needles ) {
        foreach ( $needles as $needle ) {
            if ( false !== strpos( $title, $needle ) ) {
                return $icon_type;
            }
        }
    }

    return 'default';
}

function classhall_get_sensei_course_icon_svg( $icon_type ) {
    $icons = array(
        'math'        => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><rect x="17" y="8" width="30" height="48" rx="5"></rect><path d="M24 18h16M24 30h4M36 30h4M24 39h4M36 39h4M24 48h16"></path></svg>',
        'science'     => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M26 8h12M32 8v18L18 50a6 6 0 0 0 5 9h18a6 6 0 0 0 5-9L32 26"></path><path d="M23 45h18M25 35h14"></path></svg>',
        'computer'    => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><rect x="10" y="12" width="44" height="30" rx="4"></rect><path d="M25 52h14M32 42v10"></path></svg>',
        'agriculture' => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M12 43c18 2 31-8 38-28 8 20-1 37-19 37-8 0-14-3-19-9z"></path><path d="M19 45c8-9 17-15 28-19"></path></svg>',
        'business'    => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M12 52h40M18 46V30M32 46V18M46 46V25"></path><path d="M16 26l16-12 16 8"></path></svg>',
        'language'    => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M13 15h16a9 9 0 0 1 9 9v31H22a9 9 0 0 0-9 9V15z"></path><path d="M51 15H38v40h4a9 9 0 0 1 9 9V15zM20 27h10M20 37h10"></path></svg>',
        'religious'   => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M16 18h14a8 8 0 0 1 8 8v28H24a8 8 0 0 0-8 8V18z"></path><path d="M48 18H38v36h4a8 8 0 0 1 8 8V18zM28 22v18M20 31h16"></path></svg>',
        'social'      => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><circle cx="32" cy="32" r="22"></circle><path d="M10 32h44M32 10c8 7 12 14 12 22s-4 15-12 22M32 10c-8 7-12 14-12 22s4 15 12 22"></path></svg>',
        'home'        => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M12 30 32 14l20 16v24H18V30"></path><path d="M27 54V38h10v16"></path></svg>',
        'arts'        => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M20 46c-7-2-10-8-8-16 3-12 16-20 30-15 10 4 15 13 10 22-3 5-8 4-11 1-3-2-5-2-7 2-2 5-7 8-14 6z"></path><circle cx="25" cy="27" r="2"></circle><circle cx="34" cy="23" r="2"></circle><circle cx="42" cy="30" r="2"></circle></svg>',
        'default'     => '<svg viewBox="0 0 64 64" aria-hidden="true" focusable="false"><path d="M14 13h18a8 8 0 0 1 8 8v34H22a8 8 0 0 0-8 8V13z"></path><path d="M50 13H40v42h2a8 8 0 0 1 8 8V13z"></path></svg>',
    );

    $svg = isset( $icons[ $icon_type ] ) ? $icons[ $icon_type ] : $icons['default'];

    return preg_replace(
        '/<svg /',
        '<svg width="132" height="132" style="display:block;max-width:42%;max-height:72%;fill:none;stroke:#2563eb;stroke-width:3.5;stroke-linecap:round;stroke-linejoin:round;opacity:1;visibility:visible;" ',
        $svg,
        1
    );
}
