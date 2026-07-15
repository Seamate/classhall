<?php

/* Function to get the applied rule */

add_filter( 'woocommerce_package_rates' , 'sumo_hide_other_shipping_method' ) ;

function sumo_hide_other_shipping_method( $available_methods ) {
    $AllowFreeShipping = check_whether_to_allow_other_shippings() ;
    $AllowedMethods    = array() ;
    if ( $AllowFreeShipping ) {
        if ( isset( $available_methods[ 'free_shipping' ] ) ) { //For WooCommerce - V2.5
            // To unset all methods except for free_shipping, do the following
            $AllowedMethods[ 'free_shipping' ] = $available_methods[ 'free_shipping' ] ;
        } else {                                                  //For WooCommerce - above V3.0
            foreach ( $available_methods as $id => $method_id ) {
                if ( 'free_shipping' === $method_id->method_id ) {
                    $AllowedMethods[ $id ] = $method_id ;
                    break ;
                }
            }
        }
        return ! empty( $AllowedMethods ) ? $AllowedMethods : $available_methods ;
    }

    return $available_methods ;
}

function check_whether_to_allow_other_shippings() {
    if ( ! check_sumo_discounts_are_applied_in_cart() )
        return false ;

    $CartObj = WC()->cart ;
    if ( empty( $CartObj ) )
        return false ;

    $QuantityDiscount         = SUMOFunctionalityForQP::alter_cart_price_as_discount_value( $CartObj ) ;
    $AppliedQtyDiscount       = check_quantity_discount( $CartObj , $QuantityDiscount ) ;
    $SpecialOffer             = SUMOFunctionalityForSOP::alter_cart_price_as_discount_value_for_offer( $CartObj ) ;
    $AppliedSODiscount        = check_special_offer_discount( $CartObj , $SpecialOffer ) ;
    $CartTotalDiscount        = WC()->session->get( 'applied_cart_discount_rule_id' ) ;
    $AppliedCartTotalDiscount = check_cart_total_discount( $CartTotalDiscount ) ;
    $AppliedUserRoleDiscount  = check_userrole_discount() ;
    $SRPDiscount              = WC()->session->get( 'applied_srp_discount_rule_id' ) ;
    $AppliedSRPDiscount       = check_srp_discount( $SRPDiscount ) ;
    $CatProDiscount           = WC()->session->get( 'applied_catpro_discount_rule_id' ) ;
    $AppliedCatProDiscount    = check_srp_discount( $CatProDiscount ) ;
    $AllowFreeShipping        = array_merge( $AppliedQtyDiscount , $AppliedSODiscount , $AppliedCartTotalDiscount , $AppliedUserRoleDiscount , $AppliedSRPDiscount , $AppliedCatProDiscount ) ;
    if ( in_array( 'yes' , $AllowFreeShipping ) )
        return true ;

    return false ;
}

function get_applied_discount( $CartObj , $Discountrule , $PricingRule ) {
    $AllowFreeShipping = array() ;
    if ( empty( $Discountrule ) )
        return $AllowFreeShipping ;

    foreach ( $Discountrule as $IndividualRule ) {
        if ( empty( $IndividualRule ) )
            continue ;

        foreach ( $IndividualRule as $Uniquekey => $Values ) {
            $AppliedRule         = isset( $PricingRule[ $Uniquekey ] ) ? $PricingRule[ $Uniquekey ] : array() ;
            $AllowFreeShipping[] = isset( $AppliedRule[ 'sumo_enable_free_shipping' ] ) ? $AppliedRule[ 'sumo_enable_free_shipping' ] : 'no' ;
        }
    }
    return $AllowFreeShipping ;
}

function check_quantity_discount( $CartObj , $Discountrule ) {
    $QtyPricingRule = get_option( 'sumo_pricing_rule_fields_for_qty' ) ;
    if ( empty( $QtyPricingRule ) )
        return array() ;

    $AllowFreeShipping = get_applied_discount( $CartObj , $Discountrule , $QtyPricingRule ) ;
    return $AllowFreeShipping ;
}

