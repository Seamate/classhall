<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//---------------------------------------------------------------------------------------------
//Register libraries using new wordpress register_script & enqueue_script functions
//---------------------------------------------------------------------------------------------
$pluginsurl = plugins_url( '', __FILE__ );

function wccp_pro_enqueue_scripts($wccp_pro_settings) {

	$pluginsurl = plugins_url( '', __FILE__ );
	
	$admincore = '';
	
	if (isset($_GET['page'])) $admincore = $_GET['page'];

	if( is_admin() && ($admincore == 'wccp-options-pro' || $admincore == 'wccp-options-pro_watermark_testing')) {
	
		wp_enqueue_script('jquery');
		
		$css_js_files_version_num = 1;
		
		if(!isset($wccp_pro_settings["css_js_files_version_num"]))
		{
			$css_js_files_version_num = 1;
		}else
		{
			$css_js_files_version_num = $wccp_pro_settings["css_js_files_version_num"];
		}
		
		wp_register_style('defaultcss', $pluginsurl.'/css/responsive-pure-css-tabs/default.css', array(), $css_js_files_version_num);
		wp_enqueue_style('defaultcss');
		
		wp_register_style('stylecss', $pluginsurl.'/css/responsive-pure-css-tabs/style.css', array(), $css_js_files_version_num);
		wp_enqueue_style('stylecss');
		
		wp_register_script('responsive_pure_css_tabsjs', $pluginsurl.'/css/responsive-pure-css-tabs/js.js', array(), $css_js_files_version_num);
		wp_enqueue_script('responsive_pure_css_tabsjs');
		
		if(is_rtl() == 'rtl')
			wp_register_style('bootstrapcss', $pluginsurl.'/bootstrap/css/bootstrap-rtl.min.css', array(), $css_js_files_version_num);
		else
			wp_register_style('bootstrapcss', $pluginsurl.'/bootstrap/css/bootstrap.min.css', array(), $css_js_files_version_num);
		
		wp_enqueue_style('bootstrapcss');
		
		wp_register_script('bootstrap-bundle-min-js', $pluginsurl.'/bootstrap/js/bootstrap.bundle.min.js', array(), $css_js_files_version_num);
		wp_enqueue_script('bootstrap-bundle-min-js');
		
		wp_enqueue_script( 'wccppro_slimselect', $pluginsurl.'/js/slimselect.min.js', array(), $css_js_files_version_num);
		
		wp_register_style('wccppro_slimselect_css', $pluginsurl.'/css/slimselect.min.css', array(), $css_js_files_version_num);
		
		wp_enqueue_style('wccppro_slimselect_css');
		
		
		
		wp_register_script('image-picker.js', $pluginsurl.'/image-picker/image-picker.js', array(), $css_js_files_version_num);
		
		wp_enqueue_script('image-picker.js');
		
		wp_register_style('image-picker.css', $pluginsurl.'/image-picker/image-picker.css', array(), $css_js_files_version_num);
		
		wp_enqueue_style('image-picker.css');
		
		wp_register_script('autocomplete-search-js', $pluginsurl.'/js/autocomplete.js',['jquery', 'jquery-ui-autocomplete'], null, true);
        wp_enqueue_script('autocomplete-search-js');
        wp_localize_script('autocomplete-search-js', 'AutocompleteSearch', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'ajax_nonce' => wp_create_nonce('autocompleteSearchNonce')
        ]);
        $wp_scripts = wp_scripts();
        wp_enqueue_style('jquery-ui-css','//ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-autocomplete']->ver . '/themes/smoothness/jquery-ui.css',false, null, false);
		
		//wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'my-script-handle', plugins_url('admin_script.js', __FILE__ ), array(), false, true );
		
		wp_enqueue_script('media-upload');
		add_thickbox(); //include both the thickbox script and its required CSS styles all at once.
		wp_enqueue_media();
	}
	else
	{
		wp_enqueue_script('jquery');
	}
}

function wccp_pro_enqueue_front_end_scripts($wccp_pro_settings)
{
	$pluginsurl = plugins_url( '', __FILE__ );
	
	$css_js_files_version_num = 1;
		
	if(!isset($wccp_pro_settings["css_js_files_version_num"]))
	{
		$css_js_files_version_num = 1;
	}else
	{
		$css_js_files_version_num = $wccp_pro_settings["css_js_files_version_num"];
	}

	wp_enqueue_script('jquery');

	if($wccp_pro_settings['prnt_scr_msg'] != '')
	{
		wp_register_style('print-protection.css', $pluginsurl.'/css/print-protection.css?css_js_files_version_num='.$css_js_files_version_num);
		wp_enqueue_style('print-protection.css');
	}
}

