<?php

if ($getpricingrules['sumo_dynamic_rule_based_on_pricing'] == '1') {
    $fromdate = $getpricingrules['sumo_pricing_from_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_from_datepicker']) : NULL;
    $todate = $getpricingrules['sumo_pricing_to_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_to_datepicker']) : strtotime(date_i18n('d-m-Y'));

    if ($fromdate && $todate) {
        if (($currentdate >= $fromdate) && ($currentdate <= $todate)) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_product_level.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_product_level.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    } else {
        if ($currentdate <= $todate) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_product_level.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_product_level.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    }
} elseif ($getpricingrules['sumo_dynamic_rule_based_on_pricing'] == '2') {
    $fromdate = $getpricingrules['sumo_pricing_from_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_from_datepicker']) : NULL;
    $todate = $getpricingrules['sumo_pricing_to_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_to_datepicker']) : strtotime(date_i18n('d-m-Y'));
    if ($fromdate && $todate) {
        if (($currentdate >= $fromdate) && ($currentdate <= $todate)) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_each_cart_line_item.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_each_cart_line_item.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_for_each_cart_line_item($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    } else {
        if ($currentdate <= $todate) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_each_cart_line_item.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_each_cart_line_item.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_for_each_cart_line_item($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    }
} elseif ($getpricingrules['sumo_dynamic_rule_based_on_pricing'] == '3') {
    $fromdate = $getpricingrules['sumo_pricing_from_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_from_datepicker']) : NULL;
    $todate = $getpricingrules['sumo_pricing_to_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_to_datepicker']) : strtotime(date_i18n('d-m-Y'));
    if ($fromdate && $todate) {
        if (($currentdate >= $fromdate) && ($currentdate <= $todate)) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_entire_cart_quantity.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_entire_cart_quantity.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_for_entire_cart_quantity($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    } else {
        if ($currentdate <= $todate) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_entire_cart_quantity.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_entire_cart_quantity.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_for_entire_cart_quantity($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    }
} elseif ($getpricingrules['sumo_dynamic_rule_based_on_pricing'] == '4') {
    $fromdate = $getpricingrules['sumo_pricing_from_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_from_datepicker']) : NULL;
    $todate = $getpricingrules['sumo_pricing_to_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_to_datepicker']) : strtotime(date_i18n('d-m-Y'));
    if ($fromdate && $todate) {
        if (($currentdate >= $fromdate) && ($currentdate <= $todate)) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_each_category.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_each_category.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_each_category($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    } else {
        if ($currentdate <= $todate) {
            if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
                include 'sumo_apply_discount_for_each_category.php';
            } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
                if (get_current_user_id() > 0) {
                    include 'sumo_apply_discount_for_each_category.php';
                }
            } else {
                if (get_current_user_id() == 0) {
                    $disval = self::sumo_discount_value_each_category($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                    if (!empty($disval)) {
                        $discountvalue[$key] = $disval;
                    }
                }
            }
        }
    }
}    