<?php

if ($getpricingrules['sumo_pricing_apply_to_user'] == '1') {      //For All user    
    $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
    if (!empty($disval)) {
        $discountvalue[$key] = $disval;
    }
} else if ($getpricingrules['sumo_pricing_apply_to_user'] == '2') {       //For Included User
    if (isset($getpricingrules['sumo_pricing_apply_to_include_users'])) {
        $includeduserids1 = !is_array($getpricingrules['sumo_pricing_apply_to_include_users']) ? explode(',', $getpricingrules['sumo_pricing_apply_to_include_users']) : $getpricingrules['sumo_pricing_apply_to_include_users'];
        $includeduserids = array_filter($includeduserids1);
        $currentuserid = get_current_user_id();
        if (in_array($currentuserid, $includeduserids)) {
            $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
            if (!empty($disval)) {
                $discountvalue[$key] = $disval;
            }
        }
    }
} else if ($getpricingrules['sumo_pricing_apply_to_user'] == '3') {    //For Excluded User
    if ($getpricingrules['sumo_pricing_apply_to_exclude_users'] != '') {
        $excludeduserids1 = !is_array($getpricingrules['sumo_pricing_apply_to_exclude_users']) ? explode(',', $getpricingrules['sumo_pricing_apply_to_exclude_users']) : $getpricingrules['sumo_pricing_apply_to_exclude_users'];
        $excludeduserids = array_filter($excludeduserids1);
        $currentuserid = get_current_user_id();
        if (!in_array($currentuserid, $excludeduserids)) {
            $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
            if (!empty($disval)) {
                $discountvalue[$key] = $disval;
            }
        }
    }
} else if ($getpricingrules['sumo_pricing_apply_to_user'] == '4') {    //For All user Role
    $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
    if (!empty($disval)) {
        $discountvalue[$key] = $disval;
    }
} else if ($getpricingrules['sumo_pricing_apply_to_user'] == '5') {      //For Included User Roles
    if ($getpricingrules['sumo_pricing_apply_to_include_users_role'] != '') {
        $currentuserid = get_current_user_id();
        $getuserdata = get_userdata($currentuserid);
        $currentuserrole = $getuserdata->roles;
        $includeduserrole = $getpricingrules['sumo_pricing_apply_to_include_users_role'];
        if (in_array($currentuserrole[0], $includeduserrole)) {
            $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
            if (!empty($disval)) {
                $discountvalue[$key] = $disval;
            }
        }
    }
} else if ($getpricingrules['sumo_pricing_apply_to_user'] == '6') {      //For Excluded User Roles
    if ($getpricingrules['sumo_pricing_apply_to_exclude_users_role'] != '') {
        $currentuserid = get_current_user_id();
        $getuserdata = get_userdata($currentuserid);
        $currentuserrole = $getuserdata->roles;
        $includeduserrole = $getpricingrules['sumo_pricing_apply_to_exclude_users_role'];
        if (!in_array($currentuserrole[0], $includeduserrole)) {
            $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
            if (!empty($disval)) {
                $discountvalue[$key] = $disval;
            }
        }
    }
} else if ($getpricingrules['sumo_pricing_apply_to_user'] == '7') {      //For Excluded User Roles
    if (class_exists('SUMOMemberships') && sumo_get_membership_levels()) {
        $plans = is_array($getpricingrules['sumo_pricing_apply_to_include_memberplans']) ? $getpricingrules['sumo_pricing_apply_to_include_memberplans'] : array();
        $new_post_id = sumo_get_member_post_id(get_current_user_id());
        if ($new_post_id > 0) {
            if (!empty($plans)) {
                foreach ($plans as $plan_id) {
                    if (!sumo_plan_is_already_had($plan_id, $new_post_id)) {
                        $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                        if (!empty($disval)) {
                            $discountvalue[$key] = $disval;
                        }
                    }
                }
            } else {
                $disval = self::sumo_discount_value_for_product_level($weekdays, $getpricingrules, $currentdays, $cart_object, $product_id, $products_in_cart);
                if (!empty($disval)) {
                    $discountvalue[$key] = $disval;
                }
            }
        }
    }
}