//------------------------------------------------------------------------
function wpcp_pro_write_to_file_with_markers( $filename, $marker, $insertion ) {
    if (!file_exists( $filename ) || is_writeable( $filename ) ) {
		
		//Clear the file contents
		if($marker == "CLEAR_FILE_CONTENTS")
		{
			file_put_contents( $filename, "" );
			
			return;
		}

		file_put_contents( $filename, "/* BEGIN {$marker} */\n", FILE_APPEND | LOCK_EX );
		if ( is_array( $insertion ))
			foreach ( $insertion as $insertline )
				file_put_contents( $filename, "{$insertline}\n", FILE_APPEND | LOCK_EX );
		file_put_contents( $filename, "/* END {$marker} */\n\n", FILE_APPEND | LOCK_EX );

        return true;
    } else {
        return false;
    }
}

//---------------------------------------------------------------------------------------------
//Add the plugin icon style to the top admin bar
//---------------------------------------------------------------------------------------------
function wccp_pro_get_current_page_name() {// Function to get the current page name
    // Get the script name from the server variables
    return isset($_SERVER['PHP_SELF']) ? basename($_SERVER['PHP_SELF']) : '';
}

function wccp_pro_top_bar_enqueue_style() {
	if (wccp_pro_get_current_page_name() === 'customize.php') return;//Stop if you are inside theme customizer
    ?>
    <style>
        .pro-wccp:before {
            content: "\f160";
            top: 3px;
        }
        .pro-wccp:before{
            color:#02CA03 !important
        }
        .pro-wccp {
            transform: rotate(45deg);
        }
    </style>
    <?php
}

function wccp_pro_ajax_enqueue_scripts(){
    wp_register_script(
        'wccp_pro_admin_bar_ajax',
        plugins_url('/js/admin_bar_ajax.js', __FILE__),
        array('jquery'),
        false,
        true
    );
    wp_enqueue_script( 'wccp_pro_admin_bar_ajax' );
    wp_localize_script(
        'wccp_pro_admin_bar_ajax',
        'ajax_object',
        array( 'ajaxurl' => admin_url( 'admin-ajax.php' ),'link' => wccp_pro_get_self_url()  )
    );
}
add_action('admin_enqueue_scripts', 'wccp_pro_ajax_enqueue_scripts');

function wccp_pro_ajax_top_bar($wccp_pro_settings)
{
    $obj = new wccp_pro_controls_class();
	
	$link_add = esc_url_raw($_POST['link']);
 
    if(empty($wccp_pro_settings['url_exclude_list'])){
        $wccp_pro_settings['url_exclude_list'] = $link_add;
    }else{
        $wccp_pro_settings['url_exclude_list'] = $wccp_pro_settings['url_exclude_list']."\n".$link_add;
    }
    $obj -> update_blog_option_single_and_multisite( 'wccp_pro_settings' , $wccp_pro_settings );
    wp_die(); // ajax call must die to avoid trailing 0 in your response
}

