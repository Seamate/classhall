<?php

class SUMOGeneral_Tab {

    // Construct the Class
    public function __construct() {
        add_action('init', array($this, 'sp_sumopricing_add_option_admin_settings'), 103);
        add_action('woocommerce_sp_settings_tabs_array', array($this, 'initialize_tab'));
        add_action('woocommerce_sp_settings_tabs_sp_general_settings', array($this, 'initialize_visual_appearance_admin_fields'));
        add_action('woocommerce_update_options_sp_general_settings', array($this, 'update_data_from_admin_fields'));
        include('sumo_functionality_for_general_settings.php');
    }

    public static function initialize_tab($settings_tab) {
        if(!is_array($settings_tab)){
            $settings_tab = (array)$settings_tab;
        }
        $settings_tab['sp_general_settings'] = __('General', 'sumodiscounts');
        return array_filter($settings_tab);
    }

    // Initialize Admin Fields in Sumo Discounts

    public static function initialize_admin_fields() {
        global $woocommerce, $wp_roles;
        foreach ($wp_roles->role_names as $key => $value) {
            $userrole[] = $key;
            $username[] = $value;
        }
        $product_categories = array();
        $all_categories = get_categories(array('hide_empty' => 0, 'taxonomy' => 'product_cat'));
        foreach ($all_categories as $each_category) {
            $product_categories[$each_category->term_id] = $each_category->name;
        }
        $user_role = array_combine((array) $userrole, (array) $username);
        return apply_filters('woocommerce_sp_general_settings', array(
            array(
                'name' => '',
                'type' => 'title',
                'desc' => __('Discounts will be applied in the following order', 'sumodiscounts'),
                'id' => 'sp_priority_for_pricing_adjustments'
            ),
            array(
                'type' => 'drag_and_drop_rule_priority'
            ),
            array(
                'type' => 'sectionend',
                'id' => 'sp_priority_for_pricing_adjustments'
            ),
            array(
                'name' => __('Discounted Price Display Settings', 'sumodiscounts'),
                'type' => 'title',
                'id' => 'sp_display_settings'
            ),
            array(
                'name' => __('Discount Price Display Method', 'sumodiscounts'),
                'tip' => '',
                'id' => 'sumo_price_display_method_with_discounts',
                'css' => 'min-width:150px;',
                'std' => '1',
                'type' => 'select',
                'options' => array(
                    '1' => __('Replace Original Price', 'sumodiscounts'),
                    '2' => __('Strike Original Price and Display Discounted Price', 'sumodiscounts'),
                ),
                'newids' => 'sumo_price_display_method_with_discounts',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Enable Discount Tag Label', 'sumodiscounts'),
                'tip' => '',
                'id' => 'sumo_enable_discount_tag',
                'std' => 'no',
                'type' => 'checkbox',
                'newids' => 'sumo_enable_discount_tag',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Discount Tag Label', 'sumodiscounts'),
                'id' => 'sumo_discount_tag_lable',
                'css' => 'min-width:150px;',
                'std' => '[discount_info] Off',
                'default' => '[discount_info] Off',
                'type' => 'text',
                'newids' => 'sumo_discount_tag_lable',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Display On Sale Tag for Variable Products using First Matched Variations', 'sumodiscounts'),
                'id' => 'sumo_enable_discount_for_variable_product',
                'std' => 'no',
                'type' => 'checkbox',
                'newids' => 'sumo_enable_discount_for_variable_product',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Custom CSS', 'sumodiscounts'),
                'id' => 'sumo_discount_custom_css',
                'std' => '',
                'default' => '',
                'type' => 'textarea',
                'newids' => 'sumo_discount_custom_css',
                'desc_tip' => true,
            ),
            array(
                'type' => 'sectionend',
                'id' => 'sp_display_settings'
            )
        ));
    }

    // Make it appear visually in Sumo Discounts

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields(self::initialize_admin_fields());
    }

    // Update the Settings of Sumo Discounts

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

new SUMOGeneral_Tab();
