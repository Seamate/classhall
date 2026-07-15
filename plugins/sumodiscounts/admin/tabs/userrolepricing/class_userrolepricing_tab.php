<?php

class FP_SP_UserRolePricing_Tab {

    // Construct the Class
    public function __construct() {
        add_action( 'init' , array( $this , 'sp_sumopricing_add_option_admin_settings' ) , 103 ) ;
        // make it appear in Discount System Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_array' , array( $this , 'initialize_tab' ) ) ;
        // Initialize Admin Fields in Discounts Rule
        add_action( 'woocommerce_sp_settings_tabs_fp_sp_userrole_pricing_settings' , array( $this , 'initialize_visual_appearance_admin_fields' ) ) ;

        // Initialize Update Fields in Discounts Rule
        add_action( 'woocommerce_update_options_fp_sp_userrole_pricing_settings' , array( $this , 'update_data_from_admin_fields' ) ) ;

        add_action( 'woocommerce_admin_field_user_role_pricing_menu' , array( $this , 'show_sp_user_role_pricing_settings' ) ) ;

        add_action( 'woocommerce_admin_field_sp_incproducts_at_urbp' , array( $this , 'function_sp_incproducts_at_urbp' ) ) ;

        add_action( 'woocommerce_admin_field_sp_excproducts_at_urbp' , array( $this , 'function_sp_excproducts_at_urbp' ) ) ;

        add_action( 'admin_head' , array( $this , 'sumo_display_notice' ) ) ;
    }

    public static function initialize_tab( $settings_tab ) {
        if ( ! is_array( $settings_tab ) ) {
            $settings_tab = ( array ) $settings_tab ;
        }
        $settings_tab[ 'fp_sp_userrole_pricing_settings' ] = __( 'User Role Discounts' , 'sumodiscounts' ) ;
        return array_filter( $settings_tab ) ;
    }

    // Initialize Admin Fields in Discount System

