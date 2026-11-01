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

function classhall_the_paste_default_to_webp() {
    static $added = false;

    if ( $added ) {
        return;
    }

    if ( ! is_admin() || ! current_user_can( 'upload_files' ) ) {
        return;
    }

    if ( ! wp_script_is( 'admin-the-paste', 'registered' ) && ! wp_script_is( 'admin-the-paste', 'enqueued' ) ) {
        return;
    }

    wp_add_inline_script(
        'admin-the-paste',
        <<<'JS'
(function($){
    function preferWebp(context) {
        $(context).find('.the-paste-image-list-item').addBack('.the-paste-image-list-item').each(function(){
            var $item = $(this);
            if ($item.data('classhallThePasteWebpDefaultApplied')) {
                return;
            }

            var $webp = $item.find('[name="the-paste-format"][value="image/webp"]');
            var selected = $item.find('[name="the-paste-format"]:checked').val();

            if (!$webp.length || selected === 'image/svg+xml') {
                return;
            }

            $webp.prop('checked', true).trigger('change');
            $item.data('classhallThePasteWebpDefaultApplied', true);
        });
    }

    $(function(){
        preferWebp(document);
        new MutationObserver(function(mutations){
            mutations.forEach(function(mutation){
                $(mutation.addedNodes).each(function(){
                    if (this.nodeType === 1) {
                        preferWebp(this);
                    }
                });
            });
        }).observe(document.body, { childList: true, subtree: true });
    });
})(jQuery);
JS
    );

    $added = true;
}
add_action( 'wp_enqueue_media', 'classhall_the_paste_default_to_webp', 20 );
add_action( 'wp_enqueue_editor', 'classhall_the_paste_default_to_webp', 20 );

function classhall_subscription_checkout_button_text( $button_text ) {
    return __( 'Complete Subscription', 'kleo-child' );
}
add_filter( 'wcs_place_subscription_order_text', 'classhall_subscription_checkout_button_text', 99 );

function classhall_checkout_order_button_text( $button_text ) {
    if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
        return $button_text;
    }

    if ( false === stripos( $button_text, 'renew subscription' ) ) {
        return $button_text;
    }

    if ( ! function_exists( 'WC' ) || ! WC()->cart || 0 === count( WC()->cart->get_cart() ) ) {
        return __( 'Complete Subscription', 'kleo-child' );
    }

    if ( function_exists( 'wcs_get_order_type_cart_items' ) ) {
        $renewal_items = wcs_get_order_type_cart_items( 'renewal' );

        if ( count( $renewal_items ) !== count( WC()->cart->get_cart() ) ) {
            return __( 'Complete Subscription', 'kleo-child' );
        }
    }

    return $button_text;
}
add_filter( 'woocommerce_order_button_text', 'classhall_checkout_order_button_text', 999 );

function classhall_hide_page_title_breadcrumbs( $args ) {
    $args['show_breadcrumb'] = false;

    return $args;
}
add_filter( 'kleo_title_args', 'classhall_hide_page_title_breadcrumbs', 20 );

function classhall_replace_course_word_for_frontend( $text ) {
    if ( ! is_string( $text ) || '' === $text ) {
        return $text;
    }

    $replacements = array(
        'Courses' => 'Subjects',
        'courses' => 'subjects',
        'Course'  => 'Subject',
        'course'  => 'subject',
    );

    foreach ( $replacements as $from => $to ) {
        $text = preg_replace( '/\b' . preg_quote( $from, '/' ) . '\b/u', $to, $text );
    }

    return $text;
}

function classhall_update_sensei_course_wording( $translated_text, $text = '', $domain = '' ) {
    if ( is_admin() ) {
        return $translated_text;
    }

    if ( ! function_exists( 'is_singular' ) || ! is_singular( array( 'course', 'lesson', 'quiz' ) ) ) {
        return $translated_text;
    }

    return classhall_replace_course_word_for_frontend( $translated_text );
}
add_filter( 'gettext', 'classhall_update_sensei_course_wording', 20, 3 );

function classhall_update_sensei_course_wording_plural( $translation, $single, $plural, $number, $domain = '' ) {
    return classhall_update_sensei_course_wording( $translation, '', $domain );
}
add_filter( 'ngettext', 'classhall_update_sensei_course_wording_plural', 20, 5 );

function classhall_update_sensei_course_wording_context( $translation, $text, $context, $domain = '' ) {
    return classhall_update_sensei_course_wording( $translation, $text, $domain );
}
add_filter( 'gettext_with_context', 'classhall_update_sensei_course_wording_context', 20, 4 );

function classhall_is_mathjax_context() {
    $has_math_content = classhall_current_content_contains_any(
        array(
            '\\(',
            '\\)',
            '\\[',
            '\\]',
            '\frac',
            '\sqrt',
            '\times',
            '\left',
            '\right',
            '$$',
            '[math',
            '<math',
        )
    );

    $is_learning_content = function_exists( 'is_singular' )
        && is_singular( array( 'lesson', 'question', 'dwqa-question' ) )
        && $has_math_content;
    $is_learning_archive = function_exists( 'is_post_type_archive' )
        && is_post_type_archive( array( 'lesson', 'question', 'dwqa-question' ) )
        && $has_math_content;
    $is_homepage_preview = (
        function_exists( 'is_front_page' )
        && is_front_page()
    ) || (
        function_exists( 'is_page_template' )
        && is_page_template( 'template-classhall-home.php' )
    );

    return $is_homepage_preview || $is_learning_content || $is_learning_archive;
}

