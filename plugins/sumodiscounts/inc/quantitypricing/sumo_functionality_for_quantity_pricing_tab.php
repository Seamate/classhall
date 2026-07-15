<?php

class SUMOFunctionalityForQP {

    public static function match_min_max_variation( $min , $max , $variation_id ) {
        global $woocommerce ;
        $variation           = self::get_cart_key_with_each_variations() ;
        $product             = self::get_product_variation_from_cart() ;
        $new_array_structure = array() ;
        $bool                = false ;

        $get_variant_cart_key = isset( $variation[ $variation_id ] ) ? $variation[ $variation_id ] : false ;

        if( isset( $get_variant_cart_key ) && $get_variant_cart_key ) {

            $parent_id                    = $woocommerce->cart->cart_contents[ $get_variant_cart_key ][ 'product_id' ] ;
            $list_of_variation_ids        = $product[ $parent_id ] ;
            $get_cart_keys_from_variation = self::get_cart_key_from_cart( $list_of_variation_ids ) ;
            if( is_array( $get_cart_keys_from_variation ) && ! empty( $get_cart_keys_from_variation ) ) {

                foreach( $get_cart_keys_from_variation as $ind_key ) {

                    $variation_quantity = $woocommerce->cart->cart_contents[ $ind_key ][ 'quantity' ] ;

                    //if both value matches
                    if( isset( $min ) && $min <= $variation_quantity && isset( $max ) && $max >= $variation_quantity ) {
                        return $variation_quantity ;
                    } elseif( isset( $min ) && $min <= $variation_quantity && ! isset( $max ) ) {
                        return $variation_quantity ;
                    } elseif( ! isset( $min ) && isset( $max ) && $max >= $variation_quantity ) {
                        return $variation_quantity ;
                    }
                }
            }
        }
    }

