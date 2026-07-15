<?php

class SUMOFunctionalityMP {

    public static function sumopricing_for_membership_level($price, $object) {
        $user_id = get_current_user_id();
        $post_id = sumo_get_member_post_id($user_id);
        $fromdate = get_option('sumo_membership_from_date', true) != "" ? strtotime(get_option('sumo_membership_from_date', true)) : NULL;
        $todate = get_option('sumo_membership_to_date', true) != "" ? strtotime(get_option('sumo_membership_to_date', true)) : strtotime(date_i18n('d-m-Y'));
        $apply_discount_for_date = sumo_function_for_date_filter($fromdate, $todate);
        $tabname = 'membership';
        $discount = array();
        $apply_discount_for_day = sumo_function_for_day_filter($tabname);
        if (($apply_discount_for_date && $apply_discount_for_day)) {
            $product_id = sumo_sd_get_product_id($object);
            $newarray = array(
                'product_type' => get_option('sp_membership_pricing_for_products'),
                'included_products' => get_option('sp_incproducts_at_membership') != '' ? get_option('sp_incproducts_at_membership') : '',
                'excluded_products' => get_option('sp_excproducts_at_membership') != '' ? get_option('sp_excproducts_at_membership') : '',
                'included_category' => get_option('sp_inccategories_at_membership') != '' ? get_option('sp_inccategories_at_membership') : '',
                'excluded_category' => get_option('sp_exccategories_at_membership') != '' ? get_option('sp_exccategories_at_membership') : '',
                'included_tag' => get_option('sp_inctags_at_membership') != '' ? get_option('sp_inctags_at_membership') : '',
                'excluded_tag' => get_option('sp_exctags_at_membership') != '' ? get_option('sp_exctags_at_membership') : ''
            );
            $apply_discount_for_product = sumo_function_for_product_and_category_filter(sumo_dynamic_pricing_product_id_from_other_lang($product_id), $newarray);
            if ($apply_discount_for_product) {
                $rule_priority = get_option('sp_rule_priority_for_membership_level');
                if ($post_id > 0) {
                    $get_plan_id = get_post_meta($post_id, 'sumomemberships_saved_plans', true);
                    if (is_array($get_plan_id)) {
                        foreach ($get_plan_id as $key => $value) {
                            if (isset($value['choose_plan']) && $value['choose_plan'] != '') {
                                $plan_id = $value['choose_plan'];
                                $getcurrentplantype = get_option('sumopricing_rule_discounttype_for_sm');
                                $getcurrentplanvalues = get_option('sumopricing_rule_discountvalue_for_sm');
                                if (array_key_exists($plan_id, $getcurrentplantype)) {
                                    $discount[$plan_id]['discount_type'] = $getcurrentplantype[$plan_id];
                                    $discount[$plan_id]['discount_value'] = $getcurrentplanvalues[$plan_id];
                                }
                            }
                        }
                    }
                    $alteredprice = self::sumopricing_function_to_get_discount_value($rule_priority, $discount, $price);
                    if ($object->get_sale_price() != '') {
                        $apply_discount_for_saleprice = get_option('sumo_enable_membership_when_product_has_sale_price');
                        if ($apply_discount_for_saleprice == 'yes') {
                            return $alteredprice;
                        }
                    } else {
                        return $alteredprice;
                    }
                }
            }
        }
    }

    public static function sumopricing_function_to_get_discount_value($rule_priority, $discount, $price) {
        if (is_array($discount) && !empty($discount)) {
            $discountedvalue = array();
            foreach ($discount as $key => $value) {
                if ($value['discount_type'] == '1') {
                    $discountpercentage = $value['discount_value'] / 100;
                    $discountpercentages = $discountpercentage * $price;
                    $discountedvalue[] = $price - $discountpercentages;
                } elseif ($value['discount_type'] == '2') {
                    if ($price > $value['discount_value']) {
                        $discountprice = $price - $value['discount_value'];
                        $discountedvalue[] = $discountprice;
                    } else {
                        $discountedvalue[] = 0;
                    }
                } elseif ($value['discount_type'] == '3') {
                    $discountedvalue[] = $value['discount_value'];
                } else {
//                    $discountedvalue[] = '0';
                }
            }
            if ($rule_priority == '1') {
                $matched_value = reset($discountedvalue);
                return $matched_value;
            } elseif ($rule_priority == '2') {
                $matched_value = end($discountedvalue);
                return $matched_value;
            } elseif ($rule_priority == '3') {
                $matched_value = max($discountedvalue);
                return $matched_value;
            } else {
                $matched_value = min($discountedvalue);
                return $matched_value;
            }
        } else {
            return $price;
        }
    }

}

new SUMOFunctionalityMP();
