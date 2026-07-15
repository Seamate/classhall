<?php

add_action( 'wp_head' , 'sumo_quantity_pricing_table' ) ;
add_action( 'woocommerce_cart_loaded_from_session' , 'sumo_main_function_to_apply_bulk_discount_for_user' , 10 ) ;
add_action( 'woocommerce_checkout_update_order_meta' , 'check_sumo_discounts_are_applied_in_this_order' , 10 , 1 ) ;
add_action( 'wp_ajax_nopriv_fp_apply_discount_for_first_purchase' , 'add_fee_for_user' ) ;
add_action( 'wp_ajax_fp_apply_discount_for_first_purchase' , 'add_fee_for_user' ) ;
add_action( 'wp_ajax_sumo_discounts_var_fields' , 'variation_product_disp_table' ) ;
add_action( 'wp_ajax_nopriv_sumo_discounts_var_fields' , 'variation_product_disp_table' ) ;
add_filter( 'woocommerce_order_get_total_discount' , 'woocommerce_order_get_total_discount_action' , 10 , 2 ) ;
add_filter( 'woocommerce_coupon_is_valid' , 'sumodiscounts_validate_coupons_on_cart' , 10 , 2 ) ;

if( get_option( 'sumo_price_display_method_with_discounts' ) == '2' ) {
    add_filter( 'woocommerce_cart_item_price' , 'sumo_function_to_strike_original_price' , 10 , 3 ) ;
    add_filter( 'woocommerce_order_formatted_line_subtotal' , 'woocommerce_order_formatted_line_subtotal_action' , 10 , 3 ) ;
    
    if( get_option( 'sumo_enable_discount_tag' ) == 'yes' ) {
        add_action( 'woocommerce_before_shop_loop_item_title' , 'sumo_main_function_to_show_discount_tag' ) ;
        add_action( 'woocommerce_before_single_product_summary' , 'sumo_main_function_to_show_discount_tag' ) ;
        add_action( 'woocommerce_before_single_product_summary' , 'sumo_main_function_to_show_discount_tag_for_variation' ) ;
    }
}

if( get_option( 'sp_range_price_table' ) == "after" ) {
    add_action( 'woocommerce_after_add_to_cart_button' , 'sumo_product_range_table_common_table' , 10 ) ;
    add_action( 'woocommerce_after_add_to_cart_button' , 'variable_sd_data_display' , 10 ) ;
}

if( !is_admin() ) {
    add_filter( 'woocommerce_variable_price_html' , 'sp_alter_variation_price_range_for_sitewide' , 10 , 2 ) ;
    add_filter( 'woocommerce_variable_sale_price_html' , 'sp_alter_variation_price_range_for_sitewide' , 10 , 2 ) ;
    add_filter( 'woocommerce_product_is_on_sale' , 'consider_sw_disc_as_sale_products' , 10 , 2 ) ;
    add_filter( sumo_deprecated_hooks( 'woocommerce_get_price' ) , 'sumo_main_function_to_apply_sitewide_discount' , get_option( 'sumo_filter_priority_value_on_cart' , 0 ) , 2 ) ;
    add_filter( 'woocommerce_get_price_html' , 'sumo_main_function_to_apply_sitewide_discount_html' , 10 , 2 ) ;
    
    if( ( float ) WC()->version >= ( float ) '3.0.0' ) {
        add_filter( 'woocommerce_product_variation_get_price' , 'sumo_main_function_to_apply_sitewide_discount' , get_option( 'sumo_filter_priority_value_on_cart' , 0 ) , 2 ) ;
    }
}

if( class_exists( 'FPRewardSystem' ) && get_option( 'rs_referral_activated' , 'no' ) == 'yes' && get_option( 'sumo_award_discounts_to_referred_person' , 'no' == 'yes' ) ) {
    add_action( 'woocommerce_cart_calculate_fees' , 'woocommerce_cart_calculate_fees' ) ;
    add_filter( 'woocommerce_cart_totals_get_fees_from_cart_taxes' , 'adding_fee_to_display_tax_value' , 10 , 2 ) ;
}

if( ( float ) WC()->version < ( float ) '3.0.0' ) {
    add_filter( 'woocommerce_get_variation_price_html' , 'sumo_main_function_to_apply_sitewide_variation_discount_html' , 10 , 2 ) ;
}

