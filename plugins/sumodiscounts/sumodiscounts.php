<?php

/*
 * Plugin Name: SUMO Discounts
 * Plugin URI:
 * Description: SUMO Discounts is a Complete WooCommerce Discount System
 * Version: 5.2
 * Author:Fantastic Plugins
 * Author URI:http://fantasticplugins.com/
 *
 */

class SUMODiscounts {

    // construct the class of SUMO Discounts
    public function __construct() {

        // Avoid Fatal Error on SUMO Discounts
        include_once (ABSPATH . 'wp-admin/includes/plugin.php') ;

        // Avoid Header Already Sent Problem by declaring that function in init hook
        add_action( 'init' , array( $this , 'avoid_header_already_sent_problem' ) , 10 ) ;

        // Init the active function to make sure woocommerce is active
        add_action( 'init' , array( $this , 'check_woocommerce_is_active' ) ) ;

        // Screenids alteration
        if( isset( $_GET[ 'page' ] ) ) {
            if( ($_GET[ 'page' ] == 'sumodiscounts' ) ) {
                add_filter( 'woocommerce_screen_ids' , array( $this , 'allow_css_from_woocommerce' ) , 1 ) ;
            }
        }
        // Translate Ready Function initialize it in plugins_loaded hook
        add_action( 'plugins_loaded' , array( $this , 'translate_ready' ) ) ;

        add_action( 'admin_enqueue_scripts' , array( $this , 'fp_sumo_pricing_admin_scritps' ) ) ;
        add_action( 'wp_enqueue_scripts' , array( $this , 'fp_sumo_pricing_wp_scritps' ) ) ;

        if( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            add_action( 'init' , array( $this , 'sumo_include_file_for_frontend' ) ) ;
            include_once('inc/gdpr/class-sumo-discount-privacy.php') ;
        }

        register_activation_hook( __FILE__ , array( $this , 'update_drag_and_drop_options' ) , 999 ) ;
    }

    /*
     * Check WooCommerce is Active or Not
     */

