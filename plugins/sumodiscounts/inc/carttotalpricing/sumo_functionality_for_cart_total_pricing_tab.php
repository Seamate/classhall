<?php

class CartTotalFunctionalities {

    public function __construct() {

        $array = get_option( 'sumo_pricing_tab_sorting' ) ;

        if ( is_array( $array ) && ! empty( $array ) ) {

            if ( array_key_exists( 'sumo_cart_pricing' , $array ) ) {

                if ( $array[ 'sumo_cart_pricing' ] == 'yes' ) {

                    add_filter( 'woocommerce_get_discounted_price' , array( $this , 'excluding_tax_cart_discount' ) , 10 , 3 ) ;

                    add_action( 'woocommerce_cart_calculate_fees' , array( $this , 'woo_add_cart_fee_in_checkout' ) ) ;

                    add_filter( 'woocommerce_cart_totals_fee_html' , array( $this , 'alter_the_cart_discount_html_format' ) , 10 , 2 ) ;
                }
            }
        }
    }

    public static function alter_the_cart_discount_html_format( $cart_fee_html , $fee ) {
        global $woocommerce ;
        WC()->session->__unset( 'cart_discount_value' ) ;
        $get_id_of_fee = $fee->id ;
        $label_id      = get_option( 'sp_cart_discount_fees_label' ) ;
        $label_id      = sanitize_title( $label_id ) ;
        if ( $get_id_of_fee === $label_id ) {
            $tax_rates = WC_Tax::get_rates( $fee->tax_class ) ;
            if ( ($woocommerce->session->get( 'cart_discount' ) !== null ) ) {
                global $woocommerce ;
                $array         = $woocommerce->session->get( 'cart_discount' ) ;
                $discount      = $array[ 'discount_value' ] ;
                $fee_taxes     = WC_Tax::calc_tax( $discount , $tax_rates , false ) ;
                $fees_tax      = array_sum( $fee_taxes ) ;
                $tax           = ( 'excl' == WC()->cart->tax_display_cart ) ? ($discount) : ($discount + $fees_tax) ;
                $cart_fee_html = '-' . wc_price( $tax ) ;
            }
        }
        return $cart_fee_html ;
    }

    public static function excluding_tax_cart_discount( $price , $value , $object ) {
        global $woocommerce ;
        $discount_amount  = ( float ) ($object->get_cart_discount_total()) ;
        $get_total_ex_tax = ( float ) $object->subtotal_ex_tax - $discount_amount ;
        self::before_calculate_total_action( $get_total_ex_tax ) ;
        if ( ($woocommerce->session->get( 'cart_discount' ) !== null ) ) {
            global $woocommerce ;
            $array                = $woocommerce->session->get( 'cart_discount' ) ;
            $discount             = $array[ 'discount_value' ] ;
            $price_total          = $price * $value[ 'quantity' ] ;
            $discount_calculation = ($discount / $get_total_ex_tax) * ($price_total) ;
            $remaining_value      = $price_total - $discount_calculation ;
            $remaining_value      = $remaining_value / $value[ 'quantity' ] ;
        } else {
            $remaining_value = $price ;
        }
        return $remaining_value ;
    }