function classhall_enqueue_child_assets() {
    global $wp_styles;
    global $classhall_child_style_handles;

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
    $classhall_child_style_handles = array();

    if ( $wp_styles instanceof WP_Styles ) {
        foreach ( $wp_styles->queue as $handle ) {
            if ( empty( $wp_styles->registered[ $handle ]->src ) ) {
                continue;
            }

            $queued_url = wp_parse_url( $wp_styles->registered[ $handle ]->src, PHP_URL_PATH );

            if ( $queued_url && $source_style_url && false !== strpos( $queued_url, $source_style_url ) ) {
                $wp_styles->registered[ $handle ]->src = $stylesheet_uri;
                $wp_styles->registered[ $handle ]->ver = $version;
                $classhall_child_style_handles[] = $handle;
                $style_queued = true;
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
        $classhall_child_style_handles[] = 'classhall-child-style';
    }

    $child_style_deps = ! empty( $classhall_child_style_handles )
        ? array( $classhall_child_style_handles[0] )
        : array();

    if ( classhall_is_frontend_homepage() ) {
        classhall_enqueue_page_stylesheet_asset( 'classhall-home', $child_style_deps );
    }

    if ( classhall_is_mathjax_context() && ! classhall_is_frontend_homepage() ) {
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

function classhall_plain_header_hamburger_css() {
    ?>
    <style id="classhall-plain-header-hamburger">
        .social-header,
        .social-header .top-bar {
            background: #1F4690 !important;
        }

        .social-header .top-menu > ul > li > a {
            color: #ffffff !important;
        }

        .social-header .top-menu > ul > li > a:hover,
        .social-header .top-menu > ul > li > a:focus {
            color: #dbeafe !important;
        }

        .social-header .top-menu > ul > li.registertop > a,
        .social-header .top-menu > ul > li.registertop > a i,
        .social-header .top-menu > ul > li.registertop > a i::before,
        .social-header .top-menu > ul > li.registertop > a svg,
        .social-header .top-menu > ul > li.registertop > a svg * {
            color: #000000 !important;
            fill: #000000 !important;
            stroke: #000000 !important;
        }

        .social-header .top-menu > ul > li.menu-item-has-children::before,
        .social-header .top-menu > ul > li.menu-item-has-children::after,
        .social-header .top-menu > ul > li.dropdown::before,
        .social-header .top-menu > ul > li.dropdown::after,
        .social-header .top-menu > ul > li > .caret,
        .social-header .top-menu > ul > li > .caret::after,
        .social-header .top-menu > ul > li > a .caret,
        .social-header .top-menu > ul > li > a .caret::after,
        .social-header .top-menu > ul > li > a i,
        .social-header .top-menu > ul > li > a i::before,
        .social-header .top-menu > ul > li > a i::after,
        .social-header .top-menu > ul > li > a svg,
        .social-header .top-menu > ul > li > a svg *,
        .social-header .top-menu > ul > li > a::before,
        .social-header .top-menu > ul > li > a::after {
            color: #ffffff !important;
            fill: #ffffff !important;
            stroke: #ffffff !important;
            border-top-color: #ffffff !important;
            border-bottom-color: #ffffff !important;
            border-right-color: #ffffff !important;
            border-left-color: #ffffff !important;
        }

        .social-header .top-menu > ul > li.menu-item-has-children:hover::before,
        .social-header .top-menu > ul > li.menu-item-has-children:focus-within::before,
        .social-header .top-menu > ul > li.menu-item-has-children:hover::after,
        .social-header .top-menu > ul > li.menu-item-has-children:focus-within::after,
        .social-header .top-menu > ul > li.dropdown:hover::before,
        .social-header .top-menu > ul > li.dropdown:focus-within::before,
        .social-header .top-menu > ul > li.dropdown:hover::after,
        .social-header .top-menu > ul > li.dropdown:focus-within::after,
        .social-header .top-menu > ul > li:hover > .caret,
        .social-header .top-menu > ul > li:focus-within > .caret,
        .social-header .top-menu > ul > li:hover > .caret::after,
        .social-header .top-menu > ul > li:focus-within > .caret::after,
        .social-header .top-menu > ul > li > a:hover .caret,
        .social-header .top-menu > ul > li > a:focus .caret,
        .social-header .top-menu > ul > li > a:hover .caret::after,
        .social-header .top-menu > ul > li > a:focus .caret::after,
        .social-header .top-menu > ul > li > a:hover i,
        .social-header .top-menu > ul > li > a:focus i,
        .social-header .top-menu > ul > li > a:hover i::before,
        .social-header .top-menu > ul > li > a:focus i::before,
        .social-header .top-menu > ul > li > a:hover i::after,
        .social-header .top-menu > ul > li > a:focus i::after,
        .social-header .top-menu > ul > li > a:hover svg,
        .social-header .top-menu > ul > li > a:focus svg,
        .social-header .top-menu > ul > li > a:hover svg *,
        .social-header .top-menu > ul > li > a:focus svg *,
        .social-header .top-menu > ul > li > a:hover::before,
        .social-header .top-menu > ul > li > a:focus::before,
        .social-header .top-menu > ul > li > a:hover::after,
        .social-header .top-menu > ul > li > a:focus::after {
            color: #dbeafe !important;
            fill: #dbeafe !important;
            stroke: #dbeafe !important;
            border-top-color: #dbeafe !important;
            border-bottom-color: #dbeafe !important;
            border-right-color: #dbeafe !important;
            border-left-color: #dbeafe !important;
        }

        .social-header .top-menu > ul > li.registertop > a,
        .social-header .top-menu > ul > li.registertop > a:hover,
        .social-header .top-menu > ul > li.registertop > a:focus,
        .social-header .top-menu > ul > li.registertop > a i,
        .social-header .top-menu > ul > li.registertop > a:hover i,
        .social-header .top-menu > ul > li.registertop > a:focus i,
        .social-header .top-menu > ul > li.registertop > a i::before,
        .social-header .top-menu > ul > li.registertop > a:hover i::before,
        .social-header .top-menu > ul > li.registertop > a:focus i::before,
        .social-header .top-menu > ul > li.registertop > a svg,
        .social-header .top-menu > ul > li.registertop > a:hover svg,
        .social-header .top-menu > ul > li.registertop > a:focus svg,
        .social-header .top-menu > ul > li.registertop > a svg *,
        .social-header .top-menu > ul > li.registertop > a:hover svg *,
        .social-header .top-menu > ul > li.registertop > a:focus svg * {
            color: #000000 !important;
            fill: #000000 !important;
            stroke: #000000 !important;
        }

        @media (min-width: 992px) {
            #header .kleo-main-header .kleo-mobile-switch {
                display: none !important;
            }

            .social-header .classhall-top-menu-toggle,
            .social-header button.classhall-top-menu-toggle,
            .social-header .classhall-top-menu-dropdown {
                display: none !important;
                visibility: hidden !important;
                width: 0 !important;
                height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }
        }

        @media (max-width: 991px) {
            #header .kleo-main-header .kleo-mobile-switch {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: auto !important;
                min-width: 0 !important;
                height: 100% !important;
                min-height: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                background: transparent !important;
                background-color: transparent !important;
                box-shadow: none !important;
            }

            #header .kleo-main-header button.navbar-toggle,
            #header .kleo-main-header .navbar-toggle {
                display: block !important;
                width: 22px !important;
                flex: 0 0 22px !important;
                min-width: 0 !important;
                max-width: 22px !important;
                height: 18px !important;
                min-height: 0 !important;
                max-height: 18px !important;
                margin: 0 !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                outline: 0 !important;
                background: transparent !important;
                background-color: transparent !important;
                background-image: none !important;
                box-shadow: none !important;
                line-height: 1 !important;
                text-indent: 0 !important;
                -webkit-appearance: none !important;
                appearance: none !important;
                vertical-align: middle !important;
            }

            #header .kleo-main-header button.navbar-toggle:hover,
            #header .kleo-main-header button.navbar-toggle:focus,
            #header .kleo-main-header button.navbar-toggle:active,
            #header .kleo-main-header .navbar-toggle:hover,
            #header .kleo-main-header .navbar-toggle:focus,
            #header .kleo-main-header .navbar-toggle:active {
                background: transparent !important;
                background-color: transparent !important;
                background-image: none !important;
                box-shadow: none !important;
            }

            #header .kleo-main-header .navbar-toggle .icon-bar {
                display: block !important;
                width: 22px !important;
                height: 2px !important;
                margin: 0 !important;
                border-radius: 1px !important;
                background: #111827 !important;
                background-color: #111827 !important;
            }

            #header .kleo-main-header .navbar-toggle .icon-bar + .icon-bar {
                margin-top: 4px !important;
            }

            .social-header .top-menu {
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important;
                width: 100% !important;
            }

            .social-header .top-menu > ul {
                display: flex !important;
                align-items: center !important;
                justify-content: flex-end !important;
                gap: 4px !important;
                width: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                list-style: none !important;
            }

            .social-header .top-menu > ul > li {
                display: none !important;
            }

            .social-header .top-menu > ul > li.registertop,
            .social-header .top-menu > ul > li.logintop,
            .social-header .top-menu > ul > li.classhall-auth-logout {
                display: inline-flex !important;
                width: auto !important;
            }

            .social-header .top-menu > ul > li.registertop > a,
            .social-header .top-menu > ul > li.logintop > a,
            .social-header .top-menu > ul > li.classhall-auth-logout > a {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 5px !important;
                width: auto !important;
                padding: 7px 9px !important;
                font-size: 12px !important;
                font-weight: 800 !important;
                line-height: 1.2 !important;
                white-space: nowrap !important;
            }

            .social-header .top-menu > ul > li.registertop > a {
                color: #0f172a !important;
            }

            .social-header .top-menu > ul > li.logintop > a {
                color: #ffffff !important;
            }

            .social-header .top-menu:not(.classhall-top-menu-ready)::after {
                content: "";
                display: block;
                flex: 0 0 22px;
                width: 22px;
                min-width: 22px;
                max-width: 22px;
                height: 18px;
                min-height: 18px;
                max-height: 18px;
                margin: 0 0 0 24px;
                padding: 0;
                align-self: center;
                line-height: 1;
                vertical-align: middle;
                background:
                    linear-gradient(#ffffff, #ffffff) 0 0 / 22px 2px no-repeat,
                    linear-gradient(#ffffff, #ffffff) 0 6px / 22px 2px no-repeat,
                    linear-gradient(#ffffff, #ffffff) 0 12px / 22px 2px no-repeat;
            }

            .social-header .classhall-top-menu-toggle,
            .social-header button.classhall-top-menu-toggle {
                display: block !important;
                width: 22px !important;
                min-width: 0 !important;
                max-width: 22px !important;
                height: 18px !important;
                min-height: 0 !important;
                max-height: 18px !important;
                margin: 0 0 0 24px !important;
                padding: 0 !important;
                border: 0 !important;
                border-radius: 0 !important;
                outline: 0 !important;
                background: transparent !important;
                background-color: transparent !important;
                background-image: none !important;
                box-shadow: none !important;
                line-height: 1 !important;
                text-indent: 0 !important;
                align-self: center !important;
                vertical-align: middle !important;
                -webkit-appearance: none !important;
                appearance: none !important;
            }

            .social-header .classhall-top-menu-toggle:hover,
            .social-header .classhall-top-menu-toggle:focus,
            .social-header .classhall-top-menu-toggle:active,
            .social-header button.classhall-top-menu-toggle:hover,
            .social-header button.classhall-top-menu-toggle:focus,
            .social-header button.classhall-top-menu-toggle:active {
                background: transparent !important;
                background-color: transparent !important;
                background-image: none !important;
                box-shadow: none !important;
            }

            .social-header .classhall-top-menu-toggle span {
                display: block !important;
                width: 22px !important;
                height: 2px !important;
                margin: 0 !important;
                border-radius: 1px !important;
                background: #ffffff !important;
                background-color: #ffffff !important;
            }

            .social-header .classhall-top-menu-toggle span + span {
                margin-top: 4px !important;
            }
        }
    </style>
    <?php
}
add_action( 'wp_head', 'classhall_plain_header_hamburger_css', 1000 );

function classhall_enqueue_page_stylesheet_asset( $basename, $deps = array() ) {
    $asset = classhall_get_fresh_child_stylesheet_asset( $basename );

    if ( ! $asset ) {
        return;
    }

    wp_enqueue_style(
        $basename,
        $asset['uri'],
        $deps,
        file_exists( $asset['path'] ) ? filemtime( $asset['path'] ) : wp_get_theme()->get( 'Version' )
    );
}

function classhall_get_fresh_child_stylesheet_asset( $basename ) {
    $source_path = get_stylesheet_directory() . '/' . $basename . '.css';
    $source_uri  = get_stylesheet_directory_uri() . '/' . $basename . '.css';
    $min_path    = get_stylesheet_directory() . '/' . $basename . '.min.css';
    $min_uri     = get_stylesheet_directory_uri() . '/' . $basename . '.min.css';

    if ( file_exists( $min_path ) && ( ! file_exists( $source_path ) || filemtime( $min_path ) >= filemtime( $source_path ) ) ) {
        return array(
            'path' => $min_path,
            'uri'  => $min_uri,
        );
    }

    if ( file_exists( $source_path ) ) {
        return array(
            'path' => $source_path,
            'uri'  => $source_uri,
        );
    }

    return null;
}

function classhall_is_frontend_homepage() {
    return ! is_admin()
        && (
            ( function_exists( 'is_front_page' ) && is_front_page() )
            || ( function_exists( 'is_page_template' ) && is_page_template( 'template-classhall-home.php' ) )
        );
}

function classhall_async_homepage_stylesheets( $html, $handle, $href, $media ) {
    return $html;
}
add_filter( 'style_loader_tag', 'classhall_async_homepage_stylesheets', 10, 4 );

function classhall_add_llms_txt_query_var( $vars ) {
    $vars[] = 'classhall_llms_txt';

    return $vars;
}
add_filter( 'query_vars', 'classhall_add_llms_txt_query_var' );

function classhall_add_llms_txt_rewrite_rule() {
    add_rewrite_rule( '^llms\.txt$', 'index.php?classhall_llms_txt=1', 'top' );
}
add_action( 'init', 'classhall_add_llms_txt_rewrite_rule' );

function classhall_maybe_render_llms_txt() {
    $request_path = isset( $_SERVER['REQUEST_URI'] )
        ? trim( (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ), '/' )
        : '';

    if ( 'llms.txt' !== $request_path && ! get_query_var( 'classhall_llms_txt' ) ) {
        return;
    }

    status_header( 200 );
    nocache_headers();
    header( 'Content-Type: text/plain; charset=utf-8' );

    echo "# Classhall\n\n";
    echo "> Classhall provides structured digital curriculum content, lesson notes, lesson plans, assessments, quizzes, and learning resources for teachers and students.\n\n";
    echo "## Website\n\n";
    echo "- [Home](https://classhall.com/): Classhall overview and entry point.\n";
    echo "- [Subjects catalogue](https://classhall.com/subjects-catalogue/): Browse available subjects and class bundles.\n";
    echo "- [Subscriptions](https://classhall.com/subscriptions/): Subscription plans and access options.\n";
    echo "- [Blog](https://classhall.com/blog/): Public articles and learning updates.\n";
    echo "- [FAQs](https://classhall.com/faqs/): Frequently asked questions.\n\n";
    echo "## Learning Content\n\n";
    echo "- [JSS1 subscription plans](https://classhall.com/jss1-subscription-plans/): JSS1 class access.\n";
    echo "- [JSS2 subscription plans](https://classhall.com/jss2-subscription-plans/): JSS2 class access.\n";
    echo "- [JSS3 subscription plans](https://classhall.com/jss3-subscription-plans/): JSS3 class access.\n\n";
    echo "## Crawling Guidance\n\n";
    echo "- Use canonical URLs for summaries and citations.\n";
    echo "- Public pages may be crawled when allowed by robots.txt.\n";
    echo "- Protected lesson, quiz, and question content may require sign-in or subscription access.\n";
    echo "- Do not bypass access controls or copy-protection mechanisms.\n";
    exit;
}
add_action( 'template_redirect', 'classhall_maybe_render_llms_txt', 0 );

function classhall_async_lesson_stylesheets( $html, $handle, $href, $media ) {
    if ( ! classhall_is_sensei_lesson_style_page() || empty( $href ) ) {
        return $html;
    }

    $async_handles = array(
        'kleo-google-fonts',
        'module-frontend',
        'pages-frontend',
        'sensei-page-block-patterns-style',
        'sensei-block-patterns-style',
        'kleo-sensei',
        'sensei-sidebar-mobile-menu',
        'sensei-theme-blocks',
        'sensei_course_progress-frontend',
    );
    $async_href_patterns = array(
        'fonts.googleapis.com/css',
        '/themes/kleo/assets/css/fontello.css',
        '/sensei-lms/assets/dist/css/block-patterns.css',
    );

    $should_async = in_array( $handle, $async_handles, true );

    if ( ! $should_async ) {
        foreach ( $async_href_patterns as $pattern ) {
            if ( false !== strpos( $href, $pattern ) ) {
                $should_async = true;
                break;
            }
        }
    }

    if ( ! $should_async ) {
        return $html;
    }

    $media = $media ? $media : 'all';

    return sprintf(
        '<link rel="preload" href="%1$s" as="style" onload="this.onload=null;this.rel=\'stylesheet\';this.media=\'%2$s\'" data-classhall-lesson-async-style="%3$s">' . "\n" .
        '<noscript><link rel="stylesheet" href="%1$s" media="%2$s"></noscript>' . "\n",
        esc_url( $href ),
        esc_attr( $media ),
        esc_attr( $handle )
    );
}
add_filter( 'style_loader_tag', 'classhall_async_lesson_stylesheets', 11, 4 );

function classhall_async_question_stylesheets( $html, $handle, $href, $media ) {
    return $html;
}
add_filter( 'style_loader_tag', 'classhall_async_question_stylesheets', 12, 4 );

function classhall_async_subject_stylesheets( $html, $handle, $href, $media ) {
    if ( ! classhall_is_sensei_subject_page() || empty( $href ) ) {
        return $html;
    }

    if ( ! file_exists( get_stylesheet_directory() . '/classhall-subject.min.css' ) ) {
        return $html;
    }

    $async_handles = array(
        'kleo-google-fonts',
        'css-protect.css',
        'print-protection.css',
    );
    $async_href_patterns = array(
        'fonts.googleapis.com/css',
        '/themes/kleo/assets/css/fontello.css',
        '/plugins/wccp-pro/css/css-protect.css',
        '/plugins/wccp-pro/css/print-protection.css',
    );

    $should_async = in_array( $handle, $async_handles, true );

    if ( ! $should_async ) {
        foreach ( $async_href_patterns as $pattern ) {
            if ( false !== strpos( $href, $pattern ) ) {
                $should_async = true;
                break;
            }
        }
    }

    if ( ! $should_async ) {
        return $html;
    }

    $media = $media ? $media : 'all';

    return sprintf(
        '<link rel="preload" href="%1$s" as="style" onload="this.onload=null;this.rel=\'stylesheet\';this.media=\'%2$s\'" data-classhall-subject-async-style="%3$s">' . "\n" .
        '<noscript><link rel="stylesheet" href="%1$s" media="%2$s"></noscript>' . "\n",
        esc_url( $href ),
        esc_attr( $media ),
        esc_attr( $handle )
    );
}
add_filter( 'style_loader_tag', 'classhall_async_subject_stylesheets', 13, 4 );

function classhall_rewrite_lesson_child_stylesheet_src( $src, $handle ) {
    return $src;
}
add_filter( 'style_loader_src', 'classhall_rewrite_lesson_child_stylesheet_src', 30, 2 );

function classhall_rewrite_question_child_stylesheet_src( $src, $handle ) {
    return $src;
}
add_filter( 'style_loader_src', 'classhall_rewrite_question_child_stylesheet_src', 31, 2 );

function classhall_dedupe_lesson_child_stylesheet_tags( $html, $handle, $href, $media ) {
    return $html;
}
add_filter( 'style_loader_tag', 'classhall_dedupe_lesson_child_stylesheet_tags', 100, 4 );

function classhall_wccp_excludes_current_request() {
    if ( ! function_exists( 'wccp_pro_read_options_from_db' ) || ! function_exists( 'exclude_this_page_or_not' ) ) {
        return false;
    }

    $wccp_pro_settings = wccp_pro_read_options_from_db( 'wccp_pro_settings' );

    if ( ! is_array( $wccp_pro_settings ) || empty( $wccp_pro_settings ) ) {
        return false;
    }

    return (bool) exclude_this_page_or_not( $wccp_pro_settings );
}

function classhall_print_sensei_copy_protection_fallback() {
    if ( ! classhall_is_sensei_single_content_page() ) {
        return;
    }

    if ( classhall_wccp_excludes_current_request() ) {
        return;
    }
    ?>
    <style id="classhall-sensei-copy-protection">
    body.single-lesson article.lesson,
    body.single-lesson article.lesson *:not(input):not(textarea):not(select):not(option),
    body.single-quiz article.quiz,
    body.single-quiz article.quiz *:not(input):not(textarea):not(select):not(option),
    body.single-question article.question,
    body.single-question article.question *:not(input):not(textarea):not(select):not(option),
    body.single-question .classhall-single-question,
    body.single-question .classhall-single-question *:not(input):not(textarea):not(select):not(option),
    body.single-lesson .sensei-course-theme,
    body.single-lesson .sensei-course-theme *:not(input):not(textarea):not(select):not(option),
    body.single-quiz .sensei-course-theme,
    body.single-quiz .sensei-course-theme *:not(input):not(textarea):not(select):not(option),
    body.single-question .sensei-course-theme,
    body.single-question .sensei-course-theme *:not(input):not(textarea):not(select):not(option) {
        -webkit-touch-callout: none !important;
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
    }

    body.single-lesson input,
    body.single-lesson textarea,
    body.single-quiz input,
    body.single-quiz textarea,
    body.single-question input,
    body.single-question textarea {
        -webkit-user-select: text !important;
        -moz-user-select: text !important;
        -ms-user-select: text !important;
        user-select: text !important;
    }
    </style>
    <script id="classhall-sensei-copy-protection-js">
    (function () {
        var protectedSelector = 'body.single-lesson article.lesson, body.single-quiz article.quiz, body.single-question article.question, body.single-question .classhall-single-question, body.single-lesson .sensei-course-theme, body.single-quiz .sensei-course-theme, body.single-question .sensei-course-theme';
        var editableSelector = 'input, textarea, select, option, [contenteditable="true"]';

        function isProtectedTarget(target) {
            return target && target.closest && target.closest(protectedSelector) && ! target.closest(editableSelector);
        }

        function blockProtectedAction(event) {
            if (! isProtectedTarget(event.target)) {
                return;
            }

            event.preventDefault();

            if (window.getSelection) {
                window.getSelection().removeAllRanges();
            }
        }

        ['copy', 'cut', 'dragstart', 'selectstart', 'contextmenu'].forEach(function (eventName) {
            document.addEventListener(eventName, blockProtectedAction, true);
        });

        document.addEventListener('keydown', function (event) {
            if (! isProtectedTarget(event.target)) {
                return;
            }

            var key = String(event.key || '').toLowerCase();
            if ((event.ctrlKey || event.metaKey) && ['a', 'c', 's', 'u', 'p', 'x'].indexOf(key) !== -1) {
                blockProtectedAction(event);
            }
        }, true);
    })();
    </script>
    <?php
}
add_action( 'wp_head', 'classhall_print_sensei_copy_protection_fallback', 100 );

function classhall_add_font_display_to_google_fonts( $src, $handle ) {
    if ( is_admin() || empty( $src ) || false === strpos( $src, 'fonts.googleapis.com/css' ) ) {
        return $src;
    }

    if ( false !== strpos( $src, 'display=' ) ) {
        return $src;
    }

    return add_query_arg( 'display', 'swap', $src );
}
add_filter( 'style_loader_src', 'classhall_add_font_display_to_google_fonts', 20, 2 );

function classhall_async_script_tags( $tag, $handle, $src ) {
    if ( 'classhall-mathjax' === $handle ) {
        return '<script async src="' . esc_url( $src ) . '"></script>' . "\n";
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'classhall_async_script_tags', 10, 3 );

function classhall_print_homepage_delayed_mathjax() {
    if ( ! classhall_is_frontend_homepage() ) {
        return;
    }
    ?>
    <script>
    window.MathJax = window.MathJax || {};
    window.MathJax.tex = window.MathJax.tex || {};
    window.MathJax.tex.inlineMath = [["\\(","\\)"], ["$","$"]];
    (function () {
        function loadMathJax() {
            if (document.querySelector('script[data-classhall-mathjax]')) {
                return;
            }

            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js';
            script.async = true;
            script.dataset.classhallMathjax = 'true';
            document.head.appendChild(script);
        }

        window.addEventListener('load', function () {
            if ('requestIdleCallback' in window) {
                requestIdleCallback(loadMathJax, { timeout: 1800 });
                return;
            }

            setTimeout(loadMathJax, 900);
        });
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'classhall_print_homepage_delayed_mathjax', 120 );

function classhall_print_homepage_critical_css() {
    if ( ! classhall_is_frontend_homepage() ) {
        return;
    }
    ?>
    <style id="classhall-home-critical-css">
    #classhall-home{--classhall-blue:#2563eb;--classhall-blue-dark:#1e40af;--classhall-blue-soft:#eff6ff;--classhall-green-light:#dcfce7;--classhall-green-dark:#166534;--classhall-border:#e2e8f0;--classhall-text:#0f172a;--classhall-text-secondary:#334155;--classhall-text-muted:#64748b;--ch-blue:#1f4690;--ch-blue-dark:#17356f;--ch-blue-soft:#eaf1ff;--ch-border:#d9e1eb;--ch-text:#172033;--ch-muted:#637083;--ch-white:#fff;background:#fff;color:var(--ch-text);font-family:inherit;overflow-x:clip}#classhall-home *,#classhall-home *::before,#classhall-home *::after{box-sizing:border-box}#classhall-home .ch-shell{width:min(1120px,calc(100% - 40px));margin:0 auto}#classhall-home .ch-hero{position:relative;overflow:hidden;padding:clamp(52px,7vw,92px) 0 clamp(58px,7vw,96px)!important;background:radial-gradient(circle at 8% 10%,rgba(37,99,235,.14),transparent 28rem),radial-gradient(circle at 92% 18%,rgba(16,185,129,.13),transparent 26rem),linear-gradient(180deg,#fff 0%,#f8fafc 100%)!important}#classhall-home .ch-hero-grid{display:grid;grid-template-columns:minmax(0,.95fr) minmax(360px,.78fr)!important;gap:clamp(32px,6vw,86px)!important;align-items:center}#classhall-home .ch-hero-copy{align-self:center}#classhall-home .ch-hero-brand{display:grid;grid-template-columns:58px auto;align-items:center;gap:13px;margin-bottom:26px}#classhall-home .ch-hero-brand img{width:58px;height:58px;filter:drop-shadow(0 10px 18px rgba(37,99,235,.12))}#classhall-home .ch-hero-brand .ch-brand-text{display:grid;gap:2px}#classhall-home .ch-hero-brand strong{color:var(--classhall-text)!important;font-size:24px;font-weight:900;line-height:1}#classhall-home .ch-hero-brand em{color:var(--classhall-blue)!important;font-size:14px;font-style:normal;font-weight:850;line-height:1.15}#classhall-home h1,#classhall-home h2,#classhall-home h3,#classhall-home p{color:inherit}#classhall-home .ch-hero h1{max-width:720px!important;margin:0;color:var(--classhall-text)!important;font-size:clamp(28px,3.1vw,40px)!important;line-height:1.14!important;font-weight:800;letter-spacing:0!important}#classhall-home .ch-hero .ch-lead{display:block;max-width:710px!important;margin:22px 0 0!important;color:var(--classhall-text-secondary)!important;font-size:clamp(18px,1.65vw,23px)!important;line-height:1.68!important;opacity:1!important;visibility:visible!important;transform:none!important}#classhall-home .ch-hero .ch-trust-badge{display:inline-block;margin-top:24px;padding:11px 15px;border:1px solid rgba(245,158,11,.32);border-radius:8px!important;background:#fff7df;color:var(--classhall-text-secondary)!important}#classhall-home .ch-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:30px!important}#classhall-home .ch-button{display:inline-flex;align-items:center;justify-content:center;min-height:54px!important;padding:13px 20px;border:1px solid transparent;border-radius:10px!important;font-size:15px;font-weight:800;line-height:1.2;text-decoration:none!important}#classhall-home .ch-button-primary{background:var(--classhall-blue);color:#fff!important;box-shadow:0 12px 26px rgba(37,99,235,.2)}#classhall-home .ch-button-secondary{background:#fff;color:var(--classhall-blue)!important;border-color:rgba(37,99,235,.24)}#classhall-home .ch-hero-visual{position:relative;min-width:0;transform:translateY(-36px)}#classhall-home .ch-math-lesson{position:relative;z-index:1;overflow:hidden;max-width:390px;margin:0 auto;border:1px solid rgba(37,99,235,.18);border-radius:18px;background:#fff;box-shadow:0 28px 70px rgba(15,23,42,.12);color:var(--classhall-text)}
    #classhall-home .ch-prefooter{background:#1e3a8a!important;color:#fff!important}#classhall-home .ch-prefooter h1,#classhall-home .ch-prefooter h2,#classhall-home .ch-prefooter h3,#classhall-home .ch-prefooter h4,#classhall-home .ch-prefooter p,#classhall-home .ch-prefooter a,#classhall-home .ch-prefooter span{color:#fff!important}#classhall-home .ch-prefooter .ch-bundle-panel,#classhall-home .ch-prefooter .ch-bundle-panel h1,#classhall-home .ch-prefooter .ch-bundle-panel h2,#classhall-home .ch-prefooter .ch-bundle-panel h3,#classhall-home .ch-prefooter .ch-bundle-panel p,#classhall-home .ch-prefooter .ch-bundle-panel a,#classhall-home .ch-prefooter .ch-bundle-panel span,#classhall-home .ch-bundle-panel,#classhall-home .ch-bundle-panel h1,#classhall-home .ch-bundle-panel h2,#classhall-home .ch-bundle-panel h3,#classhall-home .ch-bundle-panel p,#classhall-home .ch-bundle-panel a,#classhall-home .ch-bundle-panel span{color:#0f172a!important}#classhall-home .ch-bundle-panel .ch-eyebrow{color:#1e40af!important}#classhall-home .ch-prefooter .ch-button-primary,#classhall-home .ch-prefooter .ch-button-secondary{background:#fff!important;border-color:#fff!important;color:#172554!important}#classhall-home .ch-prefooter .ch-contact-icon{color:#fff!important;border-color:rgba(255,255,255,.45)!important}body.home #socket,body.home .socket,body.page-template-template-classhall-home #socket,body.page-template-template-classhall-home .socket{background:#0f2f72!important;color:#fff!important}body.home #socket *,body.home .socket *,body.page-template-template-classhall-home #socket *,body.page-template-template-classhall-home .socket *{color:#fff!important}
    @media (min-width:761px){#classhall-home .ch-hero{padding:clamp(52px,7vw,92px) 0 clamp(58px,7vw,96px)!important}#classhall-home .ch-shell{width:min(1120px,calc(100% - 40px))!important}#classhall-home .ch-hero-grid{grid-template-columns:minmax(0,.95fr) minmax(360px,.78fr)!important;gap:clamp(32px,6vw,86px)!important}#classhall-home .ch-hero-visual{min-height:0!important}}
    @media (max-width:760px){#classhall-home .ch-shell{width:min(100% - 28px,1120px)}#classhall-home .ch-hero{padding:34px 0 46px!important;background:radial-gradient(circle at top left,rgba(37,99,235,.10),transparent 18rem),#fff!important}#classhall-home .ch-hero-grid{display:grid;grid-template-columns:1fr!important;gap:26px!important}#classhall-home .ch-hero-brand{grid-template-columns:46px auto;gap:10px;margin-bottom:18px}#classhall-home .ch-hero-brand img{width:46px;height:46px}#classhall-home .ch-hero-brand strong{font-size:20px}#classhall-home .ch-hero .ch-lead{font-size:17px!important;line-height:1.62!important;margin-top:16px!important}#classhall-home .ch-hero .ch-actions{margin-top:22px!important}#classhall-home .ch-button{width:100%;min-height:50px!important}#classhall-home .ch-hero-visual{transform:none}}
    </style>
    <?php
}
add_action( 'wp_head', 'classhall_print_homepage_critical_css', 2 );

function classhall_logout_url() {
    return wp_logout_url( home_url( '/' ) );
}

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

function classhall_top_menu_mobile_drawer_script() {
    ?>
    <script>
    (function () {
        function setupTopMenu() {
            var topMenus = document.querySelectorAll('.social-header .top-menu');

            function getDirectChild(item, selectors) {
                for (var index = 0; index < item.children.length; index += 1) {
                    if (item.children[index].matches(selectors)) {
                        return item.children[index];
                    }
                }

                return null;
            }

            function getDirectSubmenu(item) {
                return getDirectChild(item, 'ul, .sub-menu, .dropdown-menu');
            }

            function getDirectLink(item) {
                return getDirectChild(item, 'a');
            }

            function toggleSubmenu(item, toggle) {
                var isClosed = item.classList.toggle('is-submenu-closed');
                toggle.setAttribute('aria-expanded', isClosed ? 'false' : 'true');
            }

            function buildCleanMenuItem(sourceItem) {
                var sourceLink = getDirectLink(sourceItem);

                if (!sourceLink) {
                    return null;
                }

                var item = document.createElement('li');
                var link = document.createElement('a');
                var submenu = getDirectSubmenu(sourceItem);

                link.href = sourceLink.href || sourceLink.getAttribute('href') || '#';
                link.textContent = sourceLink.textContent.replace(/\s+/g, ' ').trim();

                if (sourceLink.target) {
                    link.target = sourceLink.target;
                }

                if (sourceLink.rel) {
                    link.rel = sourceLink.rel;
                }

                item.appendChild(link);

                if (submenu) {
                    var submenuToggle = document.createElement('button');
                    var cleanSubmenu = document.createElement('ul');

                    submenuToggle.type = 'button';
                    submenuToggle.className = 'classhall-submenu-toggle';
                    submenuToggle.setAttribute('aria-label', 'Toggle submenu');
                    submenuToggle.setAttribute('aria-expanded', 'true');

                    Array.prototype.forEach.call(submenu.children, function (childSourceItem) {
                        var childItem = buildCleanMenuItem(childSourceItem);

                        if (childItem) {
                            cleanSubmenu.appendChild(childItem);
                        }
                    });

                    if (cleanSubmenu.children.length) {
                        item.appendChild(submenuToggle);
                        item.appendChild(cleanSubmenu);
                    }
                }

                return item;
            }

            topMenus.forEach(function (menu) {
                if (menu.classList.contains('classhall-top-menu-ready')) {
                    return;
                }

                var list = getDirectChild(menu, 'ul') || menu.querySelector('ul');

                if (!list) {
                    return;
                }

                var dropdown = document.createElement('ul');
                dropdown.className = 'classhall-top-menu-dropdown';

                Array.prototype.forEach.call(list.children, function (item) {
                    if (
                        item.classList.contains('registertop') ||
                        item.classList.contains('logintop') ||
                        item.classList.contains('classhall-auth-logout') ||
                        item.classList.contains('flexMenu-viewMore') ||
                        item.classList.contains('tabdrop') ||
                        item.classList.contains('hide')
                    ) {
                        return;
                    }

                    var cleanItem = buildCleanMenuItem(item);

                    if (cleanItem) {
                        dropdown.appendChild(cleanItem);
                    }
                });

                if (!dropdown.children.length) {
                    return;
                }

                var toggle = document.createElement('button');
                toggle.type = 'button';
                toggle.className = 'classhall-top-menu-toggle';
                toggle.setAttribute('aria-label', 'Toggle top menu');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.innerHTML = '<span></span><span></span><span></span>';

                menu.appendChild(toggle);
                menu.appendChild(dropdown);
                menu.classList.add('classhall-top-menu-ready');

                toggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    var isOpen = menu.classList.toggle('is-open');
                    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                });

                dropdown.addEventListener('click', function (event) {
                    var submenuToggle = event.target.closest('.classhall-submenu-toggle');

                    if (submenuToggle && dropdown.contains(submenuToggle)) {
                        event.preventDefault();
                        event.stopPropagation();

                        var item = submenuToggle.parentElement;

                        if (item) {
                            toggleSubmenu(item, submenuToggle);
                        }

                        return;
                    }

                    var link = event.target.closest('a');

                    if (!link || !dropdown.contains(link)) {
                        return;
                    }

                    var href = link.getAttribute('href');

                    if (!href || href === '#') {
                        event.preventDefault();
                        event.stopPropagation();
                        return;
                    }

                    event.stopPropagation();
                }, true);
            });
        }

        document.addEventListener('click', function (event) {
            document.querySelectorAll('.social-header .top-menu.is-open').forEach(function (menu) {
                if (!menu.contains(event.target)) {
                    menu.classList.remove('is-open');
                    var toggle = menu.querySelector('.classhall-top-menu-toggle');
                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                }
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') {
                return;
            }

            document.querySelectorAll('.social-header .top-menu.is-open').forEach(function (menu) {
                menu.classList.remove('is-open');
                var toggle = menu.querySelector('.classhall-top-menu-toggle');
                if (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth < 992) {
                return;
            }

            document.querySelectorAll('.social-header .top-menu.is-open').forEach(function (menu) {
                menu.classList.remove('is-open');
                var toggle = menu.querySelector('.classhall-top-menu-toggle');
                if (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        });

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupTopMenu);
        } else {
            setupTopMenu();
        }
    }());
    </script>
    <?php
}
add_action( 'wp_footer', 'classhall_top_menu_mobile_drawer_script', 25 );

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

function classhall_lesson_meta_description_text() {
    if ( ! function_exists( 'is_singular' ) || ! is_singular( 'lesson' ) ) {
        return '';
    }

    $post = get_post();

    if ( ! $post instanceof WP_Post ) {
        return '';
    }

    $description = get_the_excerpt( $post );

    if ( '' === trim( wp_strip_all_tags( $description ) ) ) {
        $description = $post->post_content;
    }

    $description = wp_strip_all_tags( strip_shortcodes( (string) $description ) );
    $description = preg_replace( '/\s+/', ' ', $description );
    $description = trim( html_entity_decode( $description, ENT_QUOTES, 'UTF-8' ) );

    if ( '' === $description ) {
        $description = sprintf(
            '%s lesson note, learning content, and study material on Classhall.',
            get_the_title( $post )
        );
    }

    return wp_trim_words( $description, 28, '' );
}

function classhall_lesson_yoast_meta_description( $description ) {
    $lesson_description = classhall_lesson_meta_description_text();

    return '' !== $lesson_description ? $lesson_description : $description;
}
add_filter( 'wpseo_metadesc', 'classhall_lesson_yoast_meta_description', 20 );

function classhall_quiz_meta_description_text() {
    if ( ! function_exists( 'is_singular' ) || ! is_singular( 'quiz' ) ) {
        return '';
    }

    $post = get_post();

    if ( ! $post ) {
        return '';
    }

    $lesson_id   = (int) get_post_meta( $post->ID, '_lesson_id', true );
    $lesson_name = $lesson_id ? get_the_title( $lesson_id ) : '';
    $description = get_the_excerpt( $post );

    if ( '' === trim( wp_strip_all_tags( $description ) ) ) {
        $description = $post->post_content;
    }

    $description = wp_strip_all_tags( strip_shortcodes( (string) $description ) );
    $description = preg_replace( '/\s+/', ' ', $description );
    $description = trim( html_entity_decode( $description, ENT_QUOTES, 'UTF-8' ) );

    if ( '' === $description ) {
        $description = sprintf(
            '%s quiz%s on Classhall.',
            get_the_title( $post ),
            $lesson_name ? ' for ' . $lesson_name : ''
        );
    }

    return wp_trim_words( $description, 28, '' );
}

function classhall_quiz_yoast_meta_description( $description ) {
    $quiz_description = classhall_quiz_meta_description_text();

    return '' !== $quiz_description ? $quiz_description : $description;
}
add_filter( 'wpseo_metadesc', 'classhall_quiz_yoast_meta_description', 20 );

function classhall_question_meta_description_text() {
    if ( ! function_exists( 'is_singular' ) || ! is_singular( 'question' ) ) {
        return '';
    }

    $post = get_post();

    if ( ! $post instanceof WP_Post ) {
        return '';
    }

    $description = get_the_excerpt( $post );

    if ( '' === trim( wp_strip_all_tags( $description ) ) ) {
        $description = $post->post_content;
    }

    $description = wp_strip_all_tags( strip_shortcodes( classhall_normalize_question_latex_markup( (string) $description ) ) );
    $description = preg_replace( '/\s+/', ' ', $description );
    $description = trim( html_entity_decode( $description, ENT_QUOTES, 'UTF-8' ) );

    if ( '' === $description ) {
        $description = sprintf(
            '%s question and answer practice on Classhall.',
            get_the_title( $post )
        );
    }

    return wp_trim_words( $description, 28, '' );
}

function classhall_question_yoast_meta_description( $description ) {
    $question_description = classhall_question_meta_description_text();

    return '' !== $question_description ? $question_description : $description;
}
add_filter( 'wpseo_metadesc', 'classhall_question_yoast_meta_description', 20 );

function classhall_print_lesson_meta_description_fallback() {
    if ( defined( 'WPSEO_VERSION' ) || class_exists( 'WPSEO_Frontend' ) ) {
        return;
    }

    $description = classhall_lesson_meta_description_text();

    if ( '' === $description ) {
        return;
    }

    echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
}
add_action( 'wp_head', 'classhall_print_lesson_meta_description_fallback', 2 );

function classhall_print_quiz_meta_description_fallback() {
    if ( defined( 'WPSEO_VERSION' ) || class_exists( 'WPSEO_Frontend' ) ) {
        return;
    }

    $description = classhall_quiz_meta_description_text();

    if ( '' === $description ) {
        return;
    }

    echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
}
add_action( 'wp_head', 'classhall_print_quiz_meta_description_fallback', 2 );

function classhall_print_question_meta_description_fallback() {
    if ( defined( 'WPSEO_VERSION' ) || class_exists( 'WPSEO_Frontend' ) ) {
        return;
    }

    $description = classhall_question_meta_description_text();

    if ( '' === $description ) {
        return;
    }

    echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
}
add_action( 'wp_head', 'classhall_print_question_meta_description_fallback', 2 );

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

    if ( classhall_is_frontend_homepage() ) {
        classhall_optimize_homepage_jquery_loading();
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

    if ( function_exists( 'is_front_page' ) && is_front_page() ) {
        classhall_dequeue_homepage_only_plugin_assets();
    }

    if ( classhall_is_sensei_lesson_page() ) {
        classhall_dequeue_lesson_page_plugin_assets();
    }

    if ( classhall_is_sensei_quiz_page() ) {
        classhall_dequeue_quiz_page_plugin_assets();
    }

    if ( classhall_is_sensei_question_page() ) {
        classhall_dequeue_question_page_plugin_assets();
    }

    if ( classhall_is_sensei_subject_page() ) {
        classhall_dequeue_subject_page_non_layout_assets();
    }
}
add_action( 'wp_enqueue_scripts', 'classhall_safe_frontend_performance_cleanup', 1001 );

function classhall_is_sensei_single_content_page() {
    return ! is_admin()
        && function_exists( 'is_singular' )
        && is_singular( array( 'lesson', 'quiz', 'question' ) );
}

function classhall_is_sensei_lesson_style_page() {
    return ! is_admin()
        && function_exists( 'is_singular' )
        && is_singular( array( 'lesson', 'quiz', 'question' ) );
}

function classhall_is_sensei_lesson_page() {
    return ! is_admin()
        && function_exists( 'is_singular' )
        && is_singular( 'lesson' );
}

function classhall_is_sensei_quiz_page() {
    return ! is_admin()
        && function_exists( 'is_singular' )
        && is_singular( 'quiz' );
}

function classhall_is_sensei_question_page() {
    return ! is_admin()
        && function_exists( 'is_singular' )
        && is_singular( 'question' );
}

function classhall_is_sensei_subject_page() {
    return ! is_admin()
        && function_exists( 'is_singular' )
        && is_singular( 'course' );
}

function classhall_dequeue_subject_page_non_layout_assets() {
    if ( ! classhall_is_sensei_subject_page() ) {
        return;
    }

    $has_interactive_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-lms/accordion',
            '<!-- wp:sensei-lms/flashcard',
            '<!-- wp:sensei-lms/hotspots',
            '<!-- wp:sensei-lms/interactive-video',
            '<!-- wp:sensei-lms/question',
            '<!-- wp:sensei-lms/tasklist',
            '<!-- wp:sensei-pro/accordion',
            '<!-- wp:sensei-pro/flashcard',
            '<!-- wp:sensei-pro/hotspots',
            '<!-- wp:sensei-pro/interactive-video',
            '<!-- wp:sensei-pro/question',
            '<!-- wp:sensei-pro/tasklist',
        )
    );
    $has_student_group_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-pro/join-group',
            '<!-- wp:sensei-pro/group-members',
            '<!-- wp:sensei-lms/join-group',
            '<!-- wp:sensei-lms/group-members',
        )
    );
    $has_core_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:',
            'wp-block-',
        )
    );

    $script_handles = array(
        'breeze-prefetch',
        'breeze-prefetch-js',
        'jquery-migrate',
        'jquery-migrate-js',
        'jquery-form',
        'wp-polyfill',
        'wp-util',
        'wp-hooks',
        'wp-i18n',
        'um_frontend_common',
        'um_functions',
        'um_responsive',
        'um-gdpr',
        'um_conditional',
        'um_scripts',
        'um_members',
        'um_profile',
        'um_account',
        'um_modal',
        'um_fileupload',
        'um_jquery_form',
        'um_dropdown',
        'um_raty',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_crop',
        'um_common',
        'um_confirm',
        'um_notice',
        'wc-add-to-cart',
        'woocommerce',
        'wc-cart-fragments',
        'wc-single-product',
        'wc-add-to-cart-variation',
        'wc-order-attribution',
        'wc-order-attribution-js',
        'sourcebuster-js',
        'sourcebuster-js-js',
        'sumodiscounts_frontend_js',
        'sumodiscounts_frontend_js-js',
        'wccp_pro_admin_bar_ajax',
        'wccp_pro_admin_bar_ajax-js',
        'sensei-wcpc-purchase-course',
        'sensei-wcpc-purchase-course-js',
        'sensei-wc-paid-courses-purchase-course',
        'sensei-wc-paid-courses-purchase-course-js',
        'selectWoo',
        'select2',
    );

    if ( ! $has_interactive_blocks ) {
        $script_handles[] = 'sensei-blocks-frontend';
        $script_handles[] = 'sensei-blocks-frontend-js';
        $script_handles[] = 'sensei-interactive-blocks-frontend-script';
    }

    foreach ( $script_handles as $handle ) {
        wp_dequeue_script( $handle );
    }

    $style_handles = array(
        'um_styles',
        'um_common',
        'um_responsive',
        'um_modal',
        'um_misc',
        'um_fileupload',
        'um_old_css',
        'um_ui',
        'um_tipsy',
        'um_raty',
        'um_fonticons_ii',
        'um_fonticons_fa',
        'um_crop',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_confirm',
        'um_notice',
        'um_members',
        'um_profile',
        'um_account',
        'um_default_css',
        'woocommerce-general',
        'woocommerce-layout',
        'woocommerce-smallscreen',
        'woocommerce-inline',
        'select2',
        'wp-components',
        'wc-blocks-style',
        'kleo-woocommerce',
        'classhall-forum',
        'sumodiscounts_enqueue_styles',
        'sensei-wcpc-courses',
        'sensei-wc-paid-courses-blocks',
        'sensei-wcpc-blocks',
    );

    if ( ! $has_core_blocks ) {
        $style_handles[] = 'wp-block-library';
        $style_handles[] = 'wp-block-library-theme';
    }

    if ( ! $has_interactive_blocks ) {
        $style_handles[] = 'sensei-pro-shared-module-sensei-fontawesome';
        $style_handles[] = 'sensei-interactive-blocks-styles';
    }

    if ( ! $has_student_group_blocks ) {
        $style_handles[] = 'sensei-join-group-block-style';
        $style_handles[] = 'sensei-group-members-list-block-style';
    }

    foreach ( $style_handles as $handle ) {
        wp_dequeue_style( $handle );
    }
}
add_action( 'wp_print_styles', 'classhall_dequeue_subject_page_non_layout_assets', 100 );
add_action( 'wp_print_footer_scripts', 'classhall_dequeue_subject_page_non_layout_assets', 0 );

function classhall_dequeue_lesson_page_plugin_assets() {
    if ( ! classhall_is_sensei_lesson_page() ) {
        return;
    }

    $has_interactive_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-lms/accordion',
            '<!-- wp:sensei-lms/flashcard',
            '<!-- wp:sensei-lms/hotspots',
            '<!-- wp:sensei-lms/interactive-video',
            '<!-- wp:sensei-lms/question',
            '<!-- wp:sensei-lms/tasklist',
            '<!-- wp:sensei-pro/accordion',
            '<!-- wp:sensei-pro/flashcard',
            '<!-- wp:sensei-pro/hotspots',
            '<!-- wp:sensei-pro/interactive-video',
            '<!-- wp:sensei-pro/question',
            '<!-- wp:sensei-pro/tasklist',
            '<!-- wp:core/video',
            '<!-- wp:core/embed',
        )
    );
    $has_student_group_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-pro/join-group',
            '<!-- wp:sensei-pro/group-members',
            '<!-- wp:sensei-lms/join-group',
            '<!-- wp:sensei-lms/group-members',
        )
    );

    $script_handles = array(
        'breeze-prefetch',
        'breeze-prefetch-js',
        'jquery-migrate',
        'jquery-migrate-js',
        'jquery-form',
        'wp-polyfill',
        'wp-util',
        'wp-hooks',
        'wp-i18n',
        'underscore',
        'um_frontend_common',
        'um_functions',
        'um_responsive',
        'um-gdpr',
        'um_conditional',
        'um_scripts',
        'um_members',
        'um_profile',
        'um_account',
        'um_modal',
        'um_fileupload',
        'um_jquery_form',
        'um_dropdown',
        'um_raty',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_crop',
        'um_common',
        'um_confirm',
        'um_notice',
        'wc-add-to-cart',
        'woocommerce',
        'wc-cart-fragments',
        'wc-single-product',
        'wc-add-to-cart-variation',
        'wc-order-attribution',
        'wc-order-attribution-js',
        'sourcebuster-js',
        'sourcebuster-js-js',
        'sumodiscounts_frontend_js',
        'sumodiscounts_frontend_js-js',
        'selectWoo',
        'select2',
        'wccp_pro_admin_bar_ajax',
        'wccp_pro_admin_bar_ajax-js',
    );

    if ( ! $has_interactive_blocks ) {
        $script_handles[] = 'sensei-blocks-frontend';
        $script_handles[] = 'sensei-blocks-frontend-js';
        $script_handles[] = 'sensei-interactive-blocks-frontend-script';
    }

    foreach ( $script_handles as $handle ) {
        wp_dequeue_script( $handle );
    }

    $style_handles = array(
        'um_styles',
        'um_common',
        'um_responsive',
        'um_modal',
        'um_misc',
        'um_fileupload',
        'um_old_css',
        'um_ui',
        'um_tipsy',
        'um_raty',
        'um_fonticons_ii',
        'um_fonticons_fa',
        'um_crop',
        'um_common',
        'um_ui',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_confirm',
        'um_notice',
        'um_members',
        'um_profile',
        'um_account',
        'um_default_css',
        'woocommerce-general',
        'woocommerce-layout',
        'woocommerce-smallscreen',
        'woocommerce-inline',
        'select2',
        'wp-components',
        'wc-blocks-style',
        'sensei-wcpc-courses',
        'kleo-woocommerce',
        'classhall-forum',
        'sumodiscounts_enqueue_styles',
        'css-protect.css',
        'print-protection.css',
    );

    if ( ! $has_interactive_blocks ) {
        $style_handles[] = 'sensei-pro-shared-module-sensei-fontawesome';
        $style_handles[] = 'sensei-interactive-blocks-styles';
    }

    if ( ! $has_student_group_blocks ) {
        $style_handles[] = 'sensei-join-group-block-style';
        $style_handles[] = 'sensei-group-members-list-block-style';
    }

    foreach ( $style_handles as $handle ) {
        wp_dequeue_style( $handle );
    }
}
add_action( 'wp_print_styles', 'classhall_dequeue_lesson_page_plugin_assets', 100 );
add_action( 'wp_print_footer_scripts', 'classhall_dequeue_lesson_page_plugin_assets', 0 );

