<?php

class SUMOMembershipPricing {

    public function __construct() {

        add_action('init', array($this, 'sumo_pricing_default_settings'), 103); // call the init function to update the default settings on page load
        // make it appear in SUMO Discounts Discounts Rule
        add_action('woocommerce_sp_settings_tabs_array', array($this, 'initialize_tab'));

        // Initialize Admin Fields in Discounts Rule
        add_action('woocommerce_sp_settings_tabs_sumo_membership_pricing', array($this, 'initialize_visual_appearance_admin_fields'));

        // Initialize Update Fields in Discounts Rule
        add_action('woocommerce_update_options_sumo_membership_pricing', array($this, 'update_data_from_admin_fields'));

        add_action('woocommerce_admin_field_sumopricing_saved_plans', array($this, 'add_field_for_membership'));

        add_action('woocommerce_admin_field_sp_incproducts_at_membership', array($this, 'function_sp_incproducts_at_membership'));

        add_action('woocommerce_admin_field_sp_excproducts_at_membership', array($this, 'function_sp_excproducts_at_membership'));

        add_action('admin_head', array($this, 'show_hide_field'));

        add_action('admin_head', array($this, 'sumo_display_notice'));
    }

    // Declare the Discounts Rule Tab in SUMO Discounts
    public static function initialize_tab($settings_tab) {
        if (!is_array($settings_tab)) {
            $settings_tab = (array) $settings_tab;
        }
        $settings_tab['sumo_membership_pricing'] = __('SUMO Memberships Discounts', 'sumodiscounts');
        return array_filter($settings_tab);
    }

    // Make it appear visually in SUMO Discounts

    public static function initialize_visual_appearance_admin_fields() {
        woocommerce_admin_fields(self::initialize_admin_fields());
    }

    // Update the Settings of SUMO Discounts

    public static function update_data_from_admin_fields($post) {
        woocommerce_update_options(self::initialize_admin_fields());
        $sumo_pricing_rule_discount_type = $_POST['sumo_pricing_rule_discount_type'] ? $_POST['sumo_pricing_rule_discount_type'] : array();
        $sumo_pricing_rule_discount_value = $_POST['sumo_pricing_rule_discount_value'] ? $_POST['sumo_pricing_rule_discount_value'] : array();
        $sp_incproducts_at_membership = $_POST['sp_incproducts_at_membership'] ? $_POST['sp_incproducts_at_membership'] : array();
        $sp_excproducts_at_membership = $_POST['sp_excproducts_at_membership'] ? $_POST['sp_excproducts_at_membership'] : array();

        update_option('sumopricing_rule_discounttype_for_sm', $sumo_pricing_rule_discount_type);
        update_option('sumopricing_rule_discountvalue_for_sm', $sumo_pricing_rule_discount_value);
        update_option('sp_incproducts_at_membership', $sp_incproducts_at_membership);
        update_option('sp_excproducts_at_membership', $sp_excproducts_at_membership);
    }

    /*
     * Initialize the Default Settings by looping this function
     */

    public static function sumo_pricing_default_settings() {
        global $woocommerce;
        foreach (self::initialize_admin_fields() as $setting)
            if (isset($setting['newids']) && isset($setting['std'])) {
                add_option($setting['newids'], $setting['std']);
            }
    }

