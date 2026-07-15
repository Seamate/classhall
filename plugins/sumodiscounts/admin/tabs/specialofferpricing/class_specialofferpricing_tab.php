<?php

// Initialize Discounts Rule Tab
class SUMOOfferPricing {

    // Construct the Class Name

    public function __construct() {

        add_action( 'init' , array( $this , 'sumo_pricing_default_settings' ) , 103 ) ; // call the init function to update the default settings on page load
        // make it appear in SUMO Discounts Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_array' , array( $this , 'initialize_tab' ) ) ;

        // Initialize Admin Fields in Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_sumo_offer_pricing' , array( $this , 'initialize_visual_appearance_admin_fields' ) ) ;

        // Initialize Update Fields in Discounts Rule
        add_action( 'woocommerce_update_options_sumo_offer_pricing' , array( $this , 'update_data_from_admin_fields' ) ) ;

        // Add Custom Type of Field Option
        add_action( 'woocommerce_admin_field_sumo_special_offer_pricing_rule' , array( $this , 'sumo_special_offer_pricing_rule' ) ) ;

        add_action( 'wp_ajax_sumo_pricing_rule_sortable_for_offer' , array( $this , 'admin_request_from_ajax_sortable' ) ) ;

        add_action( 'wp_ajax_sumo_pricing_uniqid_for_offer' , array( $this , 'ajax_function_response_alteration_html' ) ) ;
    }

    // Declare the Discounts Rule Tab in SUMO Discounts

    public static function initialize_tab( $settings_tab ) {
        if ( ! is_array( $settings_tab ) ) {
            $settings_tab = ( array ) $settings_tab ;
        }
        $settings_tab[ 'sumo_offer_pricing' ] = __( 'Special Offer Discounts' , 'sumodiscounts' ) ;
        return array_filter( $settings_tab ) ;
    }

    // Initialize Admin Fields in SUMO Discounts

    public static function initialize_admin_fields() {
        global $woocommerce ;
        return apply_filters( 'woocommerce_special_offer_pricing_rule' , array(
            array(
                'name' => __( 'Special Offer Discounts' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_sopricing_rule_settings'
            ) ,
            array(
                'name'    => __( 'Rule Priority' , 'sumodiscounts' ) ,
                'type'    => 'select' ,
                'id'      => 'sumo_special_offer_priority_settings' ,
                'newids'  => 'sumo_special_offer_priority_settings' ,
                'class'   => 'sumo_special_offer_priority_settings' ,
                'options' => array(
                    '1' => __( 'First Matched Rule' , 'sumodiscounts' ) ,
                    '2' => __( 'Last Matched Rule' , 'sumodiscounts' ) ,
                    '3' => __( 'Minimum Discount' , 'sumodiscounts' ) ,
                    '4' => __( 'Maximum Discount' , 'sumodiscounts' ) ,
                ) ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_sopricing_rule_settings'
            ) ,
            array(
                'type' => 'sumo_special_offer_pricing_rule'
            ) ,
        ) ) ;
    }

    // Make it appear visually in SUMO Discounts

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields( self::initialize_admin_fields() ) ;
    }

    // Update the Settings of SUMO Discounts

    public static function update_data_from_admin_fields( $post ) {
        woocommerce_update_options( self::initialize_admin_fields() ) ;
        $sumo_pricing_rule_fields_for_offer = isset( $_POST[ 'sumo_pricing_rule_fields_for_offer' ] ) ? $_POST[ 'sumo_pricing_rule_fields_for_offer' ] : array() ;
        update_option( 'sumo_pricing_rule_fields_for_offer' , $sumo_pricing_rule_fields_for_offer ) ;
    }

    /*
     * Initialize the Default Settings by looping this function
     */