function classhall_dequeue_quiz_page_plugin_assets() {
    if ( ! classhall_is_sensei_quiz_page() ) {
        return;
    }

    $script_handles = array(
        'breeze-prefetch',
        'breeze-prefetch-js',
        'jquery-migrate',
        'jquery-migrate-js',
        'jquery-form',
        'wp-polyfill',
        'wp-util',
        'wp-hooks',
        'wp-i18n',
        'underscore',
        'um_frontend_common',
        'um_functions',
        'um_responsive',
        'um-gdpr',
        'um_conditional',
        'um_scripts',
        'um_members',
        'um_profile',
        'um_account',
        'um_modal',
        'um_fileupload',
        'um_jquery_form',
        'um_dropdown',
        'um_raty',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_crop',
        'um_common',
        'um_confirm',
        'um_notice',
        'wc-add-to-cart',
        'woocommerce',
        'wc-cart-fragments',
        'wc-single-product',
        'wc-add-to-cart-variation',
        'wc-order-attribution',
        'wc-order-attribution-js',
        'sourcebuster-js',
        'sourcebuster-js-js',
        'sumodiscounts_frontend_js',
        'sumodiscounts_frontend_js-js',
        'selectWoo',
        'select2',
        'wccp_pro_admin_bar_ajax',
        'wccp_pro_admin_bar_ajax-js',
    );

    foreach ( $script_handles as $handle ) {
        wp_dequeue_script( $handle );
    }

    $style_handles = array(
        'um_styles',
        'um_common',
        'um_responsive',
        'um_modal',
        'um_misc',
        'um_fileupload',
        'um_old_css',
        'um_ui',
        'um_tipsy',
        'um_raty',
        'um_fonticons_ii',
        'um_fonticons_fa',
        'um_crop',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_confirm',
        'um_notice',
        'um_members',
        'um_profile',
        'um_account',
        'um_default_css',
        'woocommerce-general',
        'woocommerce-layout',
        'woocommerce-smallscreen',
        'woocommerce-inline',
        'select2',
        'wp-components',
        'wc-blocks-style',
        'sensei-wcpc-courses',
        'kleo-woocommerce',
        'classhall-forum',
        'sumodiscounts_enqueue_styles',
        'sensei-pro-shared-module-sensei-fontawesome',
        'sensei-interactive-blocks-styles',
        'sensei-join-group-block-style',
        'sensei-group-members-list-block-style',
    );

    foreach ( $style_handles as $handle ) {
        wp_dequeue_style( $handle );
    }
}
add_action( 'wp_print_styles', 'classhall_dequeue_quiz_page_plugin_assets', 100 );
add_action( 'wp_print_footer_scripts', 'classhall_dequeue_quiz_page_plugin_assets', 0 );