function wccp_pro_ajax_top_bar_remove_Protection($wccp_pro_settings)
{
    $obj = new wccp_pro_controls_class();
	$link_add = esc_url_raw($_POST['link']);
    $data = isset($wccp_pro_settings['url_exclude_list'])?$wccp_pro_settings['url_exclude_list']:'';
    $data = str_replace($link_add, "", $data);
    $data = preg_split("/\r\n|\n|\r/", $data);
    $data = array_filter($data, 'strlen');
    $val='';
    foreach ($data as $row){
        $val = $val."\n".$row;
    }
    $wccp_pro_settings['url_exclude_list'] = $val;
    $obj -> update_blog_option_single_and_multisite( 'wccp_pro_settings' , $wccp_pro_settings );
    wp_die(); // ajax call must die to avoid trailing 0 in your response
}
//---------------------------------------------------------------------------------------------
//Add the plugin icon to the top admin bar
//---------------------------------------------------------------------------------------------
function wpccp_add_items($wccp_pro_settings, $admin_bar)
{
    if (!current_user_can('manage_options')) return; // Permissions checker

    global $post;

    $wccpadminurl = get_admin_url();

    $args = array(
        'id'    => 'Protection',
        'title' => '<span class="ab-icon pro-wccp"></span>' . __('Protection'),
        'href'  => $wccpadminurl . 'admin.php?page=wccp-options-pro',
        'meta'  => array('title' => __('WP content copy protection PRO')),
    );

    $val       = isset($wccp_pro_settings['url_exclude_list']) ? $wccp_pro_settings['url_exclude_list'] : '';
    $thisLink  = wccp_pro_get_self_url();
    $pos       = strpos($val, $thisLink);
    $is_excluded = ($pos !== false);
    $cur_post_type = wccp_pro_get_current_post_type();

    // Submenu item depending on exclusion
    if (!$is_excluded) {
        $sub_args_include = array(
            'id'     => 'WPCCP_Protect',
            'parent' => 'Protection',
            'title'  => '<span onclick="wccp_pro_admin_bar_remove_Protection();" style="width: 100%;display: block">' . __('Exclude this page') . "</span>",
            'href'   => "#",
            'meta'   => array('title' => __('Click to exclude this page from protection')),
        );
    } else {
        $sub_args_include = array(
            'id'     => 'WPCCP_Protect',
            'parent' => 'Protection',
            'title'  => '<span onclick="wccp_pro_admin_bar_return_Protection();" style="width: 100%;display: block">' . __('Protect This page') . "</span>",
            'href'   => "#",
            'meta'   => array('title' => __('Click to return protection for this page')),
        );
    }

    // Helper function for Yes/No color
    $colorize = function ($value) {
        if ($value === 'checked' || $value === true || $value === 'Yes' || $value === 'Watermark') {
            return '<span style="color:green;font-weight:bold">Yes</span>';
        }
        return '<span style="color:red;font-weight:bold">No</span>';
    };

    // Collect blocked keys
    $keys_map = array(
        'ctrl_s_protection' => 'Ctrl+S',
        'ctrl_a_protection' => 'Ctrl+A',
        'ctrl_c_protection' => 'Ctrl+C',
        'ctrl_x_protection' => 'Ctrl+X',
        'ctrl_v_protection' => 'Ctrl+V',
        'ctrl_u_protection' => 'Ctrl+U',
        'f12_protection'    => 'F12',
    );

    $blocked_keys = array();
    foreach ($keys_map as $setting_key => $label) {
        if (isset($wccp_pro_settings[$setting_key]) && $wccp_pro_settings[$setting_key] === 'checked') {
            $blocked_keys[] = $label;
        }
    }

    $blocked_keys_text = !empty($blocked_keys)
        ? implode(', ', $blocked_keys)
        : '<span style="color:red;font-weight:bold">None</span>';
	
	// Special Checks depends on post type
    $text_protection      = in_array($cur_post_type, (array)($wccp_pro_settings['text_protection_by_type'] ?? []), true);
    $right_click_protection = in_array($cur_post_type, (array)($wccp_pro_settings['right_click_protection_by_type'] ?? []), true);

    // Add info menu + items
    $info_array_include = array(
        'id'     => 'information',
        'parent' => 'Protection',
        'title'  => '<span style="width: 100%;display: block">Protection Info</span>',
        'href'   => "",
        'meta'   => array('title' => __('Show info about this page protection settings')),
    );
    $info_items = array(
        array('id' => 'cur_post_type', 'title' => 'Current POST TYPE: ' . wccp_pro_get_current_post_type()),
        array('id' => 'cur_url', 'title' => 'Current URL: ' . esc_html($thisLink)),
        array('id' => 'is_excluded', 'title' => 'Is Excluded? ' . ($is_excluded ? '<span style="color:green;font-weight:bold">Yes</span>' : '<span style="color:red;font-weight:bold">No</span>')),
        array('id' => 'text_protection', 'title' => 'Text Protection: ' . $colorize($text_protection)),
        array('id' => 'right_click_protection', 'title' => 'Right Click: ' . $colorize($right_click_protection)),
        array('id' => 'blocked_keys', 'title' => 'Blocked CTRL + keys: ' . $blocked_keys_text),
        array('id' => 'plugin_version', 'title' => 'Plugin Version: ' . WCCP_PRO_PLUGIN_VERSION),
        array('id' => 'hotlinking_rule', 'title' => 'Hotlinking Watermark Rule: ' . $colorize($wccp_pro_settings['hotlinking_rule'] ?? '')),
        array('id' => 'mysite_rule', 'title' => 'MySite Watermark Rule: ' . $colorize($wccp_pro_settings['mysite_rule'] ?? '')),
        array('id' => 'opposite_mode', 'title' => 'Opposite Mode: ' . $colorize($wccp_pro_settings['opposite_mode'] ?? 'Inactive')),
    );

    if (current_user_can('manage_options')) {
        $admin_bar->add_menu($args);

        if (!is_admin()) {
            $admin_bar->add_menu($sub_args_include);
            $admin_bar->add_menu($info_array_include);

            foreach ($info_items as $item) {
                $admin_bar->add_menu(array(
                    'id'     => $item['id'],
                    'parent' => 'information',
                    'title'  => '<span style="width: 100%;display: block">' . $item['title'] . '</span>',
                    'href'   => "",
                    'meta'   => array('title' => __('')),
                ));
            }
        }
    }
}
//---------------------------------------------------------------------------------------------
//Show settings page
//---------------------------------------------------------------------------------------------
function show_alert_because_free_plugin_is_active()
{
	echo '<p align="center" dir="ltr">&nbsp;</p>
			<p align="center" dir="ltr">&nbsp;</p>
			<p align="center" dir="ltr">&nbsp;</p>
			<p align="center" dir="ltr"><font size="5" color="#FF0000">Alert!</font></p>
			<p align="center" dir="ltr"><font size="5">The free version of WP Content Copy 
			Protection is still active</font></p>
			<p align="center" dir="ltr"><font size="5">Please deactivate it to start using the pro version</font></p>';
}
function wccp_pro_options_page_pro()
{	
	if( is_plugin_active( 'wp-content-copy-protector/preventer-index.php' ) )
	{
		show_alert_because_free_plugin_is_active();
	}
	else
	{
		include 'admin_settings.php';
	}
}
function wccp_pro_options_page_pro_loop()
{	
	if( is_plugin_active( 'wp-content-copy-protector/preventer-index.php' ) )
	{
		show_alert_because_free_plugin_is_active();
	}
	else
	{
		include 'loop.php';
	}
}
function wccp_pro_watermark_testing()
{	
	if( is_plugin_active( 'wp-content-copy-protector/preventer-index.php' ) )
	{
		show_alert_because_free_plugin_is_active();
	}
	else
	{
		include 'watermark_testing.php';
	}
}

