<?php

class RewardPointPricingFunctionalities {

    public static function sp_alter_product_price_as_per_earned_points($price, $product) {
        $user_id = get_current_user_id();
        $product_id = sumo_sd_get_product_id($product);
        $fromdate = get_option('sumo_reward_points_pricing_from_date', true) != "" ? strtotime(get_option('sumo_reward_points_pricing_from_date', true)) : NULL;
        $todate = get_option('sumo_reward_points_pricing_to_date', true) != '' ? strtotime(get_option('sumo_reward_points_pricing_to_date', true)) : strtotime(date_i18n('d-m-Y'));
        $tabname = 'rwp';
        $apply_discount_for_date = sumo_function_for_date_filter($fromdate, $todate);
        $apply_discount_for_day = sumo_function_for_day_filter($tabname);
        if ($apply_discount_for_date && $apply_discount_for_day) {
            if ($user_id > 0) {
                $newarray = array(
                    'product_type' => get_option('sp_rewardpoints_pricing_for_products'),
                    'included_products' => get_option('sp_incproducts_at_rwpp') != '' ? get_option('sp_incproducts_at_rwpp') : '',
                    'excluded_products' => get_option('sp_excproducts_at_rwpp') != '' ? get_option('sp_excproducts_at_rwpp') : '',
                    'included_category' => get_option('sp_inccategories_at_rwpp') != '' ? get_option('sp_inccategories_at_rwpp') : '',
                    'excluded_category' => get_option('sp_exccategories_at_rwpp') != '' ? get_option('sp_exccategories_at_rwpp') : '',
                    'included_tag' => get_option('sp_inctags_at_rwpp') != '' ? get_option('sp_inctags_at_rwpp') : '',
                    'excluded_tag' => get_option('sp_exctags_at_rwpp') != '' ? get_option('sp_exctags_at_rwpp') : ''
                        );
                $apply_discount_for_product = sumo_function_for_product_and_category_filter(sumo_dynamic_pricing_product_id_from_other_lang($product_id), $newarray);
                if ($apply_discount_for_product) {
                    $Pointsdata = new RS_Points_Data($user_id);
                    $points = get_option('fp_sp_rp_pricing_select_earn_points_based_on') == '1' ? $Pointsdata->total_earned_points() : $Pointsdata->total_available_points();
                    if ($product->get_sale_price() != '') {
                        $apply_discount_for_saleprice = get_option('sumo_enable_reward_points_pricing_when_product_has_sale_price');
                        if ($apply_discount_for_saleprice == 'yes') {
                            $price = self::sp_get_price_by_sumo_reward_points($price, $points);
                            return max($price, 0);
                        }
                    } else {
                        $price = self::sp_get_price_by_sumo_reward_points($price, $points);
                        return max($price, 0);
                    }
                }
            }
        }
        
        return $price;
    }

    public static function sp_get_price_by_sumo_reward_points($price, $points) {
        $price_array = array();
        $DataforFreeShipping = array();
        $rp_rule_array = get_option('fp_sp_reward_point_pricing_rule', true);
        if (!empty($rp_rule_array) && is_array($rp_rule_array)) {
            foreach ($rp_rule_array as $unique_id => $each_array) {
                $min = $each_array['min'] == '*' ? 1 : (int) $each_array['min'];
                $max = $each_array['max'];
                if ($max != '*') {
                    if (($points >= $min) && ($points <= $max)) {
                        $pricing_type = $each_array['pricing_type'];
                        $value = $each_array['value'];
                        if ($pricing_type == '1') {
                            $altered_price = (float) ($price - (($price * $value) / 100));
                        } elseif ($pricing_type == '2') {
                            $altered_price = (float) ($price - $value);
                        } else {
                            $altered_price = (float) $value;
                        }
                        $price_array[$unique_id] = $altered_price;
                        $DataforFreeShipping[$altered_price] = $unique_id;
                    }
                } else {
                    if (($points >= $min)) {
                        $pricing_type = $each_array['pricing_type'];
                        $value = $each_array['value'];
                        if ($pricing_type == '1') {
                            $altered_price = (float) ($price - (($price * $value) / 100));
                        } elseif ($pricing_type == '2') {
                            $altered_price = (float) ($price - $value);
                        } else {
                            $altered_price = (float) $value;
                        }
                        $price_array[$unique_id] = $altered_price;
                        $DataforFreeShipping[$altered_price] = $unique_id;
                    }
                }
            }
            WC()->session->set('applied_srp_discount_rule_id', $DataforFreeShipping);
            if (!empty($price_array)) {
                $priority = get_option('fp_sp_rp_pricing_rule_priority', true);
                if ($priority == '1') {
                    $price = reset($price_array);
                } elseif ($priority == '2') {
                    $price = end($price_array);
                } elseif ($priority == '3') {
                    $price = max($price_array);
                } elseif ($priority == '4') {
                    $price = min($price_array);
                }
            }
        }
        return $price;
    }

}

if (is_plugin_active('rewardsystem/rewardsystem.php') && class_exists('FPRewardSystem')) {

    new RewardPointPricingFunctionalities();
}
