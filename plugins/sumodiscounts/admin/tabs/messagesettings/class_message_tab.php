<?php

class FP_SP_Messages_Tab {

    // Construct the Class
    public function __construct() {
        add_action('init', array($this, 'sp_sumopricing_add_option_admin_settings'), 103);
        // make it appear in Discount System Discounts Rule
        add_action('woocommerce_sp_settings_tabs_array', array($this, 'initialize_tab'));
        // Initialize Admin Fields in Discounts Rule
        add_action('woocommerce_sp_settings_tabs_fp_sp_message_tab', array($this, 'initialize_visual_appearance_admin_fields'));

        // Initialize Update Fields in Discounts Rule
        add_action('woocommerce_update_options_fp_sp_message_tab', array($this, 'update_data_from_admin_fields'));

        add_action('admin_head', array($this, 'jquery_function'));
    }

    public static function jquery_function() {
        if (isset($_GET['tab'])) {
            if ($_GET['tab'] == 'fp_sp_message_tab') {
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        if (jQuery('#sp_show_cart_rules_in_single_product').val() == 'show') {
                            jQuery('#sp_cart_rule_message_in_single_product').closest('tr').show();
                        } else {
                            jQuery('#sp_cart_rule_message_in_single_product').closest('tr').hide();
                        }
                        jQuery('#sp_show_cart_rules_in_single_product').change(function () {
                            if (jQuery(this).val() == 'show') {
                                jQuery('#sp_cart_rule_message_in_single_product').closest('tr').show();
                            } else {
                                jQuery('#sp_cart_rule_message_in_single_product').closest('tr').hide();
                            }
                        });
                        if (jQuery('#sp_show_cart_rules_in_shop').val() == 'show') {
                            jQuery('#sp_cart_rule_message_in_shop').closest('tr').show();
                        } else {
                            jQuery('#sp_cart_rule_message_in_shop').closest('tr').hide();
                        }
                        jQuery('#sp_show_cart_rules_in_shop').change(function () {
                            if (jQuery(this).val() == 'show') {
                                jQuery('#sp_cart_rule_message_in_shop').closest('tr').show();
                            } else {
                                jQuery('#sp_cart_rule_message_in_shop').closest('tr').hide();
                            }
                        });
                        if (jQuery('#sp_show_cart_rules_in_cart').val() == 'show') {
                            jQuery('#sp_cart_rule_message_in_cart').closest('tr').show();
                        } else {
                            jQuery('#sp_cart_rule_message_in_cart').closest('tr').hide();
                        }
                        jQuery('#sp_show_cart_rules_in_cart').change(function () {
                            if (jQuery(this).val() == 'show') {
                                jQuery('#sp_cart_rule_message_in_cart').closest('tr').show();
                            } else {
                                jQuery('#sp_cart_rule_message_in_cart').closest('tr').hide();
                            }
                        });
                        if (jQuery('#sp_show_discount_applied_in_cart').val() == 'show') {
                            jQuery('#sp_discount_applied_message_in_cart').closest('tr').show();
                        } else {
                            jQuery('#sp_discount_applied_message_in_cart').closest('tr').hide();
                        }
                        jQuery('#sp_show_discount_applied_in_cart').change(function () {
                            if (jQuery(this).val() == 'show') {
                                jQuery('#sp_discount_applied_message_in_cart').closest('tr').show();
                            } else {
                                jQuery('#sp_discount_applied_message_in_cart').closest('tr').hide();
                            }
                        });
                        if (jQuery('#sp_show_special_offer_pricing_message_on_single_product').val() == 'show') {
                            jQuery('#sp_message_for_special_offer_same_pro_in_single_product').closest('tr').show();
                            jQuery('#sp_message_for_special_offer_diff_pro_in_single_product').closest('tr').show();
                        } else {
                            jQuery('#sp_message_for_special_offer_same_pro_in_single_product').closest('tr').hide();
                            jQuery('#sp_message_for_special_offer_diff_pro_in_single_product').closest('tr').hide();
                        }
                        jQuery('#sp_show_special_offer_pricing_message_on_single_product').change(function () {
                            if (jQuery(this).val() == 'show') {
                                jQuery('#sp_message_for_special_offer_same_pro_in_single_product').closest('tr').show();
                                jQuery('#sp_message_for_special_offer_diff_pro_in_single_product').closest('tr').show();
                            } else {
                                jQuery('#sp_message_for_special_offer_same_pro_in_single_product').closest('tr').hide();
                                jQuery('#sp_message_for_special_offer_diff_pro_in_single_product').closest('tr').hide();
                            }
                        });
                    });
                </script>
                <?php

            }
        }
    }

    public static function initialize_tab($settings_tab) {
        if(!is_array($settings_tab)){
            $settings_tab = (array)$settings_tab;
        }
        $settings_tab['fp_sp_message_tab'] = __('Message', 'sumodiscounts');
        return array_filter($settings_tab);
    }

    // Initialize Admin Fields in Discount System

    public static function initialize_admin_fields() {
        return apply_filters('woocommerce_fp_sp_message_tab', array(
            array(
                'name' => __('Messages', 'sumodiscounts'),
                'type' => 'title',
                'id' => '_sp_message_tab_settings'
            ),
            array(
                'name' => __('Cart Total Discounts Message Setting', 'sumodiscounts'),
                'type' => 'title',
                'id' => '_sp_cart_pricing_message_settings'
            ),
            array(
                'name' => __('Discount Fees Label', 'sumodiscounts'),
                'type' => 'text',
                'tip' => '',
                'id' => 'sp_cart_discount_fees_label',
                'std' => __('Cart Discount','sumodiscounts'),
                'default' => __('Cart Discount','sumodiscounts'),
                'newids' => 'sp_cart_discount_fees_label'
            ),
            array(
                'type' => 'sectionend',
                'id' => '_sp_cart_pricing_message_settings'
            )
        ));
    }

    // Make it appear visually in Discount System

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields(self::initialize_admin_fields());
    }

    // Update the Settings of Discount System

    public static function update_data_from_admin_fields() {
        woocommerce_update_options(self::initialize_admin_fields());
    }

    public static function sp_sumopricing_add_option_admin_settings() {
        foreach (self::initialize_admin_fields() as $setting)
            if (isset($setting['newids']) && isset($setting['std'])) {
                add_option($setting['newids'], $setting['std']);
            }
    }

}

new FP_SP_Messages_Tab();