function check_special_offer_discount( $CartObj , $Discountrule ) {
    $SOPricingRule = get_option( 'sumo_pricing_rule_fields_for_offer' ) ;
    if ( empty( $SOPricingRule ) )
        return array() ;

    $AllowFreeShipping = get_applied_discount( $CartObj , $Discountrule , $SOPricingRule ) ;
    return $AllowFreeShipping ;
}

function check_cart_total_discount( $Discountrule ) {
    $AllowFreeShipping = array() ;
    if ( empty( $Discountrule ) )
        return $AllowFreeShipping ;

    $AppliedDiscount = array_keys( $Discountrule ) ;
    if ( get_option( 'sumo_cart_pricing_priority_settings' ) == '1' ) {
        $Key = reset( $AppliedDiscount ) ;
    } elseif ( get_option( 'sumo_cart_pricing_priority_settings' ) == '2' ) {
        $Key = end( $AppliedDiscount ) ;
    } elseif ( get_option( 'sumo_cart_pricing_priority_settings' ) == '3' ) {
        $Key = max( $AppliedDiscount ) ;
    } elseif ( get_option( 'sumo_cart_pricing_priority_settings' ) == '4' ) {
        $Key = min( $AppliedDiscount ) ;
    }
    $AppliedUniqueId        = $Discountrule[ $Key ] ;
    $CartTotalDiscountRules = get_option( 'sumo_pricing_rule_fields_for_cart' ) ;
    $AllowFreeShipping[]    = isset( $CartTotalDiscountRules[ $AppliedUniqueId ][ 'sumo_enable_free_shipping' ] ) ? $CartTotalDiscountRules[ $AppliedUniqueId ][ 'sumo_enable_free_shipping' ] : 'no' ;
    return $AllowFreeShipping ;
}

function check_userrole_discount() {
    $AllowFreeShipping = array() ;
    $DragRulePriority  = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $EnabledRule       = get_option( 'sumo_pricing_tab_sorting' ) ;
    foreach ( $DragRulePriority as $TabName ) {
        if ( $TabName != 'fp_sp_userrole_pricing_settings' )
            continue ;

        if ( ! (isset( $EnabledRule[ $TabName ] )) )
            return $AllowFreeShipping ;

        if ( $EnabledRule[ $TabName ] != 'yes' )
            return $AllowFreeShipping ;

        $UserId     = get_current_user_id() ;
        $FromDate   = get_option( 'sumo_user_role_based_pricing_from_date' , true ) != "" ? strtotime( get_option( 'sumo_user_role_based_pricing_from_date' , true ) ) : NULL ;
        $ToDate     = get_option( 'sumo_user_role_based_pricing_to_date' , true ) != '' ? strtotime( get_option( 'sumo_user_role_based_pricing_to_date' , true ) ) : strtotime( date_i18n( 'd-m-Y' ) ) ;
        $DateFilter = sumo_function_for_date_filter( $FromDate , $ToDate ) ;
        $Filter     = 'urp' ;
        $DayFilter  = sumo_function_for_day_filter( $Filter ) ;
        if ( ! ($DateFilter && $DayFilter) )
            return $AllowFreeShipping ;

        if ( $UserId > 0 ) {
            $UserData  = get_userdata( $UserId ) ;
            $UserRoles = $UserData->roles ;
            foreach ( $UserRoles as $Role ) {
                $AllowFreeShipping[] = get_option( 'sp_urb_allow_free_shipping_for_' . $Role ) ;
            }
        } else {
            $AllowFreeShipping[] = get_option( 'sp_urb_allow_free_shipping_for_guest' ) ;
        }
    }
    return $AllowFreeShipping ;
}