function sumo_main_function_to_apply_bulk_discount_for_user() {
    global $quantity_matched_functions ;
    global $woocommerce ;
    $array        = array() ;
    $cart_object  = $woocommerce->cart ;
    $cart_content = $cart_object->cart_contents ;
    foreach( $cart_content as $cart_key => $cart_value ) {
        $product_id = $cart_value[ 'variation_id' ] ? $cart_value[ 'variation_id' ] : $cart_value[ 'product_id' ] ;
        WC()->session->__unset( $cart_key . 'bulk_discounts_applied' ) ;
    }
    $quantity_discount      = SUMOFunctionalityForQP::alter_cart_price_as_discount_value( $cart_object ) ;
    $special_offer_discount = SUMOFunctionalityForSOP::alter_cart_price_as_discount_value_for_offer( $cart_object ) ;

    $arrangement = get_option( 'drag_and_drop_rule_priority_for_bulk_discounts' ) ;
    $enable_rule = get_option( 'sumo_pricing_tab_sorting' ) ;

    if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
        foreach( $arrangement as $tabname ) {
            if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {
                if( ($tabname != 'sumo_offer_pricing') && is_array( $quantity_discount ) && ! empty( $quantity_discount ) ) {
                    $array[][ 'qty_discount' ] = $quantity_discount ;
                } else {
                    if( isset( $enable_rule[ 'sumo_offer_pricing' ] ) && ($enable_rule[ 'sumo_offer_pricing' ] == 'yes') ) {
                        $array[][ 'special_discount' ] = $special_offer_discount ;
                    }
                }
            }
        }
    }
    $rule_priority = get_option( 'sumo_bulk_discounts' ) ;
    if( $rule_priority == '1' ) {
        $matched_rule               = reset( $array ) ;
        $quantity_matched_functions = $matched_rule ;
        if( isset( $matched_rule[ 'special_discount' ] ) ) {
            SUMOFunctionalityForSOP::sumo_function_to_apply_discount_value_for_offer( $cart_object , $matched_rule[ 'special_discount' ] ) ;
        } elseif( isset( $matched_rule[ 'qty_discount' ] ) ) {
            SUMOFunctionalityForQP::sumo_function_to_apply_discount_value( $cart_object , $matched_rule[ 'qty_discount' ] ) ;
        }
    } elseif( $rule_priority == '2' ) {

        $matched_rule = end( $array ) ;

        $quantity_matched_functions = $matched_rule ;
        if( isset( $matched_rule[ 'special_discount' ] ) ) {
            SUMOFunctionalityForSOP::sumo_function_to_apply_discount_value_for_offer( $cart_object , $matched_rule[ 'special_discount' ] ) ;
        } elseif( isset( $matched_rule[ 'qty_discount' ] ) ) {
            SUMOFunctionalityForQP::sumo_function_to_apply_discount_value( $cart_object , $matched_rule[ 'qty_discount' ] ) ;
        }
    } elseif( $rule_priority == '3' ) {
        $concluded_array          = array() ;
        $discount_matched_key     = array() ;
        $discount_array_structure = array() ;
        if( is_array( $array ) && ! empty( $array ) ) {
            foreach( $array as $key => $array_value ) {
                if( is_array( $array_value ) && ! empty( $array_value ) ) {
                    foreach( $array_value as $tab_key => $uniquevalue ) {
                        if( is_array( $uniquevalue ) && ! empty( $uniquevalue ) ) {
                            foreach( $uniquevalue as $p_id => $value ) {
                                foreach( $value as $uniqid => $each_value ) {
                                    if( is_array( $each_value[ 'discount_values' ] ) && ! empty( $each_value[ 'discount_values' ] ) ) {
                                        $discount_value = $each_value[ 'discount_values' ] ;
                                        foreach( $discount_value as $product_id => $discounted_value ) {
                                            if( ! isset( $discount_min_check[ $product_id ] ) || $discount_min_check[ $product_id ] > $discounted_value ) {
                                                $discount_min_check[ $product_id ]                              = $discounted_value ;
                                                $discount_matched_key[ $tab_key ][ $product_id ]                = $discounted_value ;
                                                $discount_array_structure[ $tab_key ][ $product_id ][ $uniqid ] = $each_value ;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $quantity_matched_functions = $discount_array_structure ;
            if( isset( $discount_matched_key[ 'qty_discount' ] ) ) {
                SUMOFunctionalityForQP::sumo_function_to_min_max_discount( $cart_object , $discount_matched_key[ 'qty_discount' ] ) ;
            } elseif( isset( $discount_matched_key[ 'special_discount' ] ) ) {
                SUMOFunctionalityForSOP::sumo_function_to_min_max_discount_for_offer( $cart_object , $discount_matched_key[ 'special_discount' ] ) ;
            }
        }
    } else {
        $concluded_array          = array() ;
        $discount_matched_key     = array() ;
        $discount_array_structure = array() ;
        if( is_array( $array ) && ! empty( $array ) ) {
            foreach( $array as $key => $array_value ) {
                if( is_array( $array_value ) && ! empty( $array_value ) ) {
                    foreach( $array_value as $tab_key => $uniquevalue ) {
                        if( is_array( $uniquevalue ) && ! empty( $uniquevalue ) ) {
                            foreach( $uniquevalue as $p_id => $value ) {
                                foreach( $value as $uniqid => $each_value ) {
                                    if( is_array( $each_value[ 'discount_values' ] ) && ! empty( $each_value[ 'discount_values' ] ) ) {
                                        $discount_value = $each_value[ 'discount_values' ] ;
                                        foreach( $discount_value as $product_id => $discounted_value ) {
                                            if( ! isset( $discount_min_check[ $product_id ] ) || $discount_min_check[ $product_id ] < $discounted_value ) {
                                                $discount_min_check[ $product_id ]                              = $discounted_value ;
                                                $discount_matched_key[ $tab_key ][ $product_id ]                = $discounted_value ;
                                                $discount_array_structure[ $tab_key ][ $product_id ][ $uniqid ] = $each_value ;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $quantity_matched_functions = $discount_array_structure ;
            if( isset( $discount_matched_key[ 'qty_discount' ] ) ) {
                SUMOFunctionalityForQP::sumo_function_to_min_max_discount( $cart_object , $discount_matched_key[ 'qty_discount' ] ) ;
            } elseif( isset( $discount_matched_key[ 'special_discount' ] ) ) {
                SUMOFunctionalityForSOP::sumo_function_to_min_max_discount_for_offer( $cart_object , $discount_matched_key[ 'special_discount' ] ) ;
            }
        }
    }
}



function sumo_function_to_strike_original_price( $price , $cart_item , $cart_item_key ) {
    $enable_rule = get_option( 'sumo_pricing_tab_sorting' ) ;
    if( ! empty( $enable_rule ) ) {
        $price = strike_orginal_price_for_quantity_discount( $enable_rule , $price , $cart_item ) ;
    }
    return $price ;
}

function strike_orginal_price_for_quantity_discount( $enable_rule , $price , $cart_item ) {
    if( isset( $enable_rule[ 'sumo_quantity_pricing' ] ) && $enable_rule[ 'sumo_quantity_pricing' ] == 'yes' ) {
        global $quantity_matched_functions ;
        $quantity_discount_applied_products = $quantity_matched_functions ;
        if( is_array( $quantity_discount_applied_products ) && ! empty( $quantity_discount_applied_products ) ) {
            foreach( $quantity_discount_applied_products as $key => $value ) {
                if( is_array( $value ) && ! empty( $value ) ) {
                    foreach( $value as $each_value ) {
                        if( is_array( $each_value ) && ! empty( $each_value ) ) {
                            foreach( $each_value as $new_key => $new_value ) {
                                $condition_checker = isset( $new_value[ 'discount_values' ] ) ? $new_value[ 'discount_values' ] : false ;
                                if( $condition_checker ) {
                                    $product_id     = $cart_item[ 'variation_id' ] > 0 ? $cart_item[ 'variation_id' ] : $cart_item[ 'product_id' ] ;
                                    $object         = sumo_sd_get_product( $product_id ) ;
                                    $original_price = $object->get_price() ;
                                    $discount_price = isset( $condition_checker[ $product_id ] ) ? $condition_checker[ $product_id ] : false ;
                                    if( $discount_price != '' ) {
                                        return strike_price_in_html_for_display_discount_value( $object , $price , $original_price ) ;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return strike_orginal_price_for_category_product_discount( $enable_rule , $price , $cart_item ) ;
}

function strike_orginal_price_for_category_product_discount( $enable_rule , $price , $cart_item ) {
    if( isset( $enable_rule[ 'sumo_cat_pro_pricing' ] ) && $enable_rule[ 'sumo_cat_pro_pricing' ] == 'yes' ) {
        if( isset( $cart_item ) ) {
            $product_price     = '' ;
            $product_id        = $cart_item[ 'variation_id' ] > 0 ? $cart_item[ 'variation_id' ] : $cart_item[ 'product_id' ] ;
            $object            = sumo_sd_get_product( $product_id ) ;
            $original_price    = is_object( $object ) && $object->get_sale_price() != '' ? $object->get_sale_price() : $object->get_regular_price() ;
            $category_discount = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $original_price , $object ) ;
            if( $category_discount != $original_price ) {
                return strike_price_in_html_for_display_discount_value( $object , $price , $original_price ) ;
            }
        }
    }
    return strike_orginal_price_for_reward_points_discount( $enable_rule , $price , $cart_item ) ;
}

function strike_orginal_price_for_reward_points_discount( $enable_rule , $price , $cart_item ) {
    if( isset( $enable_rule[ 'fp_sp_rpelpricing' ] ) && $enable_rule[ 'fp_sp_rpelpricing' ] == 'yes' ) {
        if( isset( $cart_item ) ) {
            $product_price     = '' ;
            $product_id        = $cart_item[ 'variation_id' ] > 0 ? $cart_item[ 'variation_id' ] : $cart_item[ 'product_id' ] ;
            $object            = sumo_sd_get_product( $product_id ) ;
            $original_price    = is_object( $object ) && $object->get_sale_price() != '' ? $object->get_sale_price() : $object->get_regular_price() ;
            $category_discount = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $original_price , $object ) ;
            if( $category_discount != $original_price ) {
                return strike_price_in_html_for_display_discount_value( $object , $price , $original_price ) ;
            }
        }
    }
    return $price ;
}

function strike_price_in_html_for_display_discount_value( $object , $price , $original_price ) {
    if( get_option( 'woocommerce_tax_display_cart' ) == 'incl' ) {
        $product_price = sumo_sd_get_price_including_tax( $object , 1 , $original_price ) ;
    } else {
        $product_price = sumo_sd_get_price_excluding_tax( $object , 1 , $original_price ) ;
    }
    if( $price ) {
        $del  = "<del>" . sumo_wc_price( $product_price ) . "</del>" ;
        $mark = " <mark>" . $price . "</mark>" ;
        return $del . $mark ;
    }
}

function sumo_main_function_to_apply_sitewide_discount( $price , $product ) {
    $arrangement = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $enable_rule = get_option( 'sumo_pricing_tab_sorting' ) ;
    $array       = array() ;
    if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
        foreach( $arrangement as $tabname ) {
            if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {
                if( $tabname == 'fp_sp_userrole_pricing_settings' ) {
                    if( $price != FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $price , $product ) ) {
                        $d_price                                    = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $price , $product ) ;
                        $array[ 'fp_sp_userrole_pricing_settings' ] = $d_price ;
                    }
                } elseif( $tabname == 'fp_sp_rpelpricing' ) {
                    if( class_exists( 'RewardPointPricingFunctionalities' ) ) {
                        if( $price != RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $price , $product ) ) {
                            $d_price                      = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $price , $product ) ;
                            $array[ 'fp_sp_rpelpricing' ] = $d_price ;
                        }
                    }
                } else if( $tabname == 'sumo_membership_pricing' ) {
                    if( class_exists( 'SUMOFunctionalityMP' ) ) {
                        if( $price != SUMOFunctionalityMP::sumopricing_for_membership_level( $price , $product ) ) {
                            $d_price                            = SUMOFunctionalityMP::sumopricing_for_membership_level( $price , $product ) ;
                            $array[ 'sumo_membership_pricing' ] = $d_price ;
                        }
                    }
                } else if( $tabname == 'sumo_cat_pro_pricing' ) {

                    $d_price = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $price , $product ) ;

                    if( $price != $d_price ) {
                        $array[ 'sumo_cat_pro_pricing' ] = $d_price ;
                    }
                }
            }
        }
    }
    if( ! empty( $array ) ) {
        $new_array = ( $array ) ;
        if( ! empty( $new_array ) ) {
            $rule_priority = get_option( 'sumo_site_wide_discounts' ) ;
            if( $rule_priority == '1' ) {
                $discounted_price = reset( $new_array ) ;
                $price            = $discounted_price ;
            } elseif( $rule_priority == '2' ) {
                $discounted_price = end( $new_array ) ;
                $price            = $discounted_price ;
            } elseif( $rule_priority == '3' ) {
                $discounted_price = max( $new_array ) ;
                $price            = $discounted_price ;
            } else {
                $discounted_price = min( $new_array ) ;
                $price            = $discounted_price ;
            }
        }
    }
    return $price ;
}
//Need to be reviewed
function sumo_main_function_to_apply_sitewide_discount_html( $price , $product ) {

    if( $product->is_type( 'simple' ) || $product->is_type( 'variation' ) ) {
        $arrangement     = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
        $enable_rule     = get_option( 'sumo_pricing_tab_sorting' ) ;
        $array           = array() ;
        $product_price   = ( float ) get_post_meta( sumo_sd_get_product_id( $product ) , '_price' , true ) ;
        $discount_amount = $product_price ;
        if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
            foreach( $arrangement as $tabname ) {

                if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {
                    if( $tabname == 'fp_sp_userrole_pricing_settings' ) {
                        if( $product_price != FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $product_price , $product ) ) {
                            $d_price = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $product_price , $product ) ;
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                            } else {
                                $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                            }
                            $array[ 'fp_sp_userrole_pricing_settings' ] = $d_price ;
                        }
                    } elseif( $tabname == 'fp_sp_rpelpricing' ) {
                        if( class_exists( 'RewardPointPricingFunctionalities' ) ) {
                            if( $product_price != RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $product_price , $product ) ) {
                                $d_price = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $product_price , $product ) ;
                                if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                    $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                                } else {
                                    $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                                }
                                $array[ 'fp_sp_rpelpricing' ] = $d_price ;
                            }
                        }
                    } else if( $tabname == 'sumo_membership_pricing' ) {
                        if( class_exists( 'SUMOFunctionalityMP' ) ) {
                            if( $product_price != SUMOFunctionalityMP::sumopricing_for_membership_level( $product_price , $product ) ) {
                                $d_price = SUMOFunctionalityMP::sumopricing_for_membership_level( $product_price , $product ) ;
                                if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                    $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                                } else {
                                    $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                                }
                                $array[ 'sumo_membership_pricing' ] = $d_price ;
                            }
                        }
                    } else if( $tabname == 'sumo_cat_pro_pricing' ) {

                        $d_price = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $product_price , $product ) ;
                        if( $product_price != $d_price ) {
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                            } else {
                                $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                            }
                            $array[ 'sumo_cat_pro_pricing' ] = $d_price ;
                        }
                    }
                }
            }
        }

        if( ! empty( $array ) ) {
            $new_array = ( $array ) ;
            if( ! empty( $new_array ) ) {
                $rule_priority = get_option( 'sumo_site_wide_discounts' ) ;
                if( $rule_priority == '1' ) {
                    $discounted_price = reset( $new_array ) ;
                    $discount_amount  = $discounted_price ;
                } elseif( $rule_priority == '2' ) {
                    $discounted_price = end( $new_array ) ;
                    $discount_amount  = $discounted_price ;
                } elseif( $rule_priority == '3' ) {
                    $discounted_price = max( $new_array ) ;
                    $discount_amount  = $discounted_price ;
                } else {
                    $discounted_price = min( $new_array ) ;
                    $discount_amount  = $discounted_price ;
                }
                if( get_option( 'sumo_price_display_method_with_discounts' ) == '2' ) {
                    $del_price = $product_price ;
                    if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                        $del_price = sumo_sd_get_price_including_tax( $product , 1 , $product_price ) ;
                    } else {
                        $del_price = sumo_sd_get_price_excluding_tax( $product , 1 , $product_price ) ;
                    }
                    $price = '<del>' . sumo_wc_price( $del_price ) . '</del><ins>' . sumo_wc_price( $discount_amount ) . '</ins>' ;
                } else {
                    $price = sumo_wc_price( $discount_amount ) ;
                }
            }
        }
        $price = sumo_list_table_for_quantity_pricing( sumo_sd_get_product_level_id( $product ) , $discount_amount , $price ) ;
    }
    return $price ;
}

function sumo_main_function_to_apply_sitewide_variation_discount_html( $price , $variation ) {
    global $current_user ;
    $arrangement     = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $enable_rule     = get_option( 'sumo_pricing_tab_sorting' ) ;
    $array           = array() ;
    $variation_price = ( float ) get_post_meta( sumo_sd_get_product_id( $variation ) , '_price' , true ) ;
    $discount_amount = $variation_price ;
    if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
        foreach( $arrangement as $tabname ) {
            if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {
                if( $tabname == 'fp_sp_userrole_pricing_settings' ) {
                    if( $variation_price != FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $variation_price , $variation ) ) {
                        $d_Price = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $variation_price , $variation ) ;
                        if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                            $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                        } else {
                            $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                        }
                        $array[ 'fp_sp_userrole_pricing_settings' ] = $d_Price ;
                    }
                } elseif( $tabname == 'fp_sp_rpelpricing' ) {
                    if( class_exists( 'RewardPointPricingFunctionalities' ) ) {
                        if( $variation_price != RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $variation_price , $variation ) ) {
                            $d_Price = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $variation_price , $variation ) ;
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                            } else {
                                $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                            }
                            $array[ 'fp_sp_rpelpricing' ] = $d_Price ;
                        }
                    }
                } else if( $tabname == 'sumo_membership_pricing' ) {
                    if( class_exists( 'SUMOFunctionalityMP' ) ) {
                        if( $variation_price != SUMOFunctionalityMP::sumopricing_for_membership_level( $variation_price , $variation ) ) {
                            $d_Price = SUMOFunctionalityMP::sumopricing_for_membership_level( $variation_price , $variation ) ;
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                            } else {
                                $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                            }
                            $array[ 'sumo_membership_pricing' ] = $d_Price ;
                        }
                    }
                } else if( $tabname == 'sumo_cat_pro_pricing' ) {

                    $d_Price = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $variation_price , $variation ) ;
                    if( $variation_price != $d_Price ) {
                        if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                            $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                        } else {
                            $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                        }
                        $array[ 'sumo_cat_pro_pricing' ] = $d_Price ;
                    }
                }
            }
        }
    }
    if( ! empty( $array ) ) {
        $new_array = ( $array ) ;
        if( ! empty( $new_array ) ) {
            $rule_priority = get_option( 'sumo_site_wide_discounts' ) ;
            if( $rule_priority == '1' ) {
                $discounted_price = reset( $new_array ) ;
                $discount_amount  = $discounted_price ;
            } elseif( $rule_priority == '2' ) {
                $discounted_price = end( $new_array ) ;
                $discount_amount  = $discounted_price ;
            } elseif( $rule_priority == '3' ) {
                $discounted_price = max( $new_array ) ;
                $discount_amount  = $discounted_price ;
            } else {
                $discounted_price = min( $new_array ) ;
                $discount_amount  = $discounted_price ;
            }
            if( get_option( 'sumo_price_display_method_with_discounts' ) == '2' ) {
                $del_price = $variation_price ;
                if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                    $del_price = sumo_sd_get_price_including_tax( $variation , 1 , $variation_price ) ;
                } else {
                    $del_price = sumo_sd_get_price_excluding_tax( $variation , 1 , $variation_price ) ;
                }
                $price = '<del>' . sumo_wc_price( $del_price ) . '</del><ins>' . sumo_wc_price( $discount_amount ) . '</ins>' ;
            } else {
                $price = sumo_wc_price( $discount_amount ) ;
            }
        }
    }
    $price = sumo_list_table_for_quantity_pricing( sumo_sd_get_product_id( $variation ) , $discount_amount , $price ) ;
    return $price ;
}

