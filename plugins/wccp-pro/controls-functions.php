<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class wccp_pro_controls_class
{
	public $wccp_pro_settings = array();
	
	//---------------------------------------------------------------------
	//constructors
	//---------------------------------------------------------------------
	public function __construct()
	{
        self::wccp_pro_save_settings(false);
		//print_r($wccp_pro_settings);
    }
	
	public function my_set($new_value)
	{
		if(is_array($new_value))
		{
			$this->wccp_pro_settings = array_merge($this->wccp_pro_settings, $new_value);//Set default value for any unexisted key$new_value;
		}
	}
	
	public function my_get()
	{
		return $this->wccp_pro_settings;
	}
	
	//---------------------------------------------------------------------
	//Read and write functions
	//---------------------------------------------------------------------
	public function wccp_pro_save_settings($baypass_nonce = false)
	{
		$wccp_pro_settings = self::get_default_options();
		
		if(!is_array($wccp_pro_settings) || empty($wccp_pro_settings)) $wccp_pro_settings = array();

		if (isset( $_POST['Restore_defaults'] ) && !isset( $_POST['Save_settings'] )) //Restore defaults
		{
			if(!(isset($_POST["make_this_form_verified_nonce"]) && wp_verify_nonce( $_POST[ 'make_this_form_verified_nonce' ], 'make_form_nonce_action' ))) return; //Exit if not verified
			
			self::update_blog_option_single_and_multisite( 'wccp_pro_settings' , self::get_default_options() );
		}
		
		if(isset( $_POST['Save_settings'] )) //Save settings
		{
			if(!(isset($_POST["make_this_form_verified_nonce"]) && wp_verify_nonce( $_POST[ 'make_this_form_verified_nonce' ], 'make_form_nonce_action' ))) return; //Exit if not verified
			
			foreach($wccp_pro_settings as $key => $option_new_value)
			{
				if(array_key_exists($key, $_POST))
				{
					$allowed_html = array(
						'a' => array('href' => array(),),
						'br' => array(),
						'b' => array(),
						'style' => array(),
					);
					//Sanitize the settings when saving them using wp_kses to allow some usefull html tags, just for string values
					if(!is_array($wccp_pro_settings["$key"]))
						$wccp_pro_settings["$key"] = wp_kses($_POST["$key"], $allowed_html);
					else
						$wccp_pro_settings["$key"] = $_POST["$key"];
				}
				else //if (not posted & stored before) then clear it
				{
					$wccp_pro_settings["$key"] = '';
				}
			}

			self::update_blog_option_single_and_multisite( 'wccp_pro_settings' , $wccp_pro_settings );
		}
		
		if($baypass_nonce) //Save settings because there is no settings at all for no reason, just called internally
		{
			$wccp_pro_settings = self::wccp_pro_read_options();

			self::update_blog_option_single_and_multisite( 'wccp_pro_settings' , $wccp_pro_settings );
		}
		
		flush_rewrite_rules();
	}

	public function update_blog_option_single_and_multisite($option,$value)
	{
		//echo debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
		
		if(is_multisite())
		{
			$id = get_current_blog_id();
			update_blog_option($id, $option,$value);
		}
		else
		{
			update_option($option,$value);
		}
	}

	public function get_blog_option_single_and_multisite($option = '')
	{
		$wccp_pro_settings = array();
		
		if(is_multisite())
		{
			$id = get_current_blog_id();
			
			$wccp_pro_settings = get_blog_option($id, $option);
		}
		else
		{
			$wccp_pro_settings = get_option($option);
		}
		
		$page_id = '';
		
		if (isset($_GET['page']))
		{
			$page_id = $_GET['page'];
		}
		if($page_id != 'wccp-options-pro')//show from defaults array just when called from front end
		{
			if (!isset($wccp_pro_settings) || !is_array($wccp_pro_settings)) $wccp_pro_settings = self::get_default_options();
		}
		//echo "called by: " . debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['function'];
		
		return $wccp_pro_settings;
	}
	//---------------------------------------------------------------------
	//Function to get one setting or all settings array from wp options table
	//---------------------------------------------------------------------
	public function wccp_pro_get_setting($name = '')
	{
		$wccp_pro_settings = self::get_blog_option_single_and_multisite('wccp_pro_settings');
		
		if($name == '') return $wccp_pro_settings;
			
		if (is_array($wccp_pro_settings) && array_key_exists($name,$wccp_pro_settings))
		{
			$option_value = $wccp_pro_settings["$name"];
		}
		else
		{
			$option_value = self::get_default_options($name);
		}
		if(is_string($option_value))
			$option_value = stripslashes($option_value);
		
		return $option_value; //This will happen if($name != '')
	}
	//---------------------------------------------------------------------------------------------
	//Function to read options from the database
	//---------------------------------------------------------------------------------------------
	public function get_default_options($name = '')
	{
		$pluginsurl = plugins_url( '', __FILE__ );
		
		$default_dw_logo = $pluginsurl . '/images/testing-logo.png';
		
		$defaults_array = array(
		'css_js_files_version_num' => 1,'major_update_done_for_v' => "16.8",
		'single_posts_protection' => '',"home_page_protection" => '','page_protection' => '',
		'text_protection_by_type' => array('home_page','archive','category','404','author','tag','search','post','page','attachment'),

		'smessage' => '<b>Alert: </b>Content selection is disabled!!','prntscr_protection' => 'checked','drag_drop' => 'checked',
		
		'drag_drop_images' => 'checked',
		
		'ctrl_s_protection' => 'checked','ctrl_a_protection' => 'checked','ctrl_c_protection' => 'checked',
		'ctrl_x_protection' => 'checked','ctrl_v_protection' => 'checked','ctrl_u_protection' => 'checked',
		'ctrl_message' => '<b>Alert:</b> You are not allowed to copy content or view source',
		
		'allow_sel_on_code_blocks' => '','show_copy_button_for_code_blocks' => '','text_over_copy_button' => 'Select To Copy',
		
		'f12_protection' => 'checked','custom_keys_message' => 'You are not allowed to do this action on the current page!!',
		
		'prnt_scr_msg' => 'You are not allowed to print this page!' ,'ctrl_p_protection' => 'checked',
		
		'msg_color' => '#ffecec','font_color' => '#555555',
		'border_color' => '#f5aca6','shadow_color' => '#f2bfbf',
		
		'message_show_time' => 3,'msg_font_size' => '12px',
		
		'right_click_protection_posts' => 'checked','right_click_protection_homepage' => "checked",
		'right_click_protection_pages' => "checked",'img' => "checked",
		
		'right_click_protection_by_type' => array('home_page','archive','category','404','author','tag','tax','search',
		'post','page','attachment'),
		
		'a' => "checked", 'pb' => "checked",'h' => "checked",'textarea' => "checked",
		'input' => "checked", 'emptyspaces' => "checked",'videos' => "",
		
		'alert_msg_img' => "Alert: Protected image", 'alert_msg_a' => "Alert: This link is protected",
		'alert_msg_pb' => "Alert: Right click on text is disabled",
		'alert_msg_h' => "Alert: Right click on headlines is disabled",
		'alert_msg_textarea' => "Alert: Right click is disabled",
		'alert_msg_input' => "Alert: Right click is disabled",
		'alert_msg_emptyspaces' => "Alert: Right click on empty spaces is disabled",
		'alert_msg_videos' => "Alert: Right click on videos is disabled",
		
		'home_css_protection' => "Yes", 'posts_css_protection' => "Yes", 'pages_css_protection' => "Yes",
		
		'custom_css_code' => "<style>/* Start your code after this line */\n \n/* End your code before this line */</style>",
		
		'overlay_protection_by_type' => array(), 'remove_img_urls' => "No", 'no_js_action' => "Nothing",'no_js_action_massage' => "You can not open this website with JS disabled!!",
		
		'watermark_caching' => 'checked','hotlinking_rule' => "No Action", 'mysite_rule' => "No Action",
		
		'force_watermarking_for_non_apache_servers' => "",
		
		'dw_logo' => "$default_dw_logo",'logo_size_over_image' => 27, 'dw_margin_top_factor' => 98,'dw_margin_left_factor' => 98,
		
		'dw_text' => "WATERMARKED", 'dw_font_color' => "#000000",
		'dw_position' => "center-center", 'dw_font_size_factor' => 90, 'dw_r_text' => "www.mywebsite.com",
		'dw_r_font_color' => "#efefef", 'dw_r_font_size_factor' => 55, 'dw_text_transparency' => 65, 'dw_rotation' => 40,
		'dw_imagefilter' => "None", 'dw_signature' => "This image is protected",
		
		'url_exclude_list' =>"","exclude_registered_images_sizes"=>array("150x150"),
		"excluded_images_from_watermarking"=>"logo,150x150",'selection_exclude_classes' =>"", 'exclude_online_services' =>"",
		"url_included_list" => "","do_not_use_cookies" => "", "opposite_mode" => "Inactive",
		'exclude_by_user_type' => array(),'exclude_by_post_type' => array(),'exclude_by_category' => array(),
		
		'show_admin_bar_icon' => "Yes",'developer_mode' => "No", 'kill_devlop_tools' => "", 'kill_browsers_extensions' => "", 'exclude_css_js_files' => "");
		
		//if can find default value inside the ubove defaults array
		if($name != '' && array_key_exists($name ,$defaults_array))
		{
			return $defaults_array[$name];
		}//if cant find default value inside the ubove defaults array
		else if($name != '' && !array_key_exists($name ,$defaults_array))
		{
			return null;
		}//if want to return all defaults array
		else return $defaults_array;
	}
	//---------------------------------------------------------------------------------------------
	//Function to read options from the database
	//---------------------------------------------------------------------------------------------
	public function wccp_pro_read_options()
	{
		$wccp_pro_settings = self::get_blog_option_single_and_multisite('wccp_pro_settings');
		
		if(!is_array($wccp_pro_settings)) $wccp_pro_settings = array();
		
		$defaults_array = self::get_default_options();

		if(is_array($wccp_pro_settings))
		{
			foreach ($wccp_pro_settings as $key=>$value)
			{
				if(is_string($value))$wccp_pro_settings[$key] = stripslashes($value);
				if(is_array($value))$wccp_pro_settings[$key] = $value;
			}
		}
		
		$wccp_pro_settings = array_merge($defaults_array, $wccp_pro_settings);//Set default values for any unexisted keys
		
		return $wccp_pro_settings;

	}
	//---------------------------------------------------------------------
	//Layout builders
	//---------------------------------------------------------------------
	public function new_tab($tab_id, $control_header = '')
	{
		if($control_header == 'open') echo '<section id="' .$tab_id. '" class="tab-content"><!-- Tab Opened -->';
		
		if($control_header == 'close') echo '</section><!-- Tab Closed -->';
	}
	public function add_tab_heading($text)
	{
		echo '<div class="row align-items-center tab_heading_text">'. $text .'</div>';
	}
	public function new_row($control_header = '')
	{
		if($control_header == 'open') echo '<div class="row align-items-center">';
		
		if($control_header == 'close') echo '</div><!-- Row Closed -->';
	}
	public function new_form_group($control_header = '')
	{
		if($control_header == 'open') echo '<!-- Form Group Opened --><div class="col">';
		
		if($control_header == 'close') echo '</div><!-- Form Group Closed -->';
	}
	public function new_controls_row($control_header = '')
	{
		if($control_header == 'open') echo '<div class="row col-12"><!-- Controls_row Opened -->';
		
		if($control_header == 'close') echo '</div><!-- Controls_row Closed -->';
	}

	public function add_label($text)
	{
		echo '<div class="controls_label col-12"><div class="welling"><span>'. $text .'</span></div></div>';
	}
	public function add_inner_label($text)
	{
		echo '<div class="col"><label for="disabledSelect">' . $text . '</label></div>';
	}
	public function new_controls_container($id, $control_header = '')
	{
		if($control_header == 'open'){
			echo '<div id="container_'.$id.'" style="" class="col-md-8 col controls_container">';
			echo '<div class="row d-flex align-items-center">';
		}
		if($control_header == 'close') echo '</div></div>';
	}
	public function add_help_container($text)
	{
	    if($text != ''){
			echo '<div class="col-md-4 col-12 help-container"><div class="help-container-text"><span>'. $text .'</span></div></div><!-- Help container closed -->';
		}
	}
	public function add_line()
	{
	    echo '<hr style="margin-bottom: 5px; margin-top: 5px;">';
	}
	public function add_section($title,$color)
	{
		if($color == '') $color = '#1ABC9C';
		echo '<div class="col-lg-12 section"><h4><strong><font size="3" color="$color">'.$title.'</font></strong></h4></div>';
		
		echo "<style>.col-lg-12.section {
		-moz-border-bottom-colors: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		background: rgba(0, 0, 0, 0) linear-gradient(to right bottom, #f8f8f8, #fff) repeat scroll 0 0;
		border-bottom: 1px solid #f1f1f1;
		border-image: none;
		border-left: 7px solid;
		border-right: 1px solid #f1f1f1;
		color: $color;
		margin: 8px 0;}</style>";
	}
	public function add_empty_col()
	{
		echo '<div class="col"></div>';
	}
	//---------------------------------------------------------------------
	//Function to show a message (alert - success - fail) after saving
	//---------------------------------------------------------------------
	public function save_changes_message()
	{
		echo 'Settings saved successfully';
	}
	//---------------------------------------------------------------------
	//Function to add a  photo behind any control
	//---------------------------------------------------------------------
	public function add_photo_help_container($path, $class)
	{
		$pluginsurl = plugins_url( '', __FILE__ );
		
		$img = '<img id="'.$class.'" border="0" src="'. $pluginsurl .'/'.$path.'">';
		
		echo '<div class="col-md-3 col-5 help-container"><div class=""><span>'. $img .'</span></div></div><!-- Photo container closed -->';
	}
	//---------------------------------------------------------------------
	//Add dropdown control
	//---------------------------------------------------------------------
	public function add_dropdown($name , $options_array , $default_value,$title='')
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		echo '<div id="div_'.$name.'" class="col-md-5 col-xs-12">';
		
		if(!empty($title))
		{
            echo '<div class="framework_small_font">' . $title . '</div>';
        }
		
	    	echo '<div class="styled-select-div">';
			
			echo '<select class="" size="1" id="'.$name.'" name="'.$name.'">'; //form-control select select-primary select-block mbl
	    	
	    	$arrlength = count($options_array);
	    	
	    	for($x = 0; $x < $arrlength; $x++)
	    	{
	    		if ($options_array[$x] == $prev_saved_option_value)
	    		
	    			echo '<option selected>'.$options_array[$x].'</option>';
	    			
	    		else
	    		
	    			echo '<option>'.$options_array[$x].'</option>';
	    	}
	    	
	    	echo '</select>';
	    	
	    	echo '</div>';

		echo '</div>';
	}
	//---------------------------------------------------------------------
	//Add multiselection Select2 with search ability
	//---------------------------------------------------------------------
	public function add_select2_multiselection($name , $options_array , $default_values)
	{
		$prev_saved_option_values = self::wccp_pro_get_setting($name);
		
		if(is_string($prev_saved_option_values)) $prev_saved_option_values = explode(",",$prev_saved_option_values); //Convert options & defaults to array
		
		echo '<div id="div_'.$name.'" class="col-md-10 col-xs-12">';
		
	    	echo '<select id="'.$name.'" name="'.$name.'[]" multiple>';
	    	
	    	$arrlength = count($options_array);
	    	
	    	for($x = 0; $x < $arrlength; $x++)
	    	{
				
				if (in_array($options_array[$x][0], $prev_saved_option_values))
				
	    			echo '<option value="'. $options_array[$x][0] .'" selected>'.$options_array[$x][1].'</option>'; //Real value[0] , Shown value[1] (for translations)
				
	    		else
	    		
	    			echo '<option  value="'. $options_array[$x][0] .'">'.$options_array[$x][1].'</option>'; //Real value[0] , Shown value[1] (for translations)
	    	}
	    	
	    	echo '</select>';

		echo '</div>';
		
		echo '<script>new SlimSelect({select: "#'.$name.'",settings: { closeOnSelect: false,},});</script>';
	}
	//---------------------------------------------------------------------
	//Add multiselection dropdown control
	//---------------------------------------------------------------------
	public function add_botstrap_multiselection_dropdown($name , $options_array , $default_values)
	{
		$prev_saved_option_values = self::wccp_pro_get_setting($name);
		
		if(is_string($prev_saved_option_values)) $prev_saved_option_values = explode(",",$prev_saved_option_values); //Convert options & defaults to array
		
		echo '<div id="div_'.$name.'" class="col-md-6 col-xs-12">';
		
	    	echo '<select class="selectpicker" multiple id="'.$name.'[]" name="'.$name.'[]">';
	    	
	    	$arrlength = count($options_array);
	    	
	    	for($x = 0; $x < $arrlength; $x++)
	    	{
				
				if (in_array(($options_array[$x]), ($prev_saved_option_values)))
				
	    			echo '<option value="'. $options_array[$x] .'" selected>'.$options_array[$x].'</option>';
				
	    		else
	    		
	    			echo '<option  value="'. $options_array[$x] .'">'.$options_array[$x].'</option>';
	    	}
	    	
	    	echo '</select>';

		echo '</div>';
	}
	//---------------------------------------------------------------------
	//Add multiselection dropdown control
	//---------------------------------------------------------------------
	public function add_multiselection_dropdown_old($name , $options_array , $default_value)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		//print_r($prev_saved_option_value);
		
		$values = $prev_saved_option_value;

		foreach ($values as $a){
			
			echo $a;
		}
		
		echo '<div id="div_'.$name.'" class="col-md-5 col-xs-12">';
		
	    	echo '<select class="selectpicker" multiple size="1" id="'.$name.'[]" name="'.$name.'[]">';
	    	
	    	$arrlength = count($options_array);
	    	
	    	for($x = 0; $x < $arrlength; $x++)
	    	{
	    		//if ($options_array[$x] == $prev_saved_option_value)
				
				if (in_array(($options_array[$x]), ($prev_saved_option_value)))
				
	    			echo '<option value="'. $x .'" data-subtext="Heinz1" selected>'.$options_array[$x].'</option>';
				
	    		else
	    		
	    			echo '<option  value="'. $x .'" data-subtext="Heinz">'.$options_array[$x].'</option>';
	    	}
	    	
	    	echo '</select>';

		echo '</div>';
	}
	//---------------------------------------------------------------------
	//add button
	//---------------------------------------------------------------------
	public function add_button($name , $class, $default_value, $disable_after_click, $clicked_message)
	{
		$is_disabled = "";
		
		if ($disable_after_click && isset( $_POST['clear_cached_images'] ) ) 
		{
			$is_disabled = "disabled";
		}
		
		echo "<div style=\"padding-bottom: 5px;\" class=\"$class\">";
		
		echo "<input $is_disabled type=\"submit\" class=\"form-control btn btn-success\" name=\"$name\" id=\"$name\" value=\"$default_value\" style=\"width: auto; height: auto;\">";
		
		if ($clicked_message !='' && isset( $_POST['clear_cached_images'] ) ) 
		{
			echo '<label style="margin: 0; margin-left: 7px; color: green;">'. $clicked_message .'</label>';
		}
		
		echo '</div>';
	}
	//---------------------------------------------------------------------
	//add textbox control
	//---------------------------------------------------------------------
	public function add_textbox($name , $placeholder, $class, $default_value)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		//if($prev_saved_option_value == null) $prev_saved_option_value = $default_value;
		
		echo "<div style=\"padding-bottom: 5px;\" class=\"$class\">";
		
		echo "<input type=\"text\" placeholder=\"$placeholder\" class=\"form-control textbox_custom\" name=\"$name\" id=\"$name\"   value=\"$prev_saved_option_value\" size=\"25\">";
		
		echo '</div>';
	}
	//---------------------------------------------------------------------
	//add bottom hint under any control
	//---------------------------------------------------------------------
	public function add_bottom_hint($bottom_hint)
	{
		echo '<div class="col-md-12 col-xs-12">';
		
		echo '<span class ="bottom_hint_span">' . $bottom_hint . '</span>';
		
		echo '</div>';
	}
	//---------------------------------------------------------------------
	//add textarea
	//---------------------------------------------------------------------
	public function add_textarea($name , $placeholder, $class, $bottom_hint, $default_value)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		echo "<div style=\"padding-bottom: 5px;\" class=\"$class\">";
		
		echo "<textarea placeholder=\"$placeholder\" class=\"form-control textbox_custom\" name=\"$name\" id=\"$name\">$prev_saved_option_value</textarea>";
		
		echo '</div>';
		
		if($bottom_hint != '') echo '<div class="col"><div class="">' . $bottom_hint . '</div></div>';
	}
	//---------------------------------------------------------------------
    //add modall to add link
    //---------------------------------------------------------------------
    public function add_textarea_with_modall($name , $placeholder, $class, $bottom_hint, $default_value)
    {
        $prev_saved_option_value = self::wccp_pro_get_setting($name);

        echo "<div style=\"padding-bottom: 5px;\" class=\"$class\">";

        echo "<textarea placeholder=\"$placeholder\" class=\"form-control add_textarea_with_modall textbox_custom\" name=\"$name\" id=\"$name\">$prev_saved_option_value</textarea>";

        echo '</div>';
        echo '<a class="btn_chow_modal" data-toggle="modal" data-target="#'.$name.'_modal" >';
        echo '<div class="add_link_to_textaraa">';
        echo '</div>';
        echo '</a>';
        echo '<div class="col"><div class="">';

        echo "$bottom_hint";

        echo '</div></div>';
        ?>
        <style>
			.add_textarea_with_modall{
				width: calc(100% - 26px);
				}
            .btn_chow_modal{
                cursor: pointer;
                padding: 20px;
				margin-left: -80px;
				float: right;
            }
            .add_link_to_textaraa{
                background: #666;
                position: relative;
                height: 10px;
                width: 2px;
            }
            .add_link_to_textaraa:after {
                background: #666;
                content: "";
                position: absolute;
                height: 2px;
                width: 10px;
                left: -4px;
                top: 4px;
            }
            .autocomplete {
                position: relative;
                display: inline-block;
            }

            .input{
                border: 1px solid transparent !important;
                background-color: #f1f1f1 !important;
                padding: 10px !important;
                font-size: 16px !important;
                line-height: unset !important;
                border-radius: unset !important;
            }

            .input_text{
                background-color: #f1f1f1 !important;
                width: 100% !important;
            }


            .add_links_modal {
                margin-top: 50px;
            }
            ul.ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {
                z-index: 99999999;
            }
            .add_link_added{
                font-size: 16px;
                color: #0a2c4a;
                font-weight: bolder;
            }
            .add_link_done{
                font-size: 16px;
                color: #0a2c4a;
                font-weight: bolder;
            }
        </style>
        <!-- Modal -->
        <div class="modal fade add_links_modal" id="<?php esc_attr_e($name);?>_modal" tabindex="-1" role="dialog" aria-labelledby="<?php esc_attr_e($name);?>_exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?php esc_attr_e($name);?>_exampleModalLabel"><?php _e("Select URL",'wccp_pro_translation_slug') ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                            <div class="autocomplete" style="width:100%;">
                                <input class="input input_text" id="<?php esc_attr_e($name);?>_input_text_search_post" type="text" name="<?php esc_attr_e($name);?>_myCountry" placeholder="<?php _e("Title",'wccp_pro_translation_slug') ?>">
                            </div>
                        <div id="<?php esc_attr_e($name);?>_add_link_status_done"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            jQuery(function(jQuery) {
                jQuery('#<?php esc_attr_e($name);?>_input_text_search_post').autocomplete({
                    source: function(request, response) {
                        jQuery.ajax({
                            dataType: 'json',
                            url: AutocompleteSearch.ajax_url,
                            data: {
                                term: request.term,
                                action: 'wccp_pro_autocompleteSearch',
                                security: AutocompleteSearch.ajax_nonce,
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },select: function(event, ui) {

                        let txt = jQuery("#<?php esc_attr_e($name);?>");
                        if(txt.val()==''){
                            txt.val( txt.val() + ui.item.link);
                        }else{
                            txt.val( txt.val() +"\n"+ ui.item.link);
                        }
                        setTimeout(function(){
                            jQuery("#<?php esc_attr_e($name);?>_add_link_status_done").html('<span class="add_link_added">Adding .</span>')
                        }, 0);
                        setTimeout(function(){
                            jQuery("#<?php esc_attr_e($name);?>_add_link_status_done").html('<span class="add_link_added">Adding ..</span>')
                        }, 1000);
                        setTimeout(function(){
                            jQuery("#<?php esc_attr_e($name);?>_add_link_status_done").html('<span class="add_link_added">Adding ...</span>')
                        }, 2000);
                        setTimeout(function(){
                            jQuery("#<?php esc_attr_e($name);?>_add_link_status_done").html('<span class="add_link_done">Done !</span>')
                        }, 3000);
                        setTimeout(function(){
                            jQuery("#<?php esc_attr_e($name);?>_add_link_status_done").html('')
                            jQuery("#<?php esc_attr_e($name);?>_input_text_search_post").val("")
                        }, 9000);
                        jQuery("#<?php esc_attr_e($name);?>_input_text_search_post").val("")
                    },minLength: 3,
                }).autocomplete( "instance" )._renderItem = function( ul, item ) {

                    return jQuery( "<li>" )
                        .append( "<div style='font-size: 14px'>" + item.label + "<br><small>" + item.link + "</small></div>" )
                        .appendTo( ul );
                };
            });
        </script>
        <?php
    }
	//---------------------------------------------------------------------
	//add colorpicker control whitch belongs to wordpress
	//---------------------------------------------------------------------
	public function add_colorpicker($name, $behind_text, $default_color)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		echo '<div class="col"><div class="framework_small_font">'.$behind_text.'</div>';
		
		if ($prev_saved_option_value == '') $prev_saved_option_value = $default_color;
		
		echo "<input type=\"color\" name=\"$name\" value=\"$prev_saved_option_value\" class=\"nrcw-colorpicker-field\" data-default-color=\"$default_color\">";
			
			//echo "<input name=\"$name\" type=\"text\" value=\"$prev_saved_option_value\" class=\"nrcw-colorpicker-field\" data-default-color=\"$default_color\" />";
		
		//echo "<style>.wp-picker-input-wrap,.wp-picker-holder{position: absolute;z-index:9999999;background:#ffffff;}</style>";
		
		//echo "<script>jQuery(document).ready(function($){		jQuery('.nrcw-colorpicker-field').wpColorPicker();});</script>";
		
		echo '</div>';
	}
	//---------------------------------------------------------------------
	//add dismissable alert anywhere
	//---------------------------------------------------------------------
	public function add_dismissable_box($name, $behind_text, $default_color)
	{
		//https://premium.wpmudev.org/blog/adding-admin-notices/
	}
	//---------------------------------------------------------------------
	//add Slider control
	//---------------------------------------------------------------------
	public function add_slider($name, $default_value, $min, $max, $factor, $orientation, $show_array)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		if(!array_key_exists('class', $show_array)) $show_array["class"] = 'col';
		
		if(!array_key_exists('label_over_slider', $show_array)) $show_array["label_over_slider"] = '';
		
		echo '<div style="max-width: 230px;" class="col-3">';
			
				if($show_array["label_over_slider"] != 'none')
				{
					echo '<label for="'.$name.'" class="form-label">'. $show_array["label_over_slider"] .'</label>';
				}
				echo '<input type="range" min="'. $min .'" max="'. $max .'" step="1" value="'.$prev_saved_option_value.'" class="sliderr" name="'.$name.'" id="'.$name.'">';
			
			echo '<div class="rounded-circle" style="background:#f1f1f1;text-align:center; display: block; margin-left:7px; width: 27px; float:right;"><span id="span'.$name.'">'.$prev_saved_option_value.'</span></div>';

		echo '</div>';
		
		echo '<script>';
		
			echo 'var range_slider_value_'.$name.' = document.getElementById("'.$name.'");';
			
			echo 'var range_slider_output_tag_'.$name.' = document.getElementById("span'.$name.'");';

			echo 'range_slider_output_tag_'.$name.'.innerHTML = range_slider_value_'.$name.'.value;';

			echo 'range_slider_value_'.$name.'.oninput = function() { range_slider_output_tag_'.$name.'.innerHTML = this.value; }';
			
		echo '</script>';
	}
	
	//////////////////////////////////////
	public function add_slider2($name, $default_value, $min, $max, $factor, $orientation, $show_array)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		$pluginsurl = plugins_url( '', __FILE__ );
		
		if(!array_key_exists('class', $show_array)) $show_array["class"] = 'col-md-4 col-xs-12';
		
		echo '<div class="'. $show_array["class"] .'" style="margin-top: 20px;">';

		echo '<div class="'.$name.'_tooltip"></div><div onmousemove="getslidervalue_'.$name.'();" id="'.$name.'_slider_div"></div>';
		
		echo '</div>';
		
		if ($show_array["counter"] == 1)
		{
			echo '<div class="col-md-1 col-xs-3" style="margin-top: 13px;">';
			
			echo '<input id="'.$name.'" name="'.$name.'" value="'.$prev_saved_option_value.'" readonly type="number" size="5" style="border: 1px solid #FFFFFF; border-radius: 44px;text-align: center;width: 45px;">';
			
			echo '</div>';
		}
		else
		{
			echo '<input hidden id="'.$name.'" name="'.$name.'" value="'.$prev_saved_option_value.'" readonly type="text" size="5" style="border: 1px solid #FFFFFF; border-radius: 44px;text-align: center;width: 45px;">';
		}

		if ($show_array["tansparency_meter"] == 1)
		{
			echo '<div class="col-md-1 col-xs-4" style="margin-top: 12px;">';
			
			$opacity = 1 - ($prev_saved_option_value/$max);
			
			echo '<img border="0" style="opacity: '. $opacity .'" src="'.$pluginsurl.'/framework/images/tansparency_meter.png" id="tansparency_meter_'.$name.'"/>';
			
			echo '</div>';
		}
		
		if (array_key_exists('behind_text', $show_array)) {
			
			if ($show_array["behind_text"] != '')
			{
				echo '<div class="col-md-1 col-xs-4" style="margin-top: 12px;">';
				
					echo $show_array["behind_text"];
				
				echo '</div>';
			}
			$show_array["behind_text"] = '';
		}
		echo'
			<script>var $slider_'.$name.' = jQuery"#'.$name.'_slider_div");
			tooltip = jQuery".'.$name.'_tooltip");
			//tooltip.hide();
			if ($slider_'.$name.'.length > 0) {
			  $slider_'.$name.'.slider({
			    min: '.$min * $factor.',
			    max: '.$max * $factor.',
			    value: '.$prev_saved_option_value * $factor.',
			    orientation: "horizontal",
			    range: "min",
			    start: function(event,ui) {
			          tooltip.fadeIn("fast");
			        },
			
			        stop: function(event,ui) {
			          tooltip.fadeOut("fast");
			        }
			  }).addSliderSegments($slider_'.$name.'.slider("option").max);
			}
			jQuery document ).ready(function() {
			    getslidervalue_'.$name.'();
			});

			function getslidervalue_'.$name.'()
			{
				document.getElementById("'.$name.'").value = parseInt($slider_'.$name.'.slider("option").value/'.$factor.');
				var element = document.getElementById("tansparency_meter_'.$name.'");
				var op = parseInt($slider_'.$name.'.slider("option").value/'.$factor.');
				if(element) element.style.opacity = 1 - (op/'.$max.');
			}
			</script>';
		
		echo '<style>.ui-slider-segment{ display:none !important;}</style>';
	}
	//---------------------------------------------------------------------
	// Function to add a set of photos and select one of them
	//---------------------------------------------------------------------
	public function add_image_picker($name, $settings, $options_array, $folder_path, $default_value)
	{
		//$settings = 'multiple="multiple" data-limit="2"';
		
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		$pluginsurl = plugins_url( '', __FILE__ );
		
		echo '<div class="col" style="margin: 1px 0 -9px;">';
			
		echo '<select '.$settings.' id="'.$name.'" name="'.$name.'" hidden class="image-picker show-html">';
		
		$arrlength = count($options_array[0]);
	    	
	    	for($x = 0; $x < $arrlength; $x++)
	    	{
				$value = $options_array[0][$x];
				
				$title = $options_array[1][$x];
				
	    		if ($value == $prev_saved_option_value)
					
					echo "<option selected data-img-src=\"$pluginsurl/$folder_path/$value.png\" value=\"$value\">$title</option>";
					
	    		else
					
	    			echo "<option data-img-src=\"$pluginsurl/$folder_path/$value.png\" value=\"$value\">$title</option>";
	    	}
		
		echo '</select>';
		
		echo '</div>';

		echo '
			<script>
			jQuery("select.image-picker").imagepicker({
			  hide_select:  false,
			});

			jQuery("select.image-picker.show-labels").imagepicker({
			  hide_select:  false,
			  show_label:   true,
			});

			jQuery("select.image-picker.limit_callback").imagepicker({
			  limit_reached:  function(){alert("We are full!")},
			  hide_select:    false
			});

			var container = jQuery("select.image-picker.masonry").next("ul.thumbnails");
			
		  </script>';
	}
	//---------------------------------------------------------------------
	//add media_uploader control 
	//---------------------------------------------------------------------
	public function add_media_uploader($name, $default_image)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
		
		include 'media_uploader_script.php';
	}
	//---------------------------------------------------------------------
	//add checkbox control 
	//---------------------------------------------------------------------
	public function add_checkbox($name , $behind_text , $default_value, $js_function)
	{
		$prev_saved_option_value = self::wccp_pro_get_setting($name);
				
		if ($prev_saved_option_value != '') $prev_saved_option_value = 'checked=' . $prev_saved_option_value;
		
		echo '<div class="col">';
		
		echo '<div class="custom-control custom-checkbox my-1 mr-sm-2">';
		
		echo '<input type="checkbox" class="custom-control-input" '.$js_function.' id="'.$name.'" name="'.$name.'" value="checked" '.$prev_saved_option_value.'>';

		echo '<label class="custom-control-label framework_small_font" for="'.$name.'">'. $behind_text .'</label>';
		
		echo '</div></div>';

	}
	//---------------------------------------------------------------------
	//add hidden control 
	//---------------------------------------------------------------------
	public function add_hidden_input($name , $new_value)
	{
		echo "<div style=\"padding-bottom: 5px;\">";
		
		echo "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"$new_value\" size=\"25\">";
		
		echo '</div>';
	}
	
}//Class End
?>