    public static function check_woocommerce_is_active() {

        if( is_multisite() ) {
// This Condition is for Multi Site WooCommerce Installation
            if( ! is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) && ( ! is_plugin_active( 'woocommerce/woocommerce.php' )) ) {
                if( is_admin() ) {
                    $variable = "<div class='error'><p> SUMO Discounts will not work until WooCommerce Plugin is Activated. Please Activate the WooCommerce Plugin. </p></div>" ;
                    echo $variable ;
                }
                return ;
            }
        } else {
// This Condition is for Single Site WooCommerce Installation
            if( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
                if( is_admin() ) {
                    $variable = "<div class='error'><p> SUMO Discounts will not work until WooCommerce Plugin is Activated. Please Activate the WooCommerce Plugin. </p></div>" ;
                    echo $variable ;
                }
                return ;
            }
        }
    }

    /*
     * Avoid Header Already Sent Problem
     */

    public static function avoid_header_already_sent_problem() {
        ob_start() ;
    }

    /*
     *  Allow CSS from WooCommerce
     */

    public static function allow_css_from_woocommerce() {
        global $my_admin_page ;

        $newscreenids = get_current_screen() ;

        if( isset( $_GET[ 'page' ] ) ) {
            if( ($_GET[ 'page' ] == 'sumodiscounts' ) ) {
                $array[] = $newscreenids->id ;
                return $array ;
            } else {
                $array[] = '' ;
                return $array ;
            }
        }
    }

    /*
     * Translate Ready
     */

    public static function translate_ready() {
        load_plugin_textdomain( 'sumodiscounts' , false , dirname( plugin_basename( __FILE__ ) ) . '/languages' ) ;
    }

    public static function fp_sumo_pricing_admin_scritps() {

        wp_enqueue_script( 'jquery' ) ;
        wp_enqueue_script( 'jquery-ui-sortable' ) ;
        wp_enqueue_script( 'jquery-ui-datepicker' ) ;
        wp_enqueue_script( 'jquery-ui-datepicker' ) ;
        wp_register_script( 'date_picker_initialize' , plugins_url( '/js/sp_datepicker.js' , __FILE__ ) , array( 'jquery' , 'jquery-ui-datepicker' ) ) ;
        wp_enqueue_script( 'date_picker_initialize' ) ;

        // register ui script
        wp_enqueue_script( 'jquery-ui-accordion' ) ;
        if( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'sumodiscounts' ) {
            wp_register_script( 'sweetalert2' , plugins_url( '/js/sweetalert2/sweetalert2.min.js' , __FILE__ ) , array( 'jquery' ) ) ;
            wp_register_style( 'sweetalert2' , plugins_url( '/js/sweetalert2/sweetalert2.min.css' , __FILE__ ) ) ;

            wp_enqueue_script( 'jquery-sweet-alert' ) ;
            wp_enqueue_style( 'css-sweet-alert' ) ;
        }
    }

    public static function fp_sumo_pricing_wp_scritps() {

        wp_register_script( 'sumodiscounts_frontend_js' , plugins_url( '/js/frontend_js.js' , __FILE__ ) , array( 'jquery' ) ) ;
        wp_localize_script( 'sumodiscounts_frontend_js' , 'fp_sd_args' , array(
            'sd_ajax_nonce'                         => wp_create_nonce( "secure_ajax_sd" ) ,
            'ajaxurl'                               => admin_url( 'admin-ajax.php' ) ,
            'checkout_page'                         => is_checkout() ,
            'check_quantity_pricing_enabled'        => ! empty( get_option( 'sumo_pricing_tab_sorting') ) && is_array( get_option( 'sumo_pricing_tab_sorting' ) ) ? 'yes' : 'no' ,
            'check_quantity_discount_table_enabled' => get_option( 'sumo_enable_quantity_pricing_table' , 'disable' ) ,
        ) ) ;
        wp_enqueue_script( 'sumodiscounts_frontend_js' ) ;
        wp_register_style( 'sumodiscounts_enqueue_styles' , plugins_url( 'sumodiscounts/css/mywpstyle.css' ) ) ;
        wp_enqueue_style( 'sumodiscounts_enqueue_styles' ) ;
    }

    public static function sumo_include_file_for_frontend() {

        include_once('admin/class_fpsp_admin_menu.php') ;

        include_once('inc/common_functions_for_sumopricing.php') ;

        include_once('inc/get_applied_discount_rule.php') ;

        include_once('inc/main_functions_for_sumodiscount.php') ;

        include_once('inc/quantitypricing/sumo_functionality_for_quantity_pricing_tab.php') ;

        include_once('inc/carttotalpricing/sumo_functionality_for_cart_total_pricing_tab.php') ;

        include_once('inc/specialofferpricing/sumo_functionality_for_specialofferpricing_tab.php') ;

        include_once('inc/userrolepricing/sumo_functionality_for_userrolepricing_tab.php') ;

        if( class_exists( 'SUMOMemberships' ) ) {
            if( sumo_get_membership_levels() ) {
                include_once('inc/membershippricing/sumo_functionality_for_membershippricing_tab.php') ;
            }
        }

        if( class_exists( 'FPRewardSystem' ) ) {

            include_once('inc/rewardpointpricing/sumo_functionality_for_rewardpointspricing_tab.php') ;
        }

        include_once('inc/categoryproductpricing/sumo-functionality-for-category-discount.php') ;

        include_once('inc/categoryproductpricing/sumo_functionality_for_categoryproductpricing_tab.php') ;
    }

    public static function update_drag_and_drop_options() {

        add_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' , array( '0' => 'fp_sp_userrole_pricing_settings' , '1' => 'sumo_cat_pro_pricing' , '2' => 'sumo_membership_pricing' , '3' => 'fp_sp_rpelpricing' ) ) ;

        $sitewide_priority = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;

        if( ! in_array( 'sumo_cat_pro_pricing' , $sitewide_priority ) ) {
            $new_array = array_merge( $sitewide_priority , array( 'sumo_cat_pro_pricing' ) ) ;
            update_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' , $new_array ) ;
        }

        add_option( 'drag_and_drop_rule_priority_for_bulk_discounts' , array( "0" => "sumo_quantity_pricing" , "1" => "sumo_offer_pricing" ) ) ;

        add_option( 'sp_cart_discount_fees_label' , 'Cart Discount' ) ;
    }

}

new SUMODiscounts() ;