function sumo_product_range_table_common_table() {
    global $product ;
    $product_id = $product->get_id() ;
    $s_price    = $product->get_sale_price() ;
    $price      = ($s_price == 0 ? $product->get_regular_price() : $s_price) ;
    if( $price == 0 ) {
        return false ;
    }
    echo sumo_product_range_construct_table( $product_id , $price ) ;
}

function sumo_product_range_construct_table( $product_id , $price ) {
    $table = '' ;
    if( get_option( 'sumo_enable_quantity_pricing_table' ) == 'enable' ) {
        $dprice         = $price ;
        $table_array    = array() ;
        $productobject  = sumo_sd_get_product( $product_id ) ;
        $enable_rule    = get_option( 'sumo_pricing_tab_sorting' ) ;
        $quantity_rules = get_option( 'sumo_pricing_rule_fields_for_qty' ) ;
        if( isset( $enable_rule[ 'sumo_quantity_pricing' ] ) && ($enable_rule[ 'sumo_quantity_pricing' ] == 'yes') ) {
            if( is_array( $quantity_rules ) && ! empty( $quantity_rules ) ) {
                foreach( $quantity_rules as $rule_key => $rule_array ) {
                    $my_array = '' ;
                    if( isset( $rule_array[ 'sumo_enable_the_rule' ] ) && $rule_array[ 'sumo_enable_the_rule' ] == 'yes' ) {
                        if( $productobject->get_sale_price() != '' ) {
                            if( isset( $rule_array[ 'sumo_apply_this_rule_for_sale' ] ) && $rule_array[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                                $my_array = sumo_price_table_for_quantity_pricing( $product_id , $price , $rule_array ) ;
                            }
                        } else {
                            $my_array = sumo_price_table_for_quantity_pricing( $product_id , $price , $rule_array ) ;
                        }
                    }
                    if( $my_array && is_array( $my_array ) && ! empty( $my_array ) ) {
                        foreach( $my_array as $each_array ) {
                            if( isset( $each_array[ 'sumo_pricing_rule_repeat_discount' ] ) && $each_array[ 'sumo_pricing_rule_repeat_discount' ] == 'yes' ) {
                                return sumo_wc_price( $price ) ;
                            }
                            $table_array[] = $each_array ;
                        }
                    }
                }
                if( ! empty( $table_array ) ) {
                    $check_table_for_clash_of_rules = sumo_check_rules_are_clash( $table_array ) ;
                    if( $check_table_for_clash_of_rules ) {
                        $ratings = array() ;
                        foreach( $table_array as $key => $row ) {
                            $ratings[ $key ] = $row[ 'sumo_pricing_rule_min_quantity' ] ;
                        }
                        array_multisort( $ratings , SORT_ASC , $table_array ) ;
                        $min_val    = $table_array[ 0 ][ 'sumo_pricing_rule_min_quantity' ] == '*' ? 1 : $table_array[ 0 ][ 'sumo_pricing_rule_min_quantity' ] ;
                        $last_array = end( $table_array ) ;
                        $max_val    = $last_array[ 'sumo_pricing_rule_max_quantity' ] ;

                        ob_start() ;
                        echo '<table class="pricing_table" style="color:black">'
                        . '<tbody>'
                        . '<tr>'
                        . '<td></td>'
                        . '<td>' . get_option( 'sp_qty_range_label' ) . '</td>'
                        . '<td></td>'
                        . '<td>' . get_option( 'sp_qty_price_label' ) . '</td>'
                        . '</tr>' ;
                        if( $min_val > 1 ) {
                            echo '<tr>'
                            . '<td>' . get_option( 'rs_custom_message_for_quantity' ) . '</td>'
                            . '<td> ' . __( 'Below ' , 'sumodiscounts' ) . $min_val . '</td>'
                            . '<td>' . get_option( 'rs_custom_message_for_before_price' ) . '</td>'
                            . '<td>' . sumo_wc_price( $price ) . '</td>'
                            . '<td></td>'
                            . '</tr>' ;
                        }
                        foreach( $table_array as $value ) {
                            $method  = $value[ 'sumo_pricing_rule_discount_type' ] ;
                            $d_value = $value[ 'sumo_pricing_rule_discount_value' ] ;
                            if( $method == '1' ) {
                                $dprice = $price - ($price * $d_value / 100) ;
                            } elseif( $method == '2' ) {
                                $dprice = $price - $d_value ;
                            } else {
                                $dprice = $d_value ;
                            }
                            $dprice = max( 0 , $dprice ) ;
                            $min    = $value[ 'sumo_pricing_rule_min_quantity' ] == '*' ? 1 : $value[ 'sumo_pricing_rule_min_quantity' ] ;
                            $max    = $value[ 'sumo_pricing_rule_max_quantity' ] != '*' ? ' – ' . $value[ 'sumo_pricing_rule_max_quantity' ] : ' +' ;
                            echo '<tr>'
                            . '<td>' . get_option( 'rs_custom_message_for_quantity' ) . '</td>'
                            . '<td>' . $min . $max . '</td>'
                            . '<td>' . get_option( 'rs_custom_message_for_before_price' ) . '</td>'
                            . '<td>' . sumo_wc_price( $dprice ) . '</td>'
                            . '</tr>' ;
                        }
                        if( $max_val != '*' ) {
                            echo '<tr>'
                            . '<td>' . get_option( 'rs_custom_message_for_quantity' ) . '</td>'
                            . '<td> ' . ($max_val + 1) . ' +</td>'
                            . '<td>' . get_option( 'rs_custom_message_for_before_price' ) . '</td>'
                            . '<td>' . sumo_wc_price( $price ) . '</td>'
                            . '</tr>' ;
                        }
                        echo '</tbody></table>' ;
                        $table = ob_get_clean() ;
                    }
                }
            }
        }
    }
    echo $table ;
}

function variable_sd_data_display() {
    ?><div class="sd_variation_datas"></div><?php
}

function sumo_list_table_for_quantity_pricing( $product_id , $price , $dop ) {
    $table = '' ;
    if( get_option( 'sumo_enable_quantity_pricing_table' ) == 'enable' ) {
        if( is_product() ) {
            $dprice         = $price ;
            $table_array    = array() ;
            $productobject  = sumo_sd_get_product( $product_id ) ;
            $enable_rule    = get_option( 'sumo_pricing_tab_sorting' ) ;
            $quantity_rules = get_option( 'sumo_pricing_rule_fields_for_qty' ) ;
            if( isset( $enable_rule[ 'sumo_quantity_pricing' ] ) && ($enable_rule[ 'sumo_quantity_pricing' ] == 'yes') ) {
                if( is_array( $quantity_rules ) && ! empty( $quantity_rules ) ) {
                    foreach( $quantity_rules as $rule_key => $rule_array ) {
                        $my_array = '' ;
                        if( isset( $rule_array[ 'sumo_enable_the_rule' ] ) && $rule_array[ 'sumo_enable_the_rule' ] == 'yes' ) {
                            if( $productobject->get_sale_price() != '' ) {
                                if( isset( $rule_array[ 'sumo_apply_this_rule_for_sale' ] ) && $rule_array[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                                    $my_array = sumo_price_table_for_quantity_pricing( $product_id , $price , $rule_array ) ;
                                }
                            } else {
                                $my_array = sumo_price_table_for_quantity_pricing( $product_id , $price , $rule_array ) ;
                            }
                        }
                        if( $my_array && is_array( $my_array ) && ! empty( $my_array ) ) {
                            foreach( $my_array as $each_array ) {
                                if( isset( $each_array[ 'sumo_pricing_rule_repeat_discount' ] ) && $each_array[ 'sumo_pricing_rule_repeat_discount' ] == 'yes' ) {
                                    return sumo_wc_price( $price ) ;
                                }
                                $table_array[] = $each_array ;
                            }
                        }
                    }
                    if( ! empty( $table_array ) ) {
                        $check_table_for_clash_of_rules = sumo_check_rules_are_clash( $table_array ) ;
                        if( $check_table_for_clash_of_rules ) {
                            $ratings = array() ;
                            foreach( $table_array as $key => $row ) {
                                $ratings[ $key ] = $row[ 'sumo_pricing_rule_min_quantity' ] ;
                            }
                            array_multisort( $ratings , SORT_ASC , $table_array ) ;
                            $min_val    = $table_array[ 0 ][ 'sumo_pricing_rule_min_quantity' ] == '*' ? 1 : $table_array[ 0 ][ 'sumo_pricing_rule_min_quantity' ] ;
                            $last_array = end( $table_array ) ;
                            $max_val    = $last_array[ 'sumo_pricing_rule_max_quantity' ] ;
                            ob_start() ;
                            echo '<table class="pricing_table" style="color:black">'
                            . '<tbody>'
                            . '<tr>'
                            . '<td></td>'
                            . '<td>' . get_option( 'sp_qty_range_label' ) . '</td>'
                            . '<td></td>'
                            . '<td>' . get_option( 'sp_qty_price_label' ) . '</td>'
                            . '</tr>' ;
                            if( $min_val > 1 ) {
                                echo '<tr>'
                                . '<td>' . get_option( 'rs_custom_message_for_quantity' ) . '</td>'
                                . '<td> ' . __( 'Below ' , 'sumodiscounts' ) . $min_val . '</td>'
                                . '<td>' . get_option( 'rs_custom_message_for_before_price' ) . '</td>'
                                . '<td>' . sumo_wc_price( $price ) . '</td>'
                                . '</tr>' ;
                            }
                            foreach( $table_array as $value ) {
                                $method  = $value[ 'sumo_pricing_rule_discount_type' ] ;
                                $d_value = $value[ 'sumo_pricing_rule_discount_value' ] ;
                                if( $method == '1' ) {
                                    $dprice = $price - ($price * $d_value / 100) ;
                                } elseif( $method == '2' ) {
                                    $dprice = $price - $d_value ;
                                } else {
                                    $dprice = $d_value ;
                                }
                                $dprice = max( 0 , $dprice ) ;
                                $min    = $value[ 'sumo_pricing_rule_min_quantity' ] == '*' ? 1 : $value[ 'sumo_pricing_rule_min_quantity' ] ;
                                $max    = $value[ 'sumo_pricing_rule_max_quantity' ] != '*' ? ' – ' . $value[ 'sumo_pricing_rule_max_quantity' ] : ' +' ;
                                echo '<tr>'
                                . '<td>' . get_option( 'rs_custom_message_for_quantity' ) . '</td>'
                                . '<td>' . $min . $max . '</td>'
                                . '<td>' . get_option( 'rs_custom_message_for_before_price' ) . '</td>'
                                . '<td>' . sumo_wc_price( $dprice ) . '</td>'
                                . '</tr>' ;
                            }
                            if( $max_val != '*' ) {
                                echo '<tr>'
                                . '<td>' . get_option( 'rs_custom_message_for_quantity' ) . '</td>'
                                . '<td> ' . ($max_val + 1) . ' +</td>'
                                . '<td>' . get_option( 'rs_custom_message_for_before_price' ) . '</td>'
                                . '<td>' . sumo_wc_price( $price ) . '</td>'
                                . '</tr>' ;
                            }
                            echo '</tbody></table>' ;
                            $table = ob_get_clean() ;
                        }
                    }
                }
            }
        }
    }
    $table_position = get_option( 'sp_range_price_table' ) ;
    if( $table_position == 'before' ) {
        return $dop . '<br>' . $table ;
    } else {
        return $dop ;
    }
}

function sumo_check_rules_are_clash( $table_array ) {
    $array = array() ;

    foreach( $table_array as $value ) {
        $min = $value[ 'sumo_pricing_rule_min_quantity' ] == '*' ? 1 : $value[ 'sumo_pricing_rule_min_quantity' ] ;
        $max = $value[ 'sumo_pricing_rule_max_quantity' ] ;
        for( $i = ( int ) $min ; $i <= $max ; $i ++ ) {
            $array[] = $i ;
        }
    }
    $new_array = array_count_values( $array ) ;
    foreach( $new_array as $eachvalue ) {
        if( $eachvalue > 1 ) {
            return false ;
        }
    }
    return true ;
}

function sumo_price_table_for_quantity_pricing( $product_id , $price , $rule_array ) {
    $userid                     = get_current_user_id() ;
    $currentdate                = strtotime( date_i18n( 'd-m-Y' ) ) ;
    $productobject              = sumo_sd_get_product( $product_id ) ;
    $products_in_cart           = sumo_dynamic_pricing_cart_contents() ;
    $newarray                   = array(
        'product_type'      => $rule_array[ 'sumo_pricing_apply_to_products' ] ,
        'included_products' => isset( $rule_array[ 'sumo_pricing_apply_to_include_products' ] ) ? $rule_array[ 'sumo_pricing_apply_to_include_products' ] : '' ,
        'excluded_products' => isset( $rule_array[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $rule_array[ 'sumo_pricing_apply_to_exclude_products' ] : '' ,
        'included_category' => isset( $rule_array[ 'sumo_pricing_apply_to_include_category' ] ) ? $rule_array[ 'sumo_pricing_apply_to_include_category' ] : '' ,
        'excluded_category' => isset( $rule_array[ 'sumo_pricing_apply_to_exclude_category' ] ) ? $rule_array[ 'sumo_pricing_apply_to_exclude_category' ] : '' ,
        'included_tag'      => isset( $rule_array[ 'sumo_pricing_apply_to_include_tag' ] ) ? $rule_array[ 'sumo_pricing_apply_to_include_tag' ] : '' ,
        'excluded_tag'      => isset( $rule_array[ 'sumo_pricing_apply_to_exclude_tag' ] ) ? $rule_array[ 'sumo_pricing_apply_to_exclude_tag' ] : '' ,
        'inc_condition'     => isset( $rule_array[ 'sumo_pricing_inc_condition' ] ) ? $rule_array[ 'sumo_pricing_inc_condition' ] : '1' ,
        'products_in_cart'  => $products_in_cart
            ) ;
    $apply_discount_to_products = sumo_function_for_product_and_category_filter( $product_id , $newarray , true ) ;
    if( $apply_discount_to_products ) {
        if( sumo_check_user_and_user_role_filter_for_display_quantity_table( $rule_array ) ) {
            $typeforuph           = $rule_array[ 'sumo_user_purchase_history' ] ;
            $minnooforder         = $rule_array[ 'sumo_no_of_orders_placed' ] ;
            $minamtspent          = $rule_array[ 'sumo_total_amount_spent_in_site' ] ;
            $userpurchasedhistory = check_for_user_purchase_history( $rule_array , $typeforuph , $minnooforder , $minamtspent , $userid ) ;
            if( $userpurchasedhistory ) {
                $fromdate    = $rule_array[ 'sumo_pricing_from_datepicker' ] != '' ? strtotime( $rule_array[ 'sumo_pricing_from_datepicker' ] ) : NULL ;
                $todate      = $rule_array[ 'sumo_pricing_to_datepicker' ] != '' ? strtotime( $rule_array[ 'sumo_pricing_to_datepicker' ] ) : strtotime( date_i18n( 'd-m-Y' ) ) ;
                $weekdays    = array( 'monday' , 'tuesday' , 'wednesday' , 'thursday' , 'friday' , 'saturday' , 'sunday' ) ;
                $currentday  = date( 'l' ) ;
                $currentdays = strtolower( $currentday ) ;
                foreach( $weekdays as $weekday ) {
                    if( $currentdays == $weekday ) {
                        $day = "sumo_pricing_rule_week_" . $weekday ;
                        if( isset( $rule_array[ $day ] ) ) {
                            if( $rule_array[ $day ] == '1' ) {
                                if( isset( $rule_array[ 'sumo_quantity_rule' ] ) ) {
                                    if( $fromdate && $todate ) {
                                        if( ($currentdate >= $fromdate) && ($currentdate <= $todate) ) {
                                            if( $rule_array[ 'sumo_dynamic_rule_based_on_pricing' ] == '1' ) {
                                                if( ! $productobject->is_type( 'variation' ) ) {
                                                    return $rule_array[ 'sumo_quantity_rule' ] ;
                                                }
                                            } elseif( $rule_array[ 'sumo_dynamic_rule_based_on_pricing' ] == '2' ) {
                                                if( $productobject->is_type( 'variation' ) ) {
                                                    return $rule_array[ 'sumo_quantity_rule' ] ;
                                                }
                                            }
                                        }
                                    } else {
                                        if( $currentdate <= $todate ) {
                                            if( $rule_array[ 'sumo_dynamic_rule_based_on_pricing' ] == '1' ) {
                                                if( ! $productobject->is_type( 'variation' ) ) {
                                                    return $rule_array[ 'sumo_quantity_rule' ] ;
                                                }
                                            } elseif( $rule_array[ 'sumo_dynamic_rule_based_on_pricing' ] == '2' ) {
                                                if( $productobject->is_type( 'variation' ) ) {
                                                    return $rule_array[ 'sumo_quantity_rule' ] ;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    return sumo_wc_price( $price ) ;
}

function sumo_check_user_and_user_role_filter_for_display_quantity_table( $getpricingrules ) {
    if( $getpricingrules[ 'sumo_pricing_apply_for_user_type' ] == '1' ) {
        return true ;
    } elseif( $getpricingrules[ 'sumo_pricing_apply_for_user_type' ] == '2' ) {
        if( is_user_logged_in() ) {
            $currentuserid = get_current_user_id() ;
            if( $getpricingrules[ 'sumo_pricing_apply_to_user' ] == '1' ) {
                return true ;
            } else if( $getpricingrules[ 'sumo_pricing_apply_to_user' ] == '2' ) {
                if( isset( $getpricingrules[ 'sumo_pricing_apply_to_include_users' ] ) ) {
                    $includeduserids1 = ! is_array( $getpricingrules[ 'sumo_pricing_apply_to_include_users' ] ) ? explode( ',' , $getpricingrules[ 'sumo_pricing_apply_to_include_users' ] ) : $getpricingrules[ 'sumo_pricing_apply_to_include_users' ] ;
                    $includeduserids  = array_filter( $includeduserids1 ) ;
                    if( in_array( $currentuserid , $includeduserids ) ) {
                        return true ;
                    }
                }
            } else if( $getpricingrules[ 'sumo_pricing_apply_to_user' ] == '3' ) {
                if( $getpricingrules[ 'sumo_pricing_apply_to_exclude_users' ] != '' ) {
                    $excludeduserids1 = ! is_array( $getpricingrules[ 'sumo_pricing_apply_to_exclude_users' ] ) ? explode( ',' , $getpricingrules[ 'sumo_pricing_apply_to_exclude_users' ] ) : $getpricingrules[ 'sumo_pricing_apply_to_exclude_users' ] ;
                    $excludeduserids  = array_filter( $excludeduserids1 ) ;
                    if( ! in_array( $currentuserid , $excludeduserids ) ) {
                        return true ;
                    }
                }
            } else if( $getpricingrules[ 'sumo_pricing_apply_to_user' ] == '4' ) {
                return true ;
            } else if( $getpricingrules[ 'sumo_pricing_apply_to_user' ] == '5' ) {
                if( $getpricingrules[ 'sumo_pricing_apply_to_include_users_role' ] != '' ) {
                    $getuserdata      = get_userdata( $currentuserid ) ;
                    $currentuserrole  = $getuserdata->roles ;
                    $includeduserrole = $getpricingrules[ 'sumo_pricing_apply_to_include_users_role' ] ;
                    if( in_array( $currentuserrole[ 0 ] , $includeduserrole ) ) {
                        return true ;
                    }
                }
            } else if( $getpricingrules[ 'sumo_pricing_apply_to_user' ] == '6' ) {
                if( $getpricingrules[ 'sumo_pricing_apply_to_exclude_users_role' ] != '' ) {
                    $getuserdata      = get_userdata( $currentuserid ) ;
                    $currentuserrole  = $getuserdata->roles ;
                    $includeduserrole = $getpricingrules[ 'sumo_pricing_apply_to_exclude_users_role' ] ;
                    if( ! in_array( $currentuserrole[ 0 ] , $includeduserrole ) ) {
                        return true ;
                    }
                }
            }
        }
    } else {
        if( ! is_user_logged_in() ) {
            return true ;
        }
    }
}

function sp_alter_variation_price_range_for_sitewide( $price_range , $object ) {
    $arrangement      = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $enable_rule      = get_option( 'sumo_pricing_tab_sorting' ) ;
    $prices           = $object->get_variation_prices( true ) ;
    $min_price        = current( $prices[ 'price' ] ) ;
    $max_price        = end( $prices[ 'price' ] ) ;
    $my_prices        = array_keys( $prices[ 'price' ] ) ;
    $min_variation_id = reset( $my_prices ) ;
    $max_variation_id = end( $my_prices ) ;
    $min_range        = '' ;
    $max_range        = '' ;

    if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
        foreach( $arrangement as $tabname ) {
            if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {

                $min_variation_object = sumo_sd_get_variation_object( $min_variation_id , $object ) ;
                $min_product_price    = $min_price ;
                $max_variation_object = sumo_sd_get_variation_object( $max_variation_id , $object ) ;
                $max_product_price    = $max_price ;

                if( $tabname == 'fp_sp_userrole_pricing_settings' ) {
                    $min_range = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $min_product_price , $min_variation_object ) ;
                    $max_range = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $max_product_price , $max_variation_object ) ;
                } elseif( $tabname == 'fp_sp_rpelpricing' ) {
                    if( class_exists( 'RewardPointPricingFunctionalities' ) ) {
                        $min_range = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $min_product_price , $min_variation_object ) ;
                        $max_range = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $max_product_price , $max_variation_object ) ;
                    }
                } elseif( $tabname == 'sumo_membership_pricing' ) {
                    if( class_exists( 'SUMOFunctionalityMP' ) ) {
                        $min_range = SUMOFunctionalityMP::sumopricing_for_membership_level( $min_product_price , $min_variation_object ) ;
                        $max_range = SUMOFunctionalityMP::sumopricing_for_membership_level( $max_product_price , $max_variation_object ) ;
                    }
                } else if( $tabname == 'sumo_cat_pro_pricing' ) {
                    $min_range = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $min_product_price , $min_variation_object ) ;
                    $max_range = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $max_product_price , $max_variation_object ) ;
                }
            }
        }

        $original_min = $min_price ;
        $original_max = $max_price ;
        if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
            $original_max = sumo_sd_get_price_including_tax( $object , 1 , $original_max ) ;
            $original_min = sumo_sd_get_price_including_tax( $object , 1 , $original_min ) ;
        } else {
            $original_max = sumo_sd_get_price_excluding_tax( $object , 1 , $original_max ) ;
            $original_min = sumo_sd_get_price_excluding_tax( $object , 1 , $original_min ) ;
        }
        if( $original_min == $original_max ) {
            $original_range = sumo_wc_price( $original_min ) ;
        } else {
            $original_range = sumo_wc_price( $original_min ) . ' – ' . sumo_wc_price( $original_max ) ;
        }

        $min = $min_range != '' ? $min_range : 0 ;
        $max = $max_range != '' ? $max_range : 0 ;

        if( ($min_range != $min_product_price || $max_range != $max_product_price) ) {
            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {

                $min = sumo_sd_get_price_including_tax( $object , 1 , $min ) ;
                $max = sumo_sd_get_price_including_tax( $object , 1 , $max ) ;
            } else {
                $min = sumo_sd_get_price_excluding_tax( $object , 1 , $min ) ;
                $max = sumo_sd_get_price_excluding_tax( $object , 1 , $max ) ;
            }
            if( $min == $max ) {
                $range = sumo_wc_price( $min ) ;
            } elseif( $min < $max ) {
                $range = sumo_wc_price( $min ) . ' – ' . sumo_wc_price( $max ) ;
            } else {
                $range = sumo_wc_price( $max ) . ' – ' . sumo_wc_price( $min ) ;
            }
            if( get_option( 'sumo_price_display_method_with_discounts' , true ) == '2' ) {
                $price_range = '<del>' . $original_range . '</del><ins>' . $range . '</ins>' ;
            } else {
                $price_range = $range ;
            }
        }
    }
    return $price_range ;
}

function sumo_main_function_to_show_discount_tag() {
    global $product ;
    $array       = array() ;
    $arrangement = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $enable_rule = get_option( 'sumo_pricing_tab_sorting' ) ;
    if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
        foreach( $arrangement as $tabname1 ) {
            if( isset( $enable_rule[ $tabname1 ] ) && ($enable_rule[ $tabname1 ] == 'yes') ) {
                if( ! $product->is_type( 'variable' ) ) {
                    $price = ( float ) get_post_meta( sumo_sd_get_product_level_id( $product ) , '_price' , true ) ;
                    if( $price > 0 ) {
                        if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                            $price = sumo_sd_get_price_including_tax( $product , 1 , $price ) ;
                        } else {
                            $price = sumo_sd_get_price_excluding_tax( $product , 1 , $price ) ;
                        }
                        $arrangement = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
                        $enable_rule = get_option( 'sumo_pricing_tab_sorting' ) ;
                        if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
                            foreach( $arrangement as $tabname ) {
                                if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {
                                    if( $tabname == 'fp_sp_userrole_pricing_settings' && $tabname == $tabname1 ) {
                                        if( $price != FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $price , $product ) ) {
                                            $d_price                                    = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $price , $product ) ;
                                            $array[ 'fp_sp_userrole_pricing_settings' ] = $d_price ;
                                        }
                                    } elseif( $tabname == 'fp_sp_rpelpricing' && $tabname == $tabname1 ) {
                                        if( class_exists( 'RewardPointPricingFunctionalities' ) ) {
                                            if( $price != RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $price , $product ) ) {
                                                $d_price                      = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $price , $product ) ;
                                                $array[ 'fp_sp_rpelpricing' ] = $d_price ;
                                            }
                                        }
                                    } elseif( $tabname == 'sumo_membership_pricing' && $tabname == $tabname1 ) {
                                        if( class_exists( 'SUMOFunctionalityMP' ) ) {
                                            if( $price != SUMOFunctionalityMP::sumopricing_for_membership_level( $price , $product ) ) {
                                                $d_price                            = SUMOFunctionalityMP::sumopricing_for_membership_level( $price , $product ) ;
                                                $array[ 'sumo_membership_pricing' ] = $d_price ;
                                            }
                                        }
                                    } elseif( $tabname == $tabname1 ) {

                                        $d_price = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $price , $product ) ;

                                        if( $price != $d_price ) {
                                            $array[ 'sumo_cat_pro_pricing' ] = $d_price ;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if( ! $product->is_type( 'variable' ) ) {
            if( ! empty( $array ) ) {
                $new_array = array_filter( $array ) ;
                if( ! empty( $new_array ) ) {
                    $rule_priority = get_option( 'sumo_site_wide_discounts' ) ;
                    if( $rule_priority == '1' ) {
                        $discounted_price = reset( $new_array ) ;
                        $lprice           = $discounted_price ;
                    } elseif( $rule_priority == '2' ) {
                        $discounted_price = end( $new_array ) ;
                        $lprice           = $discounted_price ;
                    } elseif( $rule_priority == '3' ) {
                        $discounted_price = max( $new_array ) ;
                        $lprice           = $discounted_price ;
                    } else {
                        $discounted_price = min( $new_array ) ;
                        $lprice           = $discounted_price ;
                    }
                    $percent_discount = round( ( ($price - $lprice) / $price ) * 100 ) . ' % ' ;
                    $message          = str_replace( '[discount_info]' , $percent_discount , get_option( 'sumo_discount_tag_lable' ) ) ;
                    echo '<span class="sumo_discount_tag onsale"><strong class="sumo_discount_tag_msg">' . $message . '</strong></span>' ;
                }
            }
        } else {
            if( ! is_product() ) {
                $variations      = $product->get_children() ;
                $first_variation = reset( $variations ) ;
                $off_sale_tag    = sumo_function_to_display_discount_tag_for_variation( sumo_sd_get_variation_object( $first_variation , $product ) ) ;
                $display         = get_option( 'sumo_enable_discount_for_variable_product' ) == 'yes' ? $off_sale_tag : __( 'Sale!' , 'woocommerce' ) ;
                if( $off_sale_tag ) {
                    echo '<span class="sumo_discount_tag onsale"><strong class="sumo_discount_tag_msg">' . $display . '</strong></span>' ;
                }
            }
        }
    }
}

function sumo_main_function_to_show_discount_tag_for_variation() {
    global $product ;
    if( is_product() ) {
        if( $product->is_type( 'variable' ) ) {
            $var_array = array() ;
            foreach( $product->get_children() as $child ) {
                $var_array[ $child ] = sumo_function_to_display_discount_tag_for_variation( sumo_sd_get_variation_object( $child , $product ) ) ;
            }
            $var_array    = array_filter( $var_array ) ;
            $off_sale_tag = get_option( 'sumo_enable_discount_for_variable_product' ) == 'yes' ? reset( $var_array ) : __( 'Sale!' , 'woocommerce' ) ;
            if( ! empty( $var_array ) ) {
                echo '<span class="sumo_discount_tag onsale"><strong class="sumo_discount_tag_msg">' . $off_sale_tag . '</strong></span>' ;
            }
            ?>
            <script type="text/javascript">
                jQuery( document ).ready( function() {
                    jQuery( '.sumo_discount_tag' ).html( '<?php echo '<strong class="sumo_discount_tag_msg">' . $off_sale_tag . '</strong>' ; ?>' ) ;
                    jQuery( '.sumo_discount_tag' ).show() ;
                    jQuery( 'input:hidden[name=variation_id]' ).change( function() {
                        var variationid = jQuery( 'input:hidden[name=variation_id]' ).val() ;
                        if( variationid > 0 ) {
                            var arrayFromPHP = <?php echo json_encode( $var_array ) ; ?> ;
                            if( arrayFromPHP[variationid] ) {
                                jQuery( '.sumo_discount_tag' ).html( '<strong class="sumo_discount_tag_msg">' + arrayFromPHP[variationid] + '</strong>' ) ;
                                jQuery( '.sumo_discount_tag' ).show() ;
                            } else {
                                jQuery( '.sumo_discount_tag' ).hide() ;
                            }
                        } else {
            <?php if( ! empty( $var_array ) ) { ?>
                                jQuery( '.sumo_discount_tag' ).html( '<?php echo '<strong class="sumo_discount_tag_msg">' . $off_sale_tag . '</strong>' ; ?>' ) ;
                                jQuery( '.sumo_discount_tag' ).show() ;
            <?php } else { ?>
                                jQuery( '.sumo_discount_tag' ).hide() ;
            <?php } ?>
                        }
                    } ) ;
                } ) ;
            </script>
            <?php
        }
    }
}

function sumo_function_to_display_discount_tag_for_variation( $variation ) {
    $arrangement     = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $enable_rule     = get_option( 'sumo_pricing_tab_sorting' ) ;
    $array           = array() ;
    $variation_price = ( float ) get_post_meta( sumo_sd_get_product_id( $variation ) , '_price' , true ) ;
    if( $variation_price > 0 ) {
        $discount_amount = $variation_price ;
        if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
            foreach( $arrangement as $tabname ) {
                if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {
                    if( $tabname == 'fp_sp_userrole_pricing_settings' ) {
                        if( $variation_price != FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $variation_price , $variation ) ) {
                            $d_Price = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $variation_price , $variation ) ;
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                            } else {
                                $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                            }
                            $array[ 'fp_sp_userrole_pricing_settings' ] = $d_Price ;
                        }
                    } elseif( $tabname == 'fp_sp_rpelpricing' ) {
                        if( class_exists( 'RewardPointPricingFunctionalities' ) ) {
                            if( $variation_price != RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $variation_price , $variation ) ) {
                                $d_Price = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $variation_price , $variation ) ;
                                if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                    $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                                } else {
                                    $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                                }
                                $array[ 'fp_sp_rpelpricing' ] = $d_Price ;
                            }
                        }
                    } elseif( $tabname == 'sumo_membership_pricing' ) {
                        if( class_exists( 'SUMOFunctionalityMP' ) ) {
                            if( $variation_price != SUMOFunctionalityMP::sumopricing_for_membership_level( $variation_price , $variation ) ) {
                                $d_Price = SUMOFunctionalityMP::sumopricing_for_membership_level( $variation_price , $variation ) ;
                                if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                    $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                                } else {
                                    $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                                }
                                $array[ 'sumo_membership_pricing' ] = $d_Price ;
                            }
                        }
                    } else {

                        $d_Price = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $variation_price , $variation ) ;

                        if( $variation_price != $d_Price ) {
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_Price = sumo_sd_get_price_including_tax( $variation , 1 , $d_Price ) ;
                            } else {
                                $d_Price = sumo_sd_get_price_excluding_tax( $variation , 1 , $d_Price ) ;
                            }
                            $array[ 'sumo_cat_pro_pricing' ] = $d_Price ;
                        }
                    }
                }
            }
        }
        if( ! empty( $array ) ) {
            $new_array = array_filter( $array ) ;
            if( ! empty( $new_array ) ) {
                $rule_priority = get_option( 'sumo_site_wide_discounts' ) ;
                if( $rule_priority == '1' ) {
                    $discounted_price = reset( $new_array ) ;
                } elseif( $rule_priority == '2' ) {
                    $discounted_price = end( $new_array ) ;
                } elseif( $rule_priority == '3' ) {
                    $discounted_price = max( $new_array ) ;
                } else {
                    $discounted_price = min( $new_array ) ;
                }
                $message = get_option( 'sumo_discount_tag_lable' ) ;
                if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                    $variation_price_tag = sumo_sd_get_price_including_tax( $variation , 1 , $variation_price ) ;
                } else {
                    $variation_price_tag = sumo_sd_get_price_excluding_tax( $variation , 1 , $variation_price ) ;
                }
                $percent_discount = round( ( ($variation_price_tag - $discounted_price) / $variation_price_tag ) * 100 ) . ' % ' ;
                $message          = str_replace( '[discount_info]' , $percent_discount , $message ) ;
                return $message ;
            }
        }
    }
}

