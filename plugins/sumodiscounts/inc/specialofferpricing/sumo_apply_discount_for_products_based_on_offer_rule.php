<?php
$fromdate = $getpricingrules['sumo_pricing_from_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_from_datepicker']) : NULL;
$todate = $getpricingrules['sumo_pricing_to_datepicker'] != '' ? strtotime($getpricingrules['sumo_pricing_to_datepicker']) : strtotime(date_i18n('d-m-Y'));
if ($fromdate && $todate) {
    if (($currentdate >= $fromdate) && ($currentdate <= $todate)) {
        if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
            include 'sumo_apply_discount_for_user_level_for_offer.php';
        } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
            if (get_current_user_id() > 0) {
                include 'sumo_apply_discount_for_user_level_for_offer.php';
            }
        } else {
            if (get_current_user_id() == 0) {
                $disval = self::sumo_discount_value_for_offer($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $sumo_so_discount_array, $cart_count, $products_in_cart);
                if (!empty($disval)) {
                    $discountvalue[$key] = $disval;
                }
            }
        }
    }
} else {
    if ($currentdate <= $todate) {
        if ($getpricingrules['sumo_pricing_apply_for_user_type'] == '1') {
            include 'sumo_apply_discount_for_user_level_for_offer.php';
        } elseif ($getpricingrules['sumo_pricing_apply_for_user_type'] == '2') {
            if (get_current_user_id() > 0) {
                include 'sumo_apply_discount_for_user_level_for_offer.php';
            }
        } else {
            if (get_current_user_id() == 0) {
                $disval = self::sumo_discount_value_for_offer($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $sumo_so_discount_array, $cart_count, $products_in_cart);
                if (!empty($disval)) {
                    $discountvalue[$key] = $disval;
                }
            }
        }
    }
}