    public static function before_calculate_total_action( $sub_total_ex_tax ) {
        global $woocommerce ;
        $userid          = get_current_user_id() ;
        $discount_amount = 0 ;
        $total           = $sub_total_ex_tax ;
        $cart_object     = $woocommerce->cart ;
        $get_data        = get_option( 'sumo_pricing_rule_fields_for_cart' ) ;
        $array           = array() ;
        $mtotal          = '' ;
        $save_price      = '' ;
        $currentdate     = strtotime( date_i18n( 'd-m-Y' ) ) ;
        if ( is_array( $get_data ) && ! empty( $get_data ) ) {
            foreach ( $get_data as $unique_id => $each_cart_rule ) {
                if ( isset( $each_cart_rule[ 'sumo_enable_the_rule' ] ) ) {
                    if ( $each_cart_rule[ 'sumo_enable_the_rule' ] == 'yes' ) {
                        $fromdate = $each_cart_rule[ 'sumo_pricing_from_datepicker' ] != '' ? strtotime( $each_cart_rule[ 'sumo_pricing_from_datepicker' ] ) : NULL ;
                        $todate   = $each_cart_rule[ 'sumo_pricing_to_datepicker' ] != '' ? strtotime( $each_cart_rule[ 'sumo_pricing_to_datepicker' ] ) : strtotime( date_i18n( 'd-m-Y' ) ) ;
                        if ( $fromdate && $todate ) {
                            if ( ($currentdate >= $fromdate) && ($currentdate <= $todate) ) {
                                $array[ $unique_id ] = self::check_cart_rule_for_weekdays( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                            }
                        } else {
                            if ( $currentdate <= $todate ) {
                                $array[ $unique_id ] = self::check_cart_rule_for_weekdays( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                            }
                        }
                    }
                }
            }
        }
        $uniq_id_array_for_display_next_offer = array() ;
        $rule_not_empty                       = array_filter( $array ) ;
        if ( is_array( $rule_not_empty ) && ! empty( $rule_not_empty ) ) {
            foreach ( $rule_not_empty as $uniq => $_check_row_not_empty ) {
                foreach ( $_check_row_not_empty as $uniq_row_id => $val ) {
                    if ( $val == NULL ) {
                        $uniq_id_array_for_display_next_offer[ $uniq ][] = $uniq_row_id ;
                    }
                }
            }
        }
        $array_to_display_messages = array( 'next_offer_array' => $uniq_id_array_for_display_next_offer , 'rule' => $get_data , 'total' => $total ) ;
        if ( ! empty( $array ) ) {
            WC()->session->__unset( 'cart_discount' ) ;
            WC()->session->__unset( 'cart_discount_value' ) ;
            WC()->session->__unset( 'applied_cart_discount_rule_id' ) ;
            $save_row_id         = array() ;
            $save_rule_id        = '' ;
            $price_at_rule_level = array() ;
            foreach ( $array as $unique_id => $each_array ) {
                if ( is_array( $each_array ) ) {
                    $price_at_row_level = array() ;
                    $price_at_row_float = array() ;
                    foreach ( $each_array as $unique_row_id => $each_row ) {
                        if ( is_array( $each_row ) ) {
                            if ( $each_row[ 'discount_type' ] == '1' ) {
                                $save_price = ($total - ($total * ($each_row[ 'value' ] / 100))) ;
                            } elseif ( $each_row[ 'discount_type' ] == '2' ) {
                                $save_price = ($total - $each_row[ 'value' ]) ;
                            }
                            $price_at_row_float[ $unique_id ][ $unique_row_id ] = $save_price ;
                        }
                    }
                    if ( ! empty( $price_at_row_float ) ) {
                        if ( $get_data[ $unique_id ][ 'sumo_dynamic_rule_priority' ] == '1' ) {
                            $DiscountedPrice                         = reset( $price_at_row_float[ $unique_id ] ) ;
                            $price_at_rule_level[ $unique_id ]       = $DiscountedPrice ;
                            $DataForFreeShipping[ $DiscountedPrice ] = $unique_id ;
                        } elseif ( $get_data[ $unique_id ][ 'sumo_dynamic_rule_priority' ] == '2' ) {
                            $DiscountedPrice                         = end( $price_at_row_float[ $unique_id ] ) ;
                            $price_at_rule_level[ $unique_id ]       = $DiscountedPrice ;
                            $DataForFreeShipping[ $DiscountedPrice ] = $unique_id ;
                        } elseif ( $get_data[ $unique_id ][ 'sumo_dynamic_rule_priority' ] == '3' ) {
                            $DiscountedPrice                         = max( $price_at_row_float[ $unique_id ] ) ;
                            $price_at_rule_level[ $unique_id ]       = $DiscountedPrice ;
                            $DataForFreeShipping[ $DiscountedPrice ] = $unique_id ;
                        } elseif ( $get_data[ $unique_id ][ 'sumo_dynamic_rule_priority' ] == '4' ) {
                            $DiscountedPrice                         = min( $price_at_row_float[ $unique_id ] ) ;
                            $price_at_rule_level[ $unique_id ]       = $DiscountedPrice ;
                            $DataForFreeShipping[ $DiscountedPrice ] = $unique_id ;
                        }
                        $save_row_id[ $unique_id ] = array_search( $price_at_rule_level[ $unique_id ] , $price_at_row_float[ $unique_id ] ) ;
                    }
                }
            }
            if ( ! empty( $price_at_rule_level ) ) {
                if ( get_option( 'sumo_cart_pricing_priority_settings' ) == '1' ) {
                    $mtotal = reset( $price_at_rule_level ) ;
                } elseif ( get_option( 'sumo_cart_pricing_priority_settings' ) == '2' ) {
                    $mtotal = end( $price_at_rule_level ) ;
                } elseif ( get_option( 'sumo_cart_pricing_priority_settings' ) == '3' ) {
                    $mtotal = max( $price_at_rule_level ) ;
                } elseif ( get_option( 'sumo_cart_pricing_priority_settings' ) == '4' ) {
                    $mtotal = min( $price_at_rule_level ) ;
                }
                $save_rule_id = array_search( $mtotal , $price_at_rule_level ) ;
            }
            if ( $mtotal !== '' ) {
                if ( $total > $mtotal ) {
                    $fees            = ( float ) ($total - $mtotal) ;
                    $discount_amount = ( float ) $fees ;
                }
                $for_log = array( 'type' => 'Cart Total Discount' , 'rule_id' => $save_rule_id , 'row_id' => $save_row_id[ $save_rule_id ] , 'discount_value' => $discount_amount , 'cart_total' => $mtotal ) ;
                WC()->session->set( 'cart_discount' , $for_log ) ;
                WC()->session->set( 'cart_discount_value' , $discount_amount ) ;
                WC()->session->set( 'applied_cart_discount_rule_id' , $DataForFreeShipping ) ;
                WC()->session->__unset( 'cart_discount_message' ) ;
            } else {
                WC()->session->__unset( 'cart_discount' ) ;
                WC()->session->__unset( 'cart_discount_value' ) ;
                WC()->session->__unset( 'applied_cart_discount_rule_id' ) ;
                WC()->session->set( 'cart_discount_message' , $array_to_display_messages ) ;
            }
        } else {
            WC()->session->__unset( 'cart_discount' ) ;
            WC()->session->__unset( 'cart_discount_value' ) ;
            WC()->session->__unset( 'applied_cart_discount_rule_id' ) ;
            WC()->session->set( 'cart_discount_message' , $array_to_display_messages ) ;
        }
    }

    public static function woo_add_cart_fee_in_checkout() {
        global $woocommerce ;
        if ( ($woocommerce->session->get( 'cart_discount' ) !== null ) ) {
            global $woocommerce ;
            $array               = $woocommerce->session->get( 'cart_discount' ) ;
            $amount              = 0 ;
            $cart_discount_label = get_option( 'sp_cart_discount_fees_label' ) ;
            $woocommerce->cart->add_fee( $cart_discount_label , $amount , true ) ;
        }
    }

    public static function check_cart_rule_for_weekdays( $each_cart_rule , $cart_object , $unique_id , $total ) {

        $weekdays    = array( 'monday' , 'tuesday' , 'wednesday' , 'thursday' , 'friday' , 'saturday' , 'sunday' ) ;
        $currentday  = date( 'l' ) ;
        $currentdays = strtolower( $currentday ) ;
        foreach ( $weekdays as $weekday ) {
            if ( $currentdays == $weekday ) {
                $day = "sumo_pricing_rule_week_" . $weekday ;
                if ( isset( $each_cart_rule[ $day ] ) ) {
                    if ( $each_cart_rule[ $day ] == '1' ) {
                        return self::check_cart_rule_for_user( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                    }
                }
            }
        }
    }

    public static function check_cart_rule_for_user( $each_cart_rule , $cart_object , $unique_id , $total ) {
        global $current_user ;
        $user_id         = get_current_user_id() ;
        $user_array      = array() ;
        $check_not_empty = array() ;
        $array           = array() ;
        if ( $each_cart_rule[ 'sumo_pricing_apply_for_user_type' ] == '1' ) {
            if ( $user_id > 0 ) {
                if ( self::check_for_user_purchase_history( $each_cart_rule ) ) {
                    return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                }
            } else {
                return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
            }
        } elseif ( $each_cart_rule[ 'sumo_pricing_apply_for_user_type' ] == '2' ) {
            if ( ($user_id > 0) && (self::check_for_user_purchase_history( $each_cart_rule )) ) {
                if ( $each_cart_rule[ 'sumo_pricing_apply_to_user' ] == '1' ) {
                    return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                } elseif ( $each_cart_rule[ 'sumo_pricing_apply_to_user' ] == "2" ) {
                    $user_array1 = ! is_array( $each_cart_rule[ 'sumo_pricing_apply_to_include_users' ] ) ? explode( ',' , $each_cart_rule[ 'sumo_pricing_apply_to_include_users' ] ) : $each_cart_rule[ 'sumo_pricing_apply_to_include_users' ] ;
                    $user_array  = array_filter( $user_array1 ) ;
                    if ( ! empty( $user_array ) ) {
                        if ( in_array( $user_id , $user_array ) ) {
                            return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                } elseif ( $each_cart_rule[ 'sumo_pricing_apply_to_user' ] == '3' ) {
                    $user_array1 = ! is_array( $each_cart_rule[ 'sumo_pricing_apply_to_exclude_users' ] ) ? explode( ',' , $each_cart_rule[ 'sumo_pricing_apply_to_exclude_users' ] ) : $each_cart_rule[ 'sumo_pricing_apply_to_exclude_users' ] ;
                    $user_array  = array_filter( $user_array1 ) ;
                    if ( ! empty( $user_array ) ) {
                        if ( ! in_array( $user_id , $user_array ) ) {
                            return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                } elseif ( $each_cart_rule[ 'sumo_pricing_apply_to_user' ] == '4' ) {
                    return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                } elseif ( $each_cart_rule[ 'sumo_pricing_apply_to_user' ] == '5' ) {
                    if ( isset( $each_cart_rule[ 'sumo_pricing_apply_to_include_users_role' ] ) ) {
                        $array = $each_cart_rule[ 'sumo_pricing_apply_to_include_users_role' ] ;
                    }
                    if ( ! empty( $array ) ) {
                        $check_not_empty = (array_intersect( $current_user->roles , $array )) ;
                        if ( ! empty( $check_not_empty ) ) {
                            return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                } elseif ( $each_cart_rule[ 'sumo_pricing_apply_to_user' ] == '6' ) {
                    if ( isset( $each_cart_rule[ 'sumo_pricing_apply_to_exclude_users_role' ] ) ) {
                        $array = $each_cart_rule[ 'sumo_pricing_apply_to_exclude_users_role' ] ;
                    }
                    if ( ! empty( $array ) ) {
                        $check_empty = (array_intersect( $current_user->roles , $array )) ;
                        if ( empty( $check_empty ) ) {
                            return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                } elseif ( $each_cart_rule[ 'sumo_pricing_apply_to_user' ] == '7' ) {
                    if ( isset( $each_cart_rule[ 'sumo_pricing_apply_to_exclude_users_role' ] ) ) {
                        $array = $each_cart_rule[ 'sumo_pricing_apply_to_exclude_users_role' ] ;
                    }
                    if ( ! empty( $array ) ) {
                        $check_empty = (array_intersect( $current_user->roles , $array )) ;
                        if ( empty( $check_empty ) ) {
                            return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                    if ( class_exists( 'SUMOMemberships' ) && sumo_get_membership_levels() ) {
                        $plans       = is_array( $each_cart_rule[ 'sumo_pricing_apply_to_include_memberplans' ] ) ? $each_cart_rule[ 'sumo_pricing_apply_to_include_memberplans' ] : array() ;
                        $new_post_id = sumo_get_member_post_id( $user_id ) ;
                        if ( $new_post_id > 0 ) {
                            if ( ! empty( $plans ) ) {
                                foreach ( $plans as $plan_id ) {
                                    if ( ! sumo_plan_is_already_had( $plan_id , $new_post_id ) ) {
                                        return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                                    }
                                }
                            } else {
                                return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                            }
                        }
                    }
                }
            }
        } else {
            if ( $user_id == 0 ) {
                return self::check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) ;
            }
        }
    }

    public static function check_for_user_purchase_history( $each_cart_rule ) {
        if ( $each_cart_rule[ 'sumo_user_purchase_history' ] == '' ) {
            return true ;
        } elseif ( $each_cart_rule[ 'sumo_user_purchase_history' ] == '1' ) {
            $no_of_orders_required = ( int ) $each_cart_rule[ 'sumo_no_of_orders_placed' ] ;
            $no_of_orders_placed   = sumo_get_no_of_orders_placed( get_current_user_id() , $each_cart_rule[ 'sumo_u_p_history_time' ] , $each_cart_rule[ 'sumo_uph_from_datepicker' ] , $each_cart_rule[ 'sumo_uph_to_datepicker' ] ) ;
            if ( $no_of_orders_placed >= $no_of_orders_required ) {
                return true ;
            }
        } elseif ( $each_cart_rule[ 'sumo_user_purchase_history' ] == '2' ) {
            $spent_in_site_required = ( float ) $each_cart_rule[ 'sumo_total_amount_spent_in_site' ] ;
            $amount_spented         = ( float ) sumo_get_customer_total_spent( get_current_user_id() , $each_cart_rule[ 'sumo_u_p_history_time' ] , $each_cart_rule[ 'sumo_uph_from_datepicker' ] , $each_cart_rule[ 'sumo_uph_to_datepicker' ] ) ;
            if ( $amount_spented >= $spent_in_site_required ) {
                return true ;
            }
        }
    }

    public static function check_cart_rule_for_product_and_categories( $each_cart_rule , $cart_object , $unique_id , $total ) {

        $product_array    = array() ;
        $category_in_cart = array() ;
        $tag_in_cart      = array() ;
        $product_in_cart  = array() ;
        $sale_price_array = array() ;
        foreach ( $cart_object->cart_contents as $cart_item_key => $cart_item_value ) {
            $product_id         = $cart_item_value[ 'variation_id' ] != ('' && 0) ? $cart_item_value[ 'variation_id' ] : $cart_item_value[ 'product_id' ] ;
            $sale_price_array[] = ( float ) get_post_meta( $product_id , '_sale_price' , true ) ;
            $product_in_cart[]  = $product_id ;
            $category           = get_the_terms( $cart_item_value[ 'product_id' ] , 'product_cat' ) ;
            if ( is_array( $category ) && ! empty( $category ) ) {
                foreach ( $category as $each_category ) {
                    $category_in_cart[] = $each_category->term_id ;
                }
            }
            $tag = get_the_terms( $cart_item_value[ 'product_id' ] , 'product_tag' ) ;
            if ( is_array( $tag ) && ! empty( $tag ) ) {
                foreach ( $tag as $each_tag ) {
                    $tag_in_cart[] = $each_tag->term_id ;
                }
            }
        }

        if ( self::check_cart_rule_for_having_sale_prices( $each_cart_rule , $sale_price_array ) ) {
            $product_array  = array() ;
            $category_array = array() ;
            $tag_array      = array() ;
            if ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '1' ) {
                return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '2' ) {
                $product_array1 = ! is_array( $each_cart_rule[ 'sumo_pricing_apply_to_include_products_for_cart' ] ) ? explode( ',' , $each_cart_rule[ 'sumo_pricing_apply_to_include_products_for_cart' ] ) : $each_cart_rule[ 'sumo_pricing_apply_to_include_products_for_cart' ] ;
                $product_array  = array_filter( $product_array1 ) ;
                if ( ! empty( $product_array ) ) {
                    $check_not_empty = (array_intersect( $product_in_cart , sumo_dynamic_pricing_translated_array( $product_array ) )) ;
                    if ( isset( $each_cart_rule[ 'sumo_pricing_inc_condition' ] ) && $each_cart_rule[ 'sumo_pricing_inc_condition' ] == '2' ) {
                        $count_product_array = count( sumo_dynamic_pricing_translated_array( $product_array ) ) ;
                        if ( count( $check_not_empty ) == $count_product_array ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    } elseif ( isset( $each_cart_rule[ 'sumo_pricing_inc_condition' ] ) && $each_cart_rule[ 'sumo_pricing_inc_condition' ] == '3' ) {
                        $count_product_array = count( sumo_dynamic_pricing_translated_array( $product_array ) ) ;
                        if ( count( $check_not_empty ) == $count_product_array && $count_product_array == count( $product_in_cart ) ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    } else {
                        if ( ! empty( $check_not_empty ) ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                }
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '3' ) {
                $product_array1 = ! is_array( $each_cart_rule[ 'sumo_pricing_apply_to_exclude_products_for_cart' ] ) ? explode( ',' , $each_cart_rule[ 'sumo_pricing_apply_to_exclude_products_for_cart' ] ) : $each_cart_rule[ 'sumo_pricing_apply_to_exclude_products_for_cart' ] ;
                $product_array  = array_filter( $product_array1 ) ;
                if ( ! empty( $product_array ) ) {
                    $check_empty = (array_intersect( $product_in_cart , sumo_dynamic_pricing_translated_array( $product_array ) )) ;
                    if ( empty( $check_empty ) ) {
                        return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                    }
                }
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '4' ) {
                if ( isset( $each_cart_rule[ 'sumo_pricing_apply_to_include_category_for_cart' ] ) ) {
                    $category_array = $each_cart_rule[ 'sumo_pricing_apply_to_include_category_for_cart' ] ;
                }
                if ( ! empty( $category_array ) ) {
                    $check_not_empty = (array_intersect( $category_in_cart , sumo_dynamic_pricing_translated_array( $category_array ) )) ;
                    if ( isset( $each_cart_rule[ 'sumo_pricing_inc_condition' ] ) && $each_cart_rule[ 'sumo_pricing_inc_condition' ] == '2' ) {
                        $count_category_array = count( sumo_dynamic_pricing_translated_array( $category_array ) ) ;
                        if ( count( $check_not_empty ) == $count_category_array ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    } elseif ( isset( $each_cart_rule[ 'sumo_pricing_inc_condition' ] ) && $each_cart_rule[ 'sumo_pricing_inc_condition' ] == '3' ) {
                        $count_category_array = count( sumo_dynamic_pricing_translated_array( $category_array ) ) ;
                        if ( count( $check_not_empty ) == $count_category_array && $count_category_array == count( $category_in_cart ) ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    } else {
                        if ( ! empty( $check_not_empty ) ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                }
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '5' ) {
                if ( isset( $each_cart_rule[ 'sumo_pricing_apply_to_exclude_category_for_cart' ] ) ) {
                    $category_array = $each_cart_rule[ 'sumo_pricing_apply_to_exclude_category_for_cart' ] ;
                }
                $check_empty = (array_intersect( $category_in_cart , sumo_dynamic_pricing_translated_array( $category_array ) )) ;
                if ( ! empty( $category_array ) ) {
                    if ( empty( $check_empty ) ) {
                        return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                    }
                }
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '6' ) {
                if ( ! empty( $category_in_cart ) ) {
                    return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                }
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '8' ) {
                if ( isset( $each_cart_rule[ 'sumo_pricing_apply_to_include_tag_for_cart' ] ) ) {
                    $tag_array = $each_cart_rule[ 'sumo_pricing_apply_to_include_tag_for_cart' ] ;
                }
                if ( ! empty( $tag_array ) ) {
                    $check_not_empty = (array_intersect( $tag_in_cart , sumo_dynamic_pricing_translated_array( $tag_array ) )) ;
                    if ( isset( $each_cart_rule[ 'sumo_pricing_inc_condition' ] ) && $each_cart_rule[ 'sumo_pricing_inc_condition' ] == '2' ) {
                        $count_tag_array = count( sumo_dynamic_pricing_translated_array( $tag_array ) ) ;
                        if ( count( $check_not_empty ) == $count_tag_array ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    } elseif ( isset( $each_cart_rule[ 'sumo_pricing_inc_condition' ] ) && $each_cart_rule[ 'sumo_pricing_inc_condition' ] == '3' ) {
                        $count_tag_array = count( sumo_dynamic_pricing_translated_array( $tag_array ) ) ;
                        if ( count( $check_not_empty ) == $count_tag_array && $count_tag_array == count( $tag_in_cart ) ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    } else {
                        if ( ! empty( $check_not_empty ) ) {
                            return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                        }
                    }
                }
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '9' ) {
                if ( isset( $each_cart_rule[ 'sumo_pricing_apply_to_exclude_tag_for_cart' ] ) ) {
                    $tag_array = $each_cart_rule[ 'sumo_pricing_apply_to_exclude_tag_for_cart' ] ;
                }
                $check_empty = (array_intersect( $tag_in_cart , sumo_dynamic_pricing_translated_array( $tag_array ) )) ;
                if ( ! empty( $tag_array ) ) {
                    if ( empty( $check_empty ) ) {
                        return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                    }
                }
            } elseif ( $each_cart_rule[ 'sumo_pricing_criteria' ] == '7' ) {
                if ( ! empty( $tag_in_cart ) ) {
                    return self::check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) ;
                }
            }
        }
    }

    public static function check_cart_rule_for_having_sale_prices( $each_cart_rule , $sale_price_array ) {
        if ( ! empty( $sale_price_array ) ) {
            if ( max( $sale_price_array ) > 0 ) {
                if ( isset( $each_cart_rule[ 'sumo_apply_this_rule_for_sale' ] ) ) {
                    if ( $each_cart_rule[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                        return true ;
                    }
                }
            } else {
                return true ;
            }
        } else {
            return true ;
        }
    }

    public static function check_cart_rule_for_each_row( $each_cart_rule , $cart_object , $unique_id , $total ) {
        $cart_rule_array = $each_cart_rule[ 'sumo_cart_total_rule' ] ;
        $array           = array() ;
        foreach ( $cart_rule_array as $unique_key => $each_cart_row ) {
            $min_total     = $each_cart_row[ 'sumo_pricing_rule_min_total' ] == '*' ? 0.01 : ( float ) $each_cart_row[ 'sumo_pricing_rule_min_total' ] ;
            $max_total     = $each_cart_row[ 'sumo_pricing_rule_max_total' ] ;
            $discount_type = $each_cart_row[ 'sumo_pricing_rule_discount_type' ] ;
            $value         = $each_cart_row[ 'sumo_pricing_rule_discount_value' ] ;
            if ( $max_total != '*' ) {
                if ( ($total >= $min_total) && ($total <= $max_total) ) {
                    $array[ $unique_key ] = array( 'discount_type' => $discount_type , 'value' => $value ) ;
                } else {
                    $array[ $unique_key ] = NULL ;
                }
            } else {
                if ( ($total >= $min_total ) ) {
                    $array[ $unique_key ] = array( 'discount_type' => $discount_type , 'value' => $value ) ;
                } else {
                    $array[ $unique_key ] = NULL ;
                }
            }
        }
        return $array ;
    }

    public static function sumo_nearest_higher_value( $array , $find ) {
        $new_array = array() ;
        foreach ( $array as $value ) {
            if ( $value > $find ) {
                $new_array[] = $value ;
            }
        }
        return min( $new_array ) ;
    }

}

new CartTotalFunctionalities() ;