function sumo_quantity_pricing_table() {
    ?>
    <style>
        div.related .pricing_table{
            display: none;

        }
        <?php echo get_option( 'sumo_discount_custom_css' ) ; ?>
    </style>
    <?php
}

function check_sumo_discounts_are_applied_in_this_order( $order_id ) {
    $cart_content = WC()->cart->cart_contents ;
    sumo_update_discounts_in_order( $order_id ) ;
    if( check_sumo_discounts_are_applied_in_cart() ) {
        update_post_meta( $order_id , 'sumo_discounts_applied' , 'yes' ) ;
    }
}

function consider_sw_disc_as_sale_products( $bool , $product ) {

    if( get_option( 'sumo_consider_swdis_as_sale_products' ) == 'yes' ) {
        $product_id        = sumo_sd_get_product_id( $product ) ;
        $sitewidediscounts = check_sitewide_discounts_are_applied( $product_id ) ;

        if( $sitewidediscounts ) {
            $bool = true ;
        }
    }
    return $bool ;
}

function check_sumo_discounts_are_applied_in_cart() {
    $cart_content  = WC()->cart->cart_contents ;
    $bulkdiscounts = array() ;
    if( empty( $cart_content ) )
        return false ;

    foreach( $cart_content as $key => $value ) {
        $product_id        = $value[ 'variation_id' ] > 0 ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
        $sitewidediscounts = check_sitewide_discounts_are_applied( $product_id ) ;
        if( $sitewidediscounts ) {
            return true ;
        }
        $bulkdiscounts[] = WC()->session->__get( $key . 'bulk_discounts_applied' ) ;
    }
    if( in_array( 'yes' , $bulkdiscounts ) ) {
        return true ;
    }
    if( WC()->session->get( 'cart_discount' ) ) {
        return true ;
    }
    if( ! is_checkout() ) {
        if( WC()->session->get( 'check_if_fee_exist' ) != 'yes' && WC()->session->get( 'check_if_fee_exist' ) != NULL ) {
            return true ;
        }
    }

    return false ;
}

