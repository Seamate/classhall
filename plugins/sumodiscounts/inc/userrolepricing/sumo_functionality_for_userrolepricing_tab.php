<?php

class FP_SP_UserRolePricing_Functionalities {

    public static function sp_alter_product_price_as_per_user_role($price, $product) {
        global $current_user;
        $product_id = sumo_sd_get_product_id($product);
        $fromdate = get_option('sumo_user_role_based_pricing_from_date', true) != "" ? strtotime(get_option('sumo_user_role_based_pricing_from_date', true)) : NULL;
        $todate = get_option('sumo_user_role_based_pricing_to_date', true) != '' ? strtotime(get_option('sumo_user_role_based_pricing_to_date', true)) : strtotime(date_i18n('d-m-Y'));
        $apply_discount_for_date = sumo_function_for_date_filter($fromdate, $todate);
        $tabname = 'urp';
        $apply_discount_for_day = sumo_function_for_day_filter($tabname);
        if ($apply_discount_for_date && $apply_discount_for_day) {
            $newarray = array(
                'product_type' => get_option('sp_urbp_pricing_for_products'),
                'included_products' => get_option('sp_incproducts_at_urbp') != '' ? get_option('sp_incproducts_at_urbp') : '',
                'excluded_products' => get_option('sp_excproducts_at_urbp') != '' ? get_option('sp_excproducts_at_urbp') : '',
                'included_category' => get_option('sp_inccategories_at_urbp') != '' ? get_option('sp_inccategories_at_urbp') : '',
                'excluded_category' => get_option('sp_exccategories_at_urbp') != '' ? get_option('sp_exccategories_at_urbp') : '',
                'included_tag' => get_option('sp_inctags_at_urbp') != '' ? get_option('sp_inctags_at_urbp') : '',
                'excluded_tag' => get_option('sp_exctags_at_urbp') != '' ? get_option('sp_exctags_at_urbp') : ''
            );
            $apply_discount_for_product = sumo_function_for_product_and_category_filter(sumo_dynamic_pricing_product_id_from_other_lang($product_id), $newarray);
            if ($apply_discount_for_product) {
                if ($current_user->ID != (0 || '')) {
                    foreach ($current_user->roles as $user_role) {
                        $discount_type = get_option('sp_urb_pricing_type_of_' . $user_role);
                        if ($discount_type == false) {
                            $discount_type = '';
                        }
                        $discount_value = get_option('sp_urb_discount_value_' . $user_role);
                        if ($discount_value == false) {
                            $discount_value = 0;
                        }
                        if ($discount_type != '') {
                            if ($discount_type == 'percent_discount') {
                                $modified_price = (float) ( $price - (( $price * $discount_value ) / 100 ));
                            } elseif ($discount_type == 'fixed_discount') {
                                $modified_price = (float) ( $price - $discount_value );
                            } elseif ($discount_type == 'fixed_price') {
                                $modified_price = (float) $discount_value;
                            } elseif ($discount_type == 'percentage_markup') {
                                $modified_price = (float) ( $price + (( $price * $discount_value ) / 100 ));
                            } else {
                                $modified_price = (float) ( $price + $discount_value );
                            }
                            if ($product->get_sale_price() != '') {
                                $apply_discount_for_saleprice = get_option('sumo_enable_user_role_based_pricing_when_product_has_sale_price');
                                if ($apply_discount_for_saleprice == 'yes') {
                                    $price = max($modified_price, 0);
                                }
                            } else {
                                $price = max($modified_price, 0);
                            }
                        }
                    }
                } elseif ($current_user->ID == (0 || '')) {
                    $discount_type = get_option('sp_urb_pricing_type_of_guest') ? get_option('sp_urb_pricing_type_of_guest') : "";
                    $discount_value = get_option('sp_urb_discount_value_guest') ? get_option('sp_urb_discount_value_guest') : '';
                    if ($discount_type != '') {
                        if ($discount_type == 'percent_discount') {
                            $modified_price = (float) ( $price - (( $price * $discount_value ) / 100 ));
                        } elseif ($discount_type == 'fixed_discount') {
                            $modified_price = (float) ( $price - $discount_value );
                        } elseif ($discount_type == 'fixed_price') {
                            $modified_price = (float) $discount_value;
                        } elseif ($discount_type == 'percentage_markup') {
                            $modified_price = (float) ( $price + (( $price * $discount_value ) / 100 ));
                        } else {
                            $modified_price = (float) ( $price + $discount_value );
                        }
                        if ($product->get_sale_price() != '') {
                            $apply_discount_for_saleprice = get_option('sumo_enable_user_role_based_pricing_when_product_has_sale_price');
                            if ($apply_discount_for_saleprice == 'yes') {
                                $price = max($modified_price, 0);
                            }
                        } else {
                            $price = max($modified_price, 0);
                        }
                    }
                }
            }
        }
        return $price;
    }

}

new FP_SP_UserRolePricing_Functionalities();