function classhall_dequeue_question_page_plugin_assets() {
    if ( ! classhall_is_sensei_question_page() ) {
        return;
    }

    $script_handles = array(
        'breeze-prefetch',
        'breeze-prefetch-js',
        'jquery-migrate',
        'jquery-migrate-js',
        'jquery-form',
        'wp-polyfill',
        'wp-util',
        'wp-hooks',
        'wp-i18n',
        'underscore',
        'elementor-common',
        'elementor-app-loader',
        'um_frontend_common',
        'um_functions',
        'um_responsive',
        'um-gdpr',
        'um_conditional',
        'um_scripts',
        'um_members',
        'um_profile',
        'um_account',
        'um_modal',
        'um_fileupload',
        'um_jquery_form',
        'um_dropdown',
        'um_raty',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_crop',
        'um_common',
        'um_confirm',
        'um_notice',
        'wc-add-to-cart',
        'woocommerce',
        'wc-cart-fragments',
        'wc-single-product',
        'wc-add-to-cart-variation',
        'wc-order-attribution',
        'wc-order-attribution-js',
        'sourcebuster-js',
        'sourcebuster-js-js',
        'sumodiscounts_frontend_js',
        'sumodiscounts_frontend_js-js',
        'selectWoo',
        'select2',
        'um_select2_locale',
        'wccp_pro_admin_bar_ajax',
        'wccp_pro_admin_bar_ajax-js',
    );

    foreach ( $script_handles as $handle ) {
        wp_dequeue_script( $handle );
    }

    $style_handles = array(
        'elementor-icons',
        'elementor-common',
        'e-theme-ui-light',
        'um_styles',
        'um_common',
        'um_responsive',
        'um_modal',
        'um_misc',
        'um_fileupload',
        'um_old_css',
        'um_ui',
        'um_tipsy',
        'um_raty',
        'um_fonticons_ii',
        'um_fonticons_fa',
        'um_crop',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'um_confirm',
        'um_notice',
        'um_members',
        'um_profile',
        'um_account',
        'um_default_css',
        'woocommerce-general',
        'woocommerce-layout',
        'woocommerce-smallscreen',
        'woocommerce-inline',
        'select2',
        'wp-components',
        'wc-blocks-style',
        'sensei-wcpc-courses',
        'kleo-woocommerce',
        'classhall-forum',
        'sumodiscounts_enqueue_styles',
        'sensei-pro-shared-module-sensei-fontawesome',
        'sensei-interactive-blocks-styles',
        'sensei-join-group-block-style',
        'sensei-group-members-list-block-style',
    );

    foreach ( $style_handles as $handle ) {
        wp_dequeue_style( $handle );
    }
}
add_action( 'wp_print_styles', 'classhall_dequeue_question_page_plugin_assets', 100 );
add_action( 'wp_print_footer_scripts', 'classhall_dequeue_question_page_plugin_assets', 0 );

