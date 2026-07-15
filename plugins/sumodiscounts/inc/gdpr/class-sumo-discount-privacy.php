<?php

/*
 * GDPR Compliance
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('SUMO_Discount')) :

    /**
     * SUMO_Discount class
     */
    class SUMO_Discount {

        /**
         * SUMO_Discount constructor.
         */
        public function __construct() {
            $this->init_hooks();
        }

        /**
         * Register SUMO Discounts
         */
        public function init_hooks() {
            add_action('admin_init', array(__CLASS__, 'add_privacy_content_for_discounts'), 20);
        }

        /**
         * Return the privacy policy content for SUMO Discount.
         */
        public static function get_privacy_content() {
            return
                    '<h2>' . __('SUMO Discounts', 'sumodiscounts') . '</h2>' .
                    '<p>' . __('This includes the basics of what personal data your store may be collecting, storing and sharing. Depending on what settings are enabled and which additional plugins are used, the specific information shared by your store will vary.', 'sumodiscounts') . '</p>' .
                    '<h2>' . __('What the plugin does', 'sumodiscounts') . '</h2>'
                    . '<p>' . __('This plugin allows you to provide the following discount features on your site,', 'sumodiscounts') . '</p>'
                    . '<ul>'
                    . '<li>' . __('- Product/Category Discounts', 'sumodiscounts') . '</li>'
                    . '<li>' . __('- Quantity Discounts', 'sumodiscounts') . '</li>'
                    . '<li>' . __('- Special Offer Discounts', 'sumodiscounts') . '</li>'
                    . '<li>' . __('- Cart Total Discounts', 'sumodiscounts') . '</li>'
                    . '<li>' . __('- User Role Discounts', 'sumodiscounts') . '</li>'
                    . '</ul>'
                    . '<h2>' . __('What we collect and store', 'sumodiscounts') . '</h2>'
                    . '<h2>' . __('User ID', 'sumodiscounts') . '</h2>'
                    . '<p>' . __('User id is used for identifying the user to offer discounts. But, this plugin does not store the user id or any other Personal Information from the user.', 'sumodiscounts') . '</p>';
        }

        /**
         * Add the privacy policy text to the policy postbox.
         */
        public static function add_privacy_content_for_discounts() {
            if (function_exists('wp_add_privacy_policy_content')) {
                $content = self::get_privacy_content();
                wp_add_privacy_policy_content(__('SUMO Discounts'), $content);
            }
        }

    }

    new SUMO_Discount();

endif;