    public static function sumo_pricing_default_settings() {
        global $woocommerce ;
        foreach ( self::initialize_admin_fields() as $setting )
            if ( isset( $setting[ 'newids' ] ) && isset( $setting[ 'std' ] ) ) {
                add_option( $setting[ 'newids' ] , $setting[ 'std' ] ) ;
            }
    }

    // Declare the Options
    public static function sumo_special_offer_pricing_rule() {
        $actionforsorting     = 'sumo_pricing_rule_sortable_for_offer' ;
        $actionforaddrule     = 'sumo_pricing_uniqid_for_offer' ;
        $classforaddlocalrule = 'add_new_row_for_offer' ;
        $get_saved_data       = get_option( 'sumo_pricing_rule_fields_for_offer' ) ;
        $pricingtype          = 'offer' ;
        $array                = array(
            'actionforsorting'     => $actionforsorting ,
            'actionforaddrule'     => $actionforaddrule ,
            'classforaddlocalrule' => $classforaddlocalrule ,
            'get_saved_data'       => $get_saved_data ,
            'pricing_type'         => $pricingtype ,
            'nameforinputfield'    => 'sumo_pricing_rule_fields_for_offer'
        ) ;
        sumo_common_function_to_add_settings_for_rule( $array ) ;
    }

    public static function admin_request_from_ajax_sortable() {
        if ( isset( $_POST ) ) {
            update_option( 'sumo_dynamic_pricing_drag_position_for_offer' , $_POST[ 'data' ] ) ;
            exit() ;
        }
    }

    // Sort Div with Sortable Manner
    public static function ajax_function_response_alteration_html() {
        if ( isset( $_POST ) ) {
            $phpuniqid = uniqid() ;
            $uniqid    = $_POST[ 'uniq_id' ] ;
            if ( isset( $_POST[ 'rule_type' ] ) && ($_POST[ 'rule_type' ] == 'specialoffer') ) {
                $new_array = array(
                    'unique_id'         => $uniqid ,
                    'phpunique_id'      => $phpuniqid ,
                    'nameforfields'     => 'sumo_offer_rule' ,
                    'rule_type'         => 'specialoffer' ,
                    'nameforinputfield' => 'sumo_pricing_rule_fields_for_offer'
                ) ;
                echo local_rule_function( $new_array ) ;
            } else {
                $new_array = array(
                    'unique_id'         => $uniqid ,
                    'phpunique_id'      => $phpuniqid ,
                    'nameforfields'     => 'sumo_offer_rule' ,
                    'rule_type'         => 'offer' ,
                    'nameforinputfield' => 'sumo_pricing_rule_fields_for_offer'
                ) ;
                echo array_to_field_conversion( $new_array ) ;
            }
        }
        exit() ;
    }