    //Function for Discount Prices
    public static function alter_cart_price_as_discount_value( $cart_object ) {

        $userid                = get_current_user_id() ;
        $newarray_for_discount = array() ;
        if( ! empty( $cart_object->cart_contents ) ) {
            $getpricingrule     = get_option( 'sumo_pricing_rule_fields_for_qty' ) ;
            $currentdate        = strtotime( date_i18n( 'd-m-Y' ) ) ;
            $currentday         = date( 'l' ) ;
            $currentdays        = strtolower( $currentday ) ;
            $weekdays           = array( 'monday' , 'tuesday' , 'wednesday' , 'thursday' , 'friday' , 'saturday' , 'sunday' ) ;
            $newarr             = array() ;
            $discountvalue      = array() ;
            $getfirstrule       = array() ;
            $allproductqty      = array() ;
            $allcategoryqty     = array() ;
            $eachcategoryqty    = array() ;
            $array_for_discount = array() ;
            $uniquid            = array() ;
            $products_in_cart   = sumo_dynamic_pricing_cart_contents() ;
            foreach( $cart_object->cart_contents as $cart_contents ) {
                $product_id = $cart_contents[ 'variation_id' ] > 0 ? $cart_contents[ 'variation_id' ] : $cart_contents[ 'product_id' ] ;
                if( is_array( $getpricingrule ) && ! empty( $getpricingrule ) ) {
                    foreach( $getpricingrule as $key => $getpricingrules ) {
                        $typeforuph           = $getpricingrules[ 'sumo_user_purchase_history' ] ;
                        $minnooforder         = $getpricingrules[ 'sumo_no_of_orders_placed' ] ;
                        $minamtspent          = $getpricingrules[ 'sumo_total_amount_spent_in_site' ] ;
                        $userpurchasedhistory = check_for_user_purchase_history( $getpricingrules , $typeforuph , $minnooforder , $minamtspent , $userid ) ;
                        if( $userpurchasedhistory ) {
                            if( isset( $getpricingrules[ 'sumo_enable_the_rule' ] ) && $getpricingrules[ 'sumo_enable_the_rule' ] == 'yes' ) {
                                include 'sumo_apply_discount_for_products_based_on_rule.php' ;
                                $uniquid[] = $key ;
                            }
                        }
                    }
                    if( is_array( $uniquid ) && ! empty( $uniquid ) ) {
                        foreach( $uniquid as $key ) {
                            if( isset( $discountvalue[ $key ] ) ) {
                                if( ! empty( $discountvalue[ $key ] ) ) {
                                    $discountvalues = ($discountvalue[ $key ]) ;
                                    if( $discountvalues != false ) {
                                        if( array_key_exists( $product_id , $discountvalues ) ) {
                                            $array_for_discount[ $product_id ][ $key ] = $discountvalues ;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if( ! empty( $array_for_discount ) && array_key_exists( $product_id , $array_for_discount ) ) {
                    if( get_option( 'sumo_quantity_pricing_priority_settings' ) == '1' ) {
                        $discountvalues                               = reset( $array_for_discount[ $product_id ] ) ;
                        $newarray_for_discount[ $product_id ][ $key ] = array(
                            'discount_values' => $discountvalues ,
                            'key'             => $key ,
                            'matched_rule'    => 1
                                ) ;
                    } elseif( get_option( 'sumo_quantity_pricing_priority_settings' ) == '2' ) {
                        $discountvalues                               = end( $array_for_discount[ $product_id ] ) ;
                        $newarray_for_discount[ $product_id ][ $key ] = array(
                            'discount_values' => $discountvalues ,
                            'key'             => $key ,
                            'matched_rule'    => 2
                                ) ;
                    } elseif( get_option( 'sumo_quantity_pricing_priority_settings' ) == '3' ) {
                        $discountvalues                               = max( $array_for_discount[ $product_id ] ) ;
                        $newarray_for_discount[ $product_id ][ $key ] = array(
                            'discount_values' => $discountvalues ,
                            'key'             => $key ,
                            'matched_rule'    => 3
                                ) ;
                    } elseif( get_option( 'sumo_quantity_pricing_priority_settings' ) == '4' ) {
                        $discountvalues                               = min( $array_for_discount[ $product_id ] ) ;
                        $newarray_for_discount[ $product_id ][ $key ] = array(
                            'discount_values' => $discountvalues ,
                            'key'             => $key ,
                            'matched_rule'    => 4
                                ) ;
                    }
                }
            }
            return $newarray_for_discount ;
        }
    }

    //Function to apply discount based on rule in bulk pricing for Each Product for Quantity Method
    public static function sumo_discount_value_for_each_cart_line_item( $weekdays , $getpricingrules , $currentdays , $cart_object , $product_id1 , $products_in_cart ) {
        $discountvalue = array() ;
        $newarr        = array() ;
        foreach( $weekdays as $weekday ) {
            $day = "sumo_pricing_rule_week_" . $weekday ;
            if( isset( $getpricingrules[ $day ] ) ) {
                if( $getpricingrules[ $day ] == '1' ) {
                    $newarr[] = $weekday ;
                }
            }
        }
        $newarray = array(
            'product_type'      => $getpricingrules[ 'sumo_pricing_apply_to_products' ] ,
            'included_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] : '' ,
            'excluded_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] : '' ,
            'included_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] : '' ,
            'excluded_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] : '' ,
            'included_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] : '' ,
            'excluded_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] : '' ,
            'inc_condition'     => isset( $getpricingrules[ 'sumo_pricing_inc_condition' ] ) ? $getpricingrules[ 'sumo_pricing_inc_condition' ] : '1' ,
            'products_in_cart'  => $products_in_cart
                ) ;
        if( in_array( $currentdays , $newarr ) ) {
            $getfirstrule = $getpricingrules[ 'sumo_quantity_rule' ] ;
            foreach( $cart_object->cart_contents as $value ) {
                $qty        = $value[ 'quantity' ] ;
                $product_id = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                if( $product_id1 == $product_id ) {
                    $apply_discount_to_products = sumo_function_for_product_and_category_filter( $product_id , $newarray , true ) ;
                    if( $apply_discount_to_products ) {
                        $productobject = sumo_sd_get_product( $product_id ) ;
                        $productprice  = get_post_meta( $product_id , '_price' , true ) ;
                        if( $productobject->get_sale_price() != '' ) {
                            if( isset( $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] ) && $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                                $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $qty , $productprice , $product_id ) ;
                            } else {
                                $getdisval = NULL ;
                            }
                        } else {
                            $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $qty , $productprice , $product_id ) ;
                        }
                    } else {
                        $getdisval = NULL ;
                    }
                    if( $getdisval !== NULL ) {
                        $discountvalue[ $product_id ] = $getdisval ;
                    }
                }
            }
            return $discountvalue ;
        }
    }

    //Function to apply discount based on rule in bulk pricing for Each Variation for Quantity Method
    public static function sumo_discount_value_each_variation( $weekdays , $getpricingrules , $currentdays , $cart_object , $products_in_cart ) {
        $discountvalue = array() ;
        $newarr        = array() ;
        foreach( $weekdays as $weekday ) {
            $day = "sumo_pricing_rule_week_" . $weekday ;
            if( isset( $getpricingrules[ $day ] ) ) {
                if( $getpricingrules[ $day ] == '1' ) {
                    $newarr[] = $weekday ;
                }
            }
        }
        $newarray = array(
            'product_type'      => $getpricingrules[ 'sumo_pricing_apply_to_products' ] ,
            'included_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] : '' ,
            'excluded_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] : '' ,
            'included_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] : '' ,
            'excluded_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] : '' ,
            'included_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] : '' ,
            'excluded_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] : '' ,
            'inc_condition'     => isset( $getpricingrules[ 'sumo_pricing_inc_condition' ] ) ? $getpricingrules[ 'sumo_pricing_inc_condition' ] : '1' ,
            'products_in_cart'  => $products_in_cart
                ) ;
        if( in_array( $currentdays , $newarr ) ) {
            $getfirstrule = $getpricingrules[ 'sumo_quantity_rule' ] ;
            if( is_array( $getfirstrule ) && ! empty( $getfirstrule ) ) {
                foreach( $cart_object->cart_contents as $value ) {
                    if( $value[ 'variation_id' ] != ('' || 0) ) {
                        $qty                        = $value[ 'quantity' ] ;
                        $product_id                 = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                        $apply_discount_to_products = sumo_function_for_product_and_category_filter( $product_id , $newarray , true ) ;
                        if( $apply_discount_to_products ) {
                            $productobject = sumo_sd_get_product( $product_id ) ;
//                            $productprice = $value['data']->price;
                            $productprice  = get_post_meta( $product_id , '_price' , true ) ;
                            if( $productobject->get_sale_price() != '' ) {
                                if( isset( $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] ) && $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                                    $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $qty , $productprice , $product_id ) ;
                                } else {
                                    $getdisval = NULL ;
                                }
                            } else {
                                $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $qty , $productprice , $product_id ) ;
                            }
                        } else {
                            $getdisval = NULL ;
                        }
                        if( $getdisval !== NULL ) {
                            $discountvalue[ $product_id ] = $getdisval ;
                        }
                    }
                }
            }
            return $discountvalue ;
        }
    }

    public static function get_product_variation_from_cart() {
        global $woocommerce ;
        $get_variations = array() ;
        foreach( $woocommerce->cart->cart_contents as $key => $value ) {
            if( $value[ 'variation_id' ] > 0 ) {
                $get_variations[ $value[ 'product_id' ] ][] = $value[ 'variation_id' ] ;
            }
        }
        return $get_variations ;
    }

    public static function get_cart_key_with_each_variations() {
        global $woocommerce ;
        $set_cart_key = array() ;
        foreach( $woocommerce->cart->cart_contents as $key => $value ) {
            if( $value[ 'variation_id' ] > 0 ) {
                $set_cart_key[ $value[ 'variation_id' ] ] = $key ;
            }
        }
        return $set_cart_key ;
    }

    public static function get_cart_key_from_cart( $listids_variation ) {
        $cart_keys = array() ;
        if( ! empty( $listids_variation ) ) {
            $getlist = self::get_cart_key_with_each_variations() ;
            foreach( $listids_variation as $key => $value ) {
                if( isset( $getlist[ $value ] ) ) {
                    $cart_keys[] = $getlist[ $value ] ;
                }
            }
        }
        return $cart_keys ;
    }

    public static function sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $qty , $productprice , $product_id ) {
        $getdiscountvalue  = array() ;
        $getdiscountvalues = '' ;
        if( is_array( $getfirstrule ) && ! empty( $getfirstrule ) ) {
            foreach( $getfirstrule as $key => $getfirstrules ) {
                $getminqty      = $getfirstrules[ 'sumo_pricing_rule_min_quantity' ] != '' ? $getfirstrules[ 'sumo_pricing_rule_min_quantity' ] : 0 ;
                $getmaxqty      = $getfirstrules[ 'sumo_pricing_rule_max_quantity' ] != '' ? $getfirstrules[ 'sumo_pricing_rule_max_quantity' ] : 0 ;
                $getdistyp      = $getfirstrules[ 'sumo_pricing_rule_discount_type' ] ;
                $getdisval      = $getfirstrules[ 'sumo_pricing_rule_discount_value' ] ;
                $repeatdiscount = isset( $getfirstrules[ 'sumo_pricing_rule_repeat_discount' ] ) ? $getfirstrules[ 'sumo_pricing_rule_repeat_discount' ] : 'no' ;
                if( $getpricingrules[ 'sumo_dynamic_rule_based_on_pricing' ] == '1' ) {
                    $sub_quantity = self::match_min_max_variation( $getminqty , $getmaxqty , $product_id ) ;
                    $qty          = isset( $sub_quantity ) ? $sub_quantity : $qty ;
                }
                $getdiscountvalues = self::sumo_function_to_get_discount_value( $getdistyp , $getminqty , $getmaxqty , $productprice , $qty , $getdisval , $product_id , $repeatdiscount ) ;


                if( $getdiscountvalues !== NULL ) {
                    $getdiscountvalue[] = $getdiscountvalues ;
                }
            }
            if( ! empty( $getdiscountvalue ) ) {
                if( $getpricingrules[ 'sumo_dynamic_rule_priority' ] == '1' ) {
                    return reset( $getdiscountvalue ) ;
                } elseif( $getpricingrules[ 'sumo_dynamic_rule_priority' ] == '2' ) {
                    return end( $getdiscountvalue ) ;
                } elseif( $getpricingrules[ 'sumo_dynamic_rule_priority' ] == '3' ) {
                    return max( $getdiscountvalue ) ;
                } else {
                    return min( $getdiscountvalue ) ;
                }
            }
        }
    }

