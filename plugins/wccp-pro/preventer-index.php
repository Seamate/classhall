<?php ob_start();
/*
Plugin Name: WP Content Copy Protection & No Right Click (premium)
Plugin URI: https://www.wp-buy.com/product/wp-content-copy-protection-pro/
License: Commercial software
License Description: https://en.wikipedia.org/wiki/Commercial_software
Description: This wp plugin protect the posts content from being copied by any other web site author , you dont want your content to spread without your permission!!
Version: 17.4
Author: wp-buy
Text Domain: wccp_pro_translation_slug
Domain Path: /languages
Author URI: https://www.wp-buy.com/
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WCCP_PRO_PLUGIN_VERSION', 17.4 );
//---------------------------------------------------------------------------------------------
//The updater
//---------------------------------------------------------------------------------------------
/* //Just for testing purposes
$blog_id = get_current_blog_id();
if (is_multisite()) {
    delete_blog_option($blog_id, 'wccp_pro_settings');
} else {
    delete_option('wccp_pro_settings');
}*/
//delete_option('wccp_pro_settings_v16_upgrade');

require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://www.wp-buy.com/wp-update-server/?action=get_metadata&slug=wccp-pro',
	__FILE__, //Full path to the main plugin file or functions.php.
	'wccp-pro'
);
//---------------------------------------------------------------------------------------------
//Load plugin textdomain to load translations
//---------------------------------------------------------------------------------------------
if (!function_exists('wccp_pro_load_textdomain')) {
	function wccp_pro_load_textdomain()
	{
	  load_plugin_textdomain( 'wccp_pro_translation_slug', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}
}
add_action( 'init', 'wccp_pro_load_textdomain' );
//---------------------------------------------------------------------------------------------
//All includes here
//---------------------------------------------------------------------------------------------
$wpccp_pluginsurl = plugins_url( '', __FILE__ );

$wccp_pro_plugins_dir = plugin_dir_path( __FILE__ );

include $wccp_pro_plugins_dir . "/functions.php";
include $wccp_pro_plugins_dir . "/controls-functions.php";
include $wccp_pro_plugins_dir . "/watermarking-rules.php";
include $wccp_pro_plugins_dir . "/common-functions.php";
include $wccp_pro_plugins_dir . "/private-functions.php";
include $wccp_pro_plugins_dir . "/js_functions.php";
include $wccp_pro_plugins_dir . "/css_functions.php";
include $wccp_pro_plugins_dir . "/play_functions.php";

try{
	$wccp_pro_settings = wccp_pro_read_options_from_db('wccp_pro_settings');

	add_action( 'upgrader_process_complete', function() use( $wccp_pro_settings ){ wccp_pro_modify_settings($wccp_pro_settings); },10, 2);
	
	add_action( 'upgrader_process_complete', 'wccp_pro_upgrade_process_for_v16');

	register_activation_hook( __FILE__, 'wccp_pro_upgrade_process_for_v16');
	
	register_activation_hook( __FILE__, function() use( $wccp_pro_settings ){ wccp_pro_modify_settings($wccp_pro_settings); } );

	register_activation_hook( __FILE__, function() use( $wccp_pro_settings ){ wccp_pro_modify_htaccess($wccp_pro_settings); } );

	register_activation_hook(__FILE__, 'wccp_pro_copy_testing_images_to_uploads');

	register_activation_hook(__FILE__, 'wccp_pro_deactivate_the_free_version');

	register_activation_hook( __FILE__, 'wccp_pro_my_activation_func' );//Report any error during activation

	register_activation_hook( __FILE__, 'create_watermarked_images_directory' ); // For caching

	// Flush rewrite rules on plugin activation and deactivation
	register_activation_hook(__FILE__, function() { flush_rewrite_rules(); });

	register_deactivation_hook(__FILE__, function() { flush_rewrite_rules(); });

	register_deactivation_hook( __FILE__, 'wccp_pro_clear_htaccess' );

	add_action( 'upgrader_process_complete', function() use( $wccp_pro_settings ){ wccp_pro_modify_htaccess($wccp_pro_settings); },10, 2);

	add_action( 'init', function() use( $wccp_pro_settings ){ wccp_pro_run($wccp_pro_settings); },10, 2); //The main function
	
	//add_action('init', 'wccp_pro_run'); //The main function
}
catch(Exception $e) {//catch exception
  error_log('WCCP_PRO Protection Plugin Error Message Catched: ' . $e->getMessage());
}
///////////////////Main plugin function/////////////////
if (!function_exists('wccp_pro_run')) {
function wccp_pro_run($wccp_pro_settings)
{
	// Exit if this is an AJAX request, except if ajax request is mine
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		// List of your plugin's AJAX actions
		$my_ajax_actions = [
			'wccp_pro_ajax_top_bar',
			'wccp_pro_ajax_top_bar_remove_Protection',
			'wccp_pro_advanced_get_link',
		];

		// If this request is not one of yours → exit
		if ( ! isset( $_REQUEST['action'] ) || ! in_array( $_REQUEST['action'], $my_ajax_actions, true ) ) {
			return;
		}
	}

    // Exit if this is a WP-Cron job
    if ( defined( 'DOING_CRON' ) && DOING_CRON ) return;
	
	wccp_pro_upgrade_process_for_v16();
	
	//$wccp_pro_settings = wccp_pro_read_options_from_db('wccp_pro_settings');
	
	wccp_pro_debug_to_console($wccp_pro_settings, "Current_post_type: ", wccp_pro_get_current_post_type());
	
	wccp_pro_block_machine_user_agents();
	
	$exclude_this_page = false;
	
	$wccp_pro_is_admin = false;
	
	$wccp_pro_is_inside_page_builder = wccp_pro_is_inside_page_builder();
	
	if ( is_admin() || is_blog_admin()) $wccp_pro_is_admin = true;
	
	if($wccp_pro_settings['show_admin_bar_icon'] == 'Yes')
	{
		add_action('admin_bar_menu',function($admin_bar) use( $wccp_pro_settings ){ wpccp_add_items($wccp_pro_settings, $admin_bar); }, 40);
	}
	
	add_action( "wp_ajax_wccp_pro_ajax_top_bar",function() use( $wccp_pro_settings ){ wccp_pro_ajax_top_bar($wccp_pro_settings); });
	
	add_action( "wp_ajax_nopriv_wccp_pro_ajax_top_bar",function() use( $wccp_pro_settings ){ wccp_pro_ajax_top_bar($wccp_pro_settings); });

	add_action( "wp_ajax_wccp_pro_ajax_top_bar_remove_Protection",function() use( $wccp_pro_settings ){ wccp_pro_ajax_top_bar_remove_Protection($wccp_pro_settings); });
	
	add_action( "wp_ajax_nopriv_wccp_pro_ajax_top_bar_remove_Protection",function() use( $wccp_pro_settings ){ wccp_pro_ajax_top_bar_remove_Protection($wccp_pro_settings); });
	
	add_filter( "plugin_action_links_".plugin_basename(__FILE__), 'wccp_pro_plugin_add_settings_link', 10, 4 ); // To add settings link under the plugin name
	
	add_action('admin_menu', 'wccp_pro_add_options');
	
	add_action( 'wp_enqueue_scripts', 'wccp_pro_ajax_enqueue_scripts' );
	
	//---------------------------------------------------------------------------------------------
	//Add the plugin icon style to the top admin bar
	//---------------------------------------------------------------------------------------------
	add_action('wp_enqueue_scripts', 'wccp_pro_top_bar_enqueue_style');
	
	add_action('admin_enqueue_scripts', 'wccp_pro_top_bar_enqueue_style');
	
	//---------------------------------------------------------------------------------------------
	//Add the plugin icon style to the top admin bar
	//---------------------------------------------------------------------------------------------
	add_action( "wp_ajax_wccp_pro_advanced_get_link",function() use( $wccp_pro_settings ){ wccp_pro_advanced_get_link($wccp_pro_settings); });
	
	add_action( "wp_ajax_nopriv_wccp_pro_advanced_get_link",function() use( $wccp_pro_settings ){ wccp_pro_advanced_get_link($wccp_pro_settings); });
	
	//if($wccp_pro_is_admin) return; //Exit from this function when inside admin dashboard
	
	if(!$wccp_pro_is_admin)
	{
		$exclude_this_page = exclude_this_page_or_not($wccp_pro_settings);
	}
	
	$do_not_use_cookies = $wccp_pro_settings["do_not_use_cookies"];
	
	if($do_not_use_cookies != "checked") //Dont use any cookies if the option checked
	{
		if($exclude_this_page == true || $wccp_pro_is_admin)
		{
			// Set the expiration date to one hour ago
			
			$value = "excludethispage";
			
			$cookie_time = time()+ (20); // cookie time is 20 seconds by default
			
			if($wccp_pro_is_admin) $cookie_time = time() + (30); //increase cookie time for admin area
			
			if (!headers_sent()) @setcookie("wccp_pro_functionality", $value, $cookie_time , "/", "", false, true); //set a timed cookie
		}
		else
		{
			if (!headers_sent()) @setcookie("wccp_pro_functionality", "", time() - 3600, "/"); // Clear the cookie
		}
	}

	if($exclude_this_page == false && !$wccp_pro_is_admin && !$wccp_pro_is_inside_page_builder)
	{
		add_action('wp_enqueue_scripts',function() use( $wccp_pro_settings ){ scripts_injection($wccp_pro_settings); });

		add_action('login_enqueue_scripts',function() use( $wccp_pro_settings ){ scripts_injection($wccp_pro_settings); });
		
		if($wccp_pro_settings['mysite_rule'] == 'Watermark' && $wccp_pro_settings['force_watermarking_for_non_apache_servers'] == 'checked')
		{
			//This will do watermak image replacements for all images in page level
			// Start output buffering
			add_action('template_redirect', 'wccp_start_output_buffer');
			function wccp_start_output_buffer() {
				if (!defined('DOING_AJAX') || !DOING_AJAX) {
					ob_start('wccp_replace_image_urls_in_content');
				}
			}
		}
	}
	
	add_action('wp_enqueue_scripts',function() use( $wccp_pro_settings ){ wccp_pro_helper_js_scripts($wccp_pro_settings); });

	add_action('login_enqueue_scripts',function() use( $wccp_pro_settings ){ wccp_pro_helper_js_scripts($wccp_pro_settings); });
	
	//Show the alert message inside admin panel for preview usage only
	
	$admincore = '';
	
	if (isset($_GET['page'])) $admincore = $_GET['page'];
	
	if( $wccp_pro_is_admin && ($admincore == 'wccp-options-pro' || $admincore == 'wccp-options-pro_watermark_testing'))
	{
		add_action( 'admin_footer',function() use( $wccp_pro_settings ){ wccp_admin_pro_alert_message($wccp_pro_settings); });
		
		add_action('admin_enqueue_scripts',function() use( $wccp_pro_settings ){ wccp_pro_enqueue_scripts($wccp_pro_settings); });
	}
	if( $wccp_pro_is_admin)
	{
		//add_action( 'admin_footer',function() use( $wccp_pro_settings ){ wccp_admin_pro_Append_Parameters_to_Media_library_Images($wccp_pro_settings); }); //canceled option because its solved by htaccess
		if(!isset($wccp_pro_settings['major_update_done_for_v']) || $wccp_pro_settings['major_update_done_for_v'] != "16.8") show_message_for_major_updates();
	}
}
}

