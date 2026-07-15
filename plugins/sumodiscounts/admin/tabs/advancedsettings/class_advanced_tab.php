<?php

class FP_SP_Advanced_Tab {

    // Construct the Class
    public function __construct() {
        add_action( 'init' , array( $this , 'sp_sumopricing_add_option_admin_settings' ) , 103 ) ;
        // make it appear in Discount System Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_array' , array( $this , 'initialize_tab' ) ) ;
        // Initialize Admin Fields in Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_fp_sp_advanced_tab' , array( $this , 'initialize_visual_appearance_admin_fields' ) ) ;

        // Initialize Update Fields in Discounts Rule
        add_action( 'woocommerce_update_options_fp_sp_advanced_tab' , array( $this , 'update_data_from_admin_fields' ) ) ;
    }

    public static function initialize_tab( $settings_tab ) {
        if( ! is_array( $settings_tab ) ) {
            $settings_tab = ( array ) $settings_tab ;
        }
        $settings_tab[ 'fp_sp_advanced_tab' ] = __( 'Experimental' , 'sumodiscounts' ) ;
        return array_filter( $settings_tab ) ;
    }

    // Initialize Admin Fields in Discount System

    public static function initialize_admin_fields() {
        $sumo_reward_points_settings_title = array() ;
        $sumo_reward_points_enable_disable = array() ;
        $discount_label                    = array() ;
        $discount_type                     = array() ;
        $discount_value                    = array() ;
        $sumo_reward_points_settings_end   = array() ;
        if( class_exists( 'FPRewardSystem' ) && get_option( 'rs_referral_activated' , 'no' ) == 'yes' ) {
            $sumo_reward_points_settings_title = array(
                'name' => __( 'SUMO Reward Points Referral Discounts' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_reward_points_settings'
                    ) ;
            $sumo_reward_points_enable_disable = array(
                'name'     => __( 'Award Discounts to Referred Person' , 'sumodiscounts' ) ,
                'tip'      => '' ,
                'id'       => 'sumo_award_discounts_to_referred_person' ,
                'std'      => 'no' ,
                'type'     => 'checkbox' ,
                'newids'   => 'sumo_award_discounts_to_referred_person' ,
                'desc_tip' => true ,
                    ) ;
            $discount_label                    = array(
                'name'    => __( 'Discount label' , 'sumodiscounts' ) ,
                'type'    => 'text' ,
                'tip'     => '' ,
                'id'      => 'srp_discount_label' ,
                'std'     => __( 'Discount' , 'sumodiscounts' ) ,
                'default' => __( 'Discount' , 'sumodiscounts' ) ,
                'newids'  => 'srp_discount_label'
                    ) ;
            $discount_type                     = array(
                'name'    => __( 'Discount Type' , 'sumodiscounts' ) ,
                'type'    => 'select' ,
                'id'      => 'srp_discount_type' ,
                'newids'  => 'srp_discount_type' ,
                'class'   => 'srp_discount_type' ,
                'options' => array(
                    'percent'        => __( 'Percentage' , 'sumodiscounts' ) ,
                    'fixed_discount' => __( 'Fixed Discount' , 'sumodiscounts' ) ,
                ) ,
                'std'     => 'percent' ,
                'default' => 'percent' ,
                    ) ;
            $discount_value                    = array(
                'name'    => __( 'Discount Value' , 'sumodiscounts' ) ,
                'type'    => 'number' ,
                'tip'     => '' ,
                'id'      => 'srp_discount_value' ,
                'std'     => '' ,
                'default' => '' ,
                'step'    => 'any' ,
                'newids'  => 'srp_discount_value'
                    ) ;
            $sumo_reward_points_settings_end   = array( 'type' => 'sectionend' ,
                'id'   => '_sp_reward_points_settings' ) ;
        }
        return apply_filters( 'woocommerce_fp_sp_advanced_tab' , array(
            array(
                'name' => __( 'Experimental' , 'sumodiscounts' ) ,
                'desc' => '<b>' . __( 'Note : ' , 'sumodiscounts' ) . '</b>' . __( 'The Features/Options present in this tab are for Experimental purposes. Some of the Features may not work.' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_advanced_tab_settings'
            ) ,
            array(
                'name' => __( 'Quantity Discounts Table Settings' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_quantity_pricing_advanced_settings'
            ) ,
            array(
                'name'    => __( 'Enable Quantity pricing table in single product page' , 'sumodiscounts' ) ,
                'type'    => 'select' ,
                'id'      => 'sumo_enable_quantity_pricing_table' ,
                'newids'  => 'sumo_enable_quantity_pricing_table' ,
                'class'   => 'sumo_enable_quantity_pricing_table' ,
                'options' => array(
                    'enable'  => __( 'Enable' , 'sumodiscounts' ) ,
                    'disable' => __( 'Disable' , 'sumodiscounts' ) ,
                ) ,
                'std'     => 'disable' ,
                'default' => 'disable' ,
            ) ,
            array(
                'name'    => __( 'Range label' , 'sumodiscounts' ) ,
                'type'    => 'text' ,
                'tip'     => '' ,
                'id'      => 'sp_qty_range_label' ,
                'std'     => __( 'Range' , 'sumodiscounts' ) ,
                'default' => __( 'Range' , 'sumodiscounts' ) ,
                'newids'  => 'sp_qty_range_label'
            ) ,
            array(
                'name'    => __( 'Price label' , 'sumodiscounts' ) ,
                'type'    => 'text' ,
                'tip'     => '' ,
                'id'      => 'sp_qty_price_label' ,
                'std'     => __( 'Price' , 'sumodiscounts' ) ,
                'default' => __( 'Price' , 'sumodiscounts' ) ,
                'newids'  => 'sp_qty_price_label'
            ) ,
            array(
                'name'    => __( 'Show Table' , 'sumodiscounts' ) ,
                'type'    => 'select' ,
                'tip'     => '' ,
                'id'      => 'sp_range_price_table' ,
                'options' => array(
                    'before' => __( 'Before' , 'sumodiscounts' ) ,
                    'after'  => __( 'After' , 'sumodiscounts' ) ,
                ) ,
                'std'     => __( 'before' , 'sumodiscounts' ) ,
                'default' => __( 'before' , 'sumodiscounts' ) ,
                'newids'  => 'sp_range_price_table'
            ) ,
            array(
                'name'        => __( 'Custom Message Before the Quantity Range in the Table' , 'sumodiscounts' ) ,
                'type'        => 'text' ,
                'tip'         => '' ,
                'id'          => 'rs_custom_message_for_quantity' ,
                'placeholder' => __( 'Enter the Message ' , 'sumodiscounts' ) ,
                'newids'      => 'rs_custom_message_for_quantity'
            ) ,
            array(
                'name'        => __( 'Custom Message Before the Price Range in the Table' , 'sumodiscounts' ) ,
                'type'        => 'text' ,
                'tip'         => '' ,
                'id'          => 'rs_custom_message_for_before_price' ,
                'placeholder' => __( 'Enter the Message ' , 'sumodiscounts' ) ,
                'newids'      => 'rs_custom_message_for_before_price'
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_quantity_pricing_advanced_settings'
            ) ,
            array(
                'name' => __( 'Sitewide Discounts Settings' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_sitewide_pricing_advanced_settings'
            ) ,
            array(
                'name'     => __( 'Consider Sitewide Discount Products as Sale Products' , 'sumodiscounts' ) ,
                'tip'      => '' ,
                'id'       => 'sumo_consider_swdis_as_sale_products' ,
                'std'      => 'no' ,
                'type'     => 'checkbox' ,
                'newids'   => 'sumo_consider_swdis_as_sale_products' ,
                'desc_tip' => true ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_sitewide_pricing_advanced_settings'
            ) ,
            array(
                'name' => __( 'Woocommerce Coupon Settings' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_woocommerce_coupon_settings'
            ) ,
            array(
                'name'     => __( 'Allow Woocommerce Coupons on Cart when SUMO Discounts available' , 'sumodiscounts' ) ,
                'tip'      => '' ,
                'id'       => 'sumo_allow_wc_coupons_on_cart' ,
                'std'      => 'yes' ,
                'default'  => 'yes' ,
                'type'     => 'checkbox' ,
                'newids'   => 'sumo_allow_wc_coupons_on_cart' ,
                'desc_tip' => true ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_woocommerce_coupon_settings'
            ) ,
            array(
                'name' => __( 'Troubleshoot Settings' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => 'sp_troubleshoot_settings'
            ) ,
            array(
                'name'     => __( 'Enter the value for Filter Hook Priority to Display Discounted Price for Category Discount (when conflict with other plugins)' , 'sumodiscounts' ) ,
                'id'       => 'sumo_filter_priority_value_on_cart' ,
                'std'      => 0 ,
                'default'  => 0 ,
                'type'     => 'number' ,
                'newids'   => 'sumo_filter_priority_value_on_cart' ,
                'desc_tip' => true ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => 'sp_troubleshoot_settings'
            ) ,
            $sumo_reward_points_settings_title , $sumo_reward_points_enable_disable , $discount_label , $discount_type , $discount_value , $sumo_reward_points_settings_end
                ) ) ;
    }

    // Make it appear visually in Discount System

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields( self::initialize_admin_fields() ) ;
    }

    // Update the Settings of Discount System

    public static function update_data_from_admin_fields() {
        woocommerce_update_options( self::initialize_admin_fields() ) ;
    }

    public static function sp_sumopricing_add_option_admin_settings() {
        foreach( self::initialize_admin_fields() as $setting )
            if( isset( $setting[ 'newids' ] ) && isset( $setting[ 'std' ] ) ) {
                add_option( $setting[ 'newids' ] , $setting[ 'std' ] ) ;
            }
    }

}

new FP_SP_Advanced_Tab() ;