function sumo_update_discounts_in_order( $order_id ) {
    $cart_content = WC()->cart->cart_contents ;
    foreach( $cart_content as $key => $value ) {
        $product_id        = $value[ 'variation_id' ] > 0 ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
        $sitewidediscounts = check_sitewide_discounts_are_applied( $product_id ) ;
        if( $sitewidediscounts || 'yes' == WC()->session->__get( $key . 'bulk_discounts_applied' ) ) {
            update_post_meta( $order_id , 'sumo_discounts_applied_for_' . $product_id , 'yes' ) ;
            $bulk_discount_price_html = WC()->session->__get( $product_id . 'bulk_discounts_applied' ) ;
            update_post_meta( $order_id , 'sumo_discounts_price_html_of' . $product_id , $bulk_discount_price_html ) ;
        }
    }
    if( WC()->session->get( 'cart_discount' ) ) {
        $cart_total_discount = WC()->session->__get( 'cart_discount_value' ) ;
        update_post_meta( $order_id , 'cart_discount_value' , $cart_total_discount ) ;
        update_post_meta( $order_id , 'sumo_cart_total_discounts_applied' , 'yes' ) ;
    } else {
        update_post_meta( $order_id , 'sumo_cart_total_discounts_applied' , 'no' ) ;
    }
}

