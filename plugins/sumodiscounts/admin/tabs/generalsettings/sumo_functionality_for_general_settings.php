<?php

class SUMOFunctionalityForGS {

    // Construct the Class
    public function __construct() {
        add_action('woocommerce_admin_field_drag_and_drop_rule_priority', array($this, 'set_drag_and_drop_rule_priority'));
        add_action('woocommerce_update_options_sp_general_settings', array($this, 'save_set_drag_and_drop_rule_priority'));
        add_action('wp_ajax_sumo_drag_and_arrange_tab', array($this, 'admin_request_from_ajax_sortable_for_general'));
        add_action('admin_head', array($this, 'show_r_hide_tag_fields'));
    }

    public static function set_drag_and_drop_rule_priority() {
        global $woocommerce_settings;
        ?>
        <script type="text/javascript">
            jQuery(function () {
                jQuery('table#sumo_drag_n_drop_site_wide_discounts').sortable({
                    axis: "y",
                    items: 'tbody',
                    update: function (event, ui) {

                        var data = jQuery(this).sortable("toArray");
                        // POST to server using $.post or $.ajax
                        console.log(data);
                        jQuery.ajax({
                            data: ({
                                action: 'sumo_drag_and_arrange_tab',
                                data: data,
                                type: 'sitewide'
                            }),
                            type: 'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            success: function (response) {
                                console.log(response);
                            },
                        });
                    }
                });
                jQuery('table#sumo_drag_n_drop_bulk_discounts').sortable({
                    axis: "y",
                    items: 'tbody',
                    update: function (event, ui) {

                        var data = jQuery(this).sortable("toArray");
                        // POST to server using $.post or $.ajax
                        console.log(data);
                        jQuery.ajax({
                            data: ({
                                action: 'sumo_drag_and_arrange_tab',
                                data: data,
                                type: 'bulk'
                            }),
                            type: 'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            success: function (response) {
                                console.log(response);
                            },
                        });
                    }
                });
            });</script>
        <style type="text/css">

            tbody.sumo_pricing_tab_drag_n_drop >tr {
                border: 1px solid #ccc;
            }


            .postbox h3 {
                font-size: 14px;
                line-height: 1.4;
                margin: 0;
                padding: 8px 12px;
            }
            .form-field label {
                display:table-row;
                font-weight:  bold;
                font-size:14px;

            }
        </style>


        <style type="text/css">
            tbody.sumo_pricing_tab_drag_n_drop {
                background:#fff;
                margin-bottom:10px;
                display: table-row-group;
                cursor:move;
            }
            table>tbody.sumo_pricing_tab_drag_n_drop:hover {
                background:#dedec6;
            }
        </style>

        <?php
        $tabs = '';
        $tabs = apply_filters('woocommerce_sp_settings_tabs_array', $tabs);
        $exclude_tabs = array('sp_general_settings', 'fp_sp_message_tab', 'sumo_quantity_pricing', 'sumo_offer_pricing', 'sumo_cart_pricing', 'fp_sp_advanced_tab', 'sumo_help');

        $priority_array = array_diff(array_keys($tabs), $exclude_tabs);
        $get_data_rule_priority_check_for_swd = (array) get_option('drag_and_drop_rule_priority_for_site_wide_discounts', true);
        $difference_array = array_diff($priority_array, array_values($get_data_rule_priority_check_for_swd));
        $newmergedvalue = array_merge($get_data_rule_priority_check_for_swd, $difference_array);
        $priority_array = is_array($difference_array) && !empty($difference_array) ? $newmergedvalue : $get_data_rule_priority_check_for_swd;
        $priority_array = array_diff($priority_array, $exclude_tabs);

        $exclude_tabs1 = array('sp_general_settings', 'fp_sp_message_tab', 'sumo_cart_pricing', 'sumo_membership_pricing', 'fp_sp_rpelpricing', 'sumo_cat_pro_pricing', 'fp_sp_userrole_pricing_settings', 'fp_sp_advanced_tab', 'sumo_help');
        $priority_array1 = array_diff(array_keys($tabs), $exclude_tabs1);
        $get_data_rule_priority_check_for_bd = (array) get_option('drag_and_drop_rule_priority_for_bulk_discounts', true);
        $difference_array1 = array_diff($priority_array1, array_values($get_data_rule_priority_check_for_bd));
        $newmergedvalue1 = array_merge($get_data_rule_priority_check_for_bd, $difference_array1);
        $priority_array1 = is_array($difference_array1) && !empty($difference_array1) ? $newmergedvalue1 : $get_data_rule_priority_check_for_bd;
        $priority_array1 = array_diff($priority_array1, $exclude_tabs1);
        ?>

        <table class="form-table" id="sumo_drag_n_drop_site_wide_discounts">
            <thead>
                <tr>
            <span><b><?php _e('Sitewide Discounts', 'sumodiscounts'); ?></b></span>
            <span style="float: right">
                <select id="sumo_site_wide_discounts" name="sumo_site_wide_discounts">
                    <option value="1" <?php selected(get_option('sumo_site_wide_discounts', true), '1') ?> ><?php _e('First Matched Rule', 'sumodiscounts'); ?></option>
                    <option value="2" <?php selected(get_option('sumo_site_wide_discounts', true), '2') ?> ><?php _e('Last Matched Rule', 'sumodiscounts'); ?></option>
                    <option value="3" <?php selected(get_option('sumo_site_wide_discounts', true), '3') ?> ><?php _e('Minimum Discount', 'sumodiscounts'); ?></option>
                    <option value="4" <?php selected(get_option('sumo_site_wide_discounts', true), '4') ?> ><?php _e('Maximum Discount', 'sumodiscounts'); ?></option>
                </select>
            </span>
        </tr>
        </thead>
        <?php
        foreach ($priority_array as $key) {
            if (isset($tabs[$key])) {
                ?>
                <tbody class="sumo_pricing_tab_drag_n_drop" id="<?php echo $key; ?>">
                    <tr class="table1 <?php echo $key; ?>">
                        <td style="width:800px;"><?php echo $tabs[$key]; ?></td>
                        <td><input type="checkbox" id="<?php echo $key; ?>" name="sumo_pricing_tab_sorting[<?php echo $key; ?>]" value="yes" <?php
                            $get_option = get_option('sumo_pricing_tab_sorting');
                            $get_key = isset($get_option[$key]) ? $get_option[$key] : "";
                            if ($get_key == 'yes') {
                                ?>checked<?php }
                            ?> > <?php _e('Enable', 'sumodiscounts'); ?></td>
                    </tr>
                </tbody>
                <?php
            }
        }
        ?>
        </table>
        <br>
        <br>
        <br>
        <table class="form-table" id="sumo_drag_n_drop_bulk_discounts">
            <thead>
                <tr>
            <span><b><?php _e('Bulk Discounts', 'sumodiscounts'); ?></b></span>
            <span style="float: right"><select id="sumo_bulk_discounts" name="sumo_bulk_discounts">
                    <option value="1" <?php selected(get_option('sumo_bulk_discounts', true), '1') ?> ><?php _e('First Matched Rule', 'sumodiscounts'); ?></option>
                    <option value="2" <?php selected(get_option('sumo_bulk_discounts', true), '2') ?> ><?php _e('Last Matched Rule', 'sumodiscounts'); ?></option>
                    <option value="3" <?php selected(get_option('sumo_bulk_discounts', true), '3') ?> ><?php _e('Minimum Discount', 'sumodiscounts'); ?></option>
                    <option value="4" <?php selected(get_option('sumo_bulk_discounts', true), '4') ?> ><?php _e('Maximum Discount', 'sumodiscounts'); ?></option>
                </select></span></tr>
        </thead>
        <?php
        foreach ($priority_array1 as $key) {
            if (isset($tabs[$key])) {
                ?>
                <tbody class="sumo_pricing_tab_drag_n_drop" id="<?php echo $key; ?>">
                    <tr class="table1 <?php echo $key; ?>">
                        <td style="width:800px;"><?php echo $tabs[$key]; ?></td>
                        <td><input type="checkbox" id="<?php echo $key; ?>" name="sumo_pricing_tab_sorting[<?php echo $key; ?>]" value="yes" <?php
                            $get_option = get_option('sumo_pricing_tab_sorting');
                            $get_key = isset($get_option[$key]) ? $get_option[$key] : "";
                            if ($get_key == 'yes') {
                                ?>checked<?php }
                            ?> > <?php _e('Enable', 'sumodiscounts'); ?></td>
                    </tr>
                </tbody>
                <?php
            }
        }
        ?>
        </table>
        <br>
        <br>
        <br>
        <table class="form-table" id="sumo_drag_n_drop_cart_discounts">
            <thead>
                <tr><span><b><?php _e('Cart Discounts', 'sumodiscounts'); ?></b></span>
        </tr>
        </thead>
        <?php
        ?>
        <tbody class="sumo_pricing_tab_drag_n_drop" id="sumo_cart_pricing">
            <tr class="table1 sumo_cart_pricing">
                <td style="width:800px;"><?php echo $tabs['sumo_cart_pricing']; ?></td>
                <td><input type="checkbox" id="sumo_cart_pricing" name="sumo_pricing_tab_sorting[sumo_cart_pricing]" value="yes" <?php
                           $get_option = get_option('sumo_pricing_tab_sorting');
                           $get_key = isset($get_option['sumo_cart_pricing']) ? $get_option['sumo_cart_pricing'] : "";
                           if ($get_key == 'yes') {
                               ?>checked<?php }
                           ?> > <?php _e('Enable', 'sumodiscounts'); ?></td>
            </tr>
        </tbody>
        <?php
        ?>
        </table>
        <?php
    }

    public static function admin_request_from_ajax_sortable_for_general() {
        if (isset($_POST)) {
            if ($_POST['type'] == 'sitewide') {
                update_option('drag_and_drop_rule_priority_for_site_wide_discounts', $_POST['data']);
            } elseif ($_POST['type'] == 'bulk') {
                update_option('drag_and_drop_rule_priority_for_bulk_discounts', $_POST['data']);
            }
        }
        exit();
    }

    public static function save_set_drag_and_drop_rule_priority() {
        if (isset($_POST)) {
            update_option('sumo_site_wide_discounts', $_POST['sumo_site_wide_discounts']);
            update_option('sumo_bulk_discounts', $_POST['sumo_bulk_discounts']);
            update_option('sumo_pricing_tab_sorting', isset($_POST['sumo_pricing_tab_sorting']) ? $_POST['sumo_pricing_tab_sorting'] : array());
        }
    }

    public static function show_r_hide_tag_fields() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                if (jQuery('#sumo_price_display_method_with_discounts').val() == '2') {
                    jQuery('#sumo_enable_discount_tag').closest('tr').show();
                    if (jQuery('#sumo_enable_discount_tag').is(':checked')) {
                        jQuery('#sumo_enable_discount_for_variable_product').closest('tr').show();
                        jQuery('#sumo_discount_tag_lable').closest('tr').show();
                    } else {
                        jQuery('#sumo_enable_discount_for_variable_product').closest('tr').hide();
                        jQuery('#sumo_discount_tag_lable').closest('tr').hide();
                    }

                    jQuery('#sumo_enable_discount_tag').change(function () {
                        if (jQuery('#sumo_enable_discount_tag').is(':checked')) {
                            jQuery('#sumo_enable_discount_for_variable_product').closest('tr').show();
                            jQuery('#sumo_discount_tag_lable').closest('tr').show();
                        } else {
                            jQuery('#sumo_enable_discount_for_variable_product').closest('tr').hide();
                            jQuery('#sumo_discount_tag_lable').closest('tr').hide();
                        }
                    });
                } else {
                    jQuery('#sumo_enable_discount_tag').closest('tr').hide();
                    jQuery('#sumo_discount_tag_lable').closest('tr').hide();
                    jQuery('#sumo_enable_discount_for_variable_product').closest('tr').hide();
                }
                jQuery('#sumo_price_display_method_with_discounts').change(function () {
                    if (jQuery(this).val() == '2') {
                        jQuery('#sumo_enable_discount_tag').closest('tr').show();
                        if (jQuery('#sumo_enable_discount_tag').is(':checked')) {
                            jQuery('#sumo_enable_discount_for_variable_product').closest('tr').show();
                            jQuery('#sumo_discount_tag_lable').closest('tr').show();
                        } else {
                            jQuery('#sumo_enable_discount_for_variable_product').closest('tr').hide();
                            jQuery('#sumo_discount_tag_lable').closest('tr').hide();
                        }

                        jQuery('#sumo_enable_discount_tag').change(function () {
                            if (jQuery('#sumo_enable_discount_tag').is(':checked')) {
                                jQuery('#sumo_enable_discount_for_variable_product').closest('tr').show();
                                jQuery('#sumo_discount_tag_lable').closest('tr').show();
                            } else {
                                jQuery('#sumo_enable_discount_for_variable_product').closest('tr').hide();
                                jQuery('#sumo_discount_tag_lable').closest('tr').hide();
                            }
                        });
                    } else {
                        jQuery('#sumo_enable_discount_tag').closest('tr').hide();
                        jQuery('#sumo_discount_tag_lable').closest('tr').hide();
                        jQuery('#sumo_enable_discount_for_variable_product').closest('tr').hide();
                    }
                });
            });
        </script>
        <?php
    }

}

new SUMOFunctionalityForGS();
