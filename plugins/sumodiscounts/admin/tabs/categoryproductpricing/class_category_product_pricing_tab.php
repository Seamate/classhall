<?php

// Initialize Discounts Rule Tab

class SUMOCategoryProductPricing {

    // Construct the Class Name

    public function __construct() {

        add_action('admin_init', array($this, 'sumo_pricing_default_settings'), 103); // call the init function to update the default settings on page load
        // make it appear in Discount System Discounts Rule
        add_action('woocommerce_sp_settings_tabs_array', array($this, 'initialize_tab'));

        // Initialize Admin Fields in Discounts Rule
        add_action('woocommerce_sp_settings_tabs_sumo_cat_pro_pricing', array($this, 'initialize_visual_appearance_admin_fields'));

        // Initialize Update Fields in Discounts Rule
        add_action('woocommerce_update_options_sumo_cat_pro_pricing', array($this, 'update_data_from_admin_fields'));


        // Admin Enqueue Scripts for the Discounts Rule
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));

        // Add Custom Type of Field Option
        add_action('woocommerce_admin_field_sumo_cat_pro_pricing_rule', array($this, 'sumo_cat_pro_pricing_rule'));

        add_action('wp_ajax_sumo_pricing_rule_sortable_for_cat_pro', array($this, 'admin_request_from_ajax_sortable'));

        add_action('wp_ajax_sumo_pricing_uniqid_for_cat_pro', array($this, 'ajax_function_response_alteration_html'));

        add_action('woocommerce_update_options_sumo_cat_pro_pricing', array($this, 'save_data_pricing_rule'));
    }

    // Declare the Discounts Rule Tab in Discount System

    public static function initialize_tab($settings_tab) {
        if(!is_array($settings_tab)){
            $settings_tab = (array)$settings_tab;
        }
        $settings_tab['sumo_cat_pro_pricing'] = __('Category/Product Discounts', 'sumodiscounts');
        return array_filter($settings_tab);
    }

    // Initialize Admin Fields in Discount System

    public static function initialize_admin_fields() {
        global $woocommerce;
        return apply_filters('woocommerce_cat_pro_pricing_rule', array(
            array(
                'name' => __('Category/Product Discounts', 'sumodiscounts'),
                'type' => 'title',
                'id' => '_sp_pricing_rule_settings'
            ),
            array(
                'name' => __('Rule Priority', 'sumodiscounts'),
                'type' => 'select',
                'id' => 'sumo_cat_pro_pricing_priority_settings',
                'newids' => 'sumo_cat_pro_pricing_priority_settings',
                'class' => 'sumo_cat_pro_pricing_priority_settings',
                'options' => array(
                    '1' => __('First Matched Rule','sumodiscounts'),
                    '2' => __('Last Matched Rule','sumodiscounts'),
                    '3' => __('Minimum Discount','sumodiscounts'),
                    '4' => __('Maximum Discount','sumodiscounts')
                ),
            ),
            array(
                'type' => 'sectionend',
                'id' => '_sp_pricing_rule_settings'
            ),
            array(
                'type' => 'sumo_cat_pro_pricing_rule'
            ),
        ));
    }

    // Make it appear visually in Discount System

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields(self::initialize_admin_fields());
    }

    // Update the Settings of Discount System

    public static function update_data_from_admin_fields($post) {
        woocommerce_update_options(self::initialize_admin_fields());
    }

    /**
     * Initialize the Default Settings by looping this function
     */
    public static function sumo_pricing_default_settings() {
        global $woocommerce;
        foreach (self::initialize_admin_fields() as $setting)
            if (isset($setting['newids']) && isset($setting['std'])) {
                add_option($setting['newids'], $setting['std']);
            }
    }

    // Enqueue Script

    public static function admin_enqueue_scripts() {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-datepicker');
    }

    // Declare the Options

    public static function sumo_cat_pro_pricing_rule() {
        $actionforsorting = 'sumo_pricing_rule_sortable_for_cat_pro';
        $actionforaddrule = 'sumo_pricing_uniqid_for_cat_pro';
        $classforaddlocalrule = 'add_new_row_for_cat_pro';
        $get_saved_data = get_option('sumo_pricing_rule_fields_for_cat_pro');
        $pricingtype = 'cat_pro_pricing';
        $array = array(
            'actionforsorting' => $actionforsorting,
            'actionforaddrule' => $actionforaddrule,
            'classforaddlocalrule' => $classforaddlocalrule,
            'get_saved_data' => $get_saved_data,
            'pricing_type' => $pricingtype,
            'nameforinputfield' => 'sumo_pricing_rule_fields_for_cat_pro'
        );
        sumo_common_function_to_add_settings_for_rule($array);
    }

    public static function admin_request_from_ajax_sortable() {
        update_option('sumo_dynamic_pricing_drag_position_for_cat_pro', $_POST['data']);
    }

    // Save the Fields

    public static function save_data_pricing_rule($value) {
        $sumo_pricing_rule_fields_for_cat_pro = isset($_POST['sumo_pricing_rule_fields_for_cat_pro']) ? $_POST['sumo_pricing_rule_fields_for_cat_pro'] : array();
        update_option('sumo_pricing_rule_fields_for_cat_pro', $sumo_pricing_rule_fields_for_cat_pro);
    }

    // Sort Div with Sortable Manner
    public static function ajax_function_response_alteration_html() {
        if (isset($_POST)) {
            $phpuniqid = uniqid();
            $uniqid = $_POST['uniq_id'];
            $new_array = array(
                'unique_id' => $uniqid,
                'phpunique_id' => $phpuniqid,
                'nameforfields' => 'sumo_cat_pro_rule',
                'rule_type' => 'cat_pro_pricing',
                'nameforinputfield' => 'sumo_pricing_rule_fields_for_cat_pro'
            );
            echo array_to_field_conversion($new_array);
        }
        exit();
    }

    public static function show_or_hide($key) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                if (jQuery('.sumo_pricing_apply_for_user_type<?php echo $key; ?>').val() == '1') {
                    jQuery('#sumo_pricing_apply_to_user<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                    jQuery('.sumo_user_purchase_history<?php echo $key; ?>').closest('p').show();
                    if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                    } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '1') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').show();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                    } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '2') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').show();
                    }
                } else if (jQuery('.sumo_pricing_apply_for_user_type<?php echo $key; ?>').val() == '2') {
                    jQuery('.sumo_user_purchase_history<?php echo $key; ?>').closest('p').show();
                    if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                    } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '1') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').show();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                    } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '2') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').show();
                    }
                    jQuery('#sumo_pricing_apply_to_user<?php echo $key; ?>').parent().show();
                    if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '1') {
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '2') {
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '3') {
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '4') {
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '5') {
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '6') {
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '7') {
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').show();
                    }

                    jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').change(function () {
                        if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '1') {
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '2') {
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '3') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '4') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '5') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '6') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '7') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').show();
                        }
                    });

                } else if (jQuery('.sumo_pricing_apply_for_user_type<?php echo $key; ?>').val() == '3') {
                    jQuery('#sumo_pricing_apply_to_user<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                    jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                    jQuery('.sumo_user_purchase_history<?php echo $key; ?>').closest('p').hide();
                    jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                    jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                }

                jQuery('.sumo_pricing_apply_for_user_type<?php echo $key; ?>').change(function () {

                    if (jQuery('.sumo_pricing_apply_for_user_type<?php echo $key; ?>').val() == '1') {
                        jQuery('#sumo_pricing_apply_to_user<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('.sumo_user_purchase_history<?php echo $key; ?>').closest('p').show();
                        if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '') {
                            jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                            jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                        } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '1') {
                            jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').show();
                            jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                        } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '2') {
                            jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                            jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').show();
                        }
                    } else if (jQuery('.sumo_pricing_apply_for_user_type<?php echo $key; ?>').val() == '2') {
                        jQuery('.sumo_user_purchase_history<?php echo $key; ?>').closest('p').show();
                        if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '') {
                            jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                            jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                        } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '1') {
                            jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').show();
                            jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                        } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '2') {
                            jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                            jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').show();
                        }
                        jQuery('#sumo_pricing_apply_to_user<?php echo $key; ?>').parent().show();
                        if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '1') {
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '2') {
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '3') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '4') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '5') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '6') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().show();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '7') {
                            jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                            jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').show();
                        }

                        jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').change(function () {
                            if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '1') {
                                jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                            } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '2') {
                                jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().show();
                                jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                            } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '3') {
                                jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().show();
                                jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                            } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '4') {
                                jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                            } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '5') {
                                jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().show();
                                jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                            } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '6') {
                                jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().show();
                                jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                            } else if (jQuery('.sumo_pricing_apply_to_user<?php echo $key; ?>').val() == '7') {
                                jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                                jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').show();
                            }
                        });
                    } else if (jQuery('.sumo_pricing_apply_for_user_type<?php echo $key; ?>').val() == '3') {
                        jQuery('#sumo_pricing_apply_to_user<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_memberplans<?php echo $key; ?>').closest('p').hide();
                        jQuery('#sumo_pricing_apply_to_exclude_users_role<?php echo $key; ?>').parent().hide();
                        jQuery('.sumo_user_purchase_history<?php echo $key; ?>').closest('p').hide();
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                    }
                });

                if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '') {
                    jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                    jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '1') {
                    jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').show();
                    jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                } else if (jQuery('.sumo_user_purchase_history<?php echo $key; ?>').val() == '2') {
                    jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                    jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').show();
                }
                jQuery('.sumo_user_purchase_history<?php echo $key; ?>').change(function () {
                    if (jQuery(this).val() == '') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                    } else if (jQuery(this).val() == '1') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').show();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').hide();
                    } else if (jQuery(this).val() == '2') {
                        jQuery(".sumo_no_of_orders_placed<?php echo $key; ?>").closest('p').hide();
                        jQuery(".sumo_total_amount_spent_in_site<?php echo $key; ?>").closest('p').show();
                    }
                });

                if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '1') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '2') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().show();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '3') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().show();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '4') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '5') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().show();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '6') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().show();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '7') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '8') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().show();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                } else if (jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').val() == '9') {
                    jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                    jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().show();
                }

                jQuery('.sumo_pricing_apply_to_products<?php echo $key; ?>').change(function () {
                    if (jQuery(this).val() == '1') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '2') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '3') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '4') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '5') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '6') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '7') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '8') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().show();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().hide();
                    } else if (jQuery(this).val() == '9') {
                        jQuery('#sumo_pricing_apply_to_include_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_products<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_category<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_include_tag<?php echo $key; ?>').parent().hide();
                        jQuery('#sumo_pricing_apply_to_exclude_tag<?php echo $key; ?>').parent().show();
                    }
                });
                jQuery('.sumo_number_input').keyup(function (event) {
                    var res = this.value.charAt(0);
                    if (res !== '*') {
                        this.value = this.value.replace(/[^0-9\.]/g, '');
        <?php
        if (isset($_GET['tab'])) {
            if ($_GET['tab'] == 'sumo_cat_pro_pricing') {
                ?>
                                if (this.value < 0.01) {
                                    this.value = '';
                                }
                <?php
            }
        }
        ?>
                    } else {
                        this.value = this.value.replace(/[^*\.]/g, '');
                    }
                });

            });
        </script>
        <?php
    }

}

new SUMOCategoryProductPricing();
