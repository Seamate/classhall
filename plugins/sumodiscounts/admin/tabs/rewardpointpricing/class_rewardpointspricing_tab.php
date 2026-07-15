<?php

class SP_RewardPoints_Pricing {

    // Construct the Class
    public function __construct() {

        add_action( 'init' , array( $this , 'sumo_reward_pricing_default_settings' ) , 103 ) ; // call the init function to update the default settings on page load
        // make it appear in Discount System Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_array' , array( $this , 'initialize_tab' ) ) ;
        // Initialize Admin Fields in Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_fp_sp_rpelpricing' , array( $this , 'initialize_visual_appearance_admin_fields' ) ) ;

        // Initialize Update Fields in Discounts Rule
        add_action( 'woocommerce_update_options_fp_sp_rpelpricing' , array( $this , 'update_data_from_admin_fields' ) ) ;

        add_action( 'woocommerce_admin_field_fp_sp_reward_point_pricing_rule' , array( $this , 'discount_cart_function' ) ) ;

        add_action( 'wp_ajax_testing' , array( 'SP_RewardPoints_Pricing' , 'process_ajax_request_in_discount' ) ) ;


        add_action( 'woocommerce_admin_field_sp_incproducts_at_rwpp' , array( $this , 'function_sp_incproducts_at_rwpp' ) ) ;

        add_action( 'woocommerce_admin_field_sp_excproducts_at_rwpp' , array( $this , 'function_sp_excproducts_at_rwpp' ) ) ;
    }

