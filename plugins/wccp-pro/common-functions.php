<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directlys

if(!isset($_SESSION)) 
    { 
        //session_start(); 
    }

$pluginsurl = plugins_url( '', __FILE__ );

////////////////////////////////////////////////////////////////////////

function wccp_pro_remove_img_urls_with_js($wccp_pro_settings)// remove direct links from images
{
	if($wccp_pro_settings["remove_img_urls"] == "Yes")
	{
	?>
		<script>
			window.addEventListener('load', function (){
			if(window.Zepto || !window.jQuery) jQuery =  $;
			jQuery(document).ready(function()
			{
				jQuery("a:has(img)").each(function()
				{
					var attr_href = jQuery(this).attr("href");
					
					if (attr_href.endsWith("jpg") || attr_href.endsWith("png") || attr_href.endsWith("gif") || attr_href.endsWith("webp") || attr_href.endsWith("bmp"))
					{
						jQuery(this).replaceWith(jQuery(this).children());
					}
				});
				
			});
			});
		</script>
	<?php
	}
}
////////////////////////////////////////////////////////////////////////
function get_selection_exclude_classes($wccp_pro_settings)
{
	$selection_exclude_classes = '';

	if ( isset( $wccp_pro_settings['selection_exclude_classes'] ) ) 
	{
		$selection_exclude_classes = $wccp_pro_settings['selection_exclude_classes'];
	}

	// Processes \r\n's first so they aren't converted twice.
	$selection_exclude_classes = str_replace("\\n", "\n", $selection_exclude_classes);

	$selection_exclude_classes = str_replace("\n", ",", $selection_exclude_classes);

	$selection_exclude_classes = str_replace("\r", ",", $selection_exclude_classes);

	$selection_exclude_classes = str_replace("|", ",", $selection_exclude_classes);

	$selection_exclude_classes = str_replace(",,", ",", $selection_exclude_classes);
	
	return $selection_exclude_classes;
}
////////////////////////////////////////////////////////////////////////
function get_role_names() {

global $wp_roles;

if ( ! isset( $wp_roles ) ) $wp_roles = new WP_Roles();

	$available_roles_names = $wp_roles->get_names();//we get all roles names

    $available_roles = array();
	$count = 0;
    foreach ($available_roles_names as $role_key => $role_name)
	{
        $available_roles[$count][0] = strtolower($role_key); //we populate the array of capable roles
		$available_roles[$count][1] = translate_user_role( $role_name );
		$count++;
    }
return $available_roles;
}
////////////////////////////////////////////////////////////////////////
function get_registered_images_sizes() {

	global $_wp_additional_image_sizes; 

	$available_sizes = array();
	$count = 0;
	foreach ($_wp_additional_image_sizes as $size)
	{
		$available_sizes[$count][0] = $size[ 'width' ] . "x" . $size[ 'height' ]; //we populate the array of capable roles
		$available_sizes[$count][1] = $available_sizes[$count][0];
		$count++;
	}
return $available_sizes;
}
////////////////////////////////////////////////////////////////////////
function wccp_pro_global_js_scripts($wccp_pro_settings)
{
	$selection_exclude_classes = get_selection_exclude_classes($wccp_pro_settings);
?>
<script id="wccp_pro_class_exclusion">
function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_wccp_pro_hiddenCopyText_";
    {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }

    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    
	// clear temporary content
	target.textContent = "";
	document.getElementsByTagName('span')[0].innerHTML = " ";
    return succeed;
}
/**************************************************/
function wccp_pro_log_to_console_if_allowed(data = "")
{//return;
	var myName = "";
	
	if(wccp_pro_log_to_console_if_allowed.caller != null) myName = wccp_pro_log_to_console_if_allowed.caller.toString();
	
	myName = myName.substr('function '.length);
	
	myName = myName.substr(0, myName.indexOf('('));
	
	<?php
	if(array_key_exists("developer_mode", $wccp_pro_settings))
	{	
		if($wccp_pro_settings['developer_mode'] == "Yes")
		{
		?>
			if(data != "" ) console.log(data + " ,Called_by: " + myName);
			//if(data != "" ) document.querySelector(".menu-section").innerHTML += "<p>" + data + " ,Called_by: " + myName + "</p>";
		<?php
		}
	}
	?>
}
/**************************************************/
function fallbackCopyTextToClipboard(text) {
  var textArea = document.createElement("textarea");
  textArea.value = text;
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();

  try {
    var successful = document.execCommand("copy");
    var msg = successful ? "successful" : "unsuccessful";
    wccp_pro_log_to_console_if_allowed("Fallback: Copying text command was " + msg);
  } catch (err) {
    console.error("Fallback: Oops, unable to copy", err);
  }

  document.body.removeChild(textArea);
}
/*****************************************/
function copyTextToClipboard(text) {
  if (!navigator.clipboard) {
    fallbackCopyTextToClipboard(text);
    return;
  }
  navigator.clipboard.writeText(text).then(
    function() {
      console.log("Async: Copying to clipboard was successful!");
    },
    function(err) {
      console.error("Async: Could not copy text: ", err);
    }
  );
}
/*****************************************/
/*getSelectionTextAndContainerElement*/
function getSelectionTextAndContainerElement()
{
    var text = "", containerElement = null;
    if (typeof window.getSelection != "undefined") {
        var sel = window.getSelection();
        if (sel.rangeCount) {
            var node = sel.getRangeAt(0).commonAncestorContainer;
            containerElement = node.nodeType == 1 ? node : node.parentNode;
			if (typeof(containerElement.parentElement) != 'undefined') current_clicked_object = containerElement.parentElement;
            text = sel.toString();
        }
    } else if (typeof document.selection != "undefined" && document.selection.type != "Control")
	{
        var textRange = document.selection.createRange();
        containerElement = textRange.parentElement();
        text = textRange.text;
    }
    
	return {
        text: text,
        containerElement: containerElement
    };
}

