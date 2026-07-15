<?php

class SUMOPricing_AdminMenu {

    public function __construct() {

        add_action('admin_menu', array($this, 'add_sub_menu_for_discount'));

        add_action('admin_init', array($this, 'sumo_include_tab_files'));
    }

    public static function add_sub_menu_for_discount() {
        add_submenu_page('woocommerce', __('SUMO Discounts', 'sumodiscounts'), __('SUMO Discounts', 'sumodiscounts'), 'manage_woocommerce', 'sumodiscounts', array('SUMOPricing_AdminMenu', 'main_sub_menu_settings'));
    }

    public static function main_sub_menu_settings() {

        global $woocommerce, $woocommerce_settings, $current_section, $current_tab;
        $tabs = "";
        do_action('woocommerce_sp_settings_start');
        $current_tab = ( empty($_GET['tab']) ) ? 'sp_general_settings' : sanitize_text_field(urldecode($_GET['tab']));
        $current_section = ( empty($_REQUEST['section']) ) ? '' : sanitize_text_field(urldecode($_REQUEST['section']));
        if (!empty($_POST['save'])) {
            if (empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce'], 'woocommerce-settings'))
                die(__('Action failed. Please refresh the page and retry.', 'sumodiscounts'));

            if (!$current_section) {
//include_once('settings/settings-save.php');
                switch ($current_tab) {
                    default :
                        if (isset($woocommerce_settings[$current_tab]))
                            woocommerce_update_options($woocommerce_settings[$current_tab]);

// Trigger action for tab
                        do_action('woocommerce_update_options_' . $current_tab);
                        break;
                }

                do_action('woocommerce_update_options');

// Handle Colour Settings
                if ($current_tab == 'sumodiscounts' && get_option('woocommerce_frontend_css') == 'yes') {
                    
                }
            } else {
// Save section onlys
                do_action('woocommerce_update_options_' . $current_tab . '_' . $current_section);
            }

// Clear any unwanted data
            delete_transient('woocommerce_cache_excluded_uris');
// Redirect back to the settings page
            $redirect = add_query_arg(array('saved' => 'true'));

            if (isset($_POST['subtab'])) {
                wp_safe_redirect(esc_url_raw($redirect));
                exit;
            }
        }
// Get any returned messages
        $error = ( empty($_GET['wc_error']) ) ? '' : urldecode(stripslashes($_GET['wc_error']));
        $message = ( empty($_GET['wc_message']) ) ? '' : urldecode(stripslashes($_GET['wc_message']));

        if ($error || $message) {

            if ($error) {
                echo '<div id="message" class="error fade"><p><strong>' . esc_html($error) . '</strong></p></div>';
            } else {
                echo '<div id="message" class="updated fade"><p><strong>' . esc_html($message) . '</strong></p></div>';
            }
        } elseif (!empty($_GET['saved'])) {

            echo '<div id="message" class="updated fade"><p><strong>' . __('Your settings have been saved.', 'sumodiscounts') . '</strong></p></div>';
        }
        ?>
        <div class="wrap woocommerce">
            <form method="post" id="mainform" action="" enctype="multipart/form-data">
                <div class="icon32 icon32-woocommerce-settings" id="icon-woocommerce"><br /></div><h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
                    <?php
                    $tabs = apply_filters('woocommerce_sp_settings_tabs_array', $tabs);

                    foreach ($tabs as $name => $label) {
                        //echo $current_tab;
                        echo '<a href="' . admin_url('admin.php?page=sumodiscounts&tab=' . $name) . '" class="nav-tab ';
                        if ($current_tab == $name)
                            echo 'nav-tab-active';
                        echo '">' . $label . '</a>';
                    }
                    do_action('woocommerce_sp_settings_tabs');
                    ?>
                </h2>

                <?php
                switch ($current_tab) :

                    default :
                        do_action('woocommerce_sp_settings_tabs_' . ($current_tab == 'sumodiscounts' ? 'sp_general_settings' : $current_tab));
                        break;
                endswitch;
                ?>

                <p class="submit">
                    <?php if (!isset($GLOBALS['hide_save_button'])) : ?>
                        <input name="save" class="button-primary" type="submit" value="<?php _e('Save Changes', 'sumodiscounts'); ?>" />
                    <?php endif; ?>
                    <input type="hidden" name="subtab" id="last_tab" />
                    <?php wp_nonce_field('woocommerce-settings', '_wpnonce', true, true); ?>
                </p>
            </form>
        </div>
        <?php
    }

    public static function sumo_include_tab_files() {

        include_once('tabs/generalsettings/class_general_settings.php');

        include_once('tabs/quantitypricing/class_quantity_pricing_tab.php');

        include_once('tabs/carttotalpricing/class_cart_pricing_tab.php');        

        include_once('tabs/specialofferpricing/class_specialofferpricing_tab.php');

        include_once('tabs/userrolepricing/class_userrolepricing_tab.php');
        
        include_once('tabs/categoryproductpricing/class_category_product_pricing_tab.php');

        if (class_exists('SUMOMemberships')) {

            if (sumo_get_membership_levels()) {
                include_once('tabs/membershippricing/class_membershippricing_tab.php');
            }
        }

        include_once('tabs/rewardpointpricing/class_rewardpointspricing_tab.php');

        include_once('tabs/messagesettings/class_message_tab.php');
        
        include_once('tabs/advancedsettings/class_advanced_tab.php');

        include_once('tabs/help/class_help_tab.php');
    }

}

new SUMOPricing_AdminMenu();
