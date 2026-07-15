<?php

class SUMOFunctionalityForSOP {

//Function for Discount Prices
    public static function alter_cart_price_as_discount_value_for_offer($cart_object) {
        $userid = get_current_user_id();
        $getpricingrule = get_option('sumo_pricing_rule_fields_for_offer');
        $currentdate = strtotime(date_i18n('d-m-Y'));
        $currentday = date('l');
        $currentdays = strtolower($currentday);
        $weekdays = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
        $newarr = array();
        $discountvalue = array();
        $sumo_so_discount_array = array();
        $getfirstrule = array();
        $allproductqty = array();
        $allcategoryqty = array();
        $eachcategoryqty = array();
        $newarray_for_discount = array();
        $array_for_discount = array();
        $uniquid = array();
        $products_in_cart = sumo_dynamic_pricing_cart_contents();
        if (!empty($cart_object->cart_contents)) {
            $cart_count = 0;
            foreach ($cart_object->cart_contents as $cart_contents) {
                $cart_count++;
                $product_id = $cart_contents['variation_id'] > 0 ? $cart_contents['variation_id'] : $cart_contents['product_id'];
                if (is_array($getpricingrule) && !empty($getpricingrule)) {
                    foreach ($getpricingrule as $key => $getpricingrules) {
                        $typeforuph = $getpricingrules['sumo_user_purchase_history'];
                        $minnooforder = $getpricingrules['sumo_no_of_orders_placed'];
                        $minamtspent = $getpricingrules['sumo_total_amount_spent_in_site'];
                        $userpurchasedhistory = check_for_user_purchase_history($getpricingrules, $typeforuph, $minnooforder, $minamtspent, $userid);
                        if ($userpurchasedhistory) {
                            if (isset($getpricingrules['sumo_enable_the_rule']) && $getpricingrules['sumo_enable_the_rule'] == 'yes') {
                                include 'sumo_apply_discount_for_products_based_on_offer_rule.php';
                                $uniquid[] = $key;
                            }
                        }
                    }
                    if (is_array($uniquid) && !empty($uniquid)) {
                        foreach ($uniquid as $key) {
                            if (isset($discountvalue[$key])) {
                                if (!empty($discountvalue[$key])) {
                                    $discountvalues = ($discountvalue[$key]);
                                    if ($discountvalues != false) {
                                        foreach ($discountvalues as $my_dis_product_id => $my_dis_val) {
                                            $array_for_discount[$my_dis_product_id][$key] = $discountvalues;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (!empty($array_for_discount)) {
                    foreach ($array_for_discount as $off_pro_id => $each_array_for_discount) {
                        if (is_array($each_array_for_discount) && !empty($each_array_for_discount)) {
                            foreach ($each_array_for_discount as $my_key => $discount_array) {
                                if (array_key_exists($off_pro_id, $discount_array)) {
                                    if (get_option('sumo_special_offer_priority_settings') == '1') {
                                        $discountvalues = reset($each_array_for_discount);
                                        $newarray_for_discount[$off_pro_id][$my_key] = array(
                                            'discount_values' => $discountvalues,
                                            'key' => $my_key,
                                            'matched_rule' => 1
                                        );
                                    } elseif (get_option('sumo_special_offer_priority_settings') == '2') {
                                        $discountvalues = end($each_array_for_discount);
                                        $newarray_for_discount[$off_pro_id][$my_key] = array(
                                            'discount_values' => $discountvalues,
                                            'key' => $my_key,
                                            'matched_rule' => 1
                                        );
                                    } elseif (get_option('sumo_special_offer_priority_settings') == '3') {
                                        foreach ($each_array_for_discount as $pro_array) {
                                            foreach ($pro_array as $pro_id => $my_val) {
                                                $my_dis_array[$pro_id][] = $my_val;
                                            }
                                        }
                                        $discountvalues[$off_pro_id] = max($my_dis_array[$off_pro_id]);
                                        $newarray_for_discount[$off_pro_id][$my_key] = array(
                                            'discount_values' => $discountvalues,
                                            'key' => $my_key,
                                            'matched_rule' => 1
                                        );
                                    } else {
                                        foreach ($each_array_for_discount as $pro_array) {
                                            foreach ($pro_array as $pro_id => $my_val) {
                                                $my_dis_array[$pro_id][] = $my_val;
                                            }
                                        }
                                        $discountvalues[$off_pro_id] = min($my_dis_array[$off_pro_id]);
                                        $newarray_for_discount[$off_pro_id][$my_key] = array(
                                            'discount_values' => $discountvalues,
                                            'key' => $my_key,
                                            'matched_rule' => 1
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $newarray_for_discount;
        }
    }

//Function to get discount value
    public static function sumo_function_to_apply_discount_value_for_offer($cart_object, $get_array_values) {
        $i = 0;

        if (is_array($get_array_values) && !empty($get_array_values)) {
            foreach ($get_array_values as $key => $values) {
                foreach ($values as $rule_id => $each_value) {
                    foreach ($cart_object->cart_contents as $cart_item_key => $value) {
//                        WC()->session->__unset($cart_item_key . 'bulk_discounts_applied');
                        $productid = $value['variation_id'] != ('' || 0) ? $value['variation_id'] : $value['product_id'];
                        if ($productid == $key) {
                            $discountvalues = $each_value['discount_values'];
                            if (is_array($discountvalues) && !empty($discountvalues)) {
                                if (isset($discountvalues[$productid])) {
                                    $value['data']->set_price($discountvalues[$productid]);
                                    WC()->session->set($cart_item_key . 'bulk_discounts_applied', 'yes');
                                }
                            }
                        }
                        $i++;
                    }
                }
            }
        }
    }

    public static function sumo_function_to_min_max_discount_for_offer($cart_object, $get_array_values) {
        $i = 0;
        if (is_array($get_array_values) && !empty($get_array_values)) {
            foreach ($get_array_values as $key => $values) {
                foreach ($cart_object->cart_contents as $cart_item_key => $value) {
//                    WC()->session->__unset($cart_item_key . 'bulk_discounts_applied');
                    $productid = $value['variation_id'] != ('' || 0) ? $value['variation_id'] : $value['product_id'];
                    $discountvalues = $values;
                    if ($productid == $key) {
                        $value['data']->set_price($discountvalues);
                        WC()->session->set($cart_item_key . 'bulk_discounts_applied', 'yes');
                    }

                    $i++;
                }
            }
        }
    }

//Function to get discount value
    public static function sumo_function_to_get_discount_value_for_offer($getdistyp, $getminqty, $getmaxqty, $product_price, $qty, $getdisval, $productid, $repeatrow, $discount_for_same_product, $buy_qty) {
        if ($discount_for_same_product) {
            $discountvalue = '';
            $totalqty = $getminqty + $getmaxqty;
            if ($getminqty < $qty) {
                if ($repeatrow == 'yes') {
                    if ((int) $qty < (int) $getminqty + $getmaxqty) {
                        $getqty = $qty - $getminqty;
                    } else {
                        $total_qty = (int) ($getminqty + $getmaxqty);
                        $modulo = (int) ($qty % $total_qty);
                        if ($modulo == 3 || $modulo == 4) {
                            $new_modulo = $modulo - $getminqty;
                        } else {
                            $new_modulo = 0;
                        }
                        $getqty = (($getmaxqty / $total_qty) * ($qty - $modulo)) + ($new_modulo);
                    }
                } else {
                    if ((int) $qty > (int) $getminqty + $getmaxqty) {
                        $getqty = (int) $qty - (int) $getminqty + $getmaxqty;
                    } else {
                        $getqty = $qty - $getminqty;
                    }

                    if ($getqty > ($getmaxqty)) {

                        if ($repeatrow == 'no') {
                            $getqty = ($getmaxqty);
                        }
                    } else {
                        $getqty = $getqty;
                    }
                }
                if ($getdistyp == '1') {
                    $discountpercentage = $getdisval / 100;
                    $discountpercentages = $discountpercentage * $product_price;
                    $discountvalue = (($product_price * $qty) - ($discountpercentages * $getqty)) / $qty;
                    return $discountvalue;
                } else if ($getdistyp == '2') {
//                    if ($product_price > $getdisval) {
                    $discountprice = (($product_price * $qty) - ($getdisval * $getqty)) / $qty;
                    $discountvalue = $discountprice;
                    return $discountvalue;
//                    } else {
//                        $discountvalue = '0';
//                        return $discountvalue;
//                    }
                } else {
                    $discountprice = ((($product_price * $qty) - ($product_price * $getqty)) + ($getdisval * $getqty)) / $qty;
                    $discountvalue = $discountprice;
                    return $discountvalue;
                }
            }
        } else {
            if ($repeatrow == 'yes') {
                if ($getminqty <= $buy_qty && $getmaxqty <= $qty) {
                    $check_cart_qty = (int) ($qty / $getmaxqty);
                    $repeat_quantity1 = (int) ($buy_qty / $getminqty);
                    if ($repeat_quantity1 <= $check_cart_qty) {
                        $repeat_quantity = $repeat_quantity1;
                    } else {
                        $repeat_quantity = $check_cart_qty;
                    }
                    $getdisval1 = $getdisval * $repeat_quantity;
                } else {
                    $getdisval1 = 0;
                }
            } else {
                $repeat_quantity = 1;
                if ($getminqty <= $buy_qty && $getmaxqty <= $qty) {
                    $getdisval1 = $getdisval;
                } else {
                    $getdisval1 = 0;
                }
            }
            if ($getdisval1) {
                if ($getdistyp == '1') {
                    $discountpercentage = $getdisval1 / 100;
                    $discountpercentages = $discountpercentage * $product_price;
                    $discountvalue = (($product_price * $qty) - ($discountpercentages * $getmaxqty)) / $qty;
                    return $discountvalue;
                } else if ($getdistyp == '2') {
//                    if ($product_price > $getdisval1) {
                    $discountprice = (($product_price * $qty) - ($getdisval1 * $getmaxqty)) / $qty;
                    $discountvalue = $discountprice;
                    return $discountvalue;
//                    } else {
//                        $discountvalue = '0';
//                        return $discountvalue;
//                    }
                } else {
                    $balance_quantity = $qty - $repeat_quantity;
                    $discountprice = ((($product_price * $qty) - ($product_price * $repeat_quantity)) + ($getdisval1)) / $qty;
                    $discountvalue = $discountprice;
                    return $discountvalue;
                }
            }
        }
    }

    public static function sumo_function_to_get_local_rule_discount_for_offer($getpricingrules, $getfirstrule, $qty, $productprice, $productid, $buy_qty = 0) {
        $getdiscountvalue = array();
        if (is_array($getfirstrule) && !empty($getfirstrule)) {
            foreach ($getfirstrule as $key => $getfirstrules) {
                $getminqty = $getfirstrules['sumo_pricing_rule_buy_offer'] != '' ? $getfirstrules['sumo_pricing_rule_buy_offer'] : 0;
                $getmaxqty = $getfirstrules['sumo_pricing_rule_free_offer'] != '' ? $getfirstrules['sumo_pricing_rule_free_offer'] : 0;
                $getdistyp = $getfirstrules['sumo_pricing_rule_discount_type_for_offer'];
                $getdisval = $getfirstrules['sumo_pricing_rule_discount_value_for_offer'];
                $repeatrow = isset($getfirstrules['sumo_pricing_repeat_rule']) ? $getfirstrules['sumo_pricing_repeat_rule'] : 'no';
                $applicable_to = isset($getpricingrules['sumo_special_offer_applicable_to_']) ? $getpricingrules['sumo_special_offer_applicable_to_'] : '';
                $discount_for_same_product = $applicable_to == '' ? true : false;
                $getdiscountvalues = self::sumo_function_to_get_discount_value_for_offer($getdistyp, $getminqty, $getmaxqty, $productprice, $qty, $getdisval, $productid, $repeatrow, $discount_for_same_product, $buy_qty);
                if ($getdiscountvalues !== NULL) {
                    $getdiscountvalue[] = $getdiscountvalues;
                }
            }
            if (!empty($getdiscountvalue)) {
                if ($getpricingrules['sumo_dynamic_rule_priority'] == '1') {
                    return reset($getdiscountvalue);
                } elseif ($getpricingrules['sumo_dynamic_rule_priority'] == '2') {
                    return end($getdiscountvalue);
                } elseif ($getpricingrules['sumo_dynamic_rule_priority'] == '3') {
                    return max($getdiscountvalue);
                } else {
                    return min($getdiscountvalue);
                }
            }
        }
    }

//Function to apply discount based on rule in bulk pricing for Each Product for Quantity Method
    public static function sumo_discount_value_for_offer($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id1, $sumo_so_discount_array, $cart_count, $products_in_cart) {
        global $woocommerce;
        $newarr = array();
        foreach ($weekdays as $weekday) {
            $day = "sumo_pricing_rule_week_" . $weekday;
            if (isset($getpricingrules[$day])) {
                if ($getpricingrules[$day] == '1') {
                    $newarr[] = $weekday;
                }
            }
        }
        $newarray = array(
            'product_type' => $getpricingrules['sumo_pricing_apply_to_products'],
            'included_products' => isset($getpricingrules['sumo_pricing_apply_to_include_products']) ? $getpricingrules['sumo_pricing_apply_to_include_products'] : '',
            'excluded_products' => isset($getpricingrules['sumo_pricing_apply_to_exclude_products']) ? $getpricingrules['sumo_pricing_apply_to_exclude_products'] : '',
            'included_category' => isset($getpricingrules['sumo_pricing_apply_to_include_category']) ? $getpricingrules['sumo_pricing_apply_to_include_category'] : '',
            'excluded_category' => isset($getpricingrules['sumo_pricing_apply_to_exclude_category']) ? $getpricingrules['sumo_pricing_apply_to_exclude_category'] : '',
            'included_tag' => isset($getpricingrules['sumo_pricing_apply_to_include_tag']) ? $getpricingrules['sumo_pricing_apply_to_include_tag'] : '',
            'excluded_tag' => isset($getpricingrules['sumo_pricing_apply_to_exclude_tag']) ? $getpricingrules['sumo_pricing_apply_to_exclude_tag'] : '',
            'inc_condition' => isset($getpricingrules['sumo_pricing_inc_condition']) ? $getpricingrules['sumo_pricing_inc_condition'] : '1',
            'products_in_cart' => $products_in_cart
        );
        if (in_array($currentdays, $newarr)) {
            $getfirstrule = $getpricingrules['sumo_offer_rule'];
            $quantities = sumo_dynamic_pricing_cart_quantities();
            $count = array_sum($quantities);
            $based_on = array_search(max($quantities), $quantities);
            foreach ($cart_object->cart_contents as $value) {
                $qty = $value['quantity'];
                $product_id = $value['variation_id'] > 0 ? $value['variation_id'] : $value['product_id'];
                $apply_discount_to_products = sumo_function_for_product_and_category_filter($product_id1, $newarray, true);
                $applicable_to = isset($getpricingrules['sumo_special_offer_applicable_to_']) ? $getpricingrules['sumo_special_offer_applicable_to_'] : '';
                if ($applicable_to == '') {
                    if ($product_id == $product_id1) {
                        if ($apply_discount_to_products) {
                            $productobject = sumo_sd_get_product($product_id);
                            $productprice = get_post_meta($product_id, '_price', true);
                            if ($productobject->get_sale_price() != '') {
                                if (isset($getpricingrules['sumo_apply_this_rule_for_sale']) && $getpricingrules['sumo_apply_this_rule_for_sale'] == 'yes') {
                                    $getdisval = self::sumo_function_to_get_local_rule_discount_for_offer($getpricingrules, $getfirstrule, $qty, $productprice, $product_id);
                                } else {
                                    $getdisval = NULL;
                                }
                            } else {
                                $getdisval = self::sumo_function_to_get_local_rule_discount_for_offer($getpricingrules, $getfirstrule, $qty, $productprice, $product_id);
                            }
                        } else {
                            $getdisval = NULL;
                        }
                        if ($getdisval !== NULL) {
                            $sumo_so_discount_array[$product_id] = $getdisval;
                        }
                    }
                } else {
                    $product_id = sumo_dynamic_pricing_product_id_from_other_lang($product_id);
                    $sumo_pro_cat_check_array = array(
                        'product_type' => $applicable_to,
                        'included_products' => isset($getpricingrules['sumo_special_offer_apply_to_include_products']) ? $getpricingrules['sumo_special_offer_apply_to_include_products'] : '',
                        'excluded_products' => isset($getpricingrules['sumo_special_offer_apply_to_exclude_products']) ? $getpricingrules['sumo_special_offer_apply_to_exclude_products'] : '',
                        'included_category' => isset($getpricingrules['sumo_special_offer_apply_to_include_category']) ? $getpricingrules['sumo_special_offer_apply_to_include_category'] : '',
                        'excluded_category' => isset($getpricingrules['sumo_special_offer_apply_to_exclude_category']) ? $getpricingrules['sumo_special_offer_apply_to_exclude_category'] : '',
                        'included_tag' => isset($getpricingrules['sumo_special_offer_apply_to_include_tag']) ? $getpricingrules['sumo_special_offer_apply_to_include_tag'] : '',
                        'excluded_tag' => isset($getpricingrules['sumo_special_offer_apply_to_exclude_tag']) ? $getpricingrules['sumo_special_offer_apply_to_exclude_tag'] : ''
                    );
                    $product_cat = get_the_terms($product_id1, 'product_cat');
                    $mycategory = array();
                    if (is_array($product_cat) && !empty($product_cat)) {
                        foreach ($product_cat as $each_category) {
                            $mycategory[] = $each_category->term_id;
                        }
                    }
                    $check_avail_discount = sumo_function_for_check_special_offer_to_product_and_category_filter($product_id, $sumo_pro_cat_check_array, $mycategory);
                    if ($applicable_to != '8') {
                        if ($apply_discount_to_products) {
                            $based_on = sumo_dynamic_pricing_product_id_from_other_lang($based_on);
                            $product_id1 = sumo_dynamic_pricing_product_id_from_other_lang($product_id1);
                            if ($based_on == $product_id1) {
                                if ($check_avail_discount) {
                                    if ($product_id != $product_id1) {
                                        $productobject = sumo_sd_get_product($product_id);
                                        $productprice = get_post_meta($product_id, '_price', true);
//                                $buy_qty = self::sumo_get_cart_item_quantities($product_id1);
                                        unset($quantities[$product_id]);
                                        $buy_qty = sumo_function_for_get_buy_quantity_on_special_offer_discount($newarray, $quantities);
                                        if ($productobject->get_sale_price() != '') {
                                            if (isset($getpricingrules['sumo_apply_this_rule_for_sale']) && $getpricingrules['sumo_apply_this_rule_for_sale'] == 'yes') {
                                                $getdisval = self::sumo_function_to_get_local_rule_discount_for_offer($getpricingrules, $getfirstrule, $qty, $productprice, $product_id, $buy_qty);
                                            } else {
                                                $getdisval = NULL;
                                            }
                                        } else {
                                            $getdisval = self::sumo_function_to_get_local_rule_discount_for_offer($getpricingrules, $getfirstrule, $qty, $productprice, $product_id, $buy_qty);
                                        }
                                        if ($getdisval !== NULL) {
                                            $sumo_so_discount_array[$product_id] = $getdisval;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $buy_quantity = isset($getpricingrules['sumo_special_offer_buy_quantity']) ? $getpricingrules['sumo_special_offer_buy_quantity'] : 0;
                        if ($count >= $buy_quantity) {
                            if (isset($getpricingrules['sumo_special_offer_apply_to_free_products'])) {
                                $pro_id = is_array($getpricingrules['sumo_special_offer_apply_to_free_products']) ? implode(',', $getpricingrules['sumo_special_offer_apply_to_free_products']) : $getpricingrules['sumo_special_offer_apply_to_free_products'];
                                $removed_productss = WC()->session->get('removed_cart_contents', array());
                                $removed_products = array();
                                foreach ($removed_productss as $key => $value4) {
                                    $removed_products[] = $value4['product_id'];
                                }

                                $validate_cart_product = self::validate_product_filter_on_applying_gift_in_cart($product_id, $newarray);
                                if ($pro_id && !in_array($pro_id, $products_in_cart['product_ids']) && $validate_cart_product) {
                                    WC()->cart->add_to_cart($pro_id);
                                }
                                if (in_array($pro_id, $products_in_cart['product_ids'])) {
                                    $free_product = wc_get_product($pro_id);
                                    $free_product_price = (float) $free_product->get_price();
                                    $quantitiesz = sumo_dynamic_pricing_cart_quantities();
                                    unset($quantities[$pro_id]);
                                    $buy_qtyz = sumo_function_for_get_buy_quantity_on_special_offer_discount($newarray, $quantities);
                                    $allowed_quantity = (int) ($quantitiesz[$pro_id] - 1 );
                                    if ($buy_qtyz >= $buy_quantity) {
                                        if ($allowed_quantity) {
                                            $sumo_so_discount_array[$pro_id] = ($free_product_price * $allowed_quantity) / $quantitiesz[$pro_id];
                                        } else {
                                            $sumo_so_discount_array[$pro_id] = 0;
                                        }
                                    }
                                } else {
                                    $sumo_so_discount_array[$pro_id] = 0;
                                }
                            }
                        }
                    }
                }
                $quantities = sumo_dynamic_pricing_cart_quantities();
            }
//            if ($cart_count == 1) {
            $allow_type = isset($getpricingrules['sumo_special_offer_applicable_on_']) ? $getpricingrules['sumo_special_offer_applicable_on_'] : '';
            $matched_discountvalue = self::sumo_allow_matched_discounts_for_special_offer($sumo_so_discount_array, $allow_type, $cart_object);
            return $matched_discountvalue;
//            }
        }
    }

    /*
     * Validate product filter on applying gift in cart.
     * 
     * @return bool.
     */

    public static function validate_product_filter_on_applying_gift_in_cart($cart_product_id, $special_offer_rule_data) {

        if (!$cart_product_id || !isset($special_offer_rule_data["product_type"])) {
            return false;
        }

        $product = wc_get_product($cart_product_id);
        if (!is_object($product)) {
            return false;
        }

        $bool = true;
        switch ($special_offer_rule_data["product_type"]) {

            case '2':
                $include_products = !empty($special_offer_rule_data["included_products"]) ? $special_offer_rule_data["included_products"] : array();
                $bool = !empty($include_products) ? in_array($cart_product_id, $include_products) : true;
                break;
            case '3':
                $exclude_products = !empty($special_offer_rule_data["excluded_products"]) ? $special_offer_rule_data["excluded_products"] : array();
                $bool = !empty($exclude_products) ? !in_array($cart_product_id, $exclude_products) : true;
                break;
            case '5':
                $include_categories = !empty($special_offer_rule_data["included_category"]) ? $special_offer_rule_data["included_category"] : array();
                $bool = !empty($include_categories) ? !empty(array_intersect((array) $product->get_category_ids(), $include_categories)) : true;
                break;
            case '6':
                $exclude_categories = !empty($special_offer_rule_data["excluded_category"]) ? $special_offer_rule_data["excluded_category"] : array();
                $bool = !empty($exclude_categories) ? empty(array_intersect((array) $product->get_category_ids(), $exclude_categories)) : true;
                break;
            case '8':
                $include_tags = !empty($special_offer_rule_data["included_tag"]) ? $special_offer_rule_data["included_tag"] : array();
                $bool = !empty($include_tags) ? !empty(array_intersect((array) $product->get_tag_ids(), $include_tags)) : true;
                break;
            case '9':
                $exclude_tags = !empty($special_offer_rule_data["excluded_tag"]) ? $special_offer_rule_data["excluded_tag"] : array();
                $bool = !empty($exclude_tags) ? empty(array_intersect((array) $product->get_tag_ids(), $exclude_tags)) : true;
                break;
        }

        return $bool;
    }

    public static function sumo_allow_matched_discounts_for_special_offer($discountvalue, $allow_type, $cart_object) {
        $original_price = array();
        $return = array();
        if (!empty($discountvalue)) {
            foreach ($cart_object->cart_contents as $value) {
                $my_product_id = $value['variation_id'] > 0 ? $value['variation_id'] : $value['product_id'];
                foreach ($discountvalue as $product_id => $price) {
                    if ($my_product_id == $product_id) {
                        $productprice = get_post_meta($product_id, '_price', true);
                        $original_price[$product_id] = (float) $productprice;
                    }
                }
            }
        }
        if (!empty($original_price)) {
            if ($allow_type == '1') {
                $price_of_product = max($original_price);
            } elseif ($allow_type == '2') {
                $price_of_product = min($original_price);
            }
            $pro_id_to_return = array_search($price_of_product, $original_price);
            $return = array($pro_id_to_return => $discountvalue[$pro_id_to_return]);
        }
        return $return;
    }

    public static function sumo_get_cart_item_quantities($id) {
        $qty = 0;
        foreach (WC()->cart->cart_contents as $value) {
            $productid = $value['variation_id'] != ('' || 0) ? $value['variation_id'] : $value['product_id'];
            if ($id == $productid) {
                $qty = $value['quantity'];
            }
        }
        return $qty;
    }

}

new SUMOFunctionalityForSOP();

function sumo_function_for_get_buy_quantity_on_special_offer_discount($newarray, $quantities) {
    $buy_quantity = 0;
    $my_array = array();
    if ($newarray['product_type'] == '1') {
        return array_sum($quantities);
    } elseif ($newarray['product_type'] == '2') {
        $include_product_in_rule = $newarray['included_products'];
        if ($include_product_in_rule != '') {
            if (is_array($include_product_in_rule)) {
                $incproductrule = $include_product_in_rule;
            } else {
                $incproductrule = explode(',', $include_product_in_rule);
            }
            $incproductrule = sumo_dynamic_pricing_translated_array($incproductrule);

            foreach ($incproductrule as $each_id) {
                if (array_key_exists($each_id, $quantities)) {
                    $buy_quantity += $quantities[$each_id];
                }
            }
        }
        return $buy_quantity;
    } elseif ($newarray['product_type'] == '3') {
        $exclude_product_in_rule = $newarray['excluded_products'];
        if ($exclude_product_in_rule != '') {
            if (is_array($exclude_product_in_rule)) {
                $excproductrule = $exclude_product_in_rule;
            } else {
                $excproductrule = explode(',', $exclude_product_in_rule);
            }
            $excproductrule = sumo_dynamic_pricing_translated_array($excproductrule);
            foreach ($excproductrule as $each_id) {
                if (!array_key_exists($each_id, $quantities)) {
                    $buy_quantity += $quantities[$each_id];
                }
            }
        }
        return $buy_quantity;
    } elseif ($newarray['product_type'] == '4') {
        foreach ($quantities as $product_id => $quantity) {
            $obj = sumo_sd_get_product(sumo_dynamic_pricing_product_id_from_other_lang($product_id));
            $parent_id = sumo_sd_get_product_level_id($obj);
            $terms = wp_get_post_terms(sumo_dynamic_pricing_product_id_from_other_lang($parent_id), 'product_cat');
            if (!empty($terms)) {
                $buy_quantity += $quantity;
            }
        }
        return $buy_quantity;
    } elseif ($newarray['product_type'] == '5') {
        $inc_cat_in_rule = $newarray['included_category'];
        if ($inc_cat_in_rule != '') {
            if (is_array($inc_cat_in_rule)) {
                $inccatinrule = $inc_cat_in_rule;
            } else {
                $inccatinrule = explode(',', $inc_cat_in_rule);
            }
            foreach ($quantities as $product_id => $quantity) {
                $obj = sumo_sd_get_product(sumo_dynamic_pricing_product_id_from_other_lang($product_id));
                $parent_id = sumo_sd_get_product_level_id($obj);
                $product_categories = get_the_terms(sumo_dynamic_pricing_product_id_from_other_lang($parent_id), 'product_cat');
                foreach ($product_categories as $category) {
                    $my_array[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang($category->term_id);
                }
                $array_intersect = array_intersect($my_array, sumo_dynamic_pricing_translated_array($inccatinrule));
                if (!empty($array_intersect)) {
                    $buy_quantity += $quantity;
                }
            }
        }
        return $buy_quantity;
    } elseif ($newarray['product_type'] == '6') {
        $exc_cat_in_rule = $newarray['excluded_category'];
        if ($exc_cat_in_rule != '') {
            if (is_array($exc_cat_in_rule)) {
                $exccatinrule = $exc_cat_in_rule;
            } else {
                $exccatinrule = explode(',', $exc_cat_in_rule);
            }
            foreach ($quantities as $product_id => $quantity) {
                $obj = sumo_sd_get_product(sumo_dynamic_pricing_product_id_from_other_lang($product_id));
                $parent_id = sumo_sd_get_product_level_id($obj);
                $product_categories = get_the_terms(sumo_dynamic_pricing_product_id_from_other_lang($parent_id), 'product_cat');
                foreach ($product_categories as $category) {
                    $my_array[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang($category->term_id);
                }
                $array_intersect = array_intersect($my_array, sumo_dynamic_pricing_translated_array($exccatinrule));
                if (empty($array_intersect)) {
                    $buy_quantity += $quantity;
                }
            }
        }
        return $buy_quantity;
    } elseif ($newarray['product_type'] == '7') {
        foreach ($quantities as $product_id => $quantity) {
            $obj = sumo_sd_get_product(sumo_dynamic_pricing_product_id_from_other_lang($product_id));
            $parent_id = sumo_sd_get_product_level_id($obj);
            $terms = wp_get_post_terms(sumo_dynamic_pricing_product_id_from_other_lang($parent_id), 'product_tag');
            if (!empty($terms)) {
                $buy_quantity += $quantity;
            }
        }
        return $buy_quantity;
    } elseif ($newarray['product_type'] == '8') {
        $inc_tag_in_rule = $newarray['included_tag'];
        if ($inc_tag_in_rule != '') {
            if (is_array($inc_tag_in_rule)) {
                $inctaginrule = $inc_tag_in_rule;
            } else {
                $inctaginrule = explode(',', $inc_tag_in_rule);
            }
            foreach ($quantities as $product_id => $quantity) {
                $obj = sumo_sd_get_product(sumo_dynamic_pricing_product_id_from_other_lang($product_id));
                $parent_id = sumo_sd_get_product_level_id($obj);
                $product_tags = get_the_terms(sumo_dynamic_pricing_product_id_from_other_lang($parent_id), 'product_tag');
                foreach ($product_tags as $tag) {
                    $my_array[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang($tag->term_id);
                }
                $array_intersect = array_intersect($my_array, sumo_dynamic_pricing_translated_array($inctaginrule));
                if (!empty($array_intersect)) {
                    $buy_quantity += $quantity;
                }
            }
        }
        return $buy_quantity;
    } elseif ($newarray['product_type'] == '9') {
        $exc_tag_in_rule = $newarray['excluded_tag'];
        if ($exc_tag_in_rule != '') {
            if (is_array($exc_tag_in_rule)) {
                $exctaginrule = $exc_tag_in_rule;
            } else {
                $exctaginrule = explode(',', $exc_tag_in_rule);
            }
            foreach ($quantities as $product_id => $quantity) {
                $obj = sumo_sd_get_product($product_id);
                $parent_id = sumo_sd_get_product_level_id($obj);
                $product_tags = get_the_terms($parent_id, 'product_cat');
                foreach ($product_tags as $tag) {
                    $my_array[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang($tag->term_id);
                }
                $array_intersect = array_intersect($my_array, sumo_dynamic_pricing_translated_array($exctaginrule));
                if (empty($array_intersect)) {
                    $buy_quantity += $quantity;
                }
            }
        }
        return $buy_quantity;
    }
}