function check_srp_discount( $Discountrule ) {
    $AllowFreeShipping = array() ;
    if ( ! (is_plugin_active( 'rewardsystem/rewardsystem.php' ) && class_exists( 'FPRewardSystem' )) )
        return $AllowFreeShipping ;

    $DragRulePriority = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $EnabledRule      = get_option( 'sumo_pricing_tab_sorting' ) ;

    foreach ( $DragRulePriority as $TabName ) {
        if ( $TabName != 'fp_sp_rpelpricing' )
            continue ;

        if ( ! (isset( $EnabledRule[ $TabName ] )) )
            return $AllowFreeShipping ;

        if ( $EnabledRule[ $TabName ] != 'yes' )
            return $AllowFreeShipping ;

        if ( empty( $Discountrule ) )
            return $AllowFreeShipping ;

        $AppliedDiscount = array_keys( $Discountrule ) ;
        if ( get_option( 'fp_sp_rp_pricing_rule_priority' ) == '1' ) {
            $Key = reset( $AppliedDiscount ) ;
        } elseif ( get_option( 'fp_sp_rp_pricing_rule_priority' ) == '2' ) {
            $Key = end( $AppliedDiscount ) ;
        } elseif ( get_option( 'fp_sp_rp_pricing_rule_priority' ) == '3' ) {
            $Key = max( $AppliedDiscount ) ;
        } elseif ( get_option( 'fp_sp_rp_pricing_rule_priority' ) == '4' ) {
            $Key = min( $AppliedDiscount ) ;
        }
        $AppliedUniqueId     = $Discountrule[ $Key ] ;
        $SRPDiscountRules    = get_option( 'fp_sp_reward_point_pricing_rule' ) ;
        $NewArray            = isset( $SRPDiscountRules[ $AppliedUniqueId ] ) ? $SRPDiscountRules[ $AppliedUniqueId ] : array() ;
        $AllowFreeShipping[] = isset( $NewArray[ 'free_sipping' ] ) ? $NewArray[ 'free_sipping' ] : 'no' ;
    }
    return $AllowFreeShipping ;
}

function check_catpro_discount( $Discountrule ) {
    $AllowFreeShipping = array() ;
    $DragRulePriority  = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $EnabledRule       = get_option( 'sumo_pricing_tab_sorting' ) ;

    foreach ( $DragRulePriority as $TabName ) {
        if ( $TabName != 'sumo_cat_pro_pricing' )
            continue ;

        if ( ! (isset( $EnabledRule[ $TabName ] )) )
            return $AllowFreeShipping ;

        if ( $EnabledRule[ $TabName ] != 'yes' )
            return $AllowFreeShipping ;

        if ( empty( $Discountrule ) )
            return $AllowFreeShipping ;

        $AppliedDiscount = array_keys( $Discountrule ) ;
        if ( get_option( 'sumo_cat_pro_pricing_priority_settings' ) == '1' ) {
            $Key = reset( $AppliedDiscount ) ;
        } elseif ( get_option( 'sumo_cat_pro_pricing_priority_settings' ) == '2' ) {
            $Key = end( $AppliedDiscount ) ;
        } elseif ( get_option( 'sumo_cat_pro_pricing_priority_settings' ) == '3' ) {
            $Key = max( $AppliedDiscount ) ;
        } elseif ( get_option( 'sumo_cat_pro_pricing_priority_settings' ) == '4' ) {
            $Key = min( $AppliedDiscount ) ;
        }
        $AppliedUniqueId     = $Discountrule[ $Key ] ;
        $SRPDiscountRules    = get_option( 'sumo_pricing_rule_fields_for_cat_pro' ) ;
        $NewArray            = isset( $SRPDiscountRules[ $AppliedUniqueId ] ) ? $SRPDiscountRules[ $AppliedUniqueId ] : array() ;
        $AllowFreeShipping[] = isset( $NewArray[ 'sumo_enable_free_shipping' ] ) ? $NewArray[ 'sumo_enable_free_shipping' ] : 'no' ;
    }
    return $AllowFreeShipping ;
}