function check_sitewide_discounts_are_applied( $product_id ) {
    $discounted_price = false ;
    $price            = get_post_meta( $product_id , '_price' , true ) ;
    $product          = sumo_sd_get_product( $product_id ) ;
    if( class_exists( 'SUMOMemberships_Restrictions' ) ) {
        $mem_obj                     = new SUMOMemberships_Restrictions() ;
        $sumo_membership_restriction = $mem_obj->sumo_membership_compatibility_for_sumo_discounts( $price , $product ) ;
        if( $sumo_membership_restriction ) {
            return false ;
        }
    }
    $arrangement   = get_option( 'drag_and_drop_rule_priority_for_site_wide_discounts' ) ;
    $enable_rule   = get_option( 'sumo_pricing_tab_sorting' ) ;
    $array         = array() ;
    $product_price = ( float ) get_post_meta( $product_id , '_price' , true ) ;
    if( is_array( $arrangement ) && ! empty( $arrangement ) ) {
        foreach( $arrangement as $tabname ) {
            if( isset( $enable_rule[ $tabname ] ) && ($enable_rule[ $tabname ] == 'yes') ) {
                if( $tabname == 'fp_sp_userrole_pricing_settings' ) {
                    if( $product_price != FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $product_price , $product ) ) {
                        $d_price = FP_SP_UserRolePricing_Functionalities::sp_alter_product_price_as_per_user_role( $product_price , $product ) ;
                        if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                            $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                        } else {
                            $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                        }
                        $array[ 'fp_sp_userrole_pricing_settings' ] = $d_price ;
                    }
                } elseif( $tabname == 'fp_sp_rpelpricing' ) {
                    if( class_exists( 'RewardPointPricingFunctionalities' ) ) {
                        if( $product_price != RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $product_price , $product ) ) {
                            $d_price = RewardPointPricingFunctionalities::sp_alter_product_price_as_per_earned_points( $product_price , $product ) ;
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                            } else {
                                $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                            }
                            $array[ 'fp_sp_rpelpricing' ] = $d_price ;
                        }
                    }
                } elseif( $tabname == 'sumo_membership_pricing' ) {
                    if( class_exists( 'SUMOFunctionalityMP' ) ) {
                        if( $product_price != SUMOFunctionalityMP::sumopricing_for_membership_level( $product_price , $product ) ) {
                            $d_price = SUMOFunctionalityMP::sumopricing_for_membership_level( $product_price , $product ) ;
                            if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                                $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                            } else {
                                $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                            }
                            $array[ 'sumo_membership_pricing' ] = $d_price ;
                        }
                    }
                } else {
                    $d_price = CategoryProductPricingFunctionalities::sp_alter_product_price_as_per_category_product_type( $product_price , $product ) ;

                    if( $product_price != $d_price ) {
                        if( get_option( 'woocommerce_tax_display_shop' ) == 'incl' ) {
                            $d_price = sumo_sd_get_price_including_tax( $product , 1 , $d_price ) ;
                        } else {
                            $d_price = sumo_sd_get_price_excluding_tax( $product , 1 , $d_price ) ;
                        }
                        $array[ 'sumo_cat_pro_pricing' ] = $d_price ;
                    }
                }
            }
        }
    }
    if( ! empty( $array ) ) {
        $new_array = array_filter( $array ) ;
        if( ! empty( $new_array ) ) {
            $rule_priority = get_option( 'sumo_site_wide_discounts' ) ;
            if( $rule_priority == '1' ) {
                $discounted_price = reset( $new_array ) ;
            } elseif( $rule_priority == '2' ) {
                $discounted_price = end( $new_array ) ;
            } elseif( $rule_priority == '3' ) {
                $discounted_price = max( $new_array ) ;
            } else {
                $discounted_price = min( $new_array ) ;
            }
        }
    }
    return $discounted_price ;
}