function getSelectionParentElement() {
    var parentEl = null, sel;
	
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount) {
            parentEl = sel.getRangeAt(0).commonAncestorContainer;
			//sel.getRangeAt(0).startContainer.parentNode;
            if (parentEl.nodeType != 1) {
                parentEl = parentEl.parentNode;
            }
        }
    } else if ( (sel = document.selection) && sel.type != "Control") {
        parentEl = sel.createRange().parentElement();
    }
	
	let arr = new Array();
	
	arr["nodeName"] = "cant_find_parent_element";
	
	if(parentEl != null)
		return parentEl;
	else
		return arr;
}
/*****************************************/
function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
/*****************************************/
</script>

<script id="apply_class_exclusion">
function apply_class_exclusion(e)
{
	wccp_pro_log_to_console_if_allowed(e);
	
	var my_return = 'No';
	
	var e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement
  	
	var target = e.target || e.srcElement || e || 'nothing';
	
	var excluded_classes = '<?php echo $selection_exclude_classes; ?>' + '';
	
	var class_to_exclude = "";
	
	if(target.parentElement != null)
	{
		class_to_exclude = target.className + ' ' + target.parentElement.className || '';
	}else{
		class_to_exclude = target.className;
	}
	
	var class_to_exclude_array = Array();
	
	//console.log(class_to_exclude);
	
	if (typeof(class_to_exclude) != 'undefined') class_to_exclude_array = class_to_exclude.split(" ");
	
	//console.log (class_to_exclude_array);
	
	class_to_exclude_array.forEach(function(item)
	{
		if(item != '' && excluded_classes.indexOf(item)>=0)
		{
			//target.style.cursor = "text";
			
			//console.log ('Yes');
			
			my_return = 'Yes';
		}
	});

	try {
		class_to_exclude = target.parentElement.getAttribute('class') || target.parentElement.className || '';
		}
	catch(err) 
		{
		class_to_exclude = '';
		}
	
	if(class_to_exclude != '' && excluded_classes.indexOf(class_to_exclude)>=0)
	{
		//target.style.cursor = "text";
		my_return = 'Yes';
	}

	return my_return;
}
</script>
<?php
}
?>
<?php
////////////////////////////////////////////////////////////////////////
function wccp_pro_alert_message($wccp_pro_settings)
{
?>
	<script id="wccp_pro_alert_message">
	window.addEventListener('DOMContentLoaded', function() {}); //This line to stop JS deffer function in wp-rockt pluign
	
	window.addEventListener('load', function (){
		// Create the first div element with the "oncontextmenu" attribute
		const wccp_pro_mask = document.createElement('div');
		wccp_pro_mask.setAttribute('oncontextmenu', 'return false;');
		wccp_pro_mask.setAttribute('id', 'wccp_pro_mask');

		// Create the second div element with the "msgmsg-box-wpcp hideme" classes
		const wpcp_error_message = document.createElement('div');
		wpcp_error_message.setAttribute('id', 'wpcp-error-message');
		wpcp_error_message.setAttribute('class', 'msgmsg-box-wpcp hideme');

		// Add a span element with the "error: " text inside the second div
		const error_span = document.createElement('span');
		error_span.innerText = 'error: ';
		wpcp_error_message.appendChild(error_span);

		// Add the error message text inside the second div
		const error_text = document.createTextNode('<?php echo $wccp_pro_settings['smessage'];?>');
		wpcp_error_message.appendChild(error_text);

		// Add the div elements to the document body
		document.body.appendChild(wccp_pro_mask);
		document.body.appendChild(wpcp_error_message);
	});

	var timeout_result;
	function show_wccp_pro_message(smessage="", style="")
	{
		wccp_pro_log_to_console_if_allowed(smessage);
		<?php
		$timeout = $wccp_pro_settings['message_show_time'] * 1000;
		
		if (isset($_GET['page']))
		{
			$admincore = $_GET['page'];
			
			if($admincore == 'wccp-options-pro') $timeout = 4000;
		}
		?>
		
		timeout = <?php echo $timeout;?>;
		
		if(style == "") style = "warning-wpcp";
		
		if (smessage !== "" && timeout!=0)
		{
			var smessage_text = smessage;
			jquery_fadeTo();
			document.getElementById("wpcp-error-message").innerHTML = smessage_text;
			document.getElementById("wpcp-error-message").className = "msgmsg-box-wpcp showme " + style;
			clearTimeout(timeout_result);
			timeout_result = setTimeout(hide_message, timeout);
		}
		else
		{
			clearTimeout(timeout_result);
			timeout_result = setTimeout(hide_message, timeout);
		}
	}
	function hide_message()
	{
		jquery_fadeOut();
		document.getElementById("wpcp-error-message").className = "msgmsg-box-wpcp warning-wpcp hideme";
	}
	function jquery_fadeTo()
	{
		try {
			jQuery("#wccp_pro_mask").fadeTo("slow", 0.3);
		}
		catch(err) {
			//alert(err.message);
			}
	}
	function jquery_fadeOut()
	{
		try {
			jQuery("#wccp_pro_mask").fadeOut( "slow" );
		}
		catch(err) {}
	}
	</script>
	<style>
	#wccp_pro_mask
	{
		position: absolute;
		bottom: 0;
		left: 0;
		position: fixed;
		right: 0;
		top: 0;
		background-color: #000;
		pointer-events: none;
		display: none;
		z-index: 10000;
		animation: 0.5s ease 0s normal none 1 running ngdialog-fadein;
		background: rgba(0, 0, 0, 0.4) none repeat scroll 0 0;
	}
	#wpcp-error-message {
    direction: ltr;
    text-align: center;
    pointer-events: none;
    z-index: 99999999;
	}
	.hideme {
		opacity: 0;
		visibility: hidden;
		transition: opacity 900ms ease-out, visibility 0s linear 900ms;
	}
	.showme {
		opacity: 1;
		visibility: visible;
		transition: none; /* instant when showing */
	}
	.msgmsg-box-wpcp {
		border-radius: 10px;
		color: <?php echo $wccp_pro_settings['font_color'];?>;
		font-family: Tahoma;
		font-size: <?php echo $wccp_pro_settings['msg_font_size'];?>;
		margin: 10px !important;
		padding: 10px 36px !important;
		position: fixed;
		width: 255px;
		top: 50%;
		left: 50%;
		margin-top: -10px !important;
		margin-left: -130px !important;
	}
	.msgmsg-box-wpcp b {
		font-weight:bold;
	}
	<?php global $pluginsurl; ?>
	.warning-wpcp {
		background:<?php echo $wccp_pro_settings['msg_color'];?> url('<?php echo $pluginsurl ?>/images/warning.png') no-repeat 10px 50%;
		border:1px solid <?php echo $wccp_pro_settings['shadow_color'];?>;
		-webkit-box-shadow: 0px 0px 34px 2px <?php echo $wccp_pro_settings['shadow_color'];?>;
		-moz-box-shadow: 0px 0px 34px 2px <?php echo $wccp_pro_settings['shadow_color'];?>;
		box-shadow: 0px 0px 34px 2px <?php echo $wccp_pro_settings['shadow_color'];?>;
	}
	.success-wpcp {
		background: #fafafa url('<?php echo $pluginsurl ?>/images/success.png') no-repeat 10px 50%;
		border: 1px solid #00b38f;
		box-shadow: 0px 0px 34px 2px #adc;
	}
    </style>