function classhall_remove_duplicate_child_stylesheets() {
    global $wp_styles;

    if ( is_admin() || ! $wp_styles instanceof WP_Styles ) {
        return;
    }

    $seen = array();

    foreach ( (array) $wp_styles->queue as $handle ) {
        if ( empty( $wp_styles->registered[ $handle ]->src ) ) {
            continue;
        }

        $src = (string) $wp_styles->registered[ $handle ]->src;

        if ( false === strpos( $src, '/themes/kleo-child/' ) ) {
            continue;
        }

        $path = wp_parse_url( $src, PHP_URL_PATH );

        if ( ! $path ) {
            continue;
        }

        $canonical_path = str_replace( '/style.css', '/style.min.css', $path );

        if ( isset( $seen[ $canonical_path ] ) ) {
            wp_dequeue_style( $handle );
            continue;
        }

        $seen[ $canonical_path ] = $handle;
    }
}
add_action( 'wp_print_styles', 'classhall_remove_duplicate_child_stylesheets', 999 );

function classhall_dequeue_homepage_only_plugin_assets() {
    if ( ! classhall_is_frontend_homepage() ) {
        return;
    }

    $script_handles = array(
        'um_frontend_common',
        'um_functions',
        'um_responsive',
        'um-gdpr',
        'um_conditional',
        'um_scripts',
        'um_members',
        'um_profile',
        'um_account',
        'um_modal',
        'um_fileupload',
        'um_jquery_form',
        'um_dropdown',
        'um_raty',
        'um_datetime',
        'um_datetime_date',
        'um_datetime_time',
        'breeze-prefetch',
        'breeze-prefetch-js',
        'jquery-migrate',
        'jquery-migrate-js',
        'wc-add-to-cart',
        'woocommerce',
        'wc-cart-fragments',
        'wc-single-product',
        'wc-add-to-cart-variation',
        'wc-order-attribution',
        'wc-order-attribution-js',
        'sourcebuster-js',
        'sourcebuster-js-js',
        'sensei-blocks-frontend',
        'wp-polyfill',
        'sumodiscounts_frontend_js',
        'sumodiscounts_frontend_js-js',
        'wccp_pro_admin_bar_ajax',
        'wccp_pro_admin_bar_ajax-js',
        'selectWoo',
        'select2',
        'elementor-frontend',
        'elementor-pro-frontend',
        'swiper',
    );

    foreach ( $script_handles as $handle ) {
        wp_dequeue_script( $handle );
    }

    $style_handles = array(
        'um_styles',
        'um_common',
        'um_responsive',
        'um_modal',
        'um_misc',
        'um_fileupload',
        'um_old_css',
        'um_ui',
        'um_tipsy',
        'um_raty',
        'um_fonticons_ii',
        'um_fonticons_fa',
        'um_members',
        'um_profile',
        'um_account',
        'um_default_css',
        'woocommerce-general',
        'woocommerce-layout',
        'woocommerce-smallscreen',
        'woocommerce-inline',
        'select2',
        'elementor-frontend',
        'elementor-post-0',
        'elementor-post-133513',
        'elementor-post-33225',
        'elementor-icons',
        'elementor-icons-shared-0',
        'elementor-icons-fa-solid',
        'elementor-icons-fa-regular',
        'elementor-icons-fa-brands',
        'widget-image',
        'widget-heading',
        'widget-divider',
        'widget-video',
        'widget-icon-box',
        'widget-social-icons',
        'e-swiper',
        'e-animation-grow',
        'e-apple-webkit',
        'kleo-google-fonts',
        'elementor-gf-local-roboto',
        'elementor-gf-local-robotoslab',
        'elementor-gf-local-maitree',
        'swiper',
        'wp-components',
        'wc-blocks-style',
        'sumodiscounts_enqueue_styles',
        'module-frontend',
        'pages-frontend',
        'sensei-frontend',
        'sensei_course_progress-frontend',
        'sensei-pro-shared-module-sensei-fontawesome',
        'sensei-interactive-blocks-styles',
        'sensei-theme-blocks',
        'sensei-sidebar-mobile-menu',
        'sensei-page-block-patterns-style',
        'sensei-join-group-block-style',
        'sensei-group-members-list-block-style',
        'sensei-wcpc-courses',
        'kleo-woocommerce',
        'kleo-sensei',
        'classhall-forum',
        'css-protect.css',
        'print-protection.css',
    );

    foreach ( $style_handles as $handle ) {
        wp_dequeue_style( $handle );
    }
}
add_action( 'wp_print_styles', 'classhall_dequeue_homepage_only_plugin_assets', 100 );
add_action( 'wp_print_footer_scripts', 'classhall_dequeue_homepage_only_plugin_assets', 0 );

function classhall_optimize_homepage_jquery_loading() {
    return;
}

function classhall_start_adsense_output_filter() {
    if ( is_admin() ) {
        return;
    }

    ob_start( 'classhall_strip_adsense_from_html' );
}
add_action( 'template_redirect', 'classhall_start_adsense_output_filter', 0 );

function classhall_strip_adsense_from_html( $html ) {
    if (
        false !== stripos( $html, 'adsbygoogle' )
        || false !== stripos( $html, 'pagead2.googlesyndication.com' )
        || false !== stripos( $html, 'googlesyndication.com/pagead' )
    ) {
        $html = preg_replace( '#<script\b[^>]*\bsrc=["\'][^"\']*(pagead2\.googlesyndication\.com|googlesyndication\.com/pagead)[^"\']*["\'][^>]*>\s*</script>#is', '', $html );
        $html = preg_replace( '#<script\b[^>]*>.*?(adsbygoogle|pagead2\.googlesyndication\.com|googlesyndication\.com/pagead).*?</script>#is', '', $html );
        $html = preg_replace( '#<ins\b[^>]*class=["\'][^"\']*adsbygoogle[^"\']*["\'][^>]*>.*?</ins>#is', '', $html );
    }

    if ( classhall_is_frontend_homepage() ) {
        $html = classhall_strip_homepage_plugin_noise( $html );
    }

    if ( classhall_is_sensei_lesson_page() ) {
        $html = classhall_use_lesson_child_stylesheet_in_html( $html );
        $html = classhall_fix_lesson_uncrawlable_modal_links( $html );
        $html = classhall_add_main_landmark_to_html( $html );
    }

    if ( classhall_is_sensei_quiz_page() ) {
        $html = classhall_use_lesson_child_stylesheet_in_html( $html );
        $html = classhall_strip_quiz_page_plugin_noise( $html );
        $html = classhall_fix_lesson_uncrawlable_modal_links( $html );
        $html = classhall_add_main_landmark_to_html( $html );
    }

    if ( classhall_is_sensei_question_page() ) {
        $html = classhall_use_lesson_child_stylesheet_in_html( $html );
        $html = classhall_strip_question_page_plugin_noise( $html );
        $html = classhall_fix_lesson_uncrawlable_modal_links( $html );
        $html = classhall_add_main_landmark_to_html( $html );
        $html = classhall_fix_question_heading_order_in_html( $html );
        $html = classhall_fix_question_accessibility_html( $html );
    }

    if ( classhall_is_sensei_subject_page() ) {
        $html = classhall_strip_subject_page_non_layout_noise( $html );
        $html = classhall_fix_lesson_uncrawlable_modal_links( $html );
        $html = classhall_add_main_landmark_to_html( $html );
    }

    return $html;
}

function classhall_add_main_landmark_to_html( $html ) {
    return preg_replace_callback(
        '#<div\b([^>]*\bid=["\']main["\'][^>]*)>#i',
        function( $matches ) {
            if ( preg_match( '#\srole=["\']#i', $matches[1] ) ) {
                return $matches[0];
            }

            return '<div' . $matches[1] . ' role="main">';
        },
        $html,
        1
    );
}

function classhall_strip_subject_page_non_layout_noise( $html ) {
    $has_interactive_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-lms/accordion',
            '<!-- wp:sensei-lms/flashcard',
            '<!-- wp:sensei-lms/hotspots',
            '<!-- wp:sensei-lms/interactive-video',
            '<!-- wp:sensei-lms/question',
            '<!-- wp:sensei-lms/tasklist',
            '<!-- wp:sensei-pro/accordion',
            '<!-- wp:sensei-pro/flashcard',
            '<!-- wp:sensei-pro/hotspots',
            '<!-- wp:sensei-pro/interactive-video',
            '<!-- wp:sensei-pro/question',
            '<!-- wp:sensei-pro/tasklist',
        )
    );
    $has_student_group_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-pro/join-group',
            '<!-- wp:sensei-pro/group-members',
            '<!-- wp:sensei-lms/join-group',
            '<!-- wp:sensei-lms/group-members',
        )
    );
    $has_core_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:',
            'wp-block-',
        )
    );

    $script_ids = array(
        'breeze-prefetch-js-extra',
        'breeze-prefetch-js',
        'jquery-migrate-js',
        'jquery-form-js',
        'wp-polyfill-js',
        'wp-util-js',
        'wp-hooks-js',
        'wp-i18n-js',
        'um_frontend_common-js-extra',
        'um_frontend_common-js',
        'um_functions-js',
        'um_responsive-js',
        'um-gdpr-js',
        'um_conditional-js',
        'um_scripts-js-extra',
        'um_scripts-js',
        'um_members-js',
        'um_profile-js',
        'um_account-js',
        'um_modal-js',
        'um_fileupload-js',
        'um_jquery_form-js',
        'um_dropdown-js',
        'um_raty-js',
        'um_crop-js',
        'um_confirm-js',
        'um_notice-js',
        'wc-order-attribution-js-extra',
        'wc-order-attribution-js',
        'sourcebuster-js-js',
        'sumodiscounts_frontend_js-js-extra',
        'sumodiscounts_frontend_js-js',
        'wccp_pro_admin_bar_ajax-js-extra',
        'wccp_pro_admin_bar_ajax-js',
        'sensei-wcpc-purchase-course-js',
        'sensei-wc-paid-courses-purchase-course-js',
    );

    if ( ! $has_interactive_blocks ) {
        $script_ids[] = 'sensei-blocks-frontend-js';
        $script_ids[] = 'sensei-interactive-blocks-frontend-script-js';
    }

    foreach ( $script_ids as $script_id ) {
        $html = preg_replace( '#<script\b[^>]*\bid=["\']' . preg_quote( $script_id, '#' ) . '["\'][^>]*>.*?</script>#is', '', $html );
    }

    $script_patterns = array(
        '/breeze-prefetch-links.min.js',
        '/jquery/jquery-migrate.min.js',
        '/jquery-form/jquery-form.min.js',
        '/ultimate-member/assets/js/',
        '/ultimate-member/assets/libs/',
        '/woocommerce/assets/js/frontend/order-attribution.min.js',
        '/woocommerce/assets/js/sourcebuster/sourcebuster.min.js',
        '/woocommerce/assets/js/frontend/add-to-cart',
        '/woocommerce/assets/js/frontend/cart-fragments',
        '/plugins/sumodiscounts/',
        '/js/admin_bar_ajax.js',
        '/dist/vendor/wp-polyfill.min.js',
        '/dist/hooks.min.js',
        '/dist/i18n.min.js',
        '/sensei-pro/assets/dist/wc-paid-courses/blocks/purchase-course/frontend.js',
    );

    if ( ! $has_interactive_blocks ) {
        $script_patterns[] = '/sensei-lms/assets/dist/blocks/frontend.js';
        $script_patterns[] = '/sensei-pro/assets/dist/interactive-blocks/interactive-blocks-frontend.js';
    }

    foreach ( $script_patterns as $pattern ) {
        $html = preg_replace(
            '#<script\b[^>]*\bsrc=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*</script>#is',
            '',
            $html
        );
    }

    $style_ids = array(
        'um_fontawesome-css',
        'um_fonticons_fa-css',
        'um_fonticons_ii-css',
        'um_account-css',
        'um_notice-css',
        'um_responsive-css',
        'um_common-css',
        'um_modal-css',
        'um_fileupload-css',
        'um_old_css-css',
        'um_misc-css',
        'um_styles-css',
        'woocommerce-general-css',
        'woocommerce-layout-css',
        'woocommerce-smallscreen-css',
        'woocommerce-inline-css',
        'kleo-woocommerce-css',
        'wc-blocks-style-css',
        'wp-components-css',
        'classhall-forum-css',
        'sumodiscounts_enqueue_styles-css',
        'sensei-wcpc-courses-css',
        'sensei-wc-paid-courses-blocks-css',
        'sensei-wcpc-blocks-css',
    );

    if ( ! $has_core_blocks ) {
        $style_ids[] = 'wp-block-library-css';
        $style_ids[] = 'wp-block-library-theme-css';
    }

    if ( ! $has_interactive_blocks ) {
        $style_ids[] = 'sensei-pro-shared-module-sensei-fontawesome-css';
        $style_ids[] = 'sensei-interactive-blocks-styles-css';
    }

    if ( ! $has_student_group_blocks ) {
        $style_ids[] = 'sensei-join-group-block-style-css';
        $style_ids[] = 'sensei-group-members-list-block-style-css';
    }

    foreach ( $style_ids as $style_id ) {
        $html = preg_replace( '#<link\b[^>]*\bid=["\']' . preg_quote( $style_id, '#' ) . '["\'][^>]*>\s*#is', '', $html );
    }

    $style_patterns = array(
        '/ultimate-member/assets/css/',
        '/ultimate-member/assets/libs/',
        '/woocommerce/assets/css/',
        '/plugins/woocommerce/assets/css/',
        '/plugins/sumodiscounts/',
        '/assets/classhall-forum.css',
        '/wp-includes/css/dist/components/style.min.css',
        '/blocks/wc-blocks.css',
        '/sensei-pro/assets/dist/wc-paid-courses/css/sensei-wcpc-courses.css',
        '/sensei-pro/assets/dist/wc-paid-courses/blocks/blocks.css',
    );

    if ( ! $has_core_blocks ) {
        $style_patterns[] = '/wp-includes/css/dist/block-library/style.min.css';
        $style_patterns[] = '/wp-includes/css/dist/block-library/theme.min.css';
    }

    if ( ! $has_interactive_blocks ) {
        $style_patterns[] = '/sensei-pro/assets/dist/shared-module/sensei-fontawesome.css';
        $style_patterns[] = '/sensei-pro/assets/dist/interactive-blocks/interactive-blocks-styles.css';
    }

    if ( ! $has_student_group_blocks ) {
        $style_patterns[] = '/sensei-pro/assets/dist/student-groups/style-join-group-block.css';
        $style_patterns[] = '/sensei-pro/assets/dist/student-groups/style-group-members-list-block.css';
    }

    foreach ( $style_patterns as $pattern ) {
        $html = preg_replace(
            '#<link\b[^>]*\bhref=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*(?:<noscript>.*?</noscript>)?#is',
            '',
            $html
        );
    }

    $html = preg_replace( '#\s*<div id=["\']um_upload_single["\'][^>]*>\s*</div>#is', '', $html );
    $html = preg_replace( '#\s*<div id=["\']um_view_photo["\'][^>]*>.*?</div>\s*</div>\s*</div>#is', '', $html );

    return $html;
}

