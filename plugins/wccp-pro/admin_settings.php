<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$c = new wccp_pro_controls_class();

if ( isset( $_POST['Restore_defaults'] ) )
{
	if(!wccp_pro_is_verified_nonce()) return; //Exit if not verified
	
	if(is_multisite())
	{
		$id = get_current_blog_id();
		delete_blog_option($id,'wccp_pro_settings');
	}
	else
	{
		delete_option('wccp_pro_settings');
	}
	
	$c->wccp_pro_save_settings(false);
}
if ( isset( $_POST['clear_cached_images'] ) || isset( $_POST['Save_settings'] ) || isset( $_POST['Restore_defaults'] ) ) 
{
	if(!wccp_pro_is_verified_nonce()) return; //Exit if not verified
	
	wccp_pro_delete_watermarked_cached_images('');
	
	wpcp_pro_renew_css_code_file();
}

//-----------------------------------------------------------
//Reload_print_page_preventer_script into located css file
//-----------------------------------------------------------
if (isset( $_POST['Save_settings'] ) || isset( $_POST['Restore_defaults'] ) ) 
{
	if(!wccp_pro_is_verified_nonce()) return; //Exit if not verified
	
	wpcp_pro_load_print_page_preventer_script($c -> wccp_pro_get_setting("prnt_scr_msg")); // Reload Css script
}
//-----------------------------------------------------------
//Update htaccess file when Save or restore defaults
//-----------------------------------------------------------
if(isset( $_POST['Save_settings'] ))
{
	if(!wccp_pro_is_verified_nonce()) return; //Exit if not verified
	
	if($_POST['hotlinking_rule'] == "Watermark" || $_POST['mysite_rule'] == "Watermark")
	{
		wccp_pro_modify_htaccess($c->wccp_pro_read_options());
	}
	if($_POST['hotlinking_rule'] == "No Action" && $_POST['mysite_rule'] == "No Action")
	{
		wccp_pro_clear_htaccess();
	}
	
	$wccpadminurl = get_admin_url();
	
	$settings_url = $wccpadminurl.'admin.php?page=wccp-options-pro';
	
	wccp_pro_redirect($settings_url);
}
if ( isset( $_POST['Restore_defaults'] ) )
{
	if(!wccp_pro_is_verified_nonce()) return; //Exit if not verified
	
	wccp_pro_modify_htaccess($c->wccp_pro_read_options());
	
	$wccpadminurl = get_admin_url();
	
	$settings_url = $wccpadminurl.'admin.php?page=wccp-options-pro';
	
	wccp_pro_redirect($settings_url);
}
//-----------------------------------------------------------
//wccp_pro_redirect
//-----------------------------------------------------------
function wccp_pro_redirect($url)
{
    if (!headers_sent())
    {
        header('Location: '.$url);
        exit;
    }
    else
        {
        echo '<script>';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>';
		exit;
    }
}
//-----------------------------------------------------------
//Verify if nonce is good or return false
//-----------------------------------------------------------
function wccp_pro_is_verified_nonce()
{
	if(!(isset($_POST["make_this_form_verified_nonce"]) && wp_verify_nonce( $_POST[ 'make_this_form_verified_nonce' ], 'make_form_nonce_action' ))) return false; //Exit if not verified
	
	return true;
}
?>
<style>
#aio_admin_main {
	text-align:left;
	direction:ltr;
	padding:10px;
	margin: 10px;
	background-color: #ffffff;
	border:1px solid #EBDDE2;
	display: relative;
	overflow: auto;
}
.inner_block{
	height: 370px;
	display: inline;
	min-width:770px;
}
#donate{
    background-color: #EEFFEE;
    border: 1px solid #66DD66;
    border-radius: 10px 10px 10px 10px;
    height: 58px;
    padding: 10px;
    margin: 15px;
    }
.text-font {
    color: #1ABC9C;
    font-size: 14px;
    line-height: 1.5;
    padding-left: 3px;
    transition: color 0.25s linear 0s;
}
.text-font:hover {
    opacity: 1;
    transition: color 0.25s linear 0s;
}
.simpleTabsContent{
	border: 1px solid #E9E9E9;
	padding: 4px;
}
div.simpleTabsContent{
	margin-top:0;
	border: 1px solid #E0E0E0;
    display: none;
    height: 100%;
    min-height: 400px;
    padding: 5px 15px 15px;
}
html {
	background: #FFFFFF;
}

.inner-label {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: #f6f6f6;
    border-image: none;
    border-radius: 3px;
    border-style: solid;
    border-width: 1px 1px 1px 7px;
    font-family: tahoma;
    font-size: 11px;
    padding: 13px;
    text-align: center;
}
.controls_container {
    border-radius: 4px;
    min-height: 54px;
	height: 100%;
    padding-top: 7px;
    font-family: tahoma;
    font-size: 11px;
}
.controls_container p, .controls_container span{
	font-family: tahoma;
    font-size: 11px;
}
.framework_small_font {
    font-family: tahoma;
    font-size: 11px;
}
.welling {
    background-image: -webkit-linear-gradient(left, #e4e4e4, #ffffff 99%, transparent 1%, transparent 100%);
    border-radius: 3px;
    height: 40px;
    font-family: tahoma;
    font-size: 11px;
}
.welling p {
    font-family: tahoma;
    font-size: 11px;
}
.welling > span {
    display: table-cell;
    height: 40px;
    vertical-align: middle;
}
.form-control{
	border: 1px solid #ced4da !important;
}
.controls_label {
    padding-left: 0px;
}
</style>
<!-- This for range slider only -->
<style>
.sliderr {
    -webkit-appearance: none;
    max-width: 161px;
    height: 15px;
    border-radius: 5px;
    background: #d3d3d3;
    outline: none;
    opacity: 0.7;
    -webkit-transition: .2s;
    transition: opacity .2s;
    width: 100%;
 }
.sliderr:hover {
    opacity: 1;
}

.sliderr::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}

.sliderr::-moz-range-thumb {
    width: 25px;
    height: 25px;
    border-radius: 50%;
    background: #4CAF50;
    cursor: pointer;
}
</style>
<style>
.styled-select-div {
  background: transparent;
  border: none;
  font-size: 14px;
  padding: 5px; /* If you add too much padding here, the options won't show in IE */
  width: 268px;
  background-color: #3b8ec2;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;
}
.styled-select-div select:focus
{
	color: #fff;
}
.styled-select-div select:hover {
    color: #fff;
	text-shadow: 3px 3px 9px;
}
/* -------------------- Colors: Text */
.styled-select-div select{
  
  border: none;
  font-size: 14px;
  height: 29px !important;
  /* padding: 0px;  If you add too much padding here, the options won't show in IE */
  width: 258px;
}