    public static function sumo_function_to_get_each_category_qty() {
        $eachcategoryqtys = array() ;
        global $woocommerce ;
        foreach( $woocommerce->cart->cart_contents as $value ) {
            $product_id       = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
            $category_product = sumo_sd_get_product( $product_id ) ;
            if( $category_product->is_type( 'variation' ) ) {
                $cat_productid = sumo_sd_get_product_level_id( $category_product ) ;
            } else {
                $cat_productid = $product_id ;
            }
            $qty      = $value[ 'quantity' ] ;
            $category = get_the_terms( $cat_productid , 'product_cat' ) ;
            if( is_array( $category ) ) {
                if( ! empty( $category ) ) {
                    foreach( $category as $categorys ) {
                        $eachcategoryqtys[ $categorys->term_id ][ $product_id ] = $qty ;
                    }
                }
            }
        }
        $final_structure = array() ;
        if( ! empty( $eachcategoryqtys ) ) {
            foreach( $eachcategoryqtys as $key => $value ) {
                $newcount = array_sum( array_values( $value ) ) ;
                foreach( $value as $each_product => $newvalue ) {
                    $final_structure[ $each_product ] = $newcount ;
                }
            }
        }
        return $final_structure ;
    }

    //Function to apply discount based on rule in bulk pricing for Each Category for Quantity Method
    public static function sumo_discount_value_each_category( $weekdays , $getpricingrules , $currentdays , $cart_object , $product_id1 , $products_in_cart ) {
        $discountvalue = array() ;
        $newarr        = array() ;
        global $woocommerce ;
        foreach( $weekdays as $weekday ) {
            $day = "sumo_pricing_rule_week_" . $weekday ;
            if( isset( $getpricingrules[ $day ] ) ) {
                if( $getpricingrules[ $day ] == '1' ) {
                    $newarr[] = $weekday ;
                }
            }
        }
        $newarray = array(
            'product_type'      => $getpricingrules[ 'sumo_pricing_apply_to_products' ] ,
            'included_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] : '' ,
            'excluded_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] : '' ,
            'included_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] : '' ,
            'excluded_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] : '' ,
            'included_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] : '' ,
            'excluded_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] : '' ,
            'inc_condition'     => isset( $getpricingrules[ 'sumo_pricing_inc_condition' ] ) ? $getpricingrules[ 'sumo_pricing_inc_condition' ] : '1' ,
            'products_in_cart'  => $products_in_cart
                ) ;
        if( in_array( $currentdays , $newarr ) ) {
            $getfirstrule = $getpricingrules[ 'sumo_quantity_rule' ] ;
            if( is_array( $getfirstrule ) && ! empty( $getfirstrule ) ) {
                $qty = self::sumo_function_to_get_each_category_qty() ;
                foreach( $cart_object->cart_contents as $value ) {
                    $product_id = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                    if( $product_id == $product_id1 ) {
                        $productobject = sumo_sd_get_product( $product_id ) ;
//                        $productprice = $value['data']->price;
                        $productprice  = get_post_meta( $product_id , '_price' , true ) ;
                        if( array_key_exists( $product_id , $qty ) ) {
                            $eachcatcount               = $qty[ $product_id ] ;
                            $apply_discount_to_products = sumo_function_for_product_and_category_filter( $product_id , $newarray , true ) ;
                            if( $apply_discount_to_products ) {
                                if( $productobject->get_sale_price() != '' ) {
                                    if( isset( $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] ) && $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                                        $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $eachcatcount , $productprice , $product_id ) ;
                                    } else {
                                        $getdisval = NULL ;
                                    }
                                } else {
                                    $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $eachcatcount , $productprice , $product_id ) ;
                                }
                            } else {
                                $getdisval = NULL ;
                            }
                            if( $getdisval !== NULL ) {
                                $discountvalue[ $product_id ] = $getdisval ;
                            }
                        }
                    }
                }
            }
            return $discountvalue ;
        }
    }

    //Function to get discount value
    public static function sumo_function_to_get_discount_value( $getdistyp , $getminqty , $getmaxqty , $productprice , $qty , $getdisval , $productid , $repeatdiscount ) {
        $discountvalue = '' ;
        $getminqty     = $getminqty == '*' ? 1 : ( int ) $getminqty ;
        if( $getmaxqty != '*' ) {
            if( $repeatdiscount != 'yes' ) {
                if( ($qty >= $getminqty) && ($qty <= $getmaxqty) ) {
                    if( $getdistyp == '1' ) {
                        $discountpercentage  = $getdisval / 100 ;
                        $discountpercentages = $discountpercentage * $productprice ;
                        $discountvalue       = $productprice - $discountpercentages ;
                        return $discountvalue ;
                    } else if( $getdistyp == '2' ) {
                        if( $productprice > $getdisval ) {
                            $discountprice = $productprice - $getdisval ;
                            $discountvalue = $discountprice ;
                            return $discountvalue ;
                        } else {
                            $discountvalue = '0' ;
                            return $discountvalue ;
                        }
                    } else if( $getdistyp == '3' ) {
                        $discountvalue = $getdisval ;
                        return $discountvalue ;
                    }
                }
            } else {
                if( ($qty >= $getminqty ) ) {
                    $remaining_mod = $qty % $getmaxqty ;
                    $remaining_mod = $remaining_mod != 0 ? $remaining_mod : ( int ) $getmaxqty ;
                    if( ($remaining_mod >= $getminqty) && ($remaining_mod <= $getmaxqty) ) {
                        if( $getdistyp == '1' ) {
                            $discountpercentage  = $getdisval / 100 ;
                            $discountpercentages = $discountpercentage * $productprice ;
                            $discountvalue       = $productprice - $discountpercentages ;
                            return $discountvalue ;
                        } else if( $getdistyp == '2' ) {
                            if( $productprice > $getdisval ) {
                                $discountprice = $productprice - $getdisval ;
                                $discountvalue = $discountprice ;
                                return $discountvalue ;
                            } else {
                                $discountvalue = '0' ;
                                return $discountvalue ;
                            }
                        } else if( $getdistyp == '3' ) {
                            $discountvalue = $getdisval ;
                            return $discountvalue ;
                        }
                    }
                }
            }
        } else {
            if( $repeatdiscount != 'yes' ) {
                if( ($qty >= $getminqty ) ) {
                    if( $getdistyp == '1' ) {
                        $discountpercentage  = $getdisval / 100 ;
                        $discountpercentages = $discountpercentage * $productprice ;
                        $discountvalue       = $productprice - $discountpercentages ;
                        return $discountvalue ;
                    } else if( $getdistyp == '2' ) {
                        if( $productprice > $getdisval ) {
                            $discountprice = $productprice - $getdisval ;
                            $discountvalue = $discountprice ;
                            return $discountvalue ;
                        } else {
                            $discountvalue = '0' ;
                            return $discountvalue ;
                        }
                    } else if( $getdistyp == '3' ) {
                        $discountvalue = $getdisval ;
                        return $discountvalue ;
                    }
                }
            } else {
                if( ($qty >= $getminqty ) ) {
                    $remaining_mod = $qty % $getminqty ;
                    $remaining_mod = $remaining_mod != 0 ? $remaining_mod : ( int ) $getminqty ;
                    if( ($remaining_mod >= $getminqty) && ($remaining_mod <= $getminqty) ) {
                        if( $getdistyp == '1' ) {
                            $discountpercentage  = $getdisval / 100 ;
                            $discountpercentages = $discountpercentage * $productprice ;
                            $discountvalue       = $productprice - $discountpercentages ;
                            return $discountvalue ;
                        } else if( $getdistyp == '2' ) {
                            if( $productprice > $getdisval ) {
                                $discountprice = $productprice - $getdisval ;
                                $discountvalue = $discountprice ;
                                return $discountvalue ;
                            } else {
                                $discountvalue = '0' ;
                                return $discountvalue ;
                            }
                        } else if( $getdistyp == '3' ) {
                            $discountvalue = $getdisval ;
                            return $discountvalue ;
                        }
                    }
                }
            }
        }
    }

    //Function to get discount value
    public static function sumo_function_to_apply_discount_value( $cart_object , $get_array_values ) {
        if( is_array( $get_array_values ) && ! empty( $get_array_values ) ) {
            foreach( $get_array_values as $key => $values ) {
                foreach( $values as $rule_id => $each_value ) {
                    foreach( $cart_object->cart_contents as $cart_item_key => $value ) {
//                        WC()->session->__unset($cart_item_key . 'bulk_discounts_applied');
                        $productid = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                        if( $key == $productid ) {
                            $discountvalues = $each_value[ 'discount_values' ] ;
                            if( is_array( $discountvalues ) && ! empty( $discountvalues ) ) {
                                if( isset( $discountvalues[ $productid ] ) ) {
                                    $value[ 'data' ]->set_price( $discountvalues[ $productid ] ) ;
                                    WC()->session->set( $cart_item_key . 'bulk_discounts_applied' , 'yes' ) ;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public static function sumo_function_to_min_max_discount( $cart_object , $get_array_values ) {
        $i = 0 ;
        if( is_array( $get_array_values ) && ! empty( $get_array_values ) ) {
            foreach( $get_array_values as $key => $values ) {
                foreach( $cart_object->cart_contents as $cart_item_key => $value ) {
//                    WC()->session->__unset($cart_item_key . 'bulk_discounts_applied');
                    $productid      = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                    $discountvalues = $values ;
                    if( $productid == $key ) {
//                        $value['data']->price = $discountvalues;
                        $value[ 'data' ]->set_price( $discountvalues ) ;
                        WC()->session->set( $cart_item_key . 'bulk_discounts_applied' , 'yes' ) ;
                    }
                    $i ++ ;
                }
            }
        }
    }

    //Function to apply discount based on rule in bulk pricing for Entire Cart Quantity for Quantity Method
    public static function sumo_discount_value_for_entire_cart_quantity( $weekdays , $getpricingrules , $currentdays , $cart_object , $product_id1 , $products_in_cart ) {
        $discountvalue = array() ;
        $newarr        = array() ;
        foreach( $weekdays as $weekday ) {
            $day = "sumo_pricing_rule_week_" . $weekday ;
            if( isset( $getpricingrules[ $day ] ) ) {
                if( $getpricingrules[ $day ] == '1' ) {
                    $newarr[] = $weekday ;
                }
            }
        }
        $newarray = array(
            'product_type'      => $getpricingrules[ 'sumo_pricing_apply_to_products' ] ,
            'included_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] : '' ,
            'excluded_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] : '' ,
            'included_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] : '' ,
            'excluded_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] : '' ,
            'included_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] : '' ,
            'excluded_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] : '' ,
            'inc_condition'     => isset( $getpricingrules[ 'sumo_pricing_inc_condition' ] ) ? $getpricingrules[ 'sumo_pricing_inc_condition' ] : '1' ,
            'products_in_cart'  => $products_in_cart
                ) ;
        if( in_array( $currentdays , $newarr ) ) {
            $getfirstrule  = $getpricingrules[ 'sumo_quantity_rule' ] ;
            $sale_status   = isset( $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] ) ? $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] : "no" ;
            $entirecartqty = self::sumo_function_to_get_entire_cart_qty( $cart_object , $newarray , $sale_status ) ;

            foreach( $cart_object->cart_contents as $value ) {
                $product_id = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                if( $product_id1 == $product_id ) {
                    $apply_discount_to_products = sumo_function_for_product_and_category_filter( $product_id , $newarray , true ) ;
                    if( $apply_discount_to_products ) {
                        $productobject = sumo_sd_get_product( $product_id ) ;
                        $productprice  = get_post_meta( $product_id , '_price' , true ) ;
                        if( $productobject->get_sale_price() != '' ) {
                            if( isset( $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] ) && $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                                $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $entirecartqty , $productprice , $product_id ) ;
                            } else {
                                $getdisval = NULL ;
                            }
                        } else {
                            $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $entirecartqty , $productprice , $product_id ) ;
                        }
                    } else {
                        $getdisval = NULL ;
                    }
                    if( $getdisval !== NULL ) {
                        $discountvalue[ $product_id ] = $getdisval ;
                    }
                }
            }
            return $discountvalue ;
        }
    }

    public static function sumo_function_to_get_entire_cart_qty( $cart_object , $newarray , $sale_status ) {
        $allproductqty = array() ;
        if( ! empty( $cart_object->cart_contents ) ) {
            foreach( $cart_object->cart_contents as $value ) {
                $product_id                 = $value[ 'variation_id' ] != ('' || 0) ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                $apply_discount_to_products = sumo_function_for_product_and_category_filter( $product_id , $newarray , true ) ;
                if( $apply_discount_to_products ) {
                    $productobject = sumo_sd_get_product( $product_id ) ;

                    if( $sale_status == 'no' ) {
                        if( $productobject->get_sale_price() == '' ) {
                            $allproductqty[] = $value[ 'quantity' ] ;
                        }
                    } else {
                        $allproductqty[] = $value[ 'quantity' ] ;
                    }
                }
            }
        }
        $totalqty = array_sum( $allproductqty ) ;
        return $totalqty ;
    }

    public static function sumo_cart_product_quantities( $product_id ) {
        $quantities = '' ;
        foreach( WC()->cart->cart_contents as $cart_item_key => $values ) {
            if( $product_id == $values[ 'product_id' ] ) {
                if( is_numeric( $values[ 'quantity' ] ) && isset( $values[ 'quantity' ] ) ) {
                    $quantities = $values[ 'quantity' ] ;
                } else {
                    $quantities += $values[ 'quantity' ] ;
                }
            }
        }

        return $quantities ;
    }

    //Function to apply discount based on rule in bulk pricing for Each Product for Quantity Method
    public static function sumo_discount_value_for_product_level( $weekdays , $getpricingrules , $currentdays , $cart_object , $product_id1 , $products_in_cart ) {
        global $woocommerce ;
        $discountvalue = array() ;
        $newarr        = array() ;
        foreach( $weekdays as $weekday ) {
            $day = "sumo_pricing_rule_week_" . $weekday ;
            if( isset( $getpricingrules[ $day ] ) ) {
                if( $getpricingrules[ $day ] == '1' ) {
                    $newarr[] = $weekday ;
                }
            }
        }
        $newarray = array(
            'product_type'      => $getpricingrules[ 'sumo_pricing_apply_to_products' ] ,
            'included_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_products' ] : '' ,
            'excluded_products' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_products' ] : '' ,
            'included_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_category' ] : '' ,
            'excluded_category' => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_category' ] : '' ,
            'included_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_include_tag' ] : '' ,
            'excluded_tag'      => isset( $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] ) ? $getpricingrules[ 'sumo_pricing_apply_to_exclude_tag' ] : '' ,
            'inc_condition'     => isset( $getpricingrules[ 'sumo_pricing_inc_condition' ] ) ? $getpricingrules[ 'sumo_pricing_inc_condition' ] : '1' ,
            'products_in_cart'  => $products_in_cart
                ) ;
        if( in_array( $currentdays , $newarr ) ) {
            $getfirstrule = $getpricingrules[ 'sumo_quantity_rule' ] ;
            foreach( $cart_object->cart_contents as $value ) {
                $product_id    = $value[ 'variation_id' ] > 0 ? $value[ 'variation_id' ] : $value[ 'product_id' ] ;
                $productobject = sumo_sd_get_product( $product_id ) ;
                if( $productobject->is_type( 'variation' ) ) {
                    $qty = self::sumo_cart_product_quantities( $value[ 'product_id' ] ) ;
                } else {
                    $qty = $value[ 'quantity' ] ;
                }
                if( $product_id == $product_id1 ) {
                    $apply_discount_to_products = sumo_function_for_product_and_category_filter( $product_id , $newarray , true ) ;
                    if( $apply_discount_to_products ) {
//                        $productprice = $value['data']->price;
                        $productprice = get_post_meta( $product_id , '_price' , true ) ;
                        if( $productobject->get_sale_price() != '' ) {
                            if( isset( $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] ) && $getpricingrules[ 'sumo_apply_this_rule_for_sale' ] == 'yes' ) {
                                $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $qty , $productprice , $product_id ) ;
                            } else {
                                $getdisval = NULL ;
                            }
                        } else {
                            $getdisval = self::sumo_function_to_get_local_rule_discount( $getpricingrules , $getfirstrule , $qty , $productprice , $product_id ) ;
                        }
                    } else {
                        $getdisval = NULL ;
                    }
                    if( $getdisval !== NULL ) {
                        $discountvalue[ $product_id ] = $getdisval ;
                    }
                }
            }
            return $discountvalue ;
        }
    }

    public static function get_cart_item_keys_from_variation( $variation_id ) {
        global $woocommerce ;
        $cart_contents                = $woocommerce->cart->cart_contents ;
        $bool                         = false ;
        $get_variations               = self::get_cart_key_with_each_variations() ;
        $get_products_and_variations  = self::get_product_variation_from_cart() ;
        $get_cartlist_from_variations = array() ;

        if( isset( $get_variations[ $variation_id ] ) ) {
            $get_cart_key   = $get_variations[ $variation_id ] ;
            $get_product_id = $woocommerce->cart->cart_contents[ $get_cart_key ][ 'product_id' ] ;

            if( isset( $get_products_and_variations[ $get_product_id ] ) ) {

                $get_list_of_keys = $get_products_and_variations[ $get_product_id ] ;
                if( is_array( $get_list_of_keys ) && ! empty( $get_list_of_keys ) ) {
                    $get_cartlist_from_variations = self::get_cart_key_from_cart( $get_list_of_keys ) ;
                }
            }
        }
        return $get_cartlist_from_variations ;
    }

    public static function get_variation_discount_quantity( $variation_id ) {
        global $woocommerce ;
        $cart_contents               = $woocommerce->cart->cart_contents ;
        $bool                        = false ;
        $get_variations              = self::get_cart_key_with_each_variations() ;
        $get_products_and_variations = self::get_product_variation_from_cart() ;

        if( isset( $get_variations[ $variation_id ] ) ) {
            $get_cart_key   = $get_variations[ $variation_id ] ;
            $get_product_id = $woocommerce->cart->cart_contents[ $get_cart_key ][ 'product_id' ] ;

            if( isset( $get_products_and_variations[ $get_product_id ] ) ) {

                $get_list_of_keys = $get_products_and_variations[ $get_product_id ] ;
                if( is_array( $get_list_of_keys ) && ! empty( $get_list_of_keys ) ) {
                    $get_cartlist_from_variations = self::get_cart_key_from_cart( $get_list_of_keys ) ;

                    foreach( $get_cartlist_from_variations as $each_key ) {

                        if( isset( $cart_contents[ $each_key ][ 'sumo_quantity' ] ) ) {
                            $get_quantity  = $cart_contents[ $each_key ][ 'quantity' ] ;
                            $sumo_quantity = $cart_contents[ $each_key ][ 'sumo_quantity' ] ;

                            $bool = array( $each_key => $get_quantity ) ;
                            return $bool ;
                        }
                    }
                }
            }
        }
        return $bool ;
    }

}

new SUMOFunctionalityForQP() ;