function classhall_strip_quiz_page_plugin_noise( $html ) {
    $script_ids = array(
        'breeze-prefetch-js-extra',
        'breeze-prefetch-js',
        'jquery-migrate-js',
        'jquery-form-js',
        'wp-polyfill-js',
        'wp-util-js',
        'underscore-js',
        'wp-hooks-js',
        'wp-i18n-js',
        'um_frontend_common-js-extra',
        'um_frontend_common-js',
        'um_functions-js',
        'um_responsive-js',
        'um-gdpr-js',
        'um_conditional-js',
        'um_scripts-js-extra',
        'um_scripts-js',
        'um_members-js',
        'um_profile-js',
        'um_account-js',
        'um_modal-js',
        'um_fileupload-js',
        'um_jquery_form-js',
        'um_dropdown-js',
        'um_raty-js',
        'um_crop-js',
        'um_confirm-js',
        'um_notice-js',
        'wc-order-attribution-js-extra',
        'wc-order-attribution-js',
        'sourcebuster-js-js',
        'sumodiscounts_frontend_js-js-extra',
        'sumodiscounts_frontend_js-js',
        'wccp_pro_admin_bar_ajax-js-extra',
        'wccp_pro_admin_bar_ajax-js',
    );

    foreach ( $script_ids as $script_id ) {
        $html = preg_replace( '#<script\b[^>]*\bid=["\']' . preg_quote( $script_id, '#' ) . '["\'][^>]*>.*?</script>#is', '', $html );
    }

    $script_patterns = array(
        '/js-front-end/breeze-prefetch-links.min.js',
        '/jquery/jquery-migrate.min.js',
        '/jquery-form/jquery-form.min.js',
        '/vendor/wp-polyfill.min.js',
        '/js/wp-util.min.js',
        '/js/underscore.min.js',
        '/dist/hooks.min.js',
        '/dist/i18n.min.js',
        '/ultimate-member/assets/js/',
        '/ultimate-member/assets/libs/',
        '/woocommerce/assets/js/frontend/order-attribution.min.js',
        '/woocommerce/assets/js/sourcebuster/sourcebuster.min.js',
        '/plugins/sumodiscounts/',
        '/js/admin_bar_ajax.js',
    );

    foreach ( $script_patterns as $pattern ) {
        $html = preg_replace(
            '#<script\b[^>]*\bsrc=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*</script>#is',
            '',
            $html
        );
    }

    $style_ids = array(
        'um_fontawesome-css',
        'um_fonticons_fa-css',
        'um_fonticons_ii-css',
        'um_account-css',
        'um_notice-css',
        'um_responsive-css',
        'um_common-css',
        'um_modal-css',
        'um_fileupload-css',
        'um_old_css-css',
        'um_misc-css',
        'um_styles-css',
        'woocommerce-general-css',
        'woocommerce-layout-css',
        'woocommerce-smallscreen-css',
        'woocommerce-inline-css',
        'kleo-woocommerce-css',
        'wc-blocks-style-css',
        'wp-components-css',
        'sensei-wcpc-courses-css',
        'classhall-forum-css',
        'sumodiscounts_enqueue_styles-css',
        'sensei-pro-shared-module-sensei-fontawesome-css',
        'sensei-join-group-block-style-css',
        'sensei-group-members-list-block-style-css',
    );

    foreach ( $style_ids as $style_id ) {
        $html = preg_replace( '#<link\b[^>]*\bid=["\']' . preg_quote( $style_id, '#' ) . '["\'][^>]*>\s*#is', '', $html );
    }

    $style_patterns = array(
        '/ultimate-member/assets/css/',
        '/ultimate-member/assets/libs/',
        '/woocommerce/assets/css/',
        '/plugins/woocommerce/assets/css/',
        '/plugins/sumodiscounts/',
        '/assets/classhall-forum.css',
        '/wp-includes/css/dist/components/style.min.css',
        '/blocks/wc-blocks.css',
        '/css/sensei-wcpc-courses.css',
        '/sensei-pro/assets/dist/shared-module/sensei-fontawesome.css',
        '/sensei-pro/assets/dist/student-groups/style-join-group-block.css',
        '/sensei-pro/assets/dist/student-groups/style-group-members-list-block.css',
    );

    foreach ( $style_patterns as $pattern ) {
        $html = preg_replace(
            '#<link\b[^>]*\bhref=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*#is',
            '',
            $html
        );
    }

    $html = preg_replace( '#\s*<div id=["\']um_upload_single["\'][^>]*>\s*</div>#is', '', $html );
    $html = preg_replace( '#\s*<div id=["\']um_view_photo["\'][^>]*>.*?</div>\s*</div>\s*</div>#is', '', $html );

    return $html;
}

function classhall_strip_question_page_plugin_noise( $html ) {
    $html = classhall_strip_quiz_page_plugin_noise( $html );

    $script_ids = array(
        'elementor-common-js-before',
        'elementor-common-js',
        'elementor-app-loader-js-before',
        'elementor-app-loader-js',
        'um_common-js-extra',
        'um_common-js',
        'um_datetime-js',
        'um_datetime_date-js',
        'um_datetime_time-js',
        'um_select2_locale-js',
        'select2-js',
        'wc-add-to-cart-variation-js-extra',
        'wc-add-to-cart-variation-js',
    );

    foreach ( $script_ids as $script_id ) {
        $html = preg_replace( '#<script\b[^>]*\bid=["\']' . preg_quote( $script_id, '#' ) . '["\'][^>]*>.*?</script>#is', '', $html );
    }

    $script_patterns = array(
        '/elementor/assets/js/common.min.js',
        '/elementor/assets/js/app-loader.min.js',
        '/ultimate-member/assets/libs/select2/',
        '/ultimate-member/assets/libs/pickadate/',
        '/woocommerce/assets/js/frontend/add-to-cart-variation.min.js',
    );

    foreach ( $script_patterns as $pattern ) {
        $html = preg_replace(
            '#<script\b[^>]*\bsrc=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*</script>#is',
            '',
            $html
        );
    }

    $style_ids = array(
        'dashicons-css',
        'elementor-icons-css',
        'elementor-common-css',
        'e-theme-ui-light-css',
        'um_tipsy-css',
        'um_datetime-css',
        'um_datetime_date-css',
        'um_datetime_time-css',
        'um_select2-css',
        'select2-css',
        'jquery-ui-css',
        'sensei-interactive-blocks-styles-css',
    );

    foreach ( $style_ids as $style_id ) {
        $html = preg_replace( '#<link\b[^>]*\bid=["\']' . preg_quote( $style_id, '#' ) . '["\'][^>]*>\s*#is', '', $html );
    }

    $style_patterns = array(
        '/elementor/assets/lib/eicons/css/elementor-icons.min.css',
        '/elementor/assets/css/common.min.css',
        '/elementor/assets/css/theme-light.min.css',
        '/ultimate-member/assets/libs/select2/',
        '/ultimate-member/assets/libs/pickadate/',
        '/ultimate-member/assets/libs/jquery-ui/',
        '/wp-includes/css/dashicons.min.css',
        '/sensei-pro/assets/dist/interactive-blocks/interactive-blocks-styles.css',
    );

    foreach ( $style_patterns as $pattern ) {
        $html = preg_replace(
            '#<link\b[^>]*\bhref=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*#is',
            '',
            $html
        );
    }

    return $html;
}

function classhall_fix_question_heading_order_in_html( $html ) {
    if ( false === stripos( $html, 'classhall-single-question' ) ) {
        return $html;
    }

    $html = preg_replace(
        '#<h4\b([^>]*)>\s*(<(?:b|strong)>Get FREE ACCESS</(?:b|strong)>.*?)</h4>#is',
        '<h3$1>$2</h3>',
        $html
    );
    $html = preg_replace(
        '#<h4\b([^>]*)>\s*(Get FREE ACCESS\s+only\s+on\s+the\s+Tupgrade\s+App.*?)</h4>#is',
        '<h3$1>$2</h3>',
        $html
    );
    $html = preg_replace( '#(<div\b[^>]*\bclass=["\'][^"\']*(?:footer|socket)[^"\']*["\'][^>]*>.*?)<h4\b([^>]*)>#is', '$1<h3$2>', $html );
    $html = preg_replace( '#(<div\b[^>]*\bclass=["\'][^"\']*(?:footer|socket)[^"\']*["\'][^>]*>.*?)</h4>#is', '$1</h3>', $html );
    $html = preg_replace( '#(<footer\b[^>]*>.*?)<h4\b([^>]*)>#is', '$1<h3$2>', $html );
    $html = preg_replace( '#(<footer\b[^>]*>.*?)</h4>#is', '$1</h3>', $html );

    return $html;
}

function classhall_fix_question_accessibility_html( $html ) {
    if ( false === stripos( $html, 'single-question' ) && false === stripos( $html, 'classhall-single-question' ) ) {
        return $html;
    }

    $html = classhall_add_question_link_label_by_pattern( $html, '/(?:kleo-register|register|sign-?up)/i', 'Sign up' );
    $html = classhall_add_question_link_label_by_pattern( $html, '/(?:kleo-login|login|log-?in)/i', 'Log in' );
    $html = classhall_add_question_link_label_by_pattern( $html, '/(?:cart|shopping|basket)/i', 'View cart' );
    $html = classhall_add_question_link_label_by_pattern( $html, '/(?:search|kleo-search)/i', 'Search' );

    $html = preg_replace_callback(
        '#<a\b([^>]*)>(.*?)</a>#is',
        function ( $matches ) {
            $attrs = $matches[1];
            $link  = $matches[0];
            $text  = trim( wp_strip_all_tags( $matches[2] ) );

            if ( preg_match( '/\b(?:aria-label|aria-labelledby|title)=/i', $attrs ) ) {
                return $matches[0];
            }

            if ( '' !== $text ) {
                return $matches[0];
            }

            $label = '';

            if ( preg_match( '/(?:cart|shopping|basket)/i', $link ) ) {
                $label = 'View cart';
            } elseif ( preg_match( '/(?:search|kleo-search)/i', $link ) ) {
                $label = 'Search';
            } elseif ( preg_match( '/(?:register|sign-?up)/i', $link ) ) {
                $label = 'Sign up';
            } elseif ( preg_match( '/(?:login|log-?in)/i', $link ) ) {
                $label = 'Log in';
            } elseif ( preg_match( '/\bhref=["\']([^"\']+)["\']/i', $attrs, $href_match ) ) {
                $href_path = trim( (string) wp_parse_url( html_entity_decode( $href_match[1], ENT_QUOTES, 'UTF-8' ), PHP_URL_PATH ), '/' );
                $label     = $href_path ? ucwords( str_replace( array( '-', '_' ), ' ', basename( $href_path ) ) ) : 'Classhall home';
            } elseif ( preg_match( '/\bhref=["\'][^"\']*\/?["\']/i', $attrs ) ) {
                $label = 'Classhall home';
            }

            if ( '' === $label ) {
                $label = 'Open link';
            }

            return '<a' . $attrs . ' aria-label="' . esc_attr( $label ) . '">' . $matches[2] . '</a>';
        },
        $html
    );

    $html = preg_replace(
        '#<div\b([^>]*\bclass=["\'][^"\']*elementor-widget-wrap[^"\']*["\'][^>]*)>\s*</div>#is',
        '<div$1 role="presentation" aria-hidden="true"></div>',
        $html
    );

    return $html;
}

function classhall_add_question_link_label_by_pattern( $html, $pattern, $label ) {
    return preg_replace_callback(
        '#<a\b([^>]*)>#is',
        function ( $matches ) use ( $pattern, $label ) {
            if ( preg_match( '/\b(?:aria-label|aria-labelledby|title)=/i', $matches[1] ) ) {
                return $matches[0];
            }

            if ( ! preg_match( $pattern, $matches[1] ) ) {
                return $matches[0];
            }

            return '<a' . $matches[1] . ' aria-label="' . esc_attr( $label ) . '">';
        },
        $html
    );
}

function classhall_strip_lesson_page_plugin_noise( $html ) {
    $html = classhall_use_lesson_child_stylesheet_in_html( $html );

    $has_interactive_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-lms/accordion',
            '<!-- wp:sensei-lms/flashcard',
            '<!-- wp:sensei-lms/hotspots',
            '<!-- wp:sensei-lms/interactive-video',
            '<!-- wp:sensei-lms/question',
            '<!-- wp:sensei-lms/tasklist',
            '<!-- wp:sensei-pro/accordion',
            '<!-- wp:sensei-pro/flashcard',
            '<!-- wp:sensei-pro/hotspots',
            '<!-- wp:sensei-pro/interactive-video',
            '<!-- wp:sensei-pro/question',
            '<!-- wp:sensei-pro/tasklist',
            '<!-- wp:core/video',
            '<!-- wp:core/embed',
        )
    );
    $has_student_group_blocks = classhall_current_content_contains_any(
        array(
            '<!-- wp:sensei-pro/join-group',
            '<!-- wp:sensei-pro/group-members',
            '<!-- wp:sensei-lms/join-group',
            '<!-- wp:sensei-lms/group-members',
        )
    );

    $script_patterns = array(
        '/breeze-prefetch-links.min.js',
        '/jquery/jquery-migrate.min.js',
        '/jquery-form/jquery-form.min.js',
        '/vendor/wp-polyfill.min.js',
        '/js/wp-util.min.js',
        '/js/underscore.min.js',
        '/dist/hooks.min.js',
        '/dist/i18n.min.js',
        '/ultimate-member/assets/js/',
        '/ultimate-member/assets/libs/',
        '/woocommerce/assets/js/frontend/order-attribution.min.js',
        '/woocommerce/assets/js/sourcebuster/sourcebuster.min.js',
        '/woocommerce/assets/js/frontend/add-to-cart',
        '/woocommerce/assets/js/frontend/cart-fragments',
        '/plugins/sumodiscounts/',
        '/js/admin_bar_ajax.js',
    );

    if ( ! $has_interactive_blocks ) {
        $script_patterns[] = '/sensei-lms/assets/dist/blocks/frontend.js';
        $script_patterns[] = '/sensei-pro/assets/dist/interactive-blocks/interactive-blocks-frontend.js';
    }

    $script_ids = array(
        'breeze-prefetch-js-extra',
        'breeze-prefetch-js',
        'jquery-migrate-js',
        'wp-polyfill-js',
        'wp-util-js',
        'underscore-js',
        'wp-hooks-js',
        'wp-i18n-js',
        'um_frontend_common-js-extra',
        'um_frontend_common-js',
        'um_functions-js',
        'um_responsive-js',
        'um-gdpr-js',
        'um_conditional-js',
        'um_scripts-js-extra',
        'um_scripts-js',
        'um_members-js',
        'um_profile-js',
        'um_account-js',
        'um_modal-js',
        'um_fileupload-js',
        'um_jquery_form-js',
        'um_dropdown-js',
        'um_raty-js',
        'um_crop-js',
        'um_confirm-js',
        'um_notice-js',
        'wc-order-attribution-js-extra',
        'wc-order-attribution-js',
        'sourcebuster-js-js',
        'sumodiscounts_frontend_js-js-extra',
        'sumodiscounts_frontend_js-js',
    );

    if ( ! $has_interactive_blocks ) {
        $script_ids[] = 'sensei-blocks-frontend-js';
        $script_ids[] = 'sensei-interactive-blocks-frontend-script-js';
    }

    foreach ( $script_ids as $script_id ) {
        $html = preg_replace( '#<script\b[^>]*\bid=["\']' . preg_quote( $script_id, '#' ) . '["\'][^>]*>.*?</script>#is', '', $html );
    }

    foreach ( $script_patterns as $pattern ) {
        $html = preg_replace(
            '#<script\b[^>]*\bsrc=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*</script>#is',
            '',
            $html
        );
    }

    $style_patterns = array(
        '/ultimate-member/assets/css/',
        '/ultimate-member/assets/libs/',
        '/woocommerce/assets/css/',
        '/plugins/woocommerce/assets/css/',
        '/plugins/sumodiscounts/',
        '/assets/classhall-forum.css',
        '/wp-includes/css/dist/components/style.min.css',
        '/wp-includes/css/dist/block-library/style.min.css',
        '/wp-includes/css/dist/block-library/theme.min.css',
        '/css/sensei-wcpc-courses.css',
        '/blocks/wc-blocks.css',
    );

    if ( ! $has_interactive_blocks ) {
        $style_patterns[] = '/sensei-pro/assets/dist/shared-module/sensei-fontawesome.css';
        $style_patterns[] = '/sensei-pro/assets/dist/interactive-blocks/interactive-blocks-styles.css';
    }

    if ( ! $has_student_group_blocks ) {
        $style_patterns[] = '/sensei-pro/assets/dist/student-groups/style-join-group-block.css';
        $style_patterns[] = '/sensei-pro/assets/dist/student-groups/style-group-members-list-block.css';
    }

    foreach ( $style_patterns as $pattern ) {
        $html = preg_replace(
            '#<link\b[^>]*\bhref=["\'][^"\']*' . preg_quote( $pattern, '#' ) . '[^"\']*["\'][^>]*>\s*(?:<noscript>.*?</noscript>)?#is',
            '',
            $html
        );
    }

    $html = classhall_async_lesson_non_layout_styles( $html );

    $html = preg_replace( '#\s*<div id=["\']um_upload_single["\'][^>]*>\s*</div>#is', '', $html );
    $html = preg_replace( '#\s*<div id=["\']um_view_photo["\'][^>]*>.*?</div>\s*</div>\s*</div>#is', '', $html );

    return $html;
}

