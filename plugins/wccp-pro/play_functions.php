<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//---------------------------------------------------------------------------------------------
//Here is how disable selection script will shown
//---------------------------------------------------------------------------------------------
function wccp_pro_main_settings($wccp_pro_settings)
{
	$pluginsurl = plugins_url( '', __FILE__ );
	
	if(isset($wccp_pro_settings['text_protection_by_type']) && !empty($wccp_pro_settings['text_protection_by_type']))
	{
		if(in_array(wccp_pro_get_current_post_type(), $wccp_pro_settings['text_protection_by_type']))
		{
			wccp_pro_disable_selection($wccp_pro_settings); //Located in js_functions.php
			
			wccp_pro_css_script();
			
			wp_register_style('css-protect.css', $pluginsurl.'/css/css-protect.css', array(), $wccp_pro_settings["css_js_files_version_num"]);
			
			wp_enqueue_style('css-protect.css');
			
			return;
		}
	}
}
//---------------------------------------------------------------------------------------------
//Here is how disable right click script will shown
//---------------------------------------------------------------------------------------------
function wccp_pro_right_click_premium_settings($wccp_pro_settings)
{
	if(isset($wccp_pro_settings['right_click_protection_by_type']) && !empty($wccp_pro_settings['right_click_protection_by_type']))
	{
		if(in_array(wccp_pro_get_current_post_type(), $wccp_pro_settings['right_click_protection_by_type']))
		{
			wccp_pro_disable_Right_Click($wccp_pro_settings); //Located in js_functions.php
			
			if($wccp_pro_settings['videos'] == 'checked') wccp_pro_video_overlay(); //Located in js_functions.php
			
			return;
		}
	}
}

//---------------------------------------------------------------------------------------------
//Here is how protection overlay is work for images
//---------------------------------------------------------------------------------------------
function wccp_pro_images_overlay_settings($wccp_pro_settings)
{
	if(isset($wccp_pro_settings['overlay_protection_by_type']) && !empty($wccp_pro_settings['overlay_protection_by_type']))
	{
		if(in_array(wccp_pro_get_current_post_type(), $wccp_pro_settings['overlay_protection_by_type']))
		{
			wccp_pro_images_overlay($wccp_pro_settings); //Located in js_functions.php
			
			return;
		}
	}
}
?>