    public static function jQuery_function() {
        global $woocommerce ;
        ?>
        <script type="text/javascript">
            jQuery( document ).ready( function () {
        <?php if ( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                    jQuery( '#sp_inccategories_at_rwpp' ).chosen() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).chosen() ;
                    jQuery( '#sp_inctags_at_rwpp' ).chosen() ;
                    jQuery( '#sp_exctags_at_rwpp' ).chosen() ;
        <?php } else { ?>
                    jQuery( '#sp_inccategories_at_rwpp' ).select2() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).select2() ;
                    jQuery( '#sp_inctags_at_rwpp' ).select2() ;
                    jQuery( '#sp_exctags_at_rwpp' ).select2() ;
        <?php } ?>
                if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '1' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '2' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '3' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '4' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '5' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '6' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '7' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '8' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '9' ) {
                    jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).show() ;
                }
                jQuery( '#sp_rewardpoints_pricing_for_products' ).change( function () {
                    if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '1' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '2' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '3' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '4' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '5' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '6' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '7' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '8' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_rewardpoints_pricing_for_products' ).val() == '9' ) {
                        jQuery( '#sp_incproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_rwpp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_rwpp' ).closest( 'tr' ).show() ;
                    }
                } ) ;
            } ) ;
        </script>
        <?php
    }

    public static function initialize_tab( $settings_tab ) {
        if ( ! is_array( $settings_tab ) ) {
            $settings_tab = ( array ) $settings_tab ;
        }
        $settings_tab[ 'fp_sp_rpelpricing' ] = __( 'SUMO Reward Points Discounts' , 'sumodiscounts' ) ;
        return array_filter( $settings_tab ) ;
    }

    // Initialize Admin Fields in Discount System

    public static function initialize_admin_fields() {
        global $woocommerce ;
        $product_categories = array() ;
        $all_categories     = get_categories( array( 'hide_empty' => 0 , 'taxonomy' => 'product_cat' ) ) ;
        foreach ( $all_categories as $each_category ) {
            $product_categories[ $each_category->term_id ] = $each_category->name ;
        }
        $product_tags = array() ;
        $all_tags     = get_categories( array( 'hide_empty' => 0 , 'taxonomy' => 'product_tag' ) ) ;
        foreach ( $all_tags as $each_tag ) {
            $product_tags[ $each_tag->term_id ] = $each_tag->name ;
        }
        return apply_filters( 'woocommerce_discounts_cart_discount' , array(
            array(
                'name' => __( 'SUMO Reward Points Earning Level Discounts (Requires SUMO Reward Points Plugin)' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_reward_points_rule_settings'
            ) ,
            array(
                'name'     => __( 'Apply Reward Point Discount for Product with Sale Price' , 'sumodiscounts' ) ,
                'type'     => 'checkbox' ,
                'id'       => 'sumo_enable_reward_points_pricing_when_product_has_sale_price' ,
                'newids'   => 'sumo_enable_reward_points_pricing_when_product_has_sale_price' ,
                'std'      => 'yes' ,
                'default'  => 'yes' ,
                'desc_tip' => true ,
                'desc'     => __( 'If enabled, Reward Point Discounts will be applicable for products with sale price' , 'sumodiscounts' ) ,
            ) ,
            array(
                'name'     => __( 'Rule Valid from' , 'sumodiscounts' ) ,
                'type'     => 'text' ,
                'class'    => 'sp_date' ,
                'id'       => 'sumo_reward_points_pricing_from_date' ,
                'newids'   => 'sumo_reward_points_pricing_from_date' ,
                'std'      => '' ,
                'default'  => '' ,
                'desc_tip' => true ,
                'desc'     => __( 'The Date from which the Discounts are valid' , 'sumodiscounts' ) ,
            ) ,
            array(
                'name'     => __( 'Rule Valid Till' , 'sumodiscounts' ) ,
                'type'     => 'text' ,
                'class'    => 'sp_date' ,
                'id'       => 'sumo_reward_points_pricing_to_date' ,
                'newids'   => 'sumo_reward_points_pricing_to_date' ,
                'std'      => '' ,
                'default'  => '' ,
                'desc_tip' => true ,
                'desc'     => __( 'The Date till which the Discounts are valid' , 'sumodiscounts' ) ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_reward_points_rule_settings'
            ) ,
            array(
                'name' => __( 'Rule is valid on the following days' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_rw_points_pricing_allowed_weekdays' ,
                'desc' => __( 'If you want to provide discounts only on certain days of a Week then select only those days.' , 'sumodiscounts' ) ,
            ) ,
            array(
                'name'    => __( 'Monday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_monday_at_rwp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_monday_at_rwp' ,
            ) ,
            array(
                'name'    => __( 'Tuesday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_tuesday_at_rwp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_tuesday_at_rwp' ,
            ) ,
            array(
                'name'    => __( 'Wednesday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_wednesday_at_rwp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_wednesday_at_rwp' ,
            ) ,
            array(
                'name'    => __( 'Thursday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_thursday_at_rwp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_thursday_at_rwp' ,
            ) ,
            array(
                'name'    => __( 'Friday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_friday_at_rwp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_friday_at_rwp' ,
            ) ,
            array(
                'name'    => __( 'Saturday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_saturday_at_rwp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_saturday_at_rwp' ,
            ) ,
            array(
                'name'    => __( 'Sunday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_sunday_at_rwp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_sunday_at_rwp' ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_rw_points_pricing_allowed_weekdays'
            ) ,
            array(
                'name' => __( 'Applicable Discounts for' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_rw_points_pricing_product_category_filter'
            ) ,
            array(
                'name'     => __( 'Select Products' , 'sumodiscounts' ) ,
                'type'     => 'select' ,
                'tip'      => '' ,
                'id'       => 'sp_rewardpoints_pricing_for_products' ,
                'options'  => array(
                    '1' => __( "All Products" , "sumodiscounts" ) ,
                    '2' => __( "Include Products" , "sumodiscounts" ) ,
                    '3' => __( "Exclude Products" , "sumodiscounts" ) ,
                    '4' => __( "All Categories" , "sumodiscounts" ) ,
                    '5' => __( "Include Categories" , "sumodiscounts" ) ,
                    '6' => __( "Exclude Categories" , "sumodiscounts" ) ,
                    '7' => __( "All Tags" , "sumodiscounts" ) ,
                    '8' => __( "Include Tags" , "sumodiscounts" ) ,
                    '9' => __( "Exclude Tags" , "sumodiscounts" )
                ) ,
                'std'      => '1' ,
                'default'  => '1' ,
                'newids'   => 'sp_rewardpoints_pricing_for_products' ,
                'desc_tip' => true ,
                'desc'     => __( 'By Default, discounts will be provided for All Products.If you want to restrict the discounts only to specific products/categories then, that can be done using the options provided' , 'sumodiscounts' )
            ) ,
            array(
                'type' => 'sp_incproducts_at_rwpp'
            ) ,
            array(
                'type' => 'sp_excproducts_at_rwpp'
            ) ,
            array(
                'name'     => __( 'Include Categories' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_inccategories_at_rwpp' ,
                'options'  => $product_categories ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_inccategories_at_rwpp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'name'     => __( 'Exclude Categories' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_exccategories_at_rwpp' ,
                'options'  => $product_categories ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_exccategories_at_rwpp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'name'     => __( 'Include Tags' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_inctags_at_rwpp' ,
                'options'  => $product_tags ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_inctags_at_rwpp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'name'     => __( 'Exclude Tags' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_exctags_at_rwpp' ,
                'options'  => $product_tags ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_exctags_at_rwpp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'name'     => __( 'Rule Priority' , 'sumodiscounts' ) ,
                'id'       => 'fp_sp_rp_pricing_rule_priority' ,
                'css'      => '' ,
                'std'      => '1' ,
                'class'    => '' ,
                'default'  => '1' ,
                'newids'   => 'fp_sp_rp_pricing_rule_priority' ,
                'type'     => 'select' ,
                'options'  => array(
                    '1' => __( 'First Matched Rule' , 'sumodiscounts' ) ,
                    '2' => __( 'Last Matched Rule' , 'sumodiscounts' ) ,
                    '3' => __( 'Minimum Reward' , 'sumodiscounts' ) ,
                    '4' => __( 'Maximum Reward' , 'sumodiscounts' ) ,
                ) ,
                'desc_tip' => true ,
                'desc'     => __( 'When multiple rules are created and When there is a overlap for a user based on the rule priority discount will be applied' , 'sumodiscounts' )
            ) ,
            array(
                'name'     => __( 'Select Earn points based on' , 'sumodiscounts' ) ,
                'id'       => 'fp_sp_rp_pricing_select_earn_points_based_on' ,
                'css'      => '' ,
                'std'      => '1' ,
                'class'    => '' ,
                'default'  => '1' ,
                'newids'   => 'fp_sp_rp_pricing_select_earn_points_based_on' ,
                'type'     => 'select' ,
                'options'  => array(
                    '1' => __( 'Based on Total Points' , 'sumodiscounts' ) ,
                    '2' => __( 'Based on Current Points' , 'sumodiscounts' )
                ) ,
                'desc_tip' => true ,
            ) ,
            array(
                'type' => 'fp_sp_reward_point_pricing_rule' ,
            ) ,
            array(
                'type' => 'section_end' ,
                'id'   => '_sp_rw_points_pricing_product_category_filter'
            )
                ) ) ;
    }

    /*
     * Initialize the Default Settings by looping this function
     */

    public static function sumo_reward_pricing_default_settings() {
        global $woocommerce ;
        foreach ( self::initialize_admin_fields() as $setting )
            if ( isset( $setting[ 'newids' ] ) && isset( $setting[ 'std' ] ) ) {
                add_option( $setting[ 'newids' ] , $setting[ 'std' ] ) ;
            }
    }

    // Make it appear visually in Discount System

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields( self::initialize_admin_fields() ) ;
    }

    // Update the Settings of Discount System

    public static function update_data_from_admin_fields() {
        woocommerce_update_options( self::initialize_admin_fields() ) ;
        $fp_sp_reward_point_pricing_rule = isset( $_POST[ 'fp_sp_reward_point_pricing_rule' ] ) ? $_POST[ 'fp_sp_reward_point_pricing_rule' ] : '' ;
        update_option( 'fp_sp_reward_point_pricing_rule' , $fp_sp_reward_point_pricing_rule ) ;
        $sp_excproducts_at_rwpp          = isset( $_POST[ 'sp_excproducts_at_rwpp' ] ) ? $_POST[ 'sp_excproducts_at_rwpp' ] : '' ;
        $sp_incproducts_at_rwpp          = isset( $_POST[ 'sp_incproducts_at_rwpp' ] ) ? $_POST[ 'sp_incproducts_at_rwpp' ] : '' ;
        update_option( 'sp_excproducts_at_rwpp' , $sp_excproducts_at_rwpp ) ;
        update_option( 'sp_incproducts_at_rwpp' , $sp_incproducts_at_rwpp ) ;
    }

    public static function discount_cart_function() {
        self::discount_cart_table_function() ;
    }

    // Donation Rewards Option
    public static function discount_cart_table_function() {
        global $woocommerce ;
        echo self::jQuery_function() ;
        ?>

        <table class="widefat fixed donationrule_rewards" cellspacing="0">
            <thead>
                <tr>
                    <th class="manage-column column-columnname" scope="col"><?php _e( 'Minimum Points' , 'sumodiscounts' ) ; ?></th>
                    <th class="manage-column column-columnname" scope="col"><?php _e( 'Maximum Points' , 'sumodiscounts' ) ; ?></th>
                    <th class="manage-column column-columnname-link" scope="col"><?php _e( 'Discount Type' , 'sumodiscounts' ) ; ?></th>
                    <th class="manage-column column-columnname-product" scope="col"><?php _e( 'Value' , 'sumodiscounts' ) ; ?></th>
                    <?php if ( check_if_free_shipping_enabled() ) { ?>
                        <th class="manage-column column-columnname-product" scope="col"><?php _e( 'Free Shipping' , 'sumodiscounts' ) ; ?></th>
                    <?php } ?>
                    <th class="manage-column column-columnname num" scope="col"><?php _e( 'Delete Rule' , 'sumodiscounts' ) ; ?></th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <?php if ( check_if_free_shipping_enabled() ) { ?>
                        <td></td>
                    <?php } ?>
                    <td></td>
                    <td class="manage-column column-columnname num" scope="col"> <span class="fpadddiscountrule button-primary"><?php _e( 'Add Rule' , 'sumodiscounts' ) ; ?></span></td>
                </tr>

            </tfoot>
            <tbody id="fpdiscountcartrule">
                <?php
                $get_data = get_option( 'fp_sp_reward_point_pricing_rule' ) ;
                if ( ($get_data) && (is_array( $get_data )) ) {

                    foreach ( $get_data as $iteration => $value ) {
                        ?>
                        <tr>
                            <td>
                                <p class="form-fields"><input type="text" class="sumo_number_input" required="required" step="any" required="required" name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][min]" min='0' value='<?php echo $value[ 'min' ] ; ?>' /></p>
                            </td>
                            <td>
                                <p class="form-fields"><input type="text" class="sumo_number_input" required="required" step='any' required="required" name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][max]" min='0' value='<?php echo $value[ 'max' ] ; ?>' /></p>
                            </td>
                            <td>
                                <p class='form-fields'>
                                    <select id='fp_sp_reward_point_pricing_rule<?php echo $iteration ; ?>'  data-key ='<?php echo $iteration ; ?>' name='fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][pricing_type]'>
                                        <option value='0' <?php echo selected( '1' , $value[ 'pricing_type' ] ) ; ?>><?php _e( 'None' , 'sumodiscounts' ) ; ?></option>
                                        <option value='1' <?php echo selected( '1' , $value[ 'pricing_type' ] ) ; ?>><?php _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                                        <option value='2' <?php echo selected( '2' , $value[ 'pricing_type' ] ) ; ?>><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                                        <option value='3' <?php echo selected( '3' , $value[ 'pricing_type' ] ) ; ?>><?php _e( 'Fixed Price' , 'sumodiscounts' ) ; ?></option>
                                    </select>
                                </p>
                            </td>
                            <td class="fp_discount_type_selection<?php echo $iteration ; ?>">
                                <input type="number" min=".01" step="any" required="required" id='fp_sp_reward_point_pricing_rule<?php echo $iteration ; ?>' value='<?php echo $value[ 'value' ] ; ?>' name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][value]" />
                            </td>
                            <?php if ( check_if_free_shipping_enabled() ) { ?>
                                <td class="fp_allow_free_shipping_<?php echo $iteration ; ?>">
                                    <input type="checkbox" <?php if ( isset( $value[ 'free_sipping' ] ) ) { ?>checked="checked"<?php } ?> name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][free_sipping]" />
                                </td>
                            <?php } ?>
                            <td class="column-columnname num">
                                <span class="fpdiscount_cart_remove button-secondary"><?php _e( 'Delete Rule' , 'sumodiscounts' ) ; ?></span>

                                <script type='text/javascript'>
                                    jQuery( function () {
                                        jQuery( '.fpdiscount_cart_remove' ).click( function () {
                                            jQuery( this ).parent().parent().remove() ;
                                        } ) ;
                                        jQuery( '.sumo_number_input' ).keyup( function ( event ) {
                                            var res = this.value.charAt( 0 ) ;
                                            if ( res !== '*' ) {
                                                this.value = this.value.replace( /[^0-9\.]/g , '' ) ;
                <?php
                if ( isset( $_GET[ 'tab' ] ) ) {
                    if ( $_GET[ 'tab' ] == 'fp_sp_rpelpricing' ) {
                        ?>
                                                        if ( this.value < 0.01 ) {
                                                            this.value = '' ;
                                                        }
                        <?php
                    }
                }
                ?>
                                            } else {
                                                this.value = this.value.replace( /[^*\.]/g , '' ) ;
                                            }
                                        } ) ;
                                    } ) ;

                                </script>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

        <script type="text/javascript">
            jQuery( function () {
                var counter ;
                jQuery( ".fpadddiscountrule" ).click( function () {
                    counter = Math.round( new Date().getTime() + ( Math.random() * 100 ) ) ;
                    console.log( counter ) ;
                    jQuery.ajax( {
                        data : ( {
                            action : 'testing' ,
                            uniq_id : counter
                        } ) ,
                        type : 'POST' ,
                        url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                        dataType : 'html' ,
                        success : function ( data ) {
                            console.log( data ) ;
                            jQuery( '#fpdiscountcartrule' ).append( data ) ;

                            jQuery( 'body' ).trigger( 'wc-enhanced-select-init' ) ;
                        }
                    } ) ;

                    return false ;
                } ) ;

                jQuery( '.fpdiscount_cart_remove' ).click( function () {
                    jQuery( this ).parent().parent().remove() ;
                } ) ;
                jQuery( '.sumo_number_input' ).keyup( function ( event ) {
                    var res = this.value.charAt( 0 ) ;
                    if ( res !== '*' ) {
                        this.value = this.value.replace( /[^0-9\.]/g , '' ) ;
        <?php
        if ( isset( $_GET[ 'tab' ] ) ) {
            if ( $_GET[ 'tab' ] == 'fp_sp_rpelpricing' ) {
                ?>
                                if ( this.value < 0.01 ) {
                                    this.value = '' ;
                                }
                <?php
            }
        }
        ?>
                    } else {
                        this.value = this.value.replace( /[^*\.]/g , '' ) ;
                    }
                } ) ;
            } ) ;
        </script>
        <?php
    }

    public static function process_ajax_request_in_discount() {
        if ( isset( $_POST ) ) {
            $iteration = $_POST[ 'uniq_id' ] ;
            echo self::perform_on_ajax_request( $iteration ) ;
        }
        exit() ;
    }

    // Perform something on ajax request
    public static function perform_on_ajax_request( $iteration ) {
        ob_start() ;
        ?>
        <tr>
            <td>
                <p class="form-fields"><input type="text" class="sumo_number_input" required="required" step="any" required="required" name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][min]" min='0' value='' /></p>
            </td>
            <td>
                <p class="form-fields"><input type="text" class="sumo_number_input" required="required" step='any' required="required" name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][max]" min='0' value='' /></p>
            </td>
            <td>
                <p class='form-fields'>
                    <select id='fp_sp_reward_point_pricing_rule<?php echo $iteration ; ?>'  data-key ='<?php echo $iteration ; ?>' name='fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][pricing_type]'>
                        <option value='0'> <?php echo _e( 'None' , 'sumodiscounts' ) ; ?></option>
                        <option value='1'> <?php echo _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                        <option value='2'> <?php echo _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                        <option value='3'> <?php echo _e( 'Fixed Price' , 'sumodiscounts' ) ; ?></option>
                    </select>
                </p>
            </td>
            <td class='fp_discount_type_selection<?php echo $iteration ; ?>'>
                <input type="number" min=".01" step="any" required="required" required="required" name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][value]" value=''/>
            </td>
            <?php if ( check_if_free_shipping_enabled() ) { ?>
                <td class="fp_allow_free_shipping_<?php echo $iteration ; ?>">
                    <input type="checkbox" name="fp_sp_reward_point_pricing_rule[<?php echo $iteration ; ?>][free_sipping]"  value='yes'/>
                </td>
            <?php } ?>
            <td class="column-columnname num">
                <span class="fpdiscount_cart_remove button-secondary"><?php _e( 'Delete Rule' , 'sumodiscounts' ) ; ?></span>

                <script type='text/javascript'>
                    jQuery( '.fpdiscount_cart_remove' ).click( function () {
                        jQuery( this ).parent().parent().remove() ;
                    } ) ;
                    jQuery( '.sumo_number_input' ).keyup( function ( event ) {
                        var res = this.value.charAt( 0 ) ;
                        if ( res !== '*' ) {
                            this.value = this.value.replace( /[^0-9\.]/g , '' ) ;
                            if ( this.value < 0.01 ) {
                                this.value = '' ;
                            }
                        } else {
                            this.value = this.value.replace( /[^*\.]/g , '' ) ;
                        }
                    } ) ;
                </script>
            </td>
        </tr>
        <?php
        return ob_get_clean() ;
    }

    public static function function_sp_incproducts_at_rwpp() {
        $name      = 'sp_incproducts_at_rwpp' ;
        $id        = 'sp_incproducts_at_rwpp' ;
        $classname = 'sp_incproducts_at_rwpp' ;
        $label     = __( 'Include Products' , 'sumodiscounts' ) ;
        $get_data  = get_option( 'sp_incproducts_at_rwpp' ) ;
        sumo_function_to_select_product_for_tab( $id , $label , $classname , $name , $get_data ) ;
    }

    public static function function_sp_excproducts_at_rwpp() {
        $name      = 'sp_excproducts_at_rwpp' ;
        $id        = 'sp_excproducts_at_rwpp' ;
        $classname = 'sp_excproducts_at_rwpp' ;
        $label     = __( 'Exclude Products' , 'sumodiscounts' ) ;
        $get_data  = get_option( 'sp_excproducts_at_rwpp' ) ;
        sumo_function_to_select_product_for_tab( $id , $label , $classname , $name , $get_data ) ;
    }

}

if ( is_plugin_active( 'rewardsystem/rewardsystem.php' ) && class_exists( 'FPRewardSystem' ) ) {

    new SP_RewardPoints_Pricing() ;
}