function classhall_use_lesson_child_stylesheet_in_html( $html ) {
    return $html;
}

function classhall_async_lesson_non_layout_styles( $html ) {
    return $html;
}

function classhall_async_lesson_known_render_styles( $html ) {
    return $html;
}

function classhall_fix_lesson_uncrawlable_modal_links( $html ) {
    return preg_replace_callback(
        '#<a\b(?=[^>]*\bdata-action=["\']um_remove_modal["\'])([^>]*)>#i',
        function( $matches ) {
            $attrs = preg_replace(
                '#\bhref=["\']javascript:void\(0\);?["\']#i',
                'href="#"',
                $matches[1]
            );

            return '<a' . $attrs . '>';
        },
        $html
    );
}

function classhall_replace_lesson_non_layout_stylesheet_with_preload( $matches ) {
    if ( false !== strpos( $matches[0], 'data-classhall-lesson-async-style' ) ) {
        return $matches[0];
    }

    $href  = html_entity_decode( $matches[1], ENT_QUOTES, get_bloginfo( 'charset' ) );
    $media = 'all';

    if ( preg_match( '#\bmedia=["\']([^"\']+)["\']#i', $matches[0], $media_match ) ) {
        $media = $media_match[1];
    }

    return sprintf(
        '<link rel="preload" href="%1$s" as="style" onload="this.onload=null;this.rel=\'stylesheet\';this.media=\'%2$s\'" data-classhall-lesson-async-style="non-layout">' . "\n" .
        '<noscript><link rel="stylesheet" href="%1$s" media="%2$s"></noscript>',
        esc_url( $href ),
        esc_attr( $media )
    );
}