<?php
}

////////////////////////////////////////////////////////////////////////
function wccp_admin_pro_Append_Parameters_to_Media_library_Images($wccp_pro_settings)
{
?>
<script>
// Wait for the DOM to be fully loaded
jQuery(document).ready(function() {

  // Define a function to update the image URLs with parameters
  function updateImageUrls() {
    // Select all the images inside the specified div elements
    var images = jQuery('.thumbnail .centered img, .details-image');

    // Loop through each image and append the desired parameters
    images.each(function() {
      var src = jQuery(this).attr('src');
      
      // Check if the URL already contains parameters
      if (src.indexOf('?') === -1) {
        var newSrc = src + '?p1=wccp_pro_watermark_pass' + '&time=' + Date.now();
        jQuery(this).attr('src', newSrc);
      }
    });
  }

  // Call the function every 2 seconds after page load
  setInterval(updateImageUrls, 2000);

});
</script>
<?php
}
////////////////////////////////////////////////////////////////////////
function wccp_admin_pro_alert_message($wccp_pro_settings)
{
?>
<div oncontextmenu="return false;" id='wccp_pro_mask'></div>
<div id="wpcp-error-message" class="msgmsg-box-wpcp hideme"><span>error: </span></div>
<script>
	var timeout_result;
	function show_admin_wccp_pro_message(smessage)
	{


		timeout = jQuery("#message_show_time").val()*1000;

		if (smessage !== "" && timeout!=0)
		{
			var smessage_text = smessage;
			jquery_admin_fadeTo();
			document.getElementById("wpcp-error-message").innerHTML = smessage_text;
			document.getElementById("wpcp-error-message").className = "msgmsg-box-wpcp warning-wpcp showme";
			clearTimeout(timeout_result);
			timeout_result = setTimeout(hide_admin_message, timeout);
		}
		else
		{
			clearTimeout(timeout_result);
			timeout_result = setTimeout(hide_admin_message, timeout);
		}

		jQuery(".msgmsg-box-wpcp").css("color", jQuery("input[name='font_color']").val());
		jQuery(".msgmsg-box-wpcp").css("font-size", jQuery("#msg_font_size").val());
		jQuery(".msgmsg-box-wpcp").css("-webkit-box-shadow", "0px 0px 34px 2px "+jQuery("input[name='shadow_color']").val());
		jQuery(".msgmsg-box-wpcp").css("-moz-box-shadow", "0px 0px 34px 2px "+jQuery("input[name='shadow_color']").val());
		jQuery(".msgmsg-box-wpcp").css("box-shadow", "0px 0px 34px 2px "+jQuery("input[name='shadow_color']").val());

		<?php global $pluginsurl; ?>
		jQuery(".warning-wpcp").css("border", "1px solid "+jQuery("input[name='border_color']").val());
		jQuery(".warning-wpcp").css("background",jQuery("input[name='msg_color']").val() +" url('<?php echo $pluginsurl ?>/images/warning.png') no-repeat 10px 50%");

	}
	function hide_admin_message()
	{
		jquery_admin_fadeOut();
		document.getElementById("wpcp-error-message").className = "msgmsg-box-wpcp warning-wpcp hideme";
	}
	function jquery_admin_fadeTo()
	{
		try {
			jQuery("#wccp_pro_mask").fadeTo("slow", 0.3);
		}
		catch(err) {
			//alert(err.message);
		}
	}
	function jquery_admin_fadeOut()
	{
		try {
			jQuery("#wccp_pro_mask").fadeOut( "slow" );
		}
		catch(err) {}
	}
</script>
<style>
	#wccp_pro_mask
	{
		position: absolute;
		bottom: 0;
		left: 0;
		position: fixed;
		right: 0;
		top: 0;
		background-color: #000;
		pointer-events: none;
		display: none;
		z-index: 10000;
		animation: 0.5s ease 0s normal none 1 running ngdialog-fadein;
		background: rgba(0, 0, 0, 0.4) none repeat scroll 0 0;
	}
	#wpcp-error-message {
		direction: ltr;
		text-align: center;
		transition: opacity 900ms ease 0s;
		pointer-events: none;
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
	.msgmsg-box-wpcp {
		border-radius: 10px;
		font-family: Tahoma;
		margin: 10px;
		padding: 10px 36px;
		position: fixed;
		width: 255px;
		top: 50%;
		left: 50%;
		margin-top: -10px;
		margin-left: -130px;

	}
	.msgmsg-box-wpcp b {
		font-weight:bold;
		text-transform:uppercase;
	}
</style>
<?php
}

function wccp_pro_helper_js_scripts($wccp_pro_settings)
{
	wccp_pro_global_js_scripts($wccp_pro_settings);

	wccp_pro_disable_selection_footer($wccp_pro_settings);

	wccp_pro_alert_message($wccp_pro_settings);
}
?>