    // Initialize Admin Fields in SUMO Discounts
    public static function initialize_admin_fields() {
        $product_categories = array();
        $all_categories = get_categories(array('hide_empty' => 0, 'taxonomy' => 'product_cat'));
        foreach ($all_categories as $each_category) {
            $product_categories[$each_category->term_id] = $each_category->name;
        }
        $product_tags = array();
        $all_tags = get_categories(array('hide_empty' => 0, 'taxonomy' => 'product_tag'));
        foreach ($all_tags as $each_tag) {
            $product_tags[$each_tag->term_id] = $each_tag->name;
        }
        return apply_filters('woocommerce_membership_pricing_rule', array(
            array(
                'name' => __('SUMO Memberships Discounts (Requires SUMO Memberships Plugin)', 'sumodiscounts'),
                'type' => 'title',
                'id' => '_sp_membershippricing_rule_settings'
            ),
            array(
                'name' => __('Apply Membership Discount for Product with Sale Price', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sumo_enable_membership_when_product_has_sale_price',
                'newids' => 'sumo_enable_membership_when_product_has_sale_price',
                'std' => 'yes',
                'default' => 'yes',
                'desc_tip' => true,
                'desc' => __('If enabled, Membership Discounts will be applicable for products with sale price', 'sumodiscounts'),
            ),
            array(
                'name' => __('Rule Valid from', 'sumodiscounts'),
                'type' => 'text',
                'class' => 'sp_date',
                'id' => 'sumo_membership_from_date',
                'newids' => 'sumo_membership_from_date',
                'std' => '',
                'default' => '',
                'desc_tip' => true,
                'desc' => __('The Date from which the Discounts are valid', 'sumodiscounts'),
            ),
            array(
                'name' => __('Rule Valid Till', 'sumodiscounts'),
                'type' => 'text',
                'class' => 'sp_date',
                'id' => 'sumo_membership_to_date',
                'newids' => 'sumo_membership_to_date',
                'std' => '',
                'default' => '',
                'desc_tip' => true,
                'desc' => __('The Date till which the Discounts are valid', 'sumodiscounts'),
            ),
            array(
                'type' => 'sectionend',
                'id' => '_sp_membershippricing_rule_settings'
            ),
            array(
                'name' => __('Rule is valid on the following days', 'sumodiscounts'),
                'type' => 'title',
                'id' => '_sp_membership_allowed_weekdays',
                'desc' => __('If you want to provide discounts only on certain days of a Week then select only those days.', 'sumodiscounts'),
            ),
            array(
                'name' => __('Monday', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sp_restrict_pricing_on_monday_at_membership',
                'std' => 'yes',
                'default' => 'yes',
                'newids' => 'sp_restrict_pricing_on_monday_at_membership',
            ),
            array(
                'name' => __('Tuesday', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sp_restrict_pricing_on_tuesday_at_membership',
                'std' => 'yes',
                'default' => 'yes',
                'newids' => 'sp_restrict_pricing_on_tuesday_at_membership',
            ),
            array(
                'name' => __('Wednesday', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sp_restrict_pricing_on_wednesday_at_membership',
                'std' => 'yes',
                'default' => 'yes',
                'newids' => 'sp_restrict_pricing_on_wednesday_at_membership',
            ),
            array(
                'name' => __('Thursday', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sp_restrict_pricing_on_thursday_at_membership',
                'std' => 'yes',
                'default' => 'yes',
                'newids' => 'sp_restrict_pricing_on_thursday_at_membership',
            ),
            array(
                'name' => __('Friday', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sp_restrict_pricing_on_friday_at_membership',
                'std' => 'yes',
                'default' => 'yes',
                'newids' => 'sp_restrict_pricing_on_friday_at_membership',
            ),
            array(
                'name' => __('Saturday', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sp_restrict_pricing_on_saturday_at_membership',
                'std' => 'yes',
                'default' => 'yes',
                'newids' => 'sp_restrict_pricing_on_saturday_at_membership',
            ),
            array(
                'name' => __('Sunday', 'sumodiscounts'),
                'type' => 'checkbox',
                'id' => 'sp_restrict_pricing_on_sunday_at_membership',
                'std' => 'yes',
                'default' => 'yes',
                'newids' => 'sp_restrict_pricing_on_sunday_at_membership',
            ),
            array(
                'type' => 'sectionend',
                'id' => '_sp_user_role_pricing_allowed_weekdays'
            ),
            array(
                'name' => __('Applicable Discounts for', 'sumodiscounts'),
                'type' => 'title',
                'id' => '_sp_membership_product_category_filter'
            ),
            array(
                'name' => __('Select Products', 'sumodiscounts'),
                'type' => 'select',
                'tip' => '',
                'id' => 'sp_membership_pricing_for_products',
                'options' => array(
                    '1' => __("All Products", "sumodiscounts"),
                    '2' => __("Include Products", "sumodiscounts"),
                    '3' => __("Exclude Products", "sumodiscounts"),
                    '4' => __("All Categories", "sumodiscounts"),
                    '5' => __("Include Categories", "sumodiscounts"),
                    '6' => __("Exclude Categories", "sumodiscounts"),
                    '7' => __("All Tags", "sumodiscounts"),
                    '8' => __("Include Tags", "sumodiscounts"),
                    '9' => __("Exclude Tags", "sumodiscounts"),
                ),
                'std' => '1',
                'default' => '1',
                'newids' => 'sp_membership_pricing_for_products',
                'desc_tip' => true,
                'desc' => __('By Default, discounts will be provided for All Products.If you want to restrict the discounts only to specific products/categories then, that can be done using the options provided', 'sumodiscounts')
            ),
            array(
                'type' => 'sp_incproducts_at_membership'
            ),
            array(
                'type' => 'sp_excproducts_at_membership'
            ),
            array(
                'name' => __('Include Categories', 'sumodiscounts'),
                'type' => 'multiselect',
                'tip' => '',
                'id' => 'sp_inccategories_at_membership',
                'options' => $product_categories,
                'std' => '',
                'default' => '',
                'newids' => 'sp_inccategories_at_membership',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Exclude Categories', 'sumodiscounts'),
                'type' => 'multiselect',
                'tip' => '',
                'id' => 'sp_exccategories_at_membership',
                'options' => $product_categories,
                'std' => '',
                'default' => '',
                'newids' => 'sp_exccategories_at_membership',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Include Tags', 'sumodiscounts'),
                'type' => 'multiselect',
                'tip' => '',
                'id' => 'sp_inctags_at_membership',
                'options' => $product_tags,
                'std' => '',
                'default' => '',
                'newids' => 'sp_inctags_at_membership',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Exclude Tags', 'sumodiscounts'),
                'type' => 'multiselect',
                'tip' => '',
                'id' => 'sp_exctags_at_membership',
                'options' => $product_tags,
                'std' => '',
                'default' => '',
                'newids' => 'sp_exctags_at_membership',
                'desc_tip' => true,
            ),
            array(
                'name' => __('Rule Priority', 'sumodiscounts'),
                'type' => 'select',
                'tip' => '',
                'id' => 'sp_rule_priority_for_membership_level',
                'options' => array(
                    '1' => __("First Matched Rule", "sumodiscounts"),
                    '2' => __("Last Matched Rule", "sumodiscounts"),
                    '3' => __("Minimum Discount", "sumodiscounts"),
                    '4' => __("Maximum Discount", "sumodiscounts")
                ),
                'std' => '1',
                'default' => '1',
                'newids' => 'sp_rule_priority_for_membership_level',
                'desc_tip' => true,
                'desc' => __('When user has purchased multiple Membership plans and discount has been configured for all membership plan, in this case based on the rule priority discount will be applied', 'sumodiscounts'),
            ),
            array(
                'type' => 'sumopricing_saved_plans'
            ),
            array(
                'type' => 'sectionend',
                'id' => '_sp_membership_product_category_filter'
            ),
        ));
    }

    public static function add_field_for_membership() {
        $membership_level = sumo_get_membership_levels();
        $selectedtype = get_option('sumopricing_rule_discounttype_for_sm');
        $selectedvalue = get_option('sumopricing_rule_discountvalue_for_sm');
        foreach ($membership_level as $key => $value) {
            $optiontype = isset($selectedtype[$key]) ? $selectedtype[$key] : '';
            $optionvalue = isset($selectedvalue[$key]) ? $selectedvalue[$key] : '';
            ?>
            <tr style="background:white;">
                <td>
                    <b><?php _e($value, 'sumodiscounts'); ?></b>                
                </td>            
                <td>
                    <b><?php _e('Discount Type :', 'sumodiscounts'); ?></b>            
                    <select name="sumo_pricing_rule_discount_type[<?php echo $key; ?>]" id="sumo_pricing_rule_discount_type_<?php echo $key; ?>" class="sumo_pricing_rule_discount_type_<?php echo $key; ?>">
                        <option value="" <?php echo selected("", $optiontype); ?>><?php _e('None', 'sumodiscounts'); ?></option>
                        <option value="1" <?php echo selected("1", $optiontype); ?>><?php _e('% Discount', 'sumodiscounts'); ?></option>
                        <option value="2" <?php echo selected("2", $optiontype); ?>><?php _e('Fixed Discount', 'sumodiscounts'); ?></option>
                        <option value="3" <?php echo selected("3", $optiontype); ?>><?php _e('Fixed Price', 'sumodiscounts'); ?></option>                        
                    </select>
                </td>
                <td>
                    <b><?php _e('Value :', 'sumodiscounts'); ?></b>            
                    <input type="number" step="any" min="0.01" id="sumo_pricing_rule_discount_value_<?php echo $key; ?>" name="sumo_pricing_rule_discount_value[<?php echo $key; ?>]" class="sumo_pricing_rule_discount_value_<?php echo $key; ?>" value="<?php echo $optionvalue; ?>"/>
                </td>
            </tr>
            <?php
        }
    }

    public static function function_sp_incproducts_at_membership() {
        $name = 'sp_incproducts_at_membership';
        $id = 'sp_incproducts_at_membership';
        $classname = 'sp_incproducts_at_membership';
        $label = __('Include Products', 'sumodiscounts');
        $get_data = get_option('sp_incproducts_at_membership');
        sumo_function_to_select_product_for_tab($id, $label, $classname, $name, $get_data);
    }

    public static function function_sp_excproducts_at_membership() {
        $name = 'sp_excproducts_at_membership';
        $id = 'sp_excproducts_at_membership';
        $classname = 'sp_excproducts_at_membership';
        $label = __('Exclude Products', 'sumodiscounts');
        $get_data = get_option('sp_excproducts_at_membership');
        sumo_function_to_select_product_for_tab($id, $label, $classname, $name, $get_data);
    }

    public static function show_hide_field() {
        global $woocommerce;
        
        if(isset($_GET['page']) && isset($_GET['tab'])&&'sumodiscounts'===$_GET['page'] && 'sumo_membership_pricing' === $_GET['tab']){
            ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
        <?php if ((float) $woocommerce->version <= (float) ('2.2.0')) { ?>
                    jQuery('#sp_inccategories_at_membership').chosen();
                    jQuery('#sp_exccategories_at_membership').chosen();
                    jQuery('#sp_inctags_at_membership').chosen();
                    jQuery('#sp_exctags_at_membership').chosen();
        <?php } else { ?>
                    jQuery('#sp_inccategories_at_membership').select2();
                    jQuery('#sp_exccategories_at_membership').select2();
                    jQuery('#sp_inctags_at_membership').select2();
                    jQuery('#sp_exctags_at_membership').select2();
        <?php } ?>
                if (jQuery('#sp_membership_pricing_for_products').val() == '1') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '2') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').show();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '3') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').show();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '4') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '5') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').show();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '6') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').show();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '7') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '8') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').show();
                    jQuery('#sp_exctags_at_membership').closest('tr').hide();
                } else if (jQuery('#sp_membership_pricing_for_products').val() == '9') {
                    jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                    jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                    jQuery('#sp_inctags_at_membership').closest('tr').hide();
                    jQuery('#sp_exctags_at_membership').closest('tr').show();
                }
                jQuery('#sp_membership_pricing_for_products').change(function () {
                    if (jQuery(this).val() == '1') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '2') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').show();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '3') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').show();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '4') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '5') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').show();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '6') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').show();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '7') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '8') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').show();
                        jQuery('#sp_exctags_at_membership').closest('tr').hide();
                    } else if (jQuery(this).val() == '9') {
                        jQuery('#sp_incproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_excproducts_at_membership').closest('tr').hide();
                        jQuery('#sp_inccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_exccategories_at_membership').closest('tr').hide();
                        jQuery('#sp_inctags_at_membership').closest('tr').hide();
                        jQuery('#sp_exctags_at_membership').closest('tr').show();
                    }
                });

            });
        </script>
        <?php
        }
    }

    public static function sumo_display_notice() {
        if (isset($_GET['tab'])) {
            if ($_GET['tab'] == 'sumo_membership_pricing') {
                ?>
                <div class="updated woocommerce-message wc-connect">
                    <p><b><?php echo '<b>'.__('"SUMO Membership Discounts is currently deprecated and Will be Removed from Future Versions"', 'sumodiscounts').'</b>'; ?></b></p>
                </div>
                <br>
                <div class="updated woocommerce-message wc-connect">
                    <p><?php echo '<b>'.__('Notice : ','sumodiscounts').'</b>'.__(' SUMO Membership Discounts can be configured for all the discount methods', 'sumodiscounts'); ?></p>
                </div>
                <?php
            }
        }
    }

}

new SUMOMembershipPricing();