function classhall_strip_homepage_plugin_noise( $html ) {
    $script_ids = array(
        'wccp_pro_disable_selection',
        'wccp_pro_css_disable_selection',
        'wccp_pro_disable_hot_keys',
        'wccp_pro_disable_Right_Click',
        'wccp_pro_alert_message',
        'wccp_pro_class_exclusion',
        'wccp_pro_disable_drag_images',
        'apply_class_exclusion',
        'breeze-prefetch-js-extra',
        'breeze-prefetch-js',
        'jquery-migrate-js',
        'wccp_pro_admin_bar_ajax-js-extra',
        'wccp_pro_admin_bar_ajax-js',
        'sumodiscounts_frontend_js-js-extra',
        'sumodiscounts_frontend_js-js',
        'sensei-blocks-frontend-js',
        'wp-polyfill-js',
        'sourcebuster-js-js',
        'wc-order-attribution-js-extra',
        'wc-order-attribution-js',
    );

    foreach ( $script_ids as $script_id ) {
        $html = preg_replace( '#<script\b[^>]*\bid=["\']' . preg_quote( $script_id, '#' ) . '["\'][^>]*>.*?</script>#is', '', $html );
    }

    $async_style_handles = array(
        'css-protect.css',
        'print-protection.css',
        'wc-blocks-style',
        'sumodiscounts_enqueue_styles',
        'elementor-gf-local-roboto',
        'elementor-gf-local-robotoslab',
        'elementor-gf-local-maitree',
        'elementor-icons-shared-0',
        'elementor-icons-fa-solid',
        'elementor-icons-fa-regular',
        'elementor-icons-fa-brands',
        'kleo-google-fonts',
    );

    foreach ( $async_style_handles as $style_handle ) {
        $html = preg_replace(
            '#<link\b[^>]*\bdata-classhall-async-style=["\']' . preg_quote( $style_handle, '#' ) . '["\'][^>]*>\s*(?:<noscript>.*?</noscript>)?#is',
            '',
            $html
        );
    }

    $html = preg_replace( '#<style\b[^>]*>\s*\.pro-wccp:before\b.*?</style>#is', '', $html );
    $html = preg_replace( '#\s*<div id=["\']um_upload_single["\'][^>]*>\s*</div>#is', '', $html );
    $html = preg_replace( '#\s*<div id=["\']um_view_photo["\'][^>]*>.*?</div>\s*</div>\s*</div>#is', '', $html );
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
function classhall_remove_guest_lesson_prerequisite_warning() {
    if ( is_admin() || is_user_logged_in() || ! function_exists( 'is_singular' ) || ! is_singular( 'lesson' ) ) {
        return;
    }

    remove_action( 'sensei_single_lesson_content_inside_before', array( 'Sensei_Lesson', 'prerequisite_complete_message' ), 20 );
}
add_action( 'wp', 'classhall_remove_guest_lesson_prerequisite_warning', 20 );

function classhall_remove_top_lesson_signup_notice() {
    if ( is_admin() || ! function_exists( 'is_singular' ) || ! is_singular( 'lesson' ) ) {
        return;
    }

    remove_action( 'sensei_single_lesson_content_inside_before', array( 'Sensei_Lesson', 'course_signup_link' ), 30 );
}
add_action( 'wp', 'classhall_remove_top_lesson_signup_notice', 20 );

function classhall_get_lesson_subject_id( $lesson_id ) {
    $lesson_id = absint( $lesson_id );

    if ( ! $lesson_id ) {
        return 0;
    }

    $sensei = function_exists( 'Sensei' ) ? Sensei() : null;

    if ( is_object( $sensei ) && isset( $sensei->lesson ) && method_exists( $sensei->lesson, 'get_course_id' ) ) {
        $course_id = absint( $sensei->lesson->get_course_id( $lesson_id ) );

        if ( $course_id ) {
            return $course_id;
        }
    }

    return absint( get_post_meta( $lesson_id, '_lesson_course', true ) );
}

function classhall_should_show_lesson_subscription_notice( $lesson_id = 0 ) {
    if ( ! function_exists( 'is_singular' ) || ! is_singular( 'lesson' ) ) {
        return false;
    }

    if ( function_exists( 'sensei_can_user_view_lesson' ) && sensei_can_user_view_lesson() ) {
        return false;
    }

    return true;
}

function classhall_get_subject_subscription_url( $subject_id ) {
    $subject_id = absint( $subject_id );

    if ( ! $subject_id ) {
        return '';
    }

    $product_ids = array_filter( array_map( 'absint', (array) get_post_meta( $subject_id, '_course_woocommerce_product', false ) ) );

    foreach ( $product_ids as $product_id ) {
        if ( 'publish' === get_post_status( $product_id ) && 'product' === get_post_type( $product_id ) ) {
            return get_permalink( $product_id );
        }
    }

    $sensei = function_exists( 'Sensei' ) ? Sensei() : null;

    if ( is_object( $sensei ) && isset( $sensei->lesson ) && method_exists( $sensei->lesson, 'get_take_course_url' ) ) {
        $take_course_url = (string) $sensei->lesson->get_take_course_url( $subject_id );

        if ( '' !== $take_course_url ) {
            return $take_course_url;
        }
    }

    return get_permalink( $subject_id );
}

function classhall_lesson_subscription_notice( $lesson_id ) {
    if ( ! classhall_should_show_lesson_subscription_notice( $lesson_id ) ) {
        return;
    }

    $subject_id   = classhall_get_lesson_subject_id( $lesson_id );
    $subject_name = $subject_id ? get_the_title( $subject_id ) : __( 'this subject', 'kleo-child' );
    $subject_link = $subject_id ? classhall_get_subject_subscription_url( $subject_id ) : '';

    if ( $subject_link ) {
        $subject_html = '<a href="' . esc_url( $subject_link ) . '">' . esc_html( $subject_name ) . '</a>';
    } else {
        $subject_html = esc_html( $subject_name );
    }

    echo '<div class="sensei-message info classhall-lesson-subscription-notice">';
    printf(
        wp_kses_post( __( 'Subscribe for %s to unlock all lessons and assessments on this subject.', 'kleo-child' ) ),
        $subject_html // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    );
    echo '</div>';
}
add_action( 'subscribe_alert', 'classhall_lesson_subscription_notice', 4 );


// Display Classhall features to visitors who cannot access the full lesson.
function add_signup_notice_after_excerpt_two() 
{
    if ( classhall_should_show_lesson_subscription_notice( get_the_ID() ) ) {
        echo '<div class="sign-up-notice-after-excerpt-two">You are viewing an excerpt of this lesson. Subscribing to the subject will give you access to the following:<br>
            <ul>
            <li>Complete and <b>updated scheme of work</b> for the entire curriculum of subject</li>
            <li>Media-rich and illustrative <b>lesson notes</b> for first, second and third terms</li>
            <li>Standard <b>evaluation questions</b>, assignments and activities aligned with lesson objectives</li>
            <li>WAEC and NECO-grade termly <b>examination questions</b></li>
            <li>Multiple-choice <b>quizzes</b> and interactive exercises designed to enhance recall and mastery</li>
            <li>Opportunity to teach this subject online and <b>earn extra income</b> (for teachers)</li>
            <li>User-led discussions on subject</li>
            <li>NEW: <b>Download</b> content in <b>MS Word</b> document format (Premium plan only)</li>
            </ul>
            </div>';} 
}
add_action('subscribe_alert','add_signup_notice_after_excerpt_two', 5 );
add_action( 'subscribe_alert', 'classhall_lesson_subscription_notice', 6 );

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

function classhall_email_live_classes_cta( $order, $sent_to_admin, $plain_text = false, $email = null ) {
    if ( $sent_to_admin || ! $order instanceof WC_Order ) {
        return;
    }

    $email_id = is_object( $email ) && ! empty( $email->id ) ? (string) $email->id : '';
    $allowed_email_ids = array(
        'customer_completed_order',
        'customer_processing_order',
        'customer_on_hold_order',
        'customer_invoice',
        'customer_completed_renewal_order',
        'customer_processing_renewal_order',
        'customer_renewal_invoice',
    );

    if ( $email_id && ! in_array( $email_id, $allowed_email_ids, true ) ) {
        return;
    }

    $subjects = classhall_email_order_subjects_for_live_classes( $order );

    if ( empty( $subjects ) ) {
        return;
    }

    $subject = reset( $subjects );
    $role    = classhall_email_normalized_user_role( $order->get_user_id() );
    $copy    = classhall_email_live_classes_copy( $role, $subject );

    if ( empty( $copy['message'] ) ) {
        return;
    }

    if ( $plain_text ) {
        echo "\n" . wp_strip_all_tags( $copy['heading'] ) . "\n";
        echo wp_strip_all_tags( $copy['message'] ) . "\n";
        echo esc_url_raw( $copy['url'] ) . "\n";
        return;
    }

    ?>
    <div style="margin:24px 0 0;padding:18px 20px;border:1px solid #dbeafe;border-radius:10px;background:#f8fbff;">
        <h2 style="margin:0 0 8px;color:#0b2e66;font-size:18px;line-height:1.35;"><?php echo esc_html( $copy['heading'] ); ?></h2>
        <p style="margin:0 0 14px;color:#334155;font-size:15px;line-height:1.6;"><?php echo esc_html( $copy['message'] ); ?></p>
        <p style="margin:0;">
            <a href="<?php echo esc_url( $copy['url'] ); ?>" style="display:inline-block;padding:11px 16px;border-radius:8px;background:#2563eb;color:#ffffff;font-weight:700;text-decoration:none;"><?php echo esc_html( $copy['button'] ); ?></a>
        </p>
    </div>
    <?php
}
add_action( 'woocommerce_email_after_order_table', 'classhall_email_live_classes_cta', 20, 4 );

function classhall_email_live_classes_copy( $role, $subject ) {
    $label       = $subject['label'];
    $subject_url = $subject['url'];

    if ( 'teacher' === $role ) {
        return array(
            'heading'  => sprintf( __( 'Teach %s live on Classhall', 'kleo-child' ), $label ),
            'message'  => sprintf( __( 'You can earn extra income by creating a live class for %s and helping students who need extra classes on this subject.', 'kleo-child' ), $label ),
            'button'   => __( 'Create a live class', 'kleo-child' ),
            'url'      => apply_filters( 'classhall_live_teacher_dashboard_url', home_url( '/teacher-live-classes/' ), $subject ),
        );
    }

    if ( in_array( $role, array( 'student', 'parent' ), true ) ) {
        return array(
            'heading'  => sprintf( __( 'Need extra help with %s?', 'kleo-child' ), $label ),
            'message'  => sprintf( __( 'You can book a Classhall live teacher for %s when live classes are available for this subject.', 'kleo-child' ), $label ),
            'button'   => __( 'Find live classes', 'kleo-child' ),
            'url'      => $subject_url,
        );
    }

    return array(
        'heading'  => sprintf( __( 'Live classes for %s', 'kleo-child' ), $label ),
        'message'  => sprintf( __( 'Classhall Live Classes can help students get extra clarification in %s, and teachers can also create live classes for this subject.', 'kleo-child' ), $label ),
        'button'   => __( 'Explore live classes', 'kleo-child' ),
        'url'      => $subject_url,
    );
}

function classhall_email_normalized_user_role( $user_id ) {
    $role = $user_id ? get_user_meta( $user_id, 'role_of_user', true ) : '';
    $role = strtolower( trim( (string) $role ) );
    $role = str_replace( array( '-', '_' ), ' ', $role );

    if ( false !== strpos( $role, 'teacher' ) ) {
        return 'teacher';
    }

    if ( false !== strpos( $role, 'parent' ) ) {
        return 'parent';
    }

    if ( false !== strpos( $role, 'student' ) ) {
        return 'student';
    }

    if ( false !== strpos( $role, 'school owner' ) ) {
        return 'school_owner';
    }

    if ( false !== strpos( $role, 'school admin' ) ) {
        return 'school_admin';
    }

    return '';
}

function classhall_email_order_subjects_for_live_classes( $order ) {
    $subjects = array();

    foreach ( $order->get_items() as $item ) {
        if ( ! $item instanceof WC_Order_Item_Product || classhall_email_is_live_class_order_item( $item ) ) {
            continue;
        }

        $subject = classhall_email_subject_from_order_item( $item );

        if ( ! $subject || empty( $subject['label'] ) || empty( $subject['url'] ) ) {
            continue;
        }

        $key = sanitize_title( $subject['label'] );
        if ( ! isset( $subjects[ $key ] ) ) {
            $subjects[ $key ] = $subject;
        }
    }

    return array_values( $subjects );
}

function classhall_email_is_live_class_order_item( $item ) {
    $product_id   = absint( $item->get_product_id() );
    $variation_id = absint( $item->get_variation_id() );

    if ( $item->get_meta( '_classhall_live_class_id', true ) || $item->get_meta( 'Live Class', true ) ) {
        return true;
    }

    return ( $product_id && get_post_meta( $product_id, '_classhall_live_class_id', true ) )
        || ( $variation_id && get_post_meta( $variation_id, '_classhall_live_class_id', true ) );
}

function classhall_email_subject_from_order_item( $item ) {
    $course_id = classhall_email_course_id_from_order_item( $item );

    if ( $course_id ) {
        return array(
            'label' => classhall_email_subject_label( get_the_title( $course_id ) ),
            'url'   => get_permalink( $course_id ),
        );
    }

    $label = classhall_email_subject_label( $item->get_name() );

    if ( '' === $label ) {
        return null;
    }

	return array(
		'label' => $label,
		'url'   => add_query_arg( 'live_class_search', $label, home_url( '/live-classes/' ) ),
	);
}

function classhall_email_course_id_from_order_item( $item ) {
    $product_ids = array_filter( array_map( 'absint', array( $item->get_variation_id(), $item->get_product_id() ) ) );

    foreach ( $product_ids as $product_id ) {
        if ( 'course' === get_post_type( $product_id ) ) {
            return $product_id;
        }
    }

    $meta_keys = array( '_course_id', 'course_id', '_course', 'course', '_lesson_course', '_sensei_course', '_wc_paid_courses_course' );

    foreach ( $meta_keys as $meta_key ) {
        $item_course_id = absint( $item->get_meta( $meta_key, true ) );
        if ( $item_course_id && 'course' === get_post_type( $item_course_id ) ) {
            return $item_course_id;
        }
    }

    foreach ( $product_ids as $product_id ) {
        foreach ( $meta_keys as $meta_key ) {
            $product_course_id = absint( get_post_meta( $product_id, $meta_key, true ) );
            if ( $product_course_id && 'course' === get_post_type( $product_course_id ) ) {
                return $product_course_id;
            }
        }
    }

    $names = array( $item->get_name() );
    foreach ( $product_ids as $product_id ) {
        $names[] = get_the_title( $product_id );
    }

    foreach ( array_filter( array_unique( $names ) ) as $name ) {
        $course_id = classhall_email_find_course_by_name( $name );
        if ( $course_id ) {
            return $course_id;
        }
    }

    return 0;
}

function classhall_email_find_course_by_name( $name ) {
    if ( ! post_type_exists( 'course' ) ) {
        return 0;
    }

    $candidates = array_unique(
        array_filter(
            array(
                trim( wp_strip_all_tags( (string) $name ) ),
                classhall_email_subject_label( $name ),
            )
        )
    );

    foreach ( $candidates as $candidate ) {
        $course = get_page_by_path( sanitize_title( $candidate ), OBJECT, 'course' );
        if ( $course instanceof WP_Post ) {
            return absint( $course->ID );
        }
    }

    $courses = get_posts(
        array(
            'post_type'      => 'course',
            'post_status'    => 'publish',
            'posts_per_page' => 300,
            'fields'         => 'ids',
        )
    );

    foreach ( $courses as $course_id ) {
        $course_title = get_the_title( $course_id );
        foreach ( $candidates as $candidate ) {
            if ( classhall_email_titles_match( $candidate, $course_title ) ) {
                return absint( $course_id );
            }
        }
    }

    return 0;
}

function classhall_email_titles_match( $left, $right ) {
    $left  = classhall_email_normalized_title( $left );
    $right = classhall_email_normalized_title( $right );

    if ( '' === $left || '' === $right ) {
        return false;
    }

    return $left === $right || false !== strpos( $left, $right ) || false !== strpos( $right, $left );
}

function classhall_email_normalized_title( $title ) {
    $title = strtolower( wp_strip_all_tags( (string) $title ) );
    $title = preg_replace( '/\b(1|one)\s*(month|term|year)\b/i', ' ', $title );
    $title = preg_replace( '/\b(subscription|bundle|plan|access|all subjects|subject)\b/i', ' ', $title );
    $title = preg_replace( '/[^a-z0-9]+/', ' ', $title );
    return trim( preg_replace( '/\s+/', ' ', $title ) );
}

function classhall_email_subject_label( $label ) {
    $label = wp_strip_all_tags( html_entity_decode( (string) $label, ENT_QUOTES, 'UTF-8' ) );
    $label = preg_replace( '/\b(1|one)\s*(month|term|year)\b/i', ' ', $label );
    $label = preg_replace( '/\b(subscription|bundle|plan|access|all subjects)\b/i', ' ', $label );
    $label = preg_replace( '/\b(JSS|SSS|SS)\s*-?\s*[123]\b/i', ' ', $label );
    $label = preg_replace( '/\bPrimary\s*-?\s*[1-6]\b/i', ' ', $label );
    $label = trim( preg_replace( '/\s+/', ' ', $label ) );

    if ( '' === $label ) {
        return '';
    }

    return function_exists( 'mb_convert_case' ) ? mb_convert_case( strtolower( $label ), MB_CASE_TITLE, 'UTF-8' ) : ucwords( strtolower( $label ) );
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
        $labels = isset( $args['labels'] ) && is_array( $args['labels'] ) ? $args['labels'] : array();
        $args['labels'] = array_merge(
            $labels,
            array(
                'name'               => __( 'Subjects', 'kleo-child' ),
                'singular_name'      => __( 'Subject', 'kleo-child' ),
                'menu_name'          => __( 'Subjects', 'kleo-child' ),
                'name_admin_bar'     => __( 'Subject', 'kleo-child' ),
                'add_new_item'       => __( 'Add New Subject', 'kleo-child' ),
                'edit_item'          => __( 'Edit Subject', 'kleo-child' ),
                'new_item'           => __( 'New Subject', 'kleo-child' ),
                'view_item'          => __( 'View Subject', 'kleo-child' ),
                'search_items'       => __( 'Search Subjects', 'kleo-child' ),
                'not_found'          => __( 'No subjects found', 'kleo-child' ),
                'not_found_in_trash' => __( 'No subjects found in Trash', 'kleo-child' ),
                'all_items'          => __( 'All Subjects', 'kleo-child' ),
            )
        );
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

function classhall_homepage_cache_path() {
    return WP_CONTENT_DIR . '/cache/classhall-homepage-cache/index.html';
}

function classhall_can_cache_homepage_response() {
    if ( is_admin() || is_user_logged_in() || ! is_front_page() ) {
        return false;
    }

    if ( defined( 'BREEZE_VERSION' ) || class_exists( 'Breeze_Options_Reader' ) ) {
        return false;
    }

    $method = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) ) : '';

    if ( 'GET' !== $method || ! empty( $_SERVER['QUERY_STRING'] ) ) {
        return false;
    }

    $cookie_header = isset( $_SERVER['HTTP_COOKIE'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_COOKIE'] ) ) : '';

    foreach ( array( 'wordpress_logged_in_', 'wordpress_sec_', 'wp-postpass_', 'comment_author_', 'woocommerce_items_in_cart', 'wp_woocommerce_session_' ) as $cookie_name ) {
        if ( false !== stripos( $cookie_header, $cookie_name ) ) {
            return false;
        }
    }

    return true;
}

function classhall_start_homepage_cache_capture() {
    if ( ! classhall_can_cache_homepage_response() ) {
        return;
    }

    ob_start( 'classhall_store_homepage_cache' );
}
add_action( 'template_redirect', 'classhall_start_homepage_cache_capture', -1 );

function classhall_store_homepage_cache( $html ) {
    if ( ! is_string( $html ) || strlen( $html ) < 1024 || false === stripos( $html, '</html>' ) ) {
        return $html;
    }

    if (
        false !== stripos( $html, 'There has been a critical error' )
        || false !== stripos( $html, 'wp-die-message' )
    ) {
        return $html;
    }

    $cache_file = classhall_homepage_cache_path();
    $cache_dir  = dirname( $cache_file );

    if ( ! wp_mkdir_p( $cache_dir ) || ! is_writable( $cache_dir ) ) {
        return $html;
    }

    $tmp_file = wp_tempnam( 'classhall-homepage-cache' );

    if ( ! $tmp_file ) {
        return $html;
    }

    file_put_contents( $tmp_file, $html, LOCK_EX ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
    @rename( $tmp_file, $cache_file ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged, WordPress.WP.AlternativeFunctions.rename_rename

    return $html;
}

function classhall_purge_homepage_cache() {
    $cache_file = classhall_homepage_cache_path();

    if ( is_readable( $cache_file ) ) {
        wp_delete_file( $cache_file );
    }
}
add_action( 'save_post', 'classhall_purge_homepage_cache' );
add_action( 'deleted_post', 'classhall_purge_homepage_cache' );
add_action( 'switch_theme', 'classhall_purge_homepage_cache' );
add_action( 'customize_save_after', 'classhall_purge_homepage_cache' );

function classhall_optimize_common_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' !== $relation_type ) {
        return $urls;
    }

    foreach ( array( 'https://fonts.gstatic.com' ) as $href ) {
        $urls[] = array(
            'href'        => $href,
            'crossorigin' => 'anonymous',
        );
    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'classhall_optimize_common_resource_hints', 20, 2 );

function classhall_refine_yoast_organization_schema( $data ) {
    if ( is_admin() || ! is_front_page() || ! is_array( $data ) ) {
        return $data;
    }

    $data['@type'] = 'EducationalOrganization';

    if ( empty( $data['logo'] ) ) {
        $data['logo'] = home_url( '/wp-content/uploads/2026/07/classhall-logo.png' );
    }

    return $data;
}
add_filter( 'wpseo_schema_organization', 'classhall_refine_yoast_organization_schema', 20 );



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
    return;
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

function classhall_sensei_lesson_order_profile( $lesson ) {
    static $profiles = array();

    $lesson_id = is_object( $lesson ) && isset( $lesson->ID ) ? absint( $lesson->ID ) : absint( $lesson );
    $title     = '';

    if ( $lesson_id && isset( $profiles[ $lesson_id ] ) ) {
        return $profiles[ $lesson_id ];
    }

    if ( is_object( $lesson ) && isset( $lesson->post_title ) ) {
        $title = (string) $lesson->post_title;
    } elseif ( $lesson_id ) {
        $title = get_the_title( $lesson_id );
    }

    $lesson_type = $lesson_id ? strtolower( trim( (string) get_post_meta( $lesson_id, '_classhall_lesson_type', true ) ) ) : '';
    $lesson_type = str_replace( array( '-', ' ' ), '_', $lesson_type );

    $is_scheme = in_array( $lesson_type, array( 'scheme_of_work', 'scheme' ), true )
        || preg_match( '/\bscheme\s+of\s+work\b/i', $title );

    $exam_term = 99;
    $is_exam   = in_array( $lesson_type, array( 'examination', 'exam' ), true )
        || preg_match( '/\b(first|second|third)\s+term\s+examination(?:\s*\(mock\))?\b/i', $title, $exam_matches );

    if ( ! empty( $exam_matches[1] ) ) {
        $term_map  = array(
            'first'  => 1,
            'second' => 2,
            'third'  => 3,
        );
        $exam_term = isset( $term_map[ strtolower( $exam_matches[1] ) ] ) ? $term_map[ strtolower( $exam_matches[1] ) ] : 99;
    }

    if ( 'examination' === $lesson_type || 'exam' === $lesson_type ) {
        $meta_exam_term = strtolower( trim( (string) get_post_meta( $lesson_id, '_classhall_exam_term', true ) ) );
        $meta_term_map  = array(
            '1'      => 1,
            'first'  => 1,
            '2'      => 2,
            'second' => 2,
            '3'      => 3,
            'third'  => 3,
        );

        if ( isset( $meta_term_map[ $meta_exam_term ] ) ) {
            $exam_term = $meta_term_map[ $meta_exam_term ];
        }
    }

    $is_mock = $lesson_id && get_post_meta( $lesson_id, '_classhall_exam_mock', true )
        ? true
        : (bool) preg_match( '/\(\s*mock\s*\)/i', $title );

    if ( $is_scheme ) {
        $priority = 0;
    } elseif ( $is_exam ) {
        $priority = 2;
    } else {
        $priority = 1;
    }

    $profile = array(
        'priority'  => $priority,
        'exam_term' => $exam_term,
        'is_mock'   => $is_mock ? 1 : 0,
        'lesson_id' => $lesson_id,
    );

    if ( $lesson_id ) {
        $profiles[ $lesson_id ] = $profile;
    }

    return $profile;
}

function classhall_compare_sensei_lessons_by_natural_order( $lesson_1, $lesson_2 ) {
    $lesson_1_order = classhall_sensei_lesson_order_profile( $lesson_1 );
    $lesson_2_order = classhall_sensei_lesson_order_profile( $lesson_2 );

    foreach ( array( 'priority', 'exam_term', 'is_mock', 'lesson_id' ) as $order_key ) {
        if ( $lesson_1_order[ $order_key ] === $lesson_2_order[ $order_key ] ) {
            continue;
        }

        return ( $lesson_1_order[ $order_key ] < $lesson_2_order[ $order_key ] ) ? -1 : 1;
    }

    return 0;
}

function classhall_sort_sensei_course_lessons_by_natural_order( $lessons ) {
    if ( is_admin() || ! is_array( $lessons ) || count( $lessons ) < 2 ) {
        return $lessons;
    }

    usort( $lessons, 'classhall_compare_sensei_lessons_by_natural_order' );

    return $lessons;
}
add_filter( 'sensei_course_get_lessons', 'classhall_sort_sensei_course_lessons_by_natural_order', 99 );

function classhall_is_sensei_course_lesson_query( $query ) {
    if ( ! $query instanceof WP_Query ) {
        return false;
    }

    $post_type = $query->get( 'post_type' );

    if ( 'lesson' !== $post_type && array( 'lesson' ) !== $post_type ) {
        return false;
    }

    $meta_query = $query->get( 'meta_query' );

    if ( ! is_array( $meta_query ) ) {
        return false;
    }

    foreach ( $meta_query as $meta_clause ) {
        if ( is_array( $meta_clause ) && isset( $meta_clause['key'] ) && '_lesson_course' === $meta_clause['key'] ) {
            return true;
        }
    }

    return false;
}

function classhall_prepare_sensei_course_lesson_query_order( $query ) {
    if ( is_admin() || ! classhall_is_sensei_course_lesson_query( $query ) ) {
        return;
    }

    $query->set( 'meta_key', '' );
    $query->set( 'orderby', 'ID' );
    $query->set( 'order', 'ASC' );
}
add_action( 'pre_get_posts', 'classhall_prepare_sensei_course_lesson_query_order', 99 );

function classhall_sort_sensei_course_lesson_query_results( $posts, $query ) {
    if ( is_admin() || ! classhall_is_sensei_course_lesson_query( $query ) ) {
        return $posts;
    }

    return classhall_sort_sensei_course_lessons_by_natural_order( $posts );
}
add_filter( 'posts_results', 'classhall_sort_sensei_course_lesson_query_results', 99, 2 );