    public static function initialize_admin_fields() {
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
        return apply_filters( 'woocommerce_fp_sp_userrole_pricing_settings' , array(
            array(
                'name' => __( 'User Role Discounts' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_user_role_pricing_settings'
            ) ,
            array(
                'name'     => __( 'Apply User Role Discount for Product with Sale Price' , 'sumodiscounts' ) ,
                'type'     => 'checkbox' ,
                'id'       => 'sumo_enable_user_role_based_pricing_when_product_has_sale_price' ,
                'newids'   => 'sumo_enable_user_role_based_pricing_when_product_has_sale_price' ,
                'std'      => 'yes' ,
                'default'  => 'yes' ,
                'desc_tip' => true ,
                'desc'     => __( 'If enabled, User Role Discounts will be applicable for products with sale price' , 'sumodiscounts' ) ,
            ) ,
            array(
                'name'     => __( 'Rule Valid from' , 'sumodiscounts' ) ,
                'type'     => 'text' ,
                'class'    => 'sp_date' ,
                'id'       => 'sumo_user_role_based_pricing_from_date' ,
                'newids'   => 'sumo_user_role_based_pricing_from_date' ,
                'std'      => '' ,
                'default'  => '' ,
                'desc_tip' => true ,
                'desc'     => __( 'The Date from which the Discounts are valid' , 'sumodiscounts' ) ,
            ) ,
            array(
                'name'     => __( 'Rule Valid Till' , 'sumodiscounts' ) ,
                'type'     => 'text' ,
                'class'    => 'sp_date' ,
                'id'       => 'sumo_user_role_based_pricing_to_date' ,
                'newids'   => 'sumo_user_role_based_pricing_to_date' ,
                'std'      => '' ,
                'default'  => '' ,
                'desc_tip' => true ,
                'desc'     => __( 'The Date till which the Discounts are valid' , 'sumodiscounts' ) ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_user_role_pricing_settings'
            ) ,
            array(
                'name' => __( 'Rule is valid on the following days' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_user_role_pricing_allowed_weekdays' ,
                'desc' => __( 'If you want to provide discounts only on certain days of a Week then select only those days.' , 'sumodiscounts' ) ,
            ) ,
            array(
                'name'    => __( 'Monday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_monday_at_urp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_monday_at_urp' ,
            ) ,
            array(
                'name'    => __( 'Tuesday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_tuesday_at_urp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_tuesday_at_urp' ,
            ) ,
            array(
                'name'    => __( 'Wednesday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_wednesday_at_urp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_wednesday_at_urp' ,
            ) ,
            array(
                'name'    => __( 'Thursday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_thursday_at_urp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_thursday_at_urp' ,
            ) ,
            array(
                'name'    => __( 'Friday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_friday_at_urp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_friday_at_urp' ,
            ) ,
            array(
                'name'    => __( 'Saturday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_saturday_at_urp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_saturday_at_urp' ,
            ) ,
            array(
                'name'    => __( 'Sunday' , 'sumodiscounts' ) ,
                'type'    => 'checkbox' ,
                'id'      => 'sp_restrict_pricing_on_sunday_at_urp' ,
                'std'     => 'yes' ,
                'default' => 'yes' ,
                'newids'  => 'sp_restrict_pricing_on_sunday_at_urp' ,
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_user_role_pricing_allowed_weekdays'
            ) ,
            array(
                'name' => __( 'Applicable Discounts for' , 'sumodiscounts' ) ,
                'type' => 'title' ,
                'id'   => '_sp_user_role_pricing_product_category_filter'
            ) ,
            array(
                'name'     => __( 'Select Products' , 'sumodiscounts' ) ,
                'type'     => 'select' ,
                'tip'      => '' ,
                'id'       => 'sp_urbp_pricing_for_products' ,
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
                'newids'   => 'sp_urbp_pricing_for_products' ,
                'desc_tip' => true ,
                'desc'     => __( 'By Default, discounts will be provided for All Products.If you want to restrict the discounts only to specific products/categories then, that can be done using the options provided' , 'sumodiscounts' )
            ) ,
            array(
                'type' => 'sp_incproducts_at_urbp'
            ) ,
            array(
                'type' => 'sp_excproducts_at_urbp'
            ) ,
            array(
                'name'     => __( 'Include Categories' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_inccategories_at_urbp' ,
                'options'  => $product_categories ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_inccategories_at_urbp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'name'     => __( 'Exclude Categories' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_exccategories_at_urbp' ,
                'options'  => $product_categories ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_exccategories_at_urbp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'name'     => __( 'Include Tags' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_inctags_at_urbp' ,
                'options'  => $product_tags ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_inctags_at_urbp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'name'     => __( 'Exclude Tags' , 'sumodiscounts' ) ,
                'type'     => 'multiselect' ,
                'tip'      => '' ,
                'id'       => 'sp_exctags_at_urbp' ,
                'options'  => $product_tags ,
                'std'      => '' ,
                'default'  => '' ,
                'newids'   => 'sp_exctags_at_urbp' ,
                'desc_tip' => true ,
            ) ,
            array(
                'type' => 'user_role_pricing_menu'
            ) ,
            array(
                'type' => 'sectionend' ,
                'id'   => '_sp_user_role_pricing_product_category_filter'
            ) ,
                ) ) ;
    }

    // Make it appear visually in Discount System

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields( self::initialize_admin_fields() ) ;
    }

    // Update the Settings of Discount System

    public static function update_data_from_admin_fields() {
        woocommerce_update_options( self::initialize_admin_fields() ) ;
        $sp_incproducts_at_urbp = isset( $_POST[ 'sp_incproducts_at_urbp' ] ) ? $_POST[ 'sp_incproducts_at_urbp' ] : '' ;
        $sp_excproducts_at_urbp = isset( $_POST[ 'sp_excproducts_at_urbp' ] ) ? $_POST[ 'sp_excproducts_at_urbp' ] : '' ;
        update_option( 'sp_incproducts_at_urbp' , $sp_incproducts_at_urbp ) ;
        update_option( 'sp_excproducts_at_urbp' , $sp_excproducts_at_urbp ) ;

        global $wp_roles ;
        foreach ( $wp_roles->role_names as $key => $value ) {
            $userrole[] = $key ;
            $username[] = $value ;
        }
        $user_role = array_combine( ( array ) $userrole , ( array ) $username ) ;
        foreach ( $user_role as $key => $each_role ) {
            $pricing_type        = $_POST[ 'sp_urb_pricing_type_of_' . $key ] ;
            update_option( 'sp_urb_pricing_type_of_' . $key , $pricing_type ) ;
            $discount_value      = $_POST[ 'sp_urb_discount_value_' . $key ] ;
            update_option( 'sp_urb_discount_value_' . $key , $discount_value ) ;
            $allow_free_shipping = isset( $_POST[ 'sp_urb_allow_free_shipping_for_' . $key ] ) ? 'yes' : 'no' ;
            update_option( 'sp_urb_allow_free_shipping_for_' . $key , $allow_free_shipping ) ;
        }
        $sp_urb_pricing_type_of_guest  = isset( $_POST[ 'sp_urb_pricing_type_of_guest' ] ) ? $_POST[ 'sp_urb_pricing_type_of_guest' ] : array() ;
        $sp_urb_discount_value_guest   = isset( $_POST[ 'sp_urb_discount_value_guest' ] ) ? $_POST[ 'sp_urb_discount_value_guest' ] : array() ;
        $allow_free_shipping_for_guest = isset( $_POST[ 'sp_urb_allow_free_shipping_for_guest' ] ) ? 'yes' : 'no' ;
        update_option( 'sp_urb_pricing_type_of_guest' , $sp_urb_pricing_type_of_guest ) ;
        update_option( 'sp_urb_discount_value_guest' , $sp_urb_discount_value_guest ) ;
        update_option( 'sp_urb_allow_free_shipping_for_guest' , $allow_free_shipping_for_guest ) ;
    }

    public static function sp_sumopricing_add_option_admin_settings() {
        foreach ( self::initialize_admin_fields() as $setting )
            if ( isset( $setting[ 'newids' ] ) && isset( $setting[ 'std' ] ) ) {
                add_option( $setting[ 'newids' ] , $setting[ 'std' ] ) ;
            }
    }

    public static function show_sp_user_role_pricing_settings() {
        global $woocommerce , $wp_roles ;
        foreach ( $wp_roles->role_names as $key => $value ) {
            $userrole[] = $key ;
            $username[] = $value ;
        }
        $user_role = array_combine( ( array ) $userrole , ( array ) $username ) ;
        foreach ( $user_role as $key => $each_role ) {
            $percentage_type_value = get_option( 'sp_urb_pricing_type_of_' . $key ) ? get_option( 'sp_urb_pricing_type_of_' . $key ) : '' ;
            $discount_value        = get_option( 'sp_urb_discount_value_' . $key ) ? get_option( 'sp_urb_discount_value_' . $key ) : '' ;
            $allow_free_shipping   = get_option( 'sp_urb_allow_free_shipping_for_' . $key ) ;
            ?>
            <tr style="background:white;">                
                <td>
                    <b><?php echo $each_role ?></b>
                </td>                
                <td> 
                    <b><?php echo __( 'Discount Type : ' , 'sumodiscounts' ) ?></b>
                    <select name="sp_urb_pricing_type_of_<?php echo $key ?>" id="sp_urb_pricing_type_of_<?php echo $key ?>" class="sumo_urp_discount_select">
                        <option value="" <?php echo selected( "" , $percentage_type_value ) ; ?>><?php echo __( 'None' , 'sumodiscounts' ) ?></option>
                        <option value="percent_discount" <?php echo selected( "percent_discount" , $percentage_type_value ) ; ?>><?php _e( '% Discount' , 'sumodiscounts' ) ?></option>
                        <option value="fixed_discount" <?php echo selected( "fixed_discount" , $percentage_type_value ) ; ?>><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ?></option>
                        <option value="fixed_price" <?php echo selected( "fixed_price" , $percentage_type_value ) ; ?>><?php _e( 'Fixed Price' , 'sumodiscounts' ) ?></option>                        
                    </select>
                </td>
                <td>
                    <b><?php echo __( 'Value : ' , 'sumodiscounts' ) ?></b>
                    <input class="sumo_urp_discount_number" type="number" min="0.01" step="any" id="sp_urb_discount_value_<?php echo $key ?>" name="sp_urb_discount_value_<?php echo $key ?>" value="<?php echo $discount_value ; ?>">
                </td>
                <?php if ( check_if_free_shipping_enabled() ) { ?>
                    <td>
                        <b><?php echo __( 'Allow Free Shipping : ' , 'sumodiscounts' ) ?></b>
                        <input type="checkbox" id="sp_urb_allow_free_shipping_for_<?php echo $key ?>" name="sp_urb_allow_free_shipping_for_<?php echo $key ?>" <?php if ( $allow_free_shipping == 'yes' ) { ?>checked="checked"<?php } ?>>
                    </td>
                <?php } ?>
            </tr>
            <?php
        }
        $percentage_type_value_guest   = get_option( 'sp_urb_pricing_type_of_guest' ) ? get_option( 'sp_urb_pricing_type_of_guest' ) : '' ;
        $discount_value_guest          = get_option( 'sp_urb_discount_value_guest' ) ? get_option( 'sp_urb_discount_value_guest' ) : '' ;
        $allow_free_shipping_for_guest = get_option( 'sp_urb_allow_free_shipping_for_guest' ) ;
        ?>
        <tr style="background:white;">
            <td>
                <b><?php echo __( 'Guest' , 'sumodiscounts' ) ?></b>
            </td>
            <td>
                <b>
                    <?php echo __( 'Discount Type : ' , 'sumodiscounts' ) ?>
                </b> 
                <select name="sp_urb_pricing_type_of_guest" id="sp_urb_pricing_type_of_guest" class="sumo_urp_discount_select">
                    <option value="" <?php echo selected( "" , $percentage_type_value_guest ) ; ?>><?php echo __( 'None' , 'sumodiscounts' ) ?></option>
                    <option value="percent_discount" <?php echo selected( "percent_discount" , $percentage_type_value_guest ) ; ?>><?php _e( '% Discount' , 'sumodiscounts' ) ?></option>
                    <option value="fixed_discount" <?php echo selected( "fixed_discount" , $percentage_type_value_guest ) ; ?>><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ?></option>
                    <option value="fixed_price" <?php echo selected( "fixed_price" , $percentage_type_value_guest ) ; ?>><?php _e( 'Fixed Price' , 'sumodiscounts' ) ?></option>                    
                </select>
            </td>
            <td>
                <b>
                    <?php echo __( 'Value : ' , 'sumodiscounts' ) ?>
                </b>  
                <input class="sumo_urp_discount_number"  min="0.01" step="any" type="number" id="sp_urb_discount_value_guest" name="sp_urb_discount_value_guest" value="<?php echo $discount_value_guest ; ?>">
            </td>
            <?php if ( check_if_free_shipping_enabled() ) { ?>
                <td>
                    <b><?php echo __( 'Allow Free Shipping : ' , 'sumodiscounts' ) ?></b>
                    <input type="checkbox" id="sp_urb_allow_free_shipping_for_guest" name="sp_urb_allow_free_shipping_for_guest" <?php if ( $allow_free_shipping_for_guest == 'yes' ) { ?>checked="checked"<?php } ?>>
                </td>
            <?php } ?>
        </tr>
        <style type="text/css">
            .sumo_urp_discount_select, .sumo_urp_discount_number {
                width:250px !important;
            }
        </style>
        <script type="text/javascript">
            jQuery( document ).ready( function () {
        <?php if ( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                    jQuery( '#sp_inccategories_at_urbp' ).chosen() ;
                    jQuery( '#sp_exccategories_at_urbp' ).chosen() ;
                    jQuery( '#sp_inctags_at_urbp' ).chosen() ;
                    jQuery( '#sp_exctags_at_urbp' ).chosen() ;
        <?php } else { ?>
                    jQuery( '#sp_inccategories_at_urbp' ).select2() ;
                    jQuery( '#sp_exccategories_at_urbp' ).select2() ;
                    jQuery( '#sp_inctags_at_urbp' ).select2() ;
                    jQuery( '#sp_exctags_at_urbp' ).select2() ;
        <?php } ?>
                if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '1' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '2' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '3' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '4' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '5' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '6' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '7' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '8' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).show() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '9' ) {
                    jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                    jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).show() ;
                }
                jQuery( '#sp_urbp_pricing_for_products' ).change( function () {
                    if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '1' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '2' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '3' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '4' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '5' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '6' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '7' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '8' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).show() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).hide() ;
                    } else if ( jQuery( '#sp_urbp_pricing_for_products' ).val() == '9' ) {
                        jQuery( '#sp_incproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_excproducts_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exccategories_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_inctags_at_urbp' ).closest( 'tr' ).hide() ;
                        jQuery( '#sp_exctags_at_urbp' ).closest( 'tr' ).show() ;
                    }
                } ) ;
            } ) ;
        </script>
        <?php
    }

    public static function function_sp_incproducts_at_urbp() {
        $name      = 'sp_incproducts_at_urbp' ;
        $id        = 'sp_incproducts_at_urbp' ;
        $classname = 'sp_incproducts_at_urbp' ;
        $label     = __( 'Include Products' , 'sumodiscounts' ) ;
        $get_data  = get_option( 'sp_incproducts_at_urbp' ) ;
        sumo_function_to_select_product_for_tab( $id , $label , $classname , $name , $get_data ) ;
    }

    public static function function_sp_excproducts_at_urbp() {
        $name      = 'sp_excproducts_at_urbp' ;
        $id        = 'sp_excproducts_at_urbp' ;
        $classname = 'sp_excproducts_at_urbp' ;
        $label     = __( 'Exclude Products' , 'sumodiscounts' ) ;
        $get_data  = get_option( 'sp_excproducts_at_urbp' ) ;
        sumo_function_to_select_product_for_tab( $id , $label , $classname , $name , $get_data ) ;
    }

    public static function sumo_display_notice() {
        if ( isset( $_GET[ 'tab' ] ) ) {
            if ( $_GET[ 'tab' ] == 'fp_sp_userrole_pricing_settings' ) {
                ?>
                <div class="updated woocommerce-message wc-connect">
                    <p><b><?php echo __( '"User Role Discounts is currently Deprecated and Will be Removed from Future Versions"' , 'sumodiscounts' ) ; ?></b></p>
                </div>
                <br>
                <div class="updated woocommerce-message wc-connect">
                    <p><?php echo __( 'User Role Discounts can be configured using the ' , 'sumodiscounts' ) . '<b>' . __( 'user filter in Product/Category Discounts' , 'sumodiscounts' ) . '</b>' ; ?></p>
                </div>
                <?php
            }
        }
    }

}

new FP_SP_UserRolePricing_Tab() ;