.styled-select-div option, .styled-select-div select{
	color: #fff;
	background-color: rgb(59, 142, 194);
}
.main_admin_page_container{
	max-width: 1250px;
}
</style>
<p style="margin: 20px 0 20px;font-size: 16px;font-weight: bold;color: rgba(30,140,190,.8);">WP Content Copy Protection &amp; No Right Click (Premium)</p>
<?php
if(isset($_POST["Save_settings"]) && wccp_pro_is_verified_nonce()) //Settings saved and need to check if htaccess is saved also or not
{
	if($_POST['hotlinking_rule'] == "Watermark" || $_POST['mysite_rule'] == "Watermark")
	{
		$htaccess_file = wccp_pro_get_uploads_dir_relative_path() . '/.htaccess';
		
		$filename = $htaccess_file;
		
		if (!is_writable($filename)) {
			
			echo '<p style="margin: 20px 0 20px;font-size: 14px;font-weight: bold;color: red;">Alert: Watermarking code not saved!! The .htaccess file is not writable!</p>';
		}
	}
}
?>
<div class="main_admin_page_container">
<form method="POST">
<?php wp_nonce_field('make_form_nonce_action','make_this_form_verified_nonce'); ?>
<input type="hidden" value="update" name="action">
<div class="contenttabs_master" style="border:1px solid #ecebeb; width:99%;">
	<input class="tab_container_radio_tabs" id="tab1" type="radio" name="tabs" checked>
	<input class="tab_container_radio_tabs" id="tab2" type="radio" name="tabs">
	<input class="tab_container_radio_tabs" id="tab3" type="radio" name="tabs">
	<input class="tab_container_radio_tabs" id="tab4" type="radio" name="tabs">
	<input class="tab_container_radio_tabs" id="tab5" type="radio" name="tabs">
	<input class="tab_container_radio_tabs" id="tab6" type="radio" name="tabs">
	<input class="tab_container_radio_tabs" id="tab7" type="radio" name="tabs">
	<input class="tab_container_radio_tabs" id="tab8" type="radio" name="tabs">
	<input class="tab_container_radio_tabs" id="tab9" type="radio" name="tabs">
	<div class="contenttabs">
		<label id="label1" class="tab_container_label_tabs label1" for="tab1"><i class="dashicons dashicons-media-text"></i><span><?php _e('Selection','wccp_pro_translation_slug'); ?></span></label>
		<label id="label2" class="tab_container_label_tabs label2" for="tab2"><i class="dashicons dashicons-shield"></i><span><?php _e('RightClick','wccp_pro_translation_slug'); ?></span></label>
		<label id="label3" class="tab_container_label_tabs label3" for="tab3"><i style="color: red;" class="dashicons dashicons-media-code"></i><span><?php _e('CSS protection','wccp_pro_translation_slug'); ?></span></label>
		<label id="label4" class="tab_container_label_tabs label4" for="tab4"><i class="dashicons dashicons-embed-photo"></i><span><?php _e('Overlay protection','wccp_pro_translation_slug'); ?></span></label>
		<label id="label5" class="tab_container_label_tabs label5" for="tab5"><i class="dashicons dashicons-format-image"></i><span><?php _e('Watermark','wccp_pro_translation_slug'); ?></span></label>
		<label id="label6" class="tab_container_label_tabs label6" for="tab6"><i class="dashicons dashicons-filter"></i><span><?php _e('Exclusion','wccp_pro_translation_slug'); ?></span></label>
		<label id="label7" class="tab_container_label_tabs label7" for="tab7"><i class="dashicons dashicons-admin-generic"></i><span><?php _e('Custom Settings','wccp_pro_translation_slug'); ?></span></label>
		<label id="label8" class="tab_container_label_tabs label8" for="tab8"><i class="dashicons dashicons-code-standards"></i><span><?php _e('Beta options','wccp_pro_translation_slug'); ?></span></label>
		<label id="label9" class="tab_container_label_tabs label9" for="tab9"><i class="dashicons dashicons-email-alt"></i><span><?php _e('Contact','wccp_pro_translation_slug'); ?></span></label>
	</div><!-- contenttabs div end -->
<div class="tab_container">
<script>
//Remeber last tab checked after refreshing the page
var currunt_tab = localStorage.getItem("wccp_pro_lastTab") || "tab1";
console.log(currunt_tab);
currunt_tab = "#" + currunt_tab;
jQuery(currunt_tab).prop('checked', 'checked');
jQuery(".contenttabs_master :radio").on("change", function(){
	console.log(this.id);
	localStorage.setItem("wccp_pro_lastTab",this.id );
});
</script>
<?php

