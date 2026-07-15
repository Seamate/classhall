<?php

class SUMODiscount_Help_Tab {

    public function __construct() {

        add_filter('woocommerce_sp_settings_tabs_array', array($this, 'initialize_tab')); // Register a New Tab in a WooCommerce
        add_action('woocommerce_sp_settings_tabs_sumo_help', array($this, 'initialize_visual_appearance_admin_fields')); // Call to register the admin settings in the Plugin Submenu with general settings tab
        add_action('woocommerce_admin_field_sumo_discount_documentation_content', array($this, 'sumo_discount_documentation_content'));

        add_action('woocommerce_admin_field_sumo_compatitablity_plugins', array($this, 'sumo_compatitablity_plugins_action'));
    }

    /*
     * Function to Define Name of the Tab
     */

    public static function initialize_tab($setting_tabs) {
        if(!is_array($setting_tabs)){
            $setting_tabs = (array)$setting_tabs;
        }
        $setting_tabs['sumo_help'] = __('Help', 'sumodiscounts');
        return array_filter($setting_tabs);
    }

    public static function sumo_discount_documentation_content() {
        ?>
        <style type="text/css">
            p.submit{
                display: none;
            }
            #mainforms{
                display: none;
            }
        </style>
        <?php
    }

    /*
     * Function label settings to Member Level Tab
     */

    public static function initialize_admin_fields() {
        global $woocommerce;

        return apply_filters('woocommerce_sumodiscount_help', array(
            array(
                'name' => __('Documentation', 'sumodiscounts'),
                'type' => 'title',
                'id' => 'sumo_help_tab_setting',
                'desc' => __('The documentation file can be found inside the documentation folder  which you will find when you unzip the downloaded zip file.', 'sumodiscounts'),
            ),
            array(
                'type' => 'sumo_compatitablity_plugins'
            ),
            array(
                'name' => __('Help', 'sumodiscounts'),
                'type' => 'title',
                'id' => '_sumo_discount_help_setting',
                'desc' => __('If you need Help, please <a href="http://support.fantasticplugins.com" target="_blank" > register and open a support ticket</a>', 'sumodiscounts'),
            ),
            array(
                'type' => 'sumo_discount_documentation_content',
            ),
            array('type' => 'sectionend', 'id' => 'sumo_help_tab_setting'),
        ));
    }

    /**
     * Registering Custom Field Admin Settings
     */
    public static function initialize_visual_appearance_admin_fields() {


        woocommerce_admin_fields(SUMODiscount_Help_Tab::initialize_admin_fields());
    }

    public static function sumo_compatitablity_plugins_action() {
        ?>
        <h2>
            <?php echo __('Compatibility', 'sumodiscounts'); ?>
        </h2>
        <p>
            <?php
            $sumo_memberships = '<a href="http://www.fantasticplugins.com/sumo-memberships">' . __('SUMO Memberships', 'sumodiscounts') . '</a>';
            $sumo_rewardpoints = '<a href="http://www.fantasticplugins.com/sumo-reward-points">' . __('SUMO Reward Points', 'sumodiscounts') . '</a>';
            echo __('The following Plugins are compatible with this Discounts Plugin.', 'sumodiscounts') . '<br><br>';
            echo "1. " . $sumo_memberships . '<br>';
            echo "2. " . $sumo_rewardpoints . '';
            ?>
        </p>
        <?php
    }

}

new SUMODiscount_Help_Tab();