    public static function show_or_hide( $key ) {
        ?>
        <script type="text/javascript">
            jQuery( document ).ready( function () {
                if ( jQuery( '.sumo_pricing_apply_for_user_type<?php echo $key ; ?>' ).val() == '1' ) {
                    jQuery( '#sumo_pricing_apply_to_user<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_for_user_type<?php echo $key ; ?>' ).val() == '2' ) {
                    jQuery( '#sumo_pricing_apply_to_user<?php echo $key ; ?>' ).parent().show() ;
                    if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '1' ) {
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '2' ) {
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '3' ) {
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '4' ) {
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '5' ) {
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '6' ) {
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '7' ) {
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).show() ;
                    }

                    jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).change( function () {
                        if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '1' ) {
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '2' ) {
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '3' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '4' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '5' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '6' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '7' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).show() ;
                        }
                    } ) ;
                } else if ( jQuery( '.sumo_pricing_apply_for_user_type<?php echo $key ; ?>' ).val() == '3' ) {
                    jQuery( '#sumo_pricing_apply_to_user<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                }

                jQuery( '.sumo_pricing_apply_for_user_type<?php echo $key ; ?>' ).change( function () {

                    if ( jQuery( '.sumo_pricing_apply_for_user_type<?php echo $key ; ?>' ).val() == '1' ) {
                        jQuery( '#sumo_pricing_apply_to_user<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_for_user_type<?php echo $key ; ?>' ).val() == '2' ) {
                        jQuery( '#sumo_pricing_apply_to_user<?php echo $key ; ?>' ).parent().show() ;
                        if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '1' ) {
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '2' ) {
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '3' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '4' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '5' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '6' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().show() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                        } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '7' ) {
                            jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                            jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).show() ;
                        }

                        jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).change( function () {
                            if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '1' ) {
                                jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                            } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '2' ) {
                                jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().show() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                            } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '3' ) {
                                jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().show() ;
                                jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                            } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '4' ) {
                                jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                            } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '5' ) {
                                jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().show() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                            } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '6' ) {
                                jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().show() ;
                                jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                            } else if ( jQuery( '.sumo_pricing_apply_to_user<?php echo $key ; ?>' ).val() == '7' ) {
                                jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                                jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).show() ;
                            }
                        } ) ;
                    } else if ( jQuery( '.sumo_pricing_apply_for_user_type<?php echo $key ; ?>' ).val() == '3' ) {
                        jQuery( '#sumo_pricing_apply_to_user<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_users_role<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_memberplans<?php echo $key ; ?>' ).closest( 'p' ).hide() ;
                    }
                } ) ;

                if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '1' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '2' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '3' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '4' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '5' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '6' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '7' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '8' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '9' ) {
                    jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().show() ;
                }

                jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).change( function () {
                    if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '1' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '2' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '3' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '4' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '5' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '6' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '7' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '8' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    } else if ( jQuery( '.sumo_pricing_apply_to_products<?php echo $key ; ?>' ).val() == '9' ) {
                        jQuery( '#sumo_pricing_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_pricing_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().show() ;
                    }
                } ) ;

                if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '1' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '2' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '3' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '4' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '5' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '6' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '7' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '8' ) {
                    jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                    jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().show() ;
                    jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).hide() ;
                    jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).hide() ;
                }

                jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).change( function () {
                    if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '1' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '2' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '3' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '4' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '5' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '6' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '7' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).show() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).show() ;
                    } else if ( jQuery( '.sumo_special_offer_applicable_to_<?php echo $key ; ?>' ).val() == '8' ) {
                        jQuery( '#sumo_special_offer_apply_to_include_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_products<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_category<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_applicable_on_<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_include_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_exclude_tag<?php echo $key ; ?>' ).parent().hide() ;
                        jQuery( '#sumo_special_offer_apply_to_free_products<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '.sumo_special_offer_buy_quantity<?php echo $key ; ?>' ).parent().show() ;
                        jQuery( '.sumo_offer_rule_<?php echo $key ; ?>' ).hide() ;
                        jQuery( '.add_new_row_for_offer<?php echo $key ; ?>' ).hide() ;
                    }
                } ) ;


                if ( jQuery( '.sumo_pricing_apply_on_products<?php echo $key ; ?>' ).val() == '1' ) {
                    jQuery( '#sumo_pricing_apply_on_include_products<?php echo $key ; ?>' ).parent().hide() ;
                } else {
                    jQuery( '#sumo_pricing_apply_on_include_products<?php echo $key ; ?>' ).parent().show() ;
                }

                jQuery( '.sumo_pricing_apply_on_products<?php echo $key ; ?>' ).change( function () {
                    if ( jQuery( '.sumo_pricing_apply_on_products<?php echo $key ; ?>' ).val() == '1' ) {
                        jQuery( '#sumo_pricing_apply_on_include_products<?php echo $key ; ?>' ).parent().hide() ;
                    } else {
                        jQuery( '#sumo_pricing_apply_on_include_products<?php echo $key ; ?>' ).parent().show() ;
                    }
                } ) ;

            } ) ;
        </script>
        <?php
    }

}

new SUMOOfferPricing() ;