function woocommerce_order_formatted_line_subtotal_action( $subtotal , $lineitem , $order ) {
    $qty                = isset( $lineitem[ 'quantity' ] ) ? $lineitem[ 'quantity' ] : $lineitem[ 'qty' ] ;
    $order_id           = ( float ) WC_VERSION >= ( float ) '3.0' ? $order->get_id() : $order->id ;
    $product_id         = $lineitem[ 'variation_id' ] ? $lineitem[ 'variation_id' ] : $lineitem[ 'product_id' ] ;
    $_discounts_applied = get_post_meta( $order_id , 'sumo_discounts_applied_for_' . $product_id , true ) ;
    if( $_discounts_applied == 'yes' ) {
        $product        = wc_get_product( $product_id ) ;
        $original_price = $product->get_sale_price() ? $product->get_sale_price() : $product->get_regular_price() ;
        if( ( float ) WC_VERSION >= ( float ) '3.0' ) {
            $price = wc_format_sale_price( wc_get_price_to_display( $product , array( 'price' => $original_price * $qty ) ) , $subtotal ) ;
        } else {
            $price = $product->get_price_html_from_to( $original_price * $qty , $subtotal ) ;
        }
        $subtotal = $price ;
    }
    return $subtotal ;
}

function woocommerce_order_get_total_discount_action( $discount , $order ) {
    $order_id             = ( float ) WC_VERSION >= ( float ) '3.0' ? $order->get_id() : $order->id ;
    $cart_total_discounts = get_post_meta( $order_id , 'sumo_cart_total_discounts_applied' , true ) ;
    if( $cart_total_discounts == 'yes' ) {
        $cart_total_discount_value = get_post_meta( $order_id , 'cart_discount_value' , true ) ;
        if( $cart_total_discount_value ) {
            $discount = $cart_total_discount_value + $discount ;
        }
    }
    return $discount ;
}