//---------------------------------------------------------------------------------------------
//Make our function to call the WordPress function to add to the correct menu
//---------------------------------------------------------------------------------------------
function wccp_pro_add_options() {

	if(!current_user_can('manage_options')) return; //Premissions checker
	
	//show menu in normal
	add_menu_page
		(
			'Copy Protection PRO',       // use null for parent slug to hide it from admin menu
			__('Protection PRO'),    // page title
			'manage_options',           // capability
			'wccp-options-pro', // current menu slug
			'wccp_pro_options_page_pro', // callback
			'dashicons-lock', //$icon_url or icon class
			6
		);
	add_submenu_page //Second sub-item
        (
                'wccp-options-pro',       // parent slug
                __('Watermark testing'),    // page title
                'Watermark testing',             // menu title
                'manage_options',           // capability
                'wccp-options-pro_watermark_testing', // current menu slug
                'wccp_pro_watermark_testing' // callback
        );
	/*
	add_submenu_page //First sub-item
	(
		'wccp-options-pro',       // parent slug
		__('Main Options'),    // page title
		'Main Options',             // menu title
		'manage_options',           // capability
		'wccp-options-pro', // current menu slug
		'wccp_pro_options_page_pro' // callback
	);
	add_submenu_page //Second sub-item
	(
		'wccp-options-pro',       // parent slug
		__('Watermarking'),    // page title
		'Watermarking',             // menu title
		'manage_options',           // capability
		'wccp-options-pro_watermark_process', // current menu slug
		'wccp_pro_options_page_pro_loop' // callback
	);
	*/
	//remove_submenu_page("wccp-options-pro" , "first_removable_slug");
}

//Show the message if settings for version 16.1 are not saved before
function show_message_for_major_updates()
{
	// Add custom content after a plugin's row in plugin settings page
	function custom_after_plugin_row_content( $plugin_file, $plugin_data, $status ) {
		// Check if the plugin matches the desired plugin
		if ( wccp_pro_plugin_folder_name().'/preventer-index.php' === $plugin_file ) {
			echo '<tr class="plugin-update-tr">
				<td colspan="3" class="plugin-update colspanchange">
					<div id="wccp-pro-update-message" class="notice inline notice-info notice-alt">
						<p>🚨 Important: Update (16.4 +) is major and you need to check & save your settings after it! 🚨 <a type="button"  href="admin.php?page=wccp-options-pro">Check the settings</a></p>
					</div>
				</td>
			</tr>';
		}
	}
	add_action( 'after_plugin_row_'.wccp_pro_plugin_folder_name().'/preventer-index.php', 'custom_after_plugin_row_content', 10, 3 );
}
?>