if (!function_exists('wccp_pro_upgrade_process_for_v16')) {
function wccp_pro_upgrade_process_for_v16()
{
	// Check if the option already exists
    if (get_option('wccp_pro_settings_v16_upgrade') === false)
	{
		$pluginsurl = plugins_url( '', __FILE__ );
		
		$default_dw_logo = $pluginsurl . '/images/testing-logo.png';
		
		$old_wccp_pro_settings = get_option('wccp_pro_settings');
		
		$old_wccp_pro_settings = array(
			"css_js_files_version_num" => "1",
			"single_posts_protection" => "checked",
			"home_page_protection" => "checked",
			"page_protection" => "checked",
			"smessage" => "Alert: Content selection is disabled!!",
			"prntscr_protection" => "checked",
			"drag_drop" => "checked",
			"drag_drop_images" => "checked",
			"ctrl_s_protection" => "checked",
			"ctrl_a_protection" => "checked",
			"ctrl_c_protection" => "checked",
			"ctrl_x_protection" => "checked",
			"ctrl_v_protection" => "checked",
			"ctrl_u_protection" => "checked",
			"ctrl_message" => "Alert: You are not allowed to copy content or view source",
			"allow_sel_on_code_blocks" => "",
			"show_copy_button_for_code_blocks" => "",
			"text_over_copy_button" => "Select To Copy",
			"f12_protection" => "checked",
			"custom_keys_message" => "You are not allowed to do this action on the current page!!",
			"prnt_scr_msg" => "You are not allowed to print this page!",
			"ctrl_p_protection" => "checked",
			"msg_color" => "#ffecec",
			"font_color" => "#555555",
			"border_color" => "#f5aca6",
			"shadow_color" => "#f2bfbf",
			"message_show_time" => "3",
			"msg_font_size" => "12px",
			"right_click_protection_posts" => "checked",
			"right_click_protection_homepage" => "checked",
			"right_click_protection_pages" => "checked",
			"img" => "checked",
			"a" => "checked",
			"pb" => "checked",
			"h" => "checked",
			"textarea" => "checked",
			"input" => "checked",
			"emptyspaces" => "checked",
			"videos" => "",
			"alert_msg_img" => "Alert: Protected image",
			"alert_msg_a" => "Alert: This link is protected",
			"alert_msg_pb" => "Alert: Right click on text is disabled",
			"alert_msg_h" => "Alert: Right click on headlines is disabled",
			"alert_msg_textarea" => "Alert: Right click is disabled",
			"alert_msg_input" => "Alert: Right click is disabled",
			"alert_msg_emptyspaces" => "Alert: Right click on empty spaces is disabled",
			"alert_msg_videos" => "Alert: Right click on videos is disabled",
			"home_css_protection" => "Yes",
			"posts_css_protection" => "Yes",
			"pages_css_protection" => "Yes",
			"custom_css_code" => "",
			"protection_overlay_posts" => "",
			"protection_overlay_homepage" => "",
			"protection_overlay_pages" => "",
			"remove_img_urls" => "No",
			"no_js_action" => "Nothing",
			"no_js_action_massage" => "You can not open this website with JS disabled!!",
			"watermark_caching" => "checked",
			"hotlinking_rule" => "Watermark",
			"mysite_rule" => "No Action",
			"dw_logo" => $default_dw_logo,
			"dw_margin_top_factor" => "98",
			"dw_margin_left_factor" => "98",
			"dw_text" => "",
			"dw_font_color" => "#000000",
			"dw_position" => "center-center",
			"dw_font_size_factor" => "90",
			"dw_r_text" => "",
			"dw_r_font_color" => "#efefef",
			"dw_r_font_size_factor" => "55",
			"dw_text_transparency" => "65",
			"dw_rotation" => "40",
			"dw_imagefilter" => "None",
			"dw_signature" => "",
			"url_exclude_list" => "",
			"exclude_registered_images_sizes" => "",
			"excluded_images_from_watermarking" => "logo,150x150",
			"selection_exclude_classes" => "",
			"exclude_online_services" => "",
			"url_included_list" => "",
			"do_not_use_cookies" => "",
			"opposite_mode" => "Inactive",
			"exclude_by_user_type" => "",
			"exclude_by_post_type" => "",
			"exclude_by_category" => "",
			"show_admin_bar_icon" => "Yes",
			"developer_mode" => "No",
			"kill_devlop_tools" => "",
			"kill_browsers_extensions" => "",
			"exclude_css_js_files" => ""
		);

		
		// Task 1: Removing unused elements from the old_array
		$keys_to_unset = array(
		"single_posts_protection",
		"home_page_protection",
		"page_protection",
		"right_click_protection_posts",
		"right_click_protection_homepage",
		"right_click_protection_pages",
		"home_css_protection",
		"posts_css_protection",
		"pages_css_protection",
		"protection_overlay_posts",
		"protection_overlay_homepage",
		"protection_overlay_pages"
		);

		foreach ($keys_to_unset as $key) {
			if (array_key_exists($key, $old_wccp_pro_settings)) {
				unset($old_wccp_pro_settings[$key]);
			}
		}
		
		$keys_to_add = array(
		'css_js_files_version_num' => 1,'major_update_done_for_v' => "15.3","force_watermarking_for_non_apache_servers" => "",
		'text_protection_by_type' => array(
			0 => 'home_page',
			1 => 'archive',
			2 => 'category',
			3 => 404,
			4 => 'author',
			5 => 'tag',
			6 => 'search',
			7 => 'post',
			8 => 'page',
			9 => 'attachment',
			10 => 'product',
			11 => 'woocommerce-pages'
			),
		'right_click_protection_by_type' => array(
			0 => 'home_page',
			1 => 'archive',
			2 => 'category',
			3 => 404,
			4 => 'author',
			5 => 'tag',
			6 => 'search',
			7 => 'post',
			8 => 'page',
			9 => 'attachment',
			10 => 'product',
			11 => 'woocommerce-pages'
			),
		'logo_size_over_image' => 27
		);

		// Task 2: Migrating new elements from the new_array to the old_array
		foreach ($keys_to_add as $key => $value) {
			$old_wccp_pro_settings[$key] = $value;
		}
		
		//var_dump($old_wccp_pro_settings);
	
		update_option('wccp_pro_settings', $old_wccp_pro_settings);
		
		wccp_pro_modify_htaccess($old_wccp_pro_settings);
		
		// Option to make sure that this function will run one time only
        add_option('wccp_pro_settings_v16_upgrade', 'done');
	}
}
}
?>