function sumodiscounts_validate_coupons_on_cart( $valid , $coupon ) {
    if( check_sumo_discounts_are_applied_in_cart() && get_option( 'sumo_allow_wc_coupons_on_cart' , 'yes' ) == 'no' ) {
        $valid = false ;
    }
    return $valid ;
}

function woocommerce_cart_calculate_fees() {
    $SessionValue = WC()->session->get( 'check_if_fee_exist' ) ;
    if( $SessionValue == 'yes' || $SessionValue == NULL )
        return ;

    $discount_type = get_option( 'srp_discount_type' , 'percent' ) ;
    if( $discount_type == 'percent' ) {
        $amount = (( float ) WC()->cart->get_subtotal() * ( float ) get_option( 'srp_discount_value' , 0 ) ) / 100 ;
    } else {
        $amount = ( float ) get_option( 'srp_discount_value' , 0 ) ;
    }
//    $amount = wc_add_number_precision_deep($amount);
    WC()->cart->add_fee( get_option( 'srp_discount_label' , 'Discount' ) , -$amount , true ) ;
}

function adding_fee_to_display_tax_value( $tax , $fee ) {
    if( get_option( 'srp_discount_label' , 'Discount' ) )
        return array() ;
    else
        return $tax ;
}

function add_fee_for_user() {
    check_ajax_referer( 'secure_ajax_sd' , 'sumo_security' ) ;

    if( ! isset( $_POST ) || ! isset( $_POST[ 'billing_email' ] ) )
        throw new exception( __( 'Invalid Request' , 'sumodiscounts' ) ) ;

    try {
        $hide_redeem_fields       = false ;
        $hide_earn_points_message = false ;
        $hide_coupon_field        = false ;
        if( isset( $_COOKIE[ 'rsreferredusername' ] ) ) {
            $userinfo                  = (get_option( 'rs_generate_referral_link_based_on_user' ) == 1) ? get_user_by( 'login' , $_COOKIE[ 'rsreferredusername' ] ) : get_user_by( 'id' , $_COOKIE[ 'rsreferredusername' ] ) ;
            $referreremail             = $userinfo->user_email ;
            $CheckIfAlreadyHasDiscount = $_POST[ 'billing_email' ] != '' ? check_if_user_has_discount( $_POST[ 'billing_email' ] , $referreremail ) : "yes" ;
            WC()->session->set( 'check_if_fee_exist' , $CheckIfAlreadyHasDiscount ) ;

            if( $CheckIfAlreadyHasDiscount == 'no' ) {
                if( class_exists( 'FPRewardSystem' ) ) {
                    if( get_option( 'rs_discounts_compatability_activated' ) == 'yes' ) {
                        if( get_option( 'rs_show_redeeming_field' ) == '2' ) {
                            $hide_redeem_fields = true ;
                        }
                        if( get_option( '_rs_not_allow_earn_points_if_sumo_discount' ) == 'yes' ) {
                            $hide_earn_points_message = true ;
                        }
                        if( get_option( '_rs_show_hide_coupon_if_sumo_discount' ) == 'yes' ) {
                            $hide_coupon_field = true ;
                        }
                    }
                }
            }
        }
        wp_send_json_success( array(
            'hide_redeem_field'        => $hide_redeem_fields ,
            'hide_earn_points_message' => $hide_earn_points_message ,
            'hide_coupon_field'        => $hide_coupon_field ,
                )
        ) ;
    } catch( Exception $e ) {
        wp_send_json_error( array( 'error' => $e->getMessage() ) ) ;
    }
}

function check_if_user_has_discount( $billing_email , $referreremail ) {
    if( $billing_email == $referreremail )
        return 'yes' ;

    if( is_user_logged_in() ) {
        $user_id    = get_current_user_id() ;
        $user_info  = get_user_by( 'ID' , $user_id ) ;
        $user_email = $user_info->user_email ;
        if( $user_email != $billing_email )
            return 'yes' ;

        $OrderCount = get_posts( array(
            'numberposts' => -1 ,
            'meta_key'    => '_customer_user' ,
            'meta_value'  => $user_id  ,
            'post_type'   => wc_get_order_types() ,
            'post_status' => array( 'wc-pending' , 'wc-processing' , 'wc-on-hold' , 'wc-completed' ) ,
                ) ) ;

        if( ! (count( $OrderCount ) >= 1) )
            return 'no' ;
    }else {
        $args     = array(
            'post_type'      => 'shop_order' ,
            'post_status'    => array( 'wc-processing' , 'wc-completed' , 'wc-on-hold' , 'wc-pending' ) ,
            'meta_query'     => array(
                array(
                    'key'     => '_billing_email' ,
                    'value'   => $billing_email ,
                    'compare' => '=' ,
                ) ,
            ) ,
            'posts_per_page' => 1 ,
            'fields'         => 'ids'
                ) ;
        $OrderIds = get_posts( $args ) ;
        if( empty( $OrderIds ) )
            return 'no' ;
    }
    return 'yes' ;
}

/*
 * Variation product table display
 */
function variation_product_disp_table() {
    if( isset( $_POST[ 'var_id_data' ] ) ) {
        $sd_var_id  = $_POST[ 'var_id_data' ] ;
        $var_obj    = new WC_Product_Variation( $sd_var_id ) ;
        $reg_price  = $var_obj->get_regular_price() ;
        $sale_price = $var_obj->get_sale_price() ;
        $price      = ($sale_price == 0 ? $reg_price : $sale_price) ;
        echo sumo_product_range_construct_table( $sd_var_id , $price ) ;
    }
    exit() ;
}