//---------------------------------------------------------------------
//Basic Protection 
//---------------------------------------------------------------------
/* translators: 1: WordPress version number, 2: plural number of bugs. */
$c->new_tab('content1', 'open');
	$c->add_tab_heading('Text Protection (<font color="#008000">Basic Layer</font>):');
		$c->new_row('open');
	    $c->add_label(__("Disable selection on:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('disable_selection_on', 'open');
			$c->new_controls_row('open');
				$options_array = array();
				$options_array = wccp_pro_list_all_public_post_types();
				$c->add_select2_multiselection('text_protection_by_type' , $options_array , '');
			$c->new_controls_row('close');
			$c->new_controls_row('open');
				$default_text = __('<b>Alert: </b>Content selection is disabled!!','wccp_pro_translation_slug');
				$hint = __('Selection disabled message','wccp_pro_translation_slug');
				$c->add_bottom_hint("<br>" . $hint);
				$c->add_textbox('smessage' , 'Selection disabled message here', 'col-md-7 col-xs-12', $default_text);
			$c->new_controls_row('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('To choose where to apply the protection <p>To allow selection please disable all css protection tab','wccp_pro_translation_slug'));
	$c->new_row('close');
    $c->add_line();
    
	$c->new_row('open');
	    $c->add_label(__("CTRL + key options & disabled message",'wccp_pro_translation_slug'));
	    $c->new_controls_container('special_keys_protection', 'open');
			$c->new_controls_row('open');
				$c->add_checkbox('ctrl_s_protection' , __('Ctrl+S Key','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('ctrl_a_protection' , __('CTRL+A Key','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('ctrl_c_protection' , __('Ctrl+C Key','wccp_pro_translation_slug') , 'checked', '');
			$c->new_controls_row('close');
			
			$c->new_controls_row('open');
				$c->add_checkbox('ctrl_x_protection' , __('Ctrl+X Key','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('ctrl_v_protection' , __('Ctrl+V Key','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('ctrl_u_protection' , __('Ctrl+U Key','wccp_pro_translation_slug') , 'checked', '');
			$c->new_controls_row('close');

			$c->new_controls_row('open');	
				//CTRL + key disabled message
				$default_text = __('<b>Alert:</b> You are not allowed to copy content or view source','wccp_pro_translation_slug');
				$hint = __('CTRL + key disabled message','wccp_pro_translation_slug');
				$c->add_bottom_hint($hint);
				$c->add_textbox('ctrl_message' , __('Write a message for CTRL + keys','wccp_pro_translation_slug'), 'col-md-7 col-xs-12', $default_text);
			$c->new_controls_row('close');
			
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Message for disable the keys  CTRL+A , CTRL+C , CTRL+X , CTRL+S or CTRL+V , CTRL+U','wccp_pro_translation_slug'));
	$c->new_row('close');
    $c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Allow selection on:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('allow_selection_on', 'open');
			$c->new_controls_row('open');
				$c->add_checkbox('allow_sel_on_code_blocks' , __('Code blocks','wccp_pro_translation_slug') , '', '');
				$c->add_checkbox('show_copy_button_for_code_blocks' , __('show copy button over blocks','wccp_pro_translation_slug') , '', '');
				$c->add_textbox('text_over_copy_button' , __('Text over copy button','wccp_pro_translation_slug'), 'col-md-7 col-xs-12', __('Select To Copy','wccp_pro_translation_slug'));
			$c->new_controls_row('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('This option will allow selection if you have code inserted inside &lt;code&gt;&lt;/code&gt; HTML blocks','wccp_pro_translation_slug'));
	$c->new_row('close');
    $c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Special keys options & disabled message:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('special_keys_disabled_message', 'open');
			$c->new_controls_row('open');
				$c->add_checkbox('prntscr_protection' , __('Print Screen Key','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('drag_drop' , __('Drag/Drop','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('f12_protection' , __('F12','wccp_pro_translation_slug') , 'checked', '');
			$c->new_controls_row('close');
			
			$default_text = __('You are not allowed to do this action on the current page!!','wccp_pro_translation_slug');
	        $c->add_textbox('custom_keys_message' , 'Write a message for PrintScreen key', 'col-md-7 col-xs-12', $default_text);
		$c->new_controls_container('','close');
	    $c->add_help_container('This message will be shown when the user try to use blocked special keys <p>Note: this may not work on all browsers</p>');
	$c->new_row('close');
    $c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Print page disabled message:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('p_p_d_m', 'open');
			$default_text = __("WARNING:  UNAUTHORIZED USE AND/OR DUPLICATION OF THIS MATERIAL WITHOUT EXPRESS AND WRITTEN PERMISSION FROM THIS SITE'S AUTHOR AND/OR OWNER IS STRICTLY PROHIBITED! CONTACT US FOR FURTHER CLARIFICATION.!!",'wccp_pro_translation_slug');
			$bottom_hint = '';
			$c->add_textarea('prnt_scr_msg', __('Write the message here','wccp_pro_translation_slug'), 'col-8 col-xs-12',$bottom_hint, $default_text);
			$c->add_checkbox('ctrl_p_protection' , __('Ctrl+P Key','wccp_pro_translation_slug') , 'checked', 'col-4 col-xs-12');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Leave this field blank & uncheck the ctrl+p option if you want to allow users to print your pages','wccp_pro_translation_slug'));
	$c->new_row('close');
    $c->add_line();
	
    $c->new_row('open');
        $c->add_label(__("Message inner style:",'wccp_pro_translation_slug'));
        $c->new_controls_container('m_i_s', 'open');
	        $c->add_colorpicker('msg_color', __('Message background','wccp_pro_translation_slug'), '#ffecec');
	        $c->add_colorpicker('font_color', __('Font color','wccp_pro_translation_slug'), '#555555');
		$c->new_controls_container('','close');
        $c->add_help_container(__('You may use CTRL+F5 after saving to preview the message','wccp_pro_translation_slug'));
    $c->new_row('close');
    $c->add_line();
    
    $c->new_row('open');
        $c->add_label(__("Message outer style:",'wccp_pro_translation_slug'));
        $c->new_controls_container('m_o_s', 'open');
	        $c->add_colorpicker('border_color', __('Border color','wccp_pro_translation_slug'), '#f5aca6');
	        $c->add_colorpicker('shadow_color', __('Shadow color','wccp_pro_translation_slug'), '#f2bfbf');
		$c->new_controls_container('','close');
        $c->add_help_container(__('You may use CTRL+F5 after saving to preview the message','wccp_pro_translation_slug'));
    $c->new_row('close');
    $c->add_line();
    
    $c->new_row('open');
        $c->add_label(__("Message Show Time:",'wccp_pro_translation_slug'));
        $c->new_controls_container('m_s_t', 'open');
			$c->new_form_group('open');
				$show_array[] = array();
				$show_array["class"] = 'col-md-4 col-xs-12';$show_array["counter"] = 1;
				$show_array["tansparency_meter"] = 0;$show_array["behind_text"] = '';
				$c->add_slider('message_show_time', 3, 0, 15, 1, 'horizontal', $show_array);
			$c->new_form_group('close');
			$options_array = array('10px','12px','14px','16px','18px','20px','22px');
            $default_value = '12px';
            $c->add_dropdown('msg_font_size', $options_array, $default_value, __('Font Size','wccp_pro_translation_slug'));
		$c->new_controls_container('','close');
        $c->add_help_container(__('By seconds, the alert message show time<p>0 value will hide the message','wccp_pro_translation_slug'));
    $c->new_row('close');

$c->new_tab('', 'close');

//---------------------------------------------------------------------
// Copy Protection on RightClick 
//---------------------------------------------------------------------
$c->new_tab('content2', 'open');
	$c->add_tab_heading(__('Copy Protection on RightClick (<font color="#008000">Premium Layer 1</font>):','wccp_pro_translation_slug'));
	$c->new_row('open');
	    $c->add_label(__("Apply the below settings on:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('','open');
			//$c->add_checkbox('right_click_protection_posts' , __('Posts','wccp_pro_translation_slug') , 'checked', '');
			//$c->add_checkbox('right_click_protection_homepage' , __('HomePage','wccp_pro_translation_slug') , 'checked', '');
			//$c->add_checkbox('right_click_protection_pages' , __('Static pages','wccp_pro_translation_slug') , 'checked', '');
			
			$options_array = array();
			$options_array = wccp_pro_list_all_public_post_types();
			$c->add_select2_multiselection('right_click_protection_by_type' , $options_array , '');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('To choose where to apply the protection','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Disables RightClick for HTML tags:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('','open');
			$c->new_controls_row('open');
				$c->add_checkbox('img' , __('Images','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('a' , __('links','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('pb' , __('Text content','wccp_pro_translation_slug') , 'checked', '');
			$c->new_controls_row('close');
			$c->new_controls_row('open');
				$c->add_checkbox('h' , __('Headlines','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('textarea' , __('Text area','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('input' , __('Text fields','wccp_pro_translation_slug') , 'checked', '');
			$c->new_controls_row('close');
			$c->new_controls_row('open');
				$c->add_checkbox('emptyspaces' , __('Empty spaces','wccp_pro_translation_slug') , 'checked', '');
				$c->add_checkbox('videos' , __('Videos (Beta)','wccp_pro_translation_slug') , '', '');
				$c->add_empty_col();
			$c->new_controls_row('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Full screen video protection is out of control','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Disable (special functions) for images:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('','open');
			$c->new_controls_row('open');
				$c->add_checkbox('drag_drop_images' , __('Drag/Drop','wccp_pro_translation_slug') , 'checked', '');
				$c->add_empty_col();
				$c->add_empty_col();
			$c->new_controls_row('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Useful to protect images on touch devices'));
	$c->new_row('close');
	$c->add_line();
	
	
	$c->new_row('open');
	    $c->add_label(__("Right click disabled (customized) messages:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('','open');
			$c->add_textbox('alert_msg_img' , __('For Images','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> Protected image');
			$c->add_textbox('alert_msg_a' , __('For Links','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> This link is protected');
			$c->add_textbox('alert_msg_pb' , __('For Text','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> Right click on text is disabled');
			$c->add_textbox('alert_msg_h' , __('For Headlines','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> Right click on headlines is disabled');
			$c->add_textbox('alert_msg_textarea' , __('For Text Area','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> Right click is disabled');
			$c->add_textbox('alert_msg_input' , __('For Text fields','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> Right click is disabled');
			$c->add_textbox('alert_msg_emptyspaces' , __('For Empty Spaces','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> Right click on empty spaces is disabled');
			$c->add_textbox('alert_msg_videos' , __('For videos','wccp_pro_translation_slug'), 'col-lg-6 col-md-6 col-sm-12', '<b>Alert:</b> Right click on videos is disabled');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Use &lt;b&gt;some text&lt;/b&gt; to show the text in <b>bold</b> format','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
$c->new_tab('', 'close');

//---------------------------------------------------------------------
//Protection by CSS Techniques 
//---------------------------------------------------------------------
$c->new_tab('content3', 'open');
	$c->new_row('open');
	    echo'<div class="alert alert-warning">
			<strong>🚨 Important Update: CSS Protection Tab Deprecated 🚨</strong>
			<p></p>
			<p>
			We want to inform you that the "CSS Protection" tab on your settings page has been deprecated. However, there is no need to worry;
			<p>
			all the previous CSS protection settings have been seamlessly integrated into the "Selection" tab.
			<p>
			If you encounter any issues or have questions regarding these changes, our support team is here to assist you.
			<p>
			You will not see this tab again after the next update
			<p>
			<p>
			Custom CSS Code area has been moved to custom settings tab.
			<p>
			Thank you.
			</div>';
	$c->new_row('close');
$c->new_tab('', 'close');

//---------------------------------------------------------------------
// Overlay protection
//---------------------------------------------------------------------
$c->new_tab('content4', 'open');
$c->add_tab_heading('Overlay protection (<font color="#008000">Premium Layer 3</font>):');
	$c->new_row('open');
	    $c->add_label(__("Auto overlay a transparent image over the real images on:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('','open');			
			$options_array = array();
			$options_array = wccp_pro_list_all_public_post_types();
			$c->add_select2_multiselection('overlay_protection_by_type' , $options_array , '');
		$c->new_controls_container('','close');
	    $c->add_photo_help_container('images/tansparent.png', '');
	$c->new_row('close');
	$c->add_line();

	$c->new_row('open');
	    $c->add_label(__("Auto remove image attachment links:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Auto-remove-image-attachment-links', 'open');
			$options_array = array('Yes', 'No');
				$default_value = 'No';
				$c->add_dropdown('remove_img_urls', $options_array, $default_value);
				$c->add_bottom_hint(__("<p>Not recommended when you are using any lightbox plugin</p>",'wccp_pro_translation_slug'));
		$c->new_controls_container('','close');
	    $c->add_help_container(__('All images will be without hover links','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Action when JavaScript is disabled:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('hotlinking_rule4', 'open');
			$options_array = array('Nothing', 'Hide content');
			$default_value = 'Nothing';
			$c->add_dropdown('no_js_action', $options_array, $default_value);
		$c->new_controls_container('','close');
	    $c->add_help_container(__('The browser will do it if the user disable JavaScript','wccp_pro_translation_slug'));
	$c->new_row('close');
	
	$c->new_row('open');
        $c->add_label(__("JavaScript disabled message:",'wccp_pro_translation_slug'));
        $c->new_controls_container('javascript_disabled_message', 'open');
            $default_text = __('You are not allowed to disable javascript on our website!! Thank you','wccp_pro_translation_slug');
            $c->add_textarea('no_js_action_massage', __('Write your message for users when they try to disable JavaScript on thier browser','wccp_pro_translation_slug'), 'col-md-10 col-xs-12', '', $default_text);
            $c->new_controls_container('','close');
        $c->add_help_container('');
        $c->new_row('close');
    $c->add_line();

$c->new_tab('', 'close');
//---------------------------------------------------------------------
//Protection by watermarking
//---------------------------------------------------------------------
$c->new_tab('content5', 'open');
	$c->add_tab_heading('Watermark your images with full control (<font color="#008000">Premium Layer 4</font>):');
	if (!extension_loaded('gd') && !function_exists('gd_info')) {
		//echo "PHP GD library is NOT installed on your web server";
		$c->add_section(__('Warning: PHP GD library is NOT installed on your web server, watermarking will not work!','wccp_pro_translation_slug'),'orange');
	}
	if(!wccp_pro_check_watermark_dir_can_cache())
		$c->add_section(__('Notice: Cache Directory is NOT found or not writable on your web server, watermarked images will not cached!','wccp_pro_translation_slug'),'red');
	/*
	$c->new_row('open');
        $c->add_label(__('Watermark way:','wccp_pro_translation_slug'));
        $c->new_controls_container('watermark-way', 'open');
			$options_array = array('No Action', 'On The Fly (need .htaccess)', 'Direct (one-time)', 'Client side', 'Fake Watermarking');
			$default_value = 'On The Fly (need .htaccess)';
			$c->add_dropdown('watermarking_way', $options_array, $default_value);
		$c->new_controls_container('','close');
		$c->add_help_container(__('Which is better for me? Check this article to know','wccp_pro_translation_slug'));
    $c->new_row('close');
	$c->add_line();
	*/
	$c->new_row('open');
        $c->add_label(__('Watermark Caching:','wccp_pro_translation_slug'));
        $c->new_controls_container('watermark-caching', 'open');
			$c->add_checkbox('watermark_caching' , __('Active (Recommended)','wccp_pro_translation_slug') , 'checked', '');
			$c->add_button('clear_cached_images' , 'Clear_cache col' , __('Clear cache','wccp_pro_translation_slug'), true, "Cleared!");
		$c->new_controls_container('','close');
		$c->add_help_container(__('Recommended for fast page loading & website server speed','wccp_pro_translation_slug'));
    $c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Hotlinking Rule:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('hotlinking_rule', 'open');
			$options_array = array('Watermark', 'No Action');
				$default_value = 'Watermark';
				$c->add_dropdown('hotlinking_rule', $options_array, $default_value);
				$htaccess_file = WP_CONTENT_DIR . '/.htaccess';
				$filename = $htaccess_file;
				if ((file_exists($filename) && is_writable($filename)) || !file_exists($filename) && is_writable(WP_CONTENT_DIR)) {
					$hint = '<p style="color:green">' . __('Good! The htaccess file is writable','wccp_pro_translation_slug') . '</p>';
				} else {
					$hint = '<p style="color:red">' . __('Opps! The htaccess file is not writable','wccp_pro_translation_slug') . '</p>';
					$hint .= '<p style="color:red">' . __('Please make this folder writable','wccp_pro_translation_slug');
					$hint .= ' (' . WP_CONTENT_DIR . ')</p>';
				}
				$c->add_bottom_hint($hint);
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Action when a thief copy your images to his site or try to download them','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("My Site Rule:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('my_site_rule', 'open');
			$c->new_form_group('open');
				$options_array = array('Watermark', 'No Action');
				$default_value = 'No Action';
				$c->add_dropdown('mysite_rule', $options_array, $default_value);
			$c->new_form_group('close');
			$c->new_form_group('open');
				$c->add_checkbox('force_watermarking_for_non_apache_servers' , __('check if your server type is not apache','wccp_pro_translation_slug') , '', '');
			$c->new_form_group('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('What will happen to images on my site','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Watermark logo:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Watermark-logo', 'open');
			$pluginsurl = plugins_url( '', __FILE__ );
			$default_image = $pluginsurl . '/images/testing-logo.png';
			$c->add_media_uploader('dw_logo',$default_image);
			
			$show_array = array();
			$show_array["label_over_slider"] = 'Stamp space over the image (%)';
			$show_array["class"] = 'col-md-4 col-xs-12';$show_array["counter"] = 1;
			$show_array["tansparency_meter"] = 0;$show_array["behind_text"] = '%';
			$c->add_slider('logo_size_over_image', 27, 1, 100, 1, 'horizontal', $show_array);//Text size
			
		$c->new_controls_container('','close');
	    $c->add_help_container(__('You can use a transparent logo in a png format<br>Best size: 128x128 px <p>Clear it to watermark without logo</p>','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Logo Margins:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('margin_factors', 'open');
			$c->new_form_group('open');
				$show_array = array();
				$show_array["label_over_slider"] = 'From Top';
				$show_array["class"] = 'col-md-4 col-xs-12';$show_array["counter"] = 1;
				$show_array["tansparency_meter"] = 0;$show_array["behind_text"] = '%';
				$c->add_slider('dw_margin_top_factor', 98, 1, 100, 1, 'horizontal', $show_array);//Text size
			$c->new_form_group('close');
			
			$c->new_form_group('open');
				$show_array = array();
				$show_array["label_over_slider"] = 'From Left';
				$show_array["class"] = 'col-md-4 col-xs-12';$show_array["counter"] = 1;
				$show_array["tansparency_meter"] = 0;$show_array["behind_text"] = '%';
				$c->add_slider('dw_margin_left_factor', 98, 1, 100, 2, 'horizontal', $show_array);//Text size
			$c->new_form_group('close');
		$c->new_controls_container('','close');
	    $c->add_photo_help_container('images/logo-positioning.png', '');
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Watermark Central text:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Watermark-text', 'open');
			$default_text = __('WATERMARKED','wccp_pro_translation_slug');
			$c->add_textbox('dw_text' , __('Watermark text','wccp_pro_translation_slug'), 'col-8', $default_text);
			$c->add_colorpicker('dw_font_color', '', '#000000');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Write a short text','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Watermark text position:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('watermark-position', 'open');
			$options_array = 
			array(
				array('top-left','top-center','top-right','center-left','center-center','center-right','bottom-left','bottom-center','bottom-right'),
				array('Top Left','Top Center','Top Rright','Center Left','Center','Center Right','Bottom Left','Bottom Center','Bottom Right')
			);
			$c->add_image_picker('dw_position', '', $options_array, 'images/img-picker-1', 'center-center');
	    $c->new_controls_container('','close');
		$c->add_help_container(__('Choose a watermark text position','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Central text font size:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Watermark-font-size', 'open');
		$c->new_form_group('open');
			$show_array = array();
			$show_array["label_over_slider"] = 'Choose a value';
			$show_array["class"] = 'col-4 col-xs-12';$show_array["counter"] = 1;
			$show_array["tansparency_meter"] = 0;$show_array["behind_text"] = '%';
			$c->add_slider('dw_font_size_factor', 90, 1, 100, 1, 'horizontal', $show_array);//Text size
		$c->new_form_group('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Depend on image size','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Watermark Repeated text:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Watermark-r-text', 'open');
			$default_text = 'your-site.com';
			$default_text = $_SERVER["SERVER_NAME"];
			$c->add_textbox('dw_r_text' , __('Watermark text','wccp_pro_translation_slug'), 'col-8', $default_text);
			$c->add_colorpicker('dw_r_font_color', '', '#efefef');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Repeated as a grid on the image','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Repeated text font size:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('repeated-text-font-size', 'open');
		$c->new_form_group('open');
			$show_array = array();
			$show_array["label_over_slider"] = 'Choose a value';
			$show_array["class"] = 'col-md-4 col-xs-12';$show_array["counter"] = 1;
			$show_array["tansparency_meter"] = 0;$show_array["behind_text"] = '%';
			$c->add_slider('dw_r_font_size_factor', 55, 1, 100, 1, 'horizontal', $show_array);//Text size
		$c->new_form_group('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Depend on image size','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Text transparency:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Watermark-transparency', 'open');
		$c->new_form_group('open');
			$show_array = array();
			$show_array["label_over_slider"] = 'Choose a value';
			$show_array["class"] = 'col-md-4 col-xs-12';$show_array["counter"] = 1;
			$show_array["tansparency_meter"] = 1;$show_array["behind_text"] = '';
			$c->add_slider('dw_text_transparency', 65, 1, 100, 1, 'horizontal', $show_array);//Text transparency
		$c->new_form_group('close');
		$c->new_form_group('open');
			$c->add_inner_label(__("Rotation",'wccp_pro_translation_slug'));
			$c->add_textbox('dw_rotation', __('Rotation value','wccp_pro_translation_slug'), 'col', '40');//Text Rotation
		$c->new_form_group('close');
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Rotation value + or - (0 to 360)','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Watermark image filter:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Watermark image filter', 'open');
			$options_array = array('Blur','Grayscale','Negate','Britness','None');
			$default_value = 'None';
			$c->add_dropdown('dw_imagefilter', $options_array, $default_value);
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Chosse any filter you want','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Signature:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('watermark_effect_3', 'open');
			$default_text = __('This image is protected','wccp_pro_translation_slug');
			$c->add_textbox('dw_signature' , __('Signature','wccp_pro_translation_slug'), 'col-8', $default_text);
		$c->new_controls_container('','close');
	    $c->add_help_container(__('Will added at the bottom area of any image','wccp_pro_translation_slug'));
	$c->new_row('close');
	$c->add_line();
$c->new_tab('', 'close');
//---------------------------------------------------------------------
// Exclude URLs (pages or posts) form protection
//---------------------------------------------------------------------
$c->new_tab('content6', 'open');
$c->add_tab_heading('' . __('Exclude (by many ways) form protection:','wccp_pro_translation_slug') . '');
	$c->new_row('open');
	    $c->add_label(__("Exclude by user type:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('','open');
			$c->new_controls_row('open');
				$options_array = get_role_names();
				$c->add_select2_multiselection('exclude_by_user_type' , $options_array , '');
			$c->new_controls_row('close');
		$c->new_controls_container('','close');
		$c->add_help_container(__("Use this option if you want to allow copy/paste for admins and editors",'wccp_pro_translation_slug'));
	$c->new_row('close');	
	
	
	$c->new_row('open');
	    $c->add_label(__("URL Exclude List (Do not protect these URLs):",'wccp_pro_translation_slug'));
	    $c->new_controls_container('url_exclude_list', 'open');
			$bottom_hint = "<span>Example: https://www.mysite.com/mypage.html</span><p><span>Note: This option will not work when opposite mode is active</span>";
			$c->add_textarea_with_modall('url_exclude_list', __('Exclude list','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint, '');
		$c->new_controls_container('','close');
	    $c->add_help_container(__("Please enter URL's line by line
		<P>To use bulk exclusion please put /* at the end of any URL
		<p>Example: mysite.com/cart/*",'wccp_pro_translation_slug'));
	$c->new_row('close');

    $c->new_row('open');
        $c->add_label(__("Exclude by post type:",'wccp_pro_translation_slug'));
        $c->new_controls_container('','open');
        $c->new_controls_row('open');
            $options_array = array();
			$options_array = wccp_pro_list_all_public_post_types();
            $c->add_select2_multiselection('exclude_by_post_type' , $options_array , '');
        $c->new_controls_row('close');
        $c->new_controls_container('','close');
        $c->add_help_container(__("Use this option to Exclude by post type",'wccp_pro_translation_slug'));
    $c->new_row('close');
	
	 $c->new_row('open');
        $c->add_label(__("Exclude by category:",'wccp_pro_translation_slug'));
        $c->new_controls_container('','open');
        $c->new_controls_row('open');
            $terms = get_terms( array(
				'taxonomy' => 'category',
				'orderby'    => 'count',
                'hide_empty' => true,
            ) );
            $options_array = array();
            foreach( $terms  as $term ) {
                $options_array[] = array($term->term_id,$term->name);
        
            }
            $c->add_select2_multiselection('exclude_by_category' , $options_array , '');
        $c->new_controls_row('close');
        $c->new_controls_container('','close');
        $c->add_help_container(__("Use this option to Exclude by post type",'wccp_pro_translation_slug'));
    $c->new_row('close');
	
	$c->new_row('open');
	    $c->add_label(__("Exclude registered images sizes from watermarking:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('exclude_registered_images_sizes_container','open');
			$c->new_controls_row('open');
				$options_array = get_registered_images_sizes();
				$c->add_select2_multiselection('exclude_registered_images_sizes' , $options_array , '150x150,100x100');
			$c->new_controls_row('close');
		$c->new_controls_container('','close');
		$c->add_help_container(__("This feature depends on image names, not real image sizes, if the size of the image is not a part of its name, it will be watermarked",'wccp_pro_translation_slug'));
	$c->new_row('close');
	
	$c->new_row('open');
	    $c->add_label(__("Exclude images by name & size (manually) from watermarking:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('excluded_images_from_watermarking', 'open');
			$bottom_hint = "Example: logo.png, my-image.jpg, background.png, 300x300, 150x150";
			$c->add_textarea('excluded_images_from_watermarking', __('Exclude list','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint, 'logo,background,150x150');
		$c->new_controls_container('','close');
	    $c->add_help_container(__("Write excluded images names or some parts of names with comma separated<p><b>Note:</b>The image name is enough to exclude it without its full URL</p>",'wccp_pro_translation_slug'));
	$c->new_row('close');
	
	$c->new_row('open');
	    $c->add_label(__("Selection exclude by class name:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('selection_exclude_classes', 'open');
			$bottom_hint = "Example: class1";
			$c->add_textarea('selection_exclude_classes', __('Exclude list','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint, '');
		$c->new_controls_container('','close');
	    $c->add_help_container(__("Write excluded calsses from selection line by line<p><b>Note:</b> This type of exclusion has some special rules</p>",'wccp_pro_translation_slug'));
	$c->new_row('close');
	
	$c->new_row('open');
	    $c->add_label(__("Exclude online services:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('bots_exclude', 'open');
			$bottom_hint = "Example: googlebot";
			$c->add_textarea('exclude_online_services', __('Exclude list','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint, '');
		$c->new_controls_container('','close');
	    $c->add_help_container(__("Write excluded service domains or agents, even SE's bots line by line",'wccp_pro_translation_slug'));
	$c->new_row('close');

$c->new_tab('', 'close');
//---------------------------------------------------------------------
//Custom Settings
//---------------------------------------------------------------------
$c->new_tab('content7', 'open');
$c->add_tab_heading('' . __('Custom Settings:','wccp_pro_translation_slug') . '');

	$c->new_row('open');
        $c->add_label(__('Cookies & GDPR:','wccp_pro_translation_slug'));
        $c->new_controls_container('gdpr_notice_for_cookies', 'open');
	        echo '<div class="col-8 notice">';
			echo '<p>Our plugin use cookies to manage watermarking exclusions, This type of cookie does not need any user consent as its specified as technical cookies</p>';
			echo '<p>Its not nessesary to notify your users about this usage, our cookie called <b>wccp_pro_functionality</b></p>';
			echo '<p>To read more about this, please <a href="https://www.wp-buy.com/privacy-policy/general-data-protection-regulation-gdpr/">click here</a></p>';
			echo '</div>';
			$c->add_checkbox('do_not_use_cookies' , __('Dont use cookies','wccp_pro_translation_slug') , '', '');
		$c->new_controls_container('','close');
	$c->add_help_container(__('Checking this option will prevent our plugin from managing watermark exclusions correctly'));
    $c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
        $c->add_label(__('Opposite mode:','wccp_pro_translation_slug'));
        $c->new_controls_container('opposite_mode', 'open');
	        $options_array = array('Active','Inactive');
	        $default_value = 'Inactive';
	        $c->add_dropdown('opposite_mode', $options_array, $default_value);
		$c->new_controls_container('','close');
	$c->add_help_container(__('With this mode active, Protection will be applied just on the below special URL\'s','wccp_pro_translation_slug'));
    $c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("URL included list (Just protect these URLs):",'wccp_pro_translation_slug'));
	    $c->new_controls_container('url_included_list', 'open');
			$bottom_hint = "Example: https://www.mysite.com/mypage.html";
			$c->add_textarea_with_modall('url_included_list', __('URL protected list','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint, '');
			//$c->add_textarea('url_included_list', __('URL protected list','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint, '');
		$c->new_controls_container('','close');
	    $c->add_help_container(__("Please enter URL's line by line
		<P>To use bulk inclusion please put /* at the end of any URL
		<p>Example: mysite.com/cart/*",'wccp_pro_translation_slug'));
	$c->new_row('close');
	echo'
	<script>
		function wccp_pro_enable_disable(id)
		{
			var value = jQuery(id).val();
				if(value == "Inactive")
				{
					jQuery("#url_included_list").attr("readonly", "true");
				}
				else
				{
					jQuery("#url_included_list").removeAttr("readonly");
				}
		}
		jQuery(function() {
			wccp_pro_enable_disable("#opposite_mode");
			jQuery("#opposite_mode").change(function() {
				wccp_pro_enable_disable("#opposite_mode");
			});
		});
	</script>
	';
	$c->new_row('open');
        $c->add_label(__('Show the plugin icon in the top admin bar:','wccp_pro_translation_slug'));
        $c->new_controls_container('plugin-icon-top-admin-bar', 'open');
	        $options_array = array('Yes','No');
	        $default_value = 'Yes';
	        $c->add_dropdown('show_admin_bar_icon', $options_array, $default_value);
		$c->new_controls_container('','close');
	$c->add_help_container(__('Used for going to plugin settings page fast','wccp_pro_translation_slug','wccp_pro_translation_slug'));
    $c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
        $c->add_label(__('Developer Mode:', 'wccp_pro_translation_slug'));
        $c->new_controls_container('developer-mode', 'open');
	        $options_array = array('Yes','No');
	        $default_value = 'No';
	        $c->add_dropdown('developer_mode', $options_array, $default_value);
		$c->new_controls_container('','close');
	$c->add_help_container(__('Allow this mode when you decide to contact the developer for support, This will output some data using browser console','wccp_pro_translation_slug'));
    $c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
	    $c->add_label(__("Add custom CSS code:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('custom_css_code_container', 'open');
			$bottom_hint = '';
			$default_value = __("<style>/* Start your code after this line */\n \n/* End your code before this line */</style>",'wccp_pro_translation_slug');
			$c->add_textarea('custom_css_code', __('Insert your custom code here','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint , $default_value);
		$c->new_controls_container('','close');
	    $c->add_help_container('');
	$c->new_row('close');
$c->new_tab('', 'close');


//---------------------------------------------------------------------
//beta Settings
//---------------------------------------------------------------------
$c->new_tab('content8', 'open');
$c->add_tab_heading('' . __('Beta Options','wccp_pro_translation_slug') . '');

	$c->new_row('open');
        $c->add_label(__('Developer Tools Killer:','wccp_pro_translation_slug'));
        $c->new_controls_container('gdpr_notice_for_cookies', 'open');
	        echo '<div class="col-8 notice">';
			echo '<p>Our plugin can prevent & kill developer tools when it opened, This option is limited and can be defeated by some tricks</p>';
			echo '<p>We know these tricks but can\'t do anything towards them</p>';
			echo '<p>By using this new feature, you agree that this feature cannot stop developer tools at all</p>';
			echo '</div>';
			$c->add_checkbox('kill_devlop_tools' , __('Kill developer tools','wccp_pro_translation_slug') , '', '');
		$c->new_controls_container('','close');
	$c->add_help_container(__('Choose this option to kill chrome & firefox developer tools console','wccp_pro_translation_slug'));
    $c->new_row('close');
	$c->add_line();
	
	$c->new_row('open');
        $c->add_label(__('Browsers Extensions Killer:','wccp_pro_translation_slug'));
        $c->new_controls_container('gdpr_notice_for_cookies', 'open');
	        echo '<div class="col-8 notice">';
			echo '<p>This killer can defeat a lot of browser extensions that allow users to copy/paste from your website</p>';
			echo '<p>Not all of them, but the most major ones are killed once activated</p>';
			echo '<p>Note: Browsers extensions have special merit in executing their code, and if they are powerful and smart enough, they can possibly crack our plugin\'s protection.</p>';
			echo '</div>';
			$c->add_checkbox('kill_browsers_extensions' , __('Kill browser extensions','wccp_pro_translation_slug') , '', '');
		$c->new_controls_container('','close');
	$c->add_help_container(__('Choose this option to kill chrome & firefox copy/paste extensions','wccp_pro_translation_slug'));
    $c->new_row('close');
	
	$c->new_row('open');
	    $c->add_label(__("Exclude CSS/JS files: comma separated",'wccp_pro_translation_slug'));
	    $c->new_controls_container('css_js_exclude', 'open');
			$bottom_hint = "Example: custom-design.css";
			$c->add_textarea('exclude_css_js_files', __('Exclude list (comma separated)','wccp_pro_translation_slug'), 'col-md-10 col-xs-12',$bottom_hint, '');
		$c->new_controls_container('','close');
	    $c->add_help_container(__("Use this feature to prevent some files from disrupting the look or functionality of our control panel. This feature only works when you are inside our plugin control panel.<p>Note: don't use this feature if you can see the plugin options without any problem",'wccp_pro_translation_slug'));
	$c->new_row('close');
	
	$c->add_line();
$c->new_tab('', 'close');
//---------------------------------------------------------------------
//About tab
//---------------------------------------------------------------------
$c->new_tab('content9', 'open');
$c->add_tab_heading('' . __('Contact US','wccp_pro_translation_slug') . '');
	$c->new_row('open');
	    $c->add_label(__("Getting Support:",'wccp_pro_translation_slug'));
	    $c->new_controls_container('Getting-Support', 'open');
			echo '<div class="col">';
			include "admin_help.php";
			echo "</div>";
		$c->new_controls_container('','close');
	$c->new_row('close');

$c->new_tab('', 'close');

//-----------------------------------------------------------
//load_print_page_preventer_script into located css file
//-----------------------------------------------------------
function wpcp_pro_load_print_page_preventer_script(string $msg = '')
{
	if($msg != '')
	{
		$script_content[] = <<<EOT
		@media print {
			body * { display: none !important;}
			body:after {
				content: "$msg"; }
			}
EOT;
		
		$wccp_free_css_file = plugin_dir_path( __FILE__ ).'/css/print-protection.css';
	
		wpcp_pro_write_to_file_with_markers($wccp_free_css_file, 'CLEAR_FILE_CONTENTS', '');//This will always clear the old scripts
		
		return wpcp_pro_write_to_file_with_markers($wccp_free_css_file, 'wpcp_print_page_preventer_script', (array) $script_content);
	}
}

$new_css_js_files_version_num = 0;

$new_css_js_files_version_num = $c->wccp_pro_get_setting("css_js_files_version_num");

$new_css_js_files_version_num = (int)$new_css_js_files_version_num + 1;

$c->add_hidden_input("css_js_files_version_num", $new_css_js_files_version_num);

$c->add_hidden_input("major_update_done_for_v", "16.8");//this will save the hidden input if the form submitted
?>

</div><!-- tab_container div end -->
</div>
<div style="width:98%;" class="">
<div class="row justify-content-end form-btns">
	<div class=""><input type="submit" class="btn btn-secondary" value="Restore defaults" style="width: 193;" name="Restore_defaults"></div>
	<div class=""><input type="button" class="btn btn-primary" alt="Use CTRL+F5 after saving" onclick="show_admin_wccp_pro_message('This is a preview message (do not forget to save changes)');" value="Preview alert message" style="width: 193;" name="B5"></div>
	<div class=""><input class="btn btn-success" type="submit" value="   Save Settings   " name="Save_settings" style="width: 193;"></div>
</div>
</div>
</form>
</div>
<style>
.form-btns .btn{
	width:180px !important;
	margin-right: 5px;
	float: right;
}
@media (max-width: 415px)
{
	.form-btns .btn
	{
	width:250px !important;
	}
	.row{
		display: block !important;
	}
	.col{
		display: table !important;
		padding-left: 8px;
	}
	.tab_container_label_tabs
	{
		width: 10%;
	}
	.tab_container_label_tabs span{
		width: max-content;
	}
}
@media (min-width: 416px) and (max-width: 575.98px)
{
	.form-btns .btn
	{
	width:390px !important;
	}
}
@media (min-width: 576px) and (min-width: 768px)
{
	.form-btns .btn
	{
	width:180px !important;
	margin-right: 5px;
	}
}

.help-container-text{
	border-color: #dddddd3b;;
    border-radius: 3px;
    min-height: 54px;
    padding: 5px;
    font-family: tahoma;
    font-size: 11px;
}
.help-container-text p {
    font-family: tahoma;
    font-size: 11px;
}
.help-container-text > span {
    display: table-cell !important;
    height: 44px;
    vertical-align: middle;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #c1c1c100;
}
.help-container-text > span:hover {
    opacity: 1;
    border: 1px solid #c1c1c1;
    transition: 1s;
    transition-property: opacity;
}
.align-items-center:hover .help-container-text > span{
	opacity: 1;
    border: 1px solid #c1c1c1;
    transition: 1s;
    transition-property: opacity;
}
.welling {
		margin-top: 15px;
		padding-left: 15px;
		width: inherit;
	}
	hr{display:none;}
	.controls_container{
		margin-top: 6px;
	}
@media (max-width: 768px)
{
	.help-container
	{
		display: none !important;
	}
	
}
@media screen and (max-width: 782px){.wp-picker-container input[type=text].wp-color-picker{width:80px;padding:6px 5px 5px;font-size:16px;line-height:18px}.wp-customizer .wp-picker-container input[type=text].wp-color-picker{padding:5px 5px 4px}.wp-picker-container .wp-color-result.button{height:auto;padding:0 0 0 40px;font-size:14px;line-height:29px}.wp-customizer .wp-picker-container .wp-color-result.button{font-size:13px;line-height:26px}.wp-picker-container .wp-color-result-text{padding:0 14px;font-size:inherit;line-height:inherit}.wp-customizer .wp-picker-container .wp-color-result-text{padding:0 10px}}
</style>
<?php
$exclude_css_js_files_list = "";

$exclude_css_js_files_list = $c->wccp_pro_get_setting("exclude_css_js_files");
?>
<script>
window.addEventListener('load', function (){
	if(window.Zepto || !window.jQuery) jQuery =  $;
	jQuery(document).ready(function(){
	  var changeWidth = function(){
		if ( jQuery(window).width() < 575.98 ){
		jQuery('.form-btns').removeClass('justify-content-end').addClass('justify-content-center');
		} else {
		  jQuery('.form-btns').removeClass('justify-content-center').addClass('justify-content-end');
		}
	  };
	  jQuery(window).resize(changeWidth);
	});
});
<?php if($exclude_css_js_files_list != ""){ ?>
//Remove unwanted header css files after page load
window.addEventListener('load', function (){
	if(window.Zepto || !window.jQuery) jQuery =  $;
	jQuery(document).ready(function()
	{
		jQuery("link,script,style").each(function()
		{
			str = jQuery(this).attr("href") + " " + jQuery(this).attr("id");
			if (str != "" && typeof str != 'undefined'){
				if(str.includes("<?php echo $exclude_css_js_files_list; ?>"))
				{
					jQuery(this).remove();
				}
			}
		});
	});
});
<?php } ?>
</script>
<div class="msgmsg-box-wpcp warning-wpcp hideme" id="wpcp-error-message"><b>Alert: </b>Content selection is disabled!!</div>


<style>
	#wpcp-error-message {
	    direction: ltr;
	    text-align: center;
	    transition: opacity 900ms ease 0s;
	    z-index: 99999999;
	}
	.hideme {
    	opacity:0;
    	visibility: hidden;
	}
	.showme {
    	opacity:1;
    	visibility: visible;
	}
	.enable-me{
		
	}
	.disable-me{
	
	}
	.msgmsg-box-wpcp {
		border-radius: 10px;
		color: <?php echo $c -> wccp_pro_get_setting("font_color");?>;
		font-family: Tahoma;
		font-size: <?php echo $c -> wccp_pro_get_setting("msg_font_size");?>;
		margin: 10px;
		padding: 10px 36px;
		position: fixed;
		width: 255px;
		top: 50%;
  		left: 50%;
  		margin-top: -10px;
  		margin-left: -130px;
  		-webkit-box-shadow: 0px 0px 34px 2px <?php echo $c -> wccp_pro_get_setting("shadow_color");?>;
		-moz-box-shadow: 0px 0px 34px 2px <?php echo $c -> wccp_pro_get_setting("shadow_color");?>;
		box-shadow: 0px 0px 34px 2px <?php echo $c -> wccp_pro_get_setting("shadow_color");?>;
	}
	.msgmsg-box-wpcp span {
		font-weight:bold;
		text-transform:uppercase;
	}
	.error-wpcp {<?php global $pluginsurl; ?>
		background:#ffecec url('<?php echo $pluginsurl ?>/images/error.png') no-repeat 10px 50%;
		border:1px solid #f5aca6;
	}
	.success {
		background:#e9ffd9 url('<?php echo $pluginsurl ?>/images/success.png') no-repeat 10px 50%;
		border:1px solid #a6ca8a;
	}
	.warning-wpcp {
		background:<?php echo $c -> wccp_pro_get_setting("msg_color");?> url('<?php echo $pluginsurl ?>/images/warning.png') no-repeat 10px 50%;
		border:1px solid <?php echo $c -> wccp_pro_get_setting("shadow_color");?>;
	}
	<?php if(is_rtl()){ ?>
		.tab_container_label_tabs {float: right !important;}
	<?php } ?>
</style>
<?php
//---------------------------------------------------------------------
//Check if watermark directory is created & writable or not
//---------------------------------------------------------------------
function wccp_pro_check_watermark_dir_can_cache()
{
	$upload_dir = wp_upload_dir();

	$basedir = $upload_dir['basedir'];  //   /home3/server-folder/sitefoldername.com/wp-content/uploads

	$cachedir = $basedir. '/wccp_pro_watermarked_images';
		
	$can_cache = false;

	if($cachedir !== false AND is_dir($cachedir) AND is_writable($cachedir))
		{
			$can_cache = true;
		}
	if (!$can_cache) $can_cache = create_watermarked_images_directory();

	return $can_cache;
}
//---------------------------------------------------------------------
//php delete function that deals with directories recursively
//---------------------------------------------------------------------
function wccp_pro_delete_watermarked_cached_images($cachedir) {
    
	$upload_dir = wp_upload_dir();

	$basedir = $upload_dir['basedir'];  //   /home3/server-folder/sitefoldername.com/wp-content/uploads

	if (!isset($cachedir) || $cachedir == '') $cachedir = $basedir. '/wccp_pro_watermarked_images/';
	
	$can_delete_cache = false;

	if($cachedir !== false AND is_dir($cachedir) AND is_writable($cachedir))
		{
			$can_delete_cache = true;
		}
	if($can_delete_cache){
        
		$files = glob( $cachedir . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file )
		{
            if(is_file($file)){
				unlink($file);
			  }
        }
        //rmdir( $cachedir );
    }
}

//---------------------------------------------------------------------
//php renew the old css file with new one based on new css settings
//---------------------------------------------------------------------
function wpcp_pro_renew_css_code_file()
{
	$css_content[] = <<<EOT
	*:not(input):not(textarea):not(text):not([contenteditable="true"]):not([contenteditable="true"] *):not([contenteditable]):not([contenteditable] *):not(code):not(code *):not(codeblock_wccp):not(codeblock_wccp *),
	*::after,
	*::backdrop,
	*::before,
	*::cue,
	*::marker,
	*::placeholder
	{
		/*-webkit-touch-callout: none;*/
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		-webkit-user-select: none;
	}

	/* 1. Apply transparent background to ALL selections */
	::selection,
	::-moz-selection {
		background: transparent;
		color: inherit; /* Optional: ensures selected text color remains the same */
	}

	/* 2. Override the rule for the specific elements you want to have a default/visible selection */
	/* Note: You must apply a specific background color here, as the browser default is now overridden by step 1. */
	input::selection,
	input::-moz-selection,
	textarea::selection,
	textarea::-moz-selection,
	[contenteditable="true"]::selection,
	[contenteditable="true"]::-moz-selection,
	[contenteditable]::selection,
	[contenteditable]::-moz-selection,
	code::selection,
	code::-moz-selection {
		/* Use a standard selection color, e.g., browser default blue/gray */
		background: #b3d4fc; /* A common light blue selection color */
		color: #000000; /* Ensure selected text is visible */
	}


	.cover-container {
		   border: 1px solid #DDDDDD;
		   width: 100%;
		   height: 100%;
		   position: relative;
		}
	.glass-cover {
	   float: left;
	   position: relative;
	   left: 0px;
	   top: 0px;
	   z-index: 1000;
	   background-color: #92AD40;
	   padding: 5px;
	   color: #FFFFFF;
	   font-weight: bold;
	}
	.unselectable
	{
	-moz-user-select:none;
	-webkit-user-select:none;
	-khtml-user-select: none;
	user-select: none;
	cursor: default;
	}
EOT;
	
	$wccp_pro_css_file = plugin_dir_path( __FILE__ ).'/css/css-protect.css';
	
	wpcp_pro_write_to_file_with_markers($wccp_pro_css_file, 'CLEAR_FILE_CONTENTS', '');//This will always clear the old scripts
	
	return wpcp_pro_write_to_file_with_markers($wccp_pro_css_file, 'css-protection script', (array) $css_content);
}
?>

