<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$pluginsurl = plugins_url( '', __FILE__ );

function wccp_pro_Watermark_by_JS($wccp_pro_settings)
{return;
	$pluginsurl = plugins_url( '', __FILE__ );
	?>
	<script src="<?php echo $pluginsurl ?>/js/watermark.js"></script>

	<script>
	  window.addEventListener('load', function() {
		Watermark.applyAll('img', { opacity: 0.92, spacing: 6 });
		// or a specific element:
		// Watermark.apply(document.getElementById('photo'));
	  });
	</script>
<?php
}
function wccp_pro_disable_Right_Click($wccp_pro_settings)
{
?>
<script id="wccp_pro_disable_Right_Click">

	function wccp_pro_nocontext(e)
	{
		wccp_pro_log_to_console_if_allowed("wccp_pro_nocontext function");
		
		const caller = wccp_pro_nocontext.caller;
		
		if (caller) wccp_pro_log_to_console_if_allowed("Caller function is: " + caller.name);
		
		e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement
		
		if (apply_class_exclusion(e) == 'Yes') return true;
		
		var exception_tags = 'NOTAG,';
		
		var clickedTag = (e==null) ? event.srcElement.tagName : e.target.tagName;
		
		wccp_pro_log_to_console_if_allowed("clickedTag: " + clickedTag);
		
		var target = e.target || e.srcElement;
		
		var parent_tag = ""; var parent_of_parent_tag = "";
		
		if(target.parentElement != null)
		{
			parent_tag = target.parentElement.tagName;
			
			if(target.parentElement.parentElement != null) parent_of_parent_tag = target.parentElement.parentElement.tagName;
		}
		
		var checker = '<?php echo $wccp_pro_settings['img'];?>';
		if ((clickedTag == "IMG" || clickedTag == "FIGURE" || clickedTag == "SVG" || clickedTag == "PROTECTEDIMGDIV") && checker == 'checked') {
			if (alertMsg_IMG != "")show_wccp_pro_message(alertMsg_IMG);
			return false;
		}else {exception_tags = exception_tags + 'IMG,';}
		
		checker = '<?php echo $wccp_pro_settings['videos'];?>';
		if ((clickedTag == "VIDEO" || clickedTag == "PROTECTEDWCCPVIDEO" || clickedTag == "EMBED") && checker == 'checked') {
			if (alertMsg_VIDEO != "")show_wccp_pro_message(alertMsg_VIDEO);
			return false;
		}else {exception_tags = exception_tags + 'VIDEO,PROTECTEDWCCPVIDEO,EMBED,';}
		
		checker = '<?php echo $wccp_pro_settings['a'];?>';
		if ((clickedTag == "A" || clickedTag == "TIME" || parent_tag == "A" || parent_of_parent_tag == "A") && checker == 'checked') {
			if (alertMsg_A != "")show_wccp_pro_message(alertMsg_A);
			return false;
		}else {exception_tags = exception_tags + 'A,';if(parent_tag == "A" || parent_of_parent_tag == "A") clickedTag = "A";}

		checker = '<?php echo $wccp_pro_settings['pb'];?>';
		if ((clickedTag == "P" || clickedTag == "B" || clickedTag == "FONT" ||  clickedTag == "LI" || clickedTag == "UL" || clickedTag == "STRONG" || clickedTag == "OL" || clickedTag == "BLOCKQUOTE" || clickedTag == "TH" || clickedTag == "TR" || clickedTag == "TD" || clickedTag == "SPAN" || clickedTag == "EM" || clickedTag == "SMALL" || clickedTag == "I" || clickedTag == "BUTTON") && checker == 'checked') {
			if (alertMsg_PB != "")show_wccp_pro_message(alertMsg_PB);
			return false;
		}else {exception_tags = exception_tags + 'P,B,FONT,LI,UL,STRONG,OL,BLOCKQUOTE,TD,SPAN,EM,SMALL,I,BUTTON,';}
		
		checker = '<?php echo $wccp_pro_settings['input'];?>';
		if ((clickedTag == "INPUT" || clickedTag == "PASSWORD") && checker == 'checked') {
			if (alertMsg_INPUT != "")show_wccp_pro_message(alertMsg_INPUT);
			return false;
		}else {exception_tags = exception_tags + 'INPUT,PASSWORD,';}
		
		checker = '<?php echo $wccp_pro_settings['h'];?>';
		if ((clickedTag == "H1" || clickedTag == "H2" || clickedTag == "H3" || clickedTag == "H4" || clickedTag == "H5" || clickedTag == "H6" || clickedTag == "ASIDE" || clickedTag == "NAV") && checker == 'checked') {
			if (alertMsg_H != "")show_wccp_pro_message(alertMsg_H);
			return false;
		}else {exception_tags = exception_tags + 'H1,H2,H3,H4,H5,H6,';}
		
		checker = '<?php echo $wccp_pro_settings['textarea'];?>';
		if (clickedTag == "TEXTAREA" && checker == 'checked') {
			if (alertMsg_TEXTAREA != "")show_wccp_pro_message(alertMsg_TEXTAREA);
			return false;
		}else {exception_tags = exception_tags + 'TEXTAREA,';}
		
		checker = '<?php echo $wccp_pro_settings['emptyspaces'];?>';
		if ((clickedTag == "DIV" || clickedTag == "BODY" || clickedTag == "HTML" || clickedTag == "ARTICLE" || clickedTag == "SECTION" || clickedTag == "NAV" || clickedTag == "HEADER" || clickedTag == "FOOTER") && checker == 'checked') {
			if (alertMsg_EmptySpaces != "")show_wccp_pro_message(alertMsg_EmptySpaces);
			return false;
		}
		else
		{
			if (exception_tags.indexOf(clickedTag)!=-1)
			{
				return true;
			}
			else
			return false;
		}
	}
	
	function disable_drag_images(e)
	{return;
		wccp_pro_log_to_console_if_allowed("disable_drag_images");
		
		var e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement
		
		var target = e.target || e.srcElement;
		
		//For contenteditable tags
		if (apply_class_exclusion(e) == "Yes") return true;

		var elemtype = e.target.nodeName;
		
		if (elemtype != "IMG") {return;}
		
		elemtype = elemtype.toUpperCase();
		
		var disable_drag_drop_images = '<?php echo $wccp_pro_settings['drag_drop_images'];?>';
		
		if (disable_drag_drop_images != "checked")  return true;
		
		if (window.location.href.indexOf("/user/") > -1) {
		  return true; //To allow users to drag & drop images when editing thier profiles
		}
		
		show_wccp_pro_message(alertMsg_IMG);
		
		return false;
	}
	
	var alertMsg_IMG = "<?php echo addslashes($wccp_pro_settings['alert_msg_img']);?>";
	var alertMsg_A = "<?php echo addslashes($wccp_pro_settings['alert_msg_a']);?>";
	var alertMsg_PB = "<?php echo addslashes($wccp_pro_settings['alert_msg_pb']);?>";
	var alertMsg_INPUT = "<?php echo addslashes($wccp_pro_settings['alert_msg_input']);?>";
	var alertMsg_H = "<?php echo addslashes($wccp_pro_settings['alert_msg_h']);?>";
	var alertMsg_TEXTAREA = "<?php echo addslashes($wccp_pro_settings['alert_msg_textarea']);?>";
	var alertMsg_EmptySpaces = "<?php echo addslashes($wccp_pro_settings['alert_msg_emptyspaces']);?>";
	var alertMsg_VIDEO = "<?php echo addslashes($wccp_pro_settings['alert_msg_videos']);?>";
	//document.oncontextmenu=null;
	window.addEventListener('load', function (){
	if(window.Zepto || !window.jQuery) jQuery =  $;
	jQuery(document).ready(function(){
		jQuery(document).on('contextmenu', wccp_pro_nocontext);
	});
	});
	window.addEventListener('load', function (){
	if (typeof jQuery === 'undefined')
	{
		alert("no jquery");
		document.oncontextmenu = wccp_pro_nocontext;
		document.addEventListener("contextmenu",wccp_pro_nocontext);
		window.addEventListener("contextmenu",wccp_pro_nocontext);
	}
	});
</script>
	
<?php if(isset($wccp_pro_settings['drag_drop_images']) && $wccp_pro_settings['drag_drop_images'] == "checked"){?>
	<script id="wccp_pro_disable_drag_images">
	document.ondragstart = disable_drag_images;
		window.addEventListener('load', function (){
			if(window.Zepto || !window.jQuery) jQuery =  $;
			jQuery(document).ready(function(){
				jQuery('img').each(function() {
					jQuery(this).attr('draggable', false);
				});
			});
		});
	</script>
	<style id="wccp_pro_style1">
		img{
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
			-khtml-user-select: none;
			user-select: none;
			-webkit-user-drag: none;
		}
	</style>
<?php } ?>
<?php
}?>
<?php
///////////////////////////////////////////////////////////
function wccp_pro_disable_prntscr_key($wccp_pro_settings)
{
	?>
	<script id="wccp_pro_disable_prntscr_key">
	/*js detect when page is out of focus*/
	jQuery(window).blur(function(){
	  wccp_pro_visibilitychange("start");
	});
	jQuery(window).focus(function(){
	  wccp_pro_visibilitychange("stop");
	});
	
	var wccp_pro_Interval;
	
	function wccp_pro_visibilitychange(action = "stop")
	{
		wccp_pro_log_to_console_if_allowed("wccp_pro_visibilitychange" + action);
		
		if(action == "start" && wccp_pro_Interval != "")
			wccp_pro_Interval = setInterval(show_wccp_pro_message, 2000);
		if(action == "stop")
			clearInterval(wccp_pro_Interval);
	}
	
	//window.addEventListener("keyup", dealWithPrintScrKey, false);
	//document.onkeyup = dealWithPrintScrKey;
	
	function dealWithPrintScrKey(e)
	{
		wccp_pro_log_to_console_if_allowed("dealWithPrintScrKey");
		
		e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement
		
		// gets called when any of the keyboard events are overheard
		var prtsc = e.keyCode||e.charCode;

		if (prtsc == 44)
		{
			copyTextToClipboard("no");
			show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
		}
	}
	</script>
<?php
}
///////////////////////////////////////////////////////////
function wccp_pro_disable_selection_footer($wccp_pro_settings)
{	
	echo '<style id="wccp_pro_style2" data-asas-style="">

	
	*[contenteditable] , [contenteditable] *,*[contenteditable="true"] , [contenteditable="true"] * { /* for contenteditable tags*/ , /* for tags inside contenteditable tags*/
	  -webkit-user-select: auto !important;
	  cursor: text !important;
	  user-select: text !important;
	  pointer-events: auto !important;
	}
	
	/*
	*[contenteditable]::selection, [contenteditable] *::selection, [contenteditable="true"]::selection, [contenteditable="true"] *::selection { background: Highlight !important; color: HighlightText !important;}
	*[contenteditable]::-moz-selection, [contenteditable="true"] *::-moz-selection { background: Highlight !important; color: HighlightText !important;}
	input::selection,textarea::selection, code::selection, code > *::selection { background: Highlight !important; color: HighlightText !important;}
	input::-moz-selection,textarea::-moz-selection, code::-moz-selection, code > *::-moz-selection { background: Highlight !important; color: HighlightText !important;}
	*/
	a{ cursor: pointer ; pointer-events: auto !important;}

	</style>';
	
	$contenteditable_inputs = 'TEXT,TEXTAREA,input[type="text"]';
	
	if($wccp_pro_settings['allow_sel_on_code_blocks'] == 'checked') $contenteditable_inputs = 'TEXT,TEXTAREA,input[type="text"],CODE';
		
	echo "<style>" . $contenteditable_inputs . " " . "{cursor: text !important; user-select: text !important;}</style>";
	
	$contenteditable_inputs_selection = str_replace(",", "::selection, ", $contenteditable_inputs);
	
	//echo "<style>" . $contenteditable_inputs_selection . "::selection{background-color: #338FFF !important; color: #fff !important;}</style>";
	
	$selection_exclude_classes = get_selection_exclude_classes($wccp_pro_settings);
	
	if($selection_exclude_classes != "")
	{
		$selection_exclude_classes2 = str_replace(",", ", .", $selection_exclude_classes);
		
		echo "<style> ." . $selection_exclude_classes2 . " " . "{cursor: text !important; user-select: text !important;}</style>";
		
		$selection_exclude_classes3 = str_replace(",", "::selection, .", $selection_exclude_classes);
		
		echo "<style> ." . $selection_exclude_classes3 . "::selection{background-color: #338FFF !important; color: #fff !important;}</style>";
		
		//Loop here to create a full string of selection_exclude_classes2 with all tags seperated by commas
		$tags_array = array("body" , "div" , "p" , "span" , "h1" , "h2" , "h3" , "h4" , "h5", "a");
		
		foreach($tags_array as $tag_name)
		{
			$selection_exclude_classes2 = str_replace(",", " > $tag_name ,.", $selection_exclude_classes);
		
			echo "<style> ." . $selection_exclude_classes2 . " > $tag_name" . "{cursor: text !important; user-select: text !important;}</style>";
			
			$selection_exclude_classes3 = str_replace(",", " $tag_name::selection, .", $selection_exclude_classes);
			
			echo "<style> ." . $selection_exclude_classes3 . " $tag_name::selection{background-color: #338FFF !important; color: #fff !important;}</style>";
		}
	}
}
///////////////////////////////////////////////////////////
function wccp_pro_disable_hot_keys($wccp_pro_settings)
{
?>
<script id="wccp_pro_disable_hot_keys">
/*****************For contenteditable tags***************/
var wccp_pro_iscontenteditable_flag = false;

function wccp_pro_iscontenteditable(e)
{
	var e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement
  	
	var target = e.target || e.srcElement;
	
	var iscontenteditable = "false";
		
	if(typeof target.getAttribute!="undefined" )
	{
		iscontenteditable = target.getAttribute("contenteditable"); // Return true or false as string
		
		if(typeof target.hasAttribute!="undefined")
		{
			if(target.hasAttribute("contenteditable"))
				iscontenteditable = true;
		}
	}
	
	wccp_pro_log_to_console_if_allowed("iscontenteditable:" + iscontenteditable);
	
	var iscontenteditable2 = false;
	
	if(typeof target.isContentEditable!="undefined" ) iscontenteditable2 = target.isContentEditable; // Return true or false as boolean

	if(target.parentElement !=null) iscontenteditable2 = target.parentElement.isContentEditable;
	
	if (iscontenteditable == "true" || iscontenteditable == true || iscontenteditable2 == true)
	{
		if(typeof target.style!="undefined" ) target.style.cursor = "text";
		
		wccp_pro_iscontenteditable_flag = true;
		
		wccp_pro_log_to_console_if_allowed("wccp_pro_iscontenteditable: true");
		
		return true;
	}
	wccp_pro_log_to_console_if_allowed("wccp_pro_iscontenteditable: false");
}
/******************************************************/
function wccp_pro_clear_any_selection()
{
	if(window.wccp_pro_iscontenteditable_flag == true) return;
	
	wccp_pro_log_to_console_if_allowed("wccp_pro_clear_any_selection");
	
	var myName = wccp_pro_clear_any_selection.caller.toString();
	
	myName = myName.substr('function '.length);
	
	myName = myName.substr(0, myName.indexOf('('));

	wccp_pro_log_to_console_if_allowed("called_by: " + myName);
	
	if (window.getSelection)
	{
		if (window.getSelection().empty)
		{  // Chrome
			window.getSelection().empty();
		} else if (window.getSelection().removeAllRanges) 
		{  // Firefox
			window.getSelection().removeAllRanges();
		}
	} else if (document.selection)
	{  // IE?
		document.selection.empty();
	}
	
	//show_wccp_pro_message("You are not allowed to make this operation");
}

<?php if($wccp_pro_settings['show_copy_button_for_code_blocks'] == 'checked')
{
	$text_over_copy_button = "Select to Copy";
	
	if(array_key_exists("text_over_copy_button" ,$wccp_pro_settings) && $wccp_pro_settings['text_over_copy_button'] != "")
	{
		$text_over_copy_button = $wccp_pro_settings['text_over_copy_button'];
	}
?>
/*select all code on doubleclick*/
window.addEventListener('load', function (){
	if(window.Zepto || !window.jQuery) jQuery =  $;
	jQuery(document).ready(function() {
		jQuery("pre:has(code)").wrap('<codeblock_wccp style="display: block; position: relative;height: 100%; width: 100%;"></codeblock_wccp>');
		jQuery("pre").append('<input disabled class="wccp_pro_copy_code_button" onclick="wccp_pro_copy_data(this)" type="button" value="<?php echo $text_over_copy_button ?>">');
	});
});
document.onselectionchange = disable_enable_copy_button;

function disable_enable_copy_button()
{	
	wccp_pro_log_to_console_if_allowed("disable_enable_copy_button ");
	
	var sel = getSelectionTextAndContainerElement();
	
	// Get the element with id="myDIV" (a div), then get all elements inside div with class="example"
	var target_button = current_clicked_object.querySelectorAll(".wccp_pro_copy_code_button"); 
	
	if (sel.text == null || sel.text == "") 
	{
		jQuery(".wccp_pro_copy_code_button").prop('disabled', 'true');
		
		jQuery(".wccp_pro_copy_code_button").prop("value", "<?php echo $text_over_copy_button ?>");
	}else
	{
		let wccp_node_Name = getSelectionParentElement().nodeName;
		
		wccp_pro_log_to_console_if_allowed("disable_enable_copy_button " + wccp_node_Name);
		
		let isUCBrowser = navigator.userAgent.indexOf('UCBrowser') >= 0;
		
		if(isUCBrowser) wccp_pro_clear_any_selection();
		
		//if(is_content_editable_element(wccp_node_Name) == false && window.wccp_pro_iscontenteditable_flag == false && isUCBrowser) {wccp_pro_clear_any_selection(); return;}
		
		jQuery(target_button[0]).removeAttr('disabled');
		
		jQuery(target_button[0]).prop('value', '  Copy  ');
		
		//var result = jQuery(getSelectionParentElement().nodeName).closest(".wccp_pro_copy_code_button").prop('value', '  Copy 3  ');
		
		// console.log(result);
	}
}

async function wccp_pro_copy_data(e)
{
	wccp_pro_log_to_console_if_allowed("wccp_pro_copy_data");
	
	var sel = getSelectionTextAndContainerElement();

	copyTextToClipboard(sel.text)
	
	e.value = " Copied! ";
	
	await sleep(2 * 1000);
	
	e.value = " Copy ";
}
<?php } ?>

<?php if($wccp_pro_settings['allow_sel_on_code_blocks'] == 'checked')
{ ?>
window.addEventListener('load', function (){
if(window.Zepto || !window.jQuery) jQuery =  $;
jQuery(document).ready(function() {
    /* select all code on doubleclick */
    jQuery('code').dblclick(function()
	{
        wccp_pro_log_to_console_if_allowed("jQuery_code_dblclick: ");
		
		jQuery(this).select();

        var text = this,
            range, selection;

        if (document.body.createTextRange) {
            range = document.body.createTextRange();
            range.moveToElementText(text);
            range.select();
        } else if (window.getSelection) {
            selection = window.getSelection();
            range = document.createRange();
            range.selectNodeContents(text);
            selection.removeAllRanges();
            selection.addRange(range);
        }
    });
});
});
<?php } ?>
/*Is content_editable element*/
function is_content_editable_element(element_name = "")
{
	if (element_name == "TEXT" || element_name == "#TEXT" || element_name == "TEXTAREA" || element_name == "INPUT" || element_name == "PASSWORD" || element_name == "SELECT" || element_name == "OPTION" || element_name == "EMBED" || element_name == "CODE" || element_name == "CODEBLOCK_WCCP")
	{
		wccp_pro_log_to_console_if_allowed("is_content_editable_element: true >>" + element_name);
		
		return true;
	}
	wccp_pro_log_to_console_if_allowed("is_content_editable_element: false >>" + element_name);
	
	return false;
}
/*Is selection enabled element*/
/*
function is_selection_enabled_element(element_name = "")
{
	if (is_content_editable_element == true)
	{
		wccp_pro_log_to_console_if_allowed("is_selection_enabled_element: true >>" + element_name);
		
		return true;
	}
	wccp_pro_log_to_console_if_allowed("is_selection_enabled_element: false >>" + element_name);
	
	return false;
}
*/
/*Hot keys function  */
function disable_hot_keys(e)
{
	wccp_pro_log_to_console_if_allowed("disable_hot_keys");
	
	e = e || window.event;
	
	//console.log(e);
	
	if (!e) return;
	
	var key;

		if(window.event)
			  key = window.event.keyCode;     /*IE*/
		else if (e.hasOwnProperty("which")) key = e.which;     /*firefox (97)*/

	wccp_pro_log_to_console_if_allowed("Data:", key);
	
	<?php if($wccp_pro_settings['f12_protection'] == 'checked')/*Case F12*/
	{ ?>
		
		if (key == 123 || (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) )//F12 chrome developer key disable
		{
			show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
			
			return false;
		}
	<?php } ?>
	
	var elemtype = e.target.tagName;
	
	elemtype = elemtype.toUpperCase();
	
	var sel = getSelectionTextAndContainerElement();
	
	if(elemtype == "BODY" && sel.text != "") elemtype = sel.containerElement.tagName; /* no need for it when tag name is BODY, so we get the selected text tag name */

	/*elemtype must be merged by elemtype checker on function disable_copy & disable_copy_ie*/
	if (is_content_editable_element(elemtype) == true)
	{
		elemtype = 'TEXT';
	}
	
	if(wccp_pro_iscontenteditable(e) == true) elemtype = 'TEXT';
	
	<?php if($wccp_pro_settings['prntscr_protection'] == 'checked')/*For any emement type, text elemtype is not excluded here, (prntscr = 44)*/
		{ ?>
	if (key == 44)/*For any emement type, text elemtype is not excluded here, (prntscr (44)*/
		{
			copyTextToClipboard("");
			show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
			return false;
		}<?php } ?>
	
	if (e.ctrlKey || e.metaKey)
	{
		if (elemtype!= 'TEXT' && (key == 97 || key == 99 || key == 120 || key == 26 || key == 43))
		{
			 show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['ctrl_message']);?>');
			 return false;
		}
		if (elemtype!= 'TEXT')
		{
			<?php if($wccp_pro_settings['ctrl_a_protection'] == 'checked')/*Case Ctrl + A 65*/
			{ ?>
			
			if (key == 65)
			{
				show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
				return false;
			}<?php } ?>
			
			<?php if($wccp_pro_settings['ctrl_c_protection'] == 'checked')/*Case Ctrl + C 67*/
			{ ?>
			
			if (key == 67)
			{
				show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
				return false;
			}<?php } ?>
			
			<?php if($wccp_pro_settings['ctrl_x_protection'] == 'checked')/*Case Ctrl + X 88*/
			{ ?>
			
			if (key == 88)
			{
				show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
				return false;
			}<?php } ?>
			
			<?php if($wccp_pro_settings['ctrl_v_protection'] == 'checked')/*Case Ctrl + V 86*/
			{ ?>
			
			if (key == 86)
			{
				show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
				return false;
			}<?php } ?>
		}
		<?php if($wccp_pro_settings['ctrl_u_protection'] == 'checked')/*Case Ctrl + U 85*/
			{ ?>
		
		if (key == 85)
		{
			show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
			return false;
		}<?php } ?>
		
		<?php if($wccp_pro_settings['ctrl_p_protection'] == 'checked')/*For any emement type, text elemtype is not excluded here, Case Ctrl + P 80 */
		{ ?>
		if (key == 80)
		{
			show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
			return false;
		}<?php } ?>
		
		<?php if($wccp_pro_settings['prntscr_protection'] == 'checked')/*For any emement type, text elemtype is not excluded here, (ctrl + prntscr (44)*/
		{ ?>
		if (key == 44)
		{
			copyTextToClipboard("no");
			show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
			return false;
		}<?php } ?>
		
		
		<?php if($wccp_pro_settings['f12_protection'] == 'checked')/*Case (CTRL + Shift + I) to show developer tools*/
		{ ?>
			if (key == 73)//F12 chrome developer key disable
			{
				show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
				return false;
			}
		<?php } ?>
		
		<?php if($wccp_pro_settings['ctrl_s_protection'] == 'checked')/*Case Ctrl + S 83*/
		{ ?>
		
		if (key == 83)
		{
			show_wccp_pro_message('<?php echo addslashes($wccp_pro_settings['custom_keys_message']);?>');
			return false;
		}<?php } ?>
    }
return true;
}


window.addEventListener('load', function (){
	if(window.Zepto || !window.jQuery) jQuery =  $;
	jQuery(document).ready(function() {
	  jQuery(document).bind("keyup keydown", disable_hot_keys);
	});
});

</script>
	<?php
	if($wccp_pro_settings['allow_sel_on_code_blocks'] == 'checked'){ ?>
		<style>
		.wccp_pro_copy_code_button
		{
			line-height: 6px;
			width: auto;
			font-size: 8pt;
			font-family: tahoma;
			margin-top: 1px;
			position:absolute;
			top:0;
			right:0;
			border-radius: 4px;
			opacity: 100%;
		}
		.wccp_pro_copy_code_button:hover
		{
			opacity: 100%;
		}

		.wccp_pro_copy_code_button[disabled]
		{
			opacity: 40%;
		}
		code,pre
		{
			overflow: visible;
		}
		</style>
	<?php } ?>
<?php
}
///////////////////////////////////////////////////////////
function wccp_pro_kill_browser_extentions($wccp_pro_settings)
{	
	if($wccp_pro_settings['kill_browsers_extensions'] != 'checked') return;
	
	?>
	<script id="wccp_pro_clear_body_at_all_for_extentions">
	function clear_body_at_all_for_extentions()
	{
		wccp_pro_log_to_console_if_allowed("clear_body_at_all_for_extentions");
		
		clearInterval(remove_ext_code);
		clearInterval(disable_ext_code);
		jQuery("body").empty();
		div_style = 'style="margin: auto;width: 60%;border: 5px solid #ff0060a3;padding: 10px;"';
		jQuery("body").append('<p>&nbsp;</p><p>&nbsp;</p><div ' + div_style + '><p style="text-align: center;"><b>Warning:</b> Unwanted <u>Copy/Paste</u> extension detected!</p><p style="text-align: center;">Please deactivate it and refresh</p></div>');
	}

	window.addEventListener('load', function (){
		if(window.Zepto || !window.jQuery) jQuery =  $;
		jQuery(document).ready(disable_ext_code);
	});
	function disable_ext_code(){
		wccp_pro_log_to_console_if_allowed("disable_ext_code");
		/*PART-1: check for any extension fingrprint inside HTML */
		var str = "";
		var div_style = "";
		setTimeout(() => {
			  jQuery("script,style").each(function()
				{
					str = jQuery(this).attr("src") + " " + jQuery(this).attr("id");
					if (str != "" && typeof str != 'undefined'){
						if(str.includes("onepmapfbjohnegdmfhndpefjkppbjkm") || str.includes("allow-copy_style")) 
						{
							clear_body_at_all_for_extentions();
						}
					}
				});
			}, 2000);
	}
	setInterval(disable_ext_code,4000);

	function remove_ext_code()
	{
		wccp_pro_log_to_console_if_allowed("remove_ext_code " + jQuery("p").css("user-select").toString().toLowerCase());
		
		const TextSelectionType = jQuery("p").css("user-select").toString().toLowerCase();
		
		if(TextSelectionType == "text" || TextSelectionType == "auto") clear_body_at_all_for_extentions(); /* if selection still! kill the page content at all */
	}
	setInterval(remove_ext_code,1000);

	const ultraPropagation = function(event) {
		
		if (ultraMode.toggle) event.stopPropagation();
	};
	</script>
	<?php
}
///////////////////////////////////////////////////////////
function wccp_pro_disable_dev_tools($wccp_pro_settings)
{

if($wccp_pro_settings['kill_devlop_tools'] != 'checked') return;

$pluginsurl = plugins_url( '', __FILE__ );
?>
<script id="wccp_pro_module" type="module">
import devtools from '<?php echo $pluginsurl ?>/index.js';
function devtools_isOpen()
{
	wccp_pro_log_to_console_if_allowed("devtools_isOpen" + devtools.isOpen);
	
	if(devtools.isOpen)
	{
		clear_body_at_all();
	}
}
var devtools_isOpen_checker = setInterval(devtools_isOpen,1000);

document.addEventListener('visibilitychange', function (event) {
    if (document.hidden) {
        return;
    } else {
		if(devtools.isOpen)
		{
			clear_body_at_all();
		}
    }
});

window.addEventListener('devtoolschange', event => {
	if(devtools.isOpen)
{
	clear_body_at_all();
}
});

function clear_body_at_all()
{
	wccp_pro_log_to_console_if_allowed("clear_body_at_all");
	clearInterval(devtools_isOpen_checker);
	//return;
	localStorage.setItem("wccp_was_desktop_with_div_tools", "yes"); // save yes if im on devtools opened on desktop any time
	jQuery("body").empty();
	var div_style = 'style="margin: auto;width: 60%;border: 5px solid #ff0060a3;padding: 10px;"';
	jQuery("body").append('<p>&nbsp;</p><p>&nbsp;</p><div ' + div_style + '><p style="text-align: center;"><b>Warning:</b> Unwanted <u>Dev Tools Console</u> detected!</p><p style="text-align: center;">Please close it and refresh</p></div>');
}
</script>
<?php
}
///////////////////////////////////////////////////////////
function wccp_pro_disable_selection($wccp_pro_settings)
{
wccp_pro_kill_browser_extentions($wccp_pro_settings); //This function called here because it must used when text selection disabled
?>
<script id="wccp_pro_disable_selection">

var image_save_msg = 'You are not allowed to save images!';

var no_menu_msg = 'Context menu disabled!';

var smessage = "<?php echo $wccp_pro_settings['smessage'];?>";


"use strict";
/* This because search property "includes" does not supported by IE*/
if (!String.prototype.includes) {
String.prototype.includes = function(search, start) {
  if (typeof start !== 'number') {
	start = 0;
  }

  if (start + search.length > this.length) {
	return false;
  } else {
	return this.indexOf(search, start) !== -1;
  }
};
}
/*////////////////////////////////////*/
let canCall = true;

function call_disable_copy_WithDelay(e) {
  if (canCall) {
    canCall = false;
    disable_copy(e);
    setTimeout(() => {
      canCall = true;
    }, 1000);
  }
}

function disable_copy(e)
{
	window.wccp_pro_iscontenteditable_flag = false;
	
	wccp_pro_log_to_console_if_allowed("disable_copy");
	
	var e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement
  	
	var target = e.target || e.srcElement;

	var elemtype = e.target.nodeName;
	
	elemtype = elemtype.toUpperCase();
	
	if (apply_class_exclusion(e) == "Yes") return true;

	if(wccp_pro_iscontenteditable(e) == true) {return true;}
	
	if(is_content_editable_element(current_clicked_element) == true)
	{
		return true;
	}
	else
	{
		if (smessage !== "" && e.detail == 2)
			show_wccp_pro_message(smessage);
		
		if (isSafari)
		{
			return true;
		}
		else
		{
			//wccp_pro_clear_any_selection();
			
			return false;
		}
	}
	
	/*disable context menu when shift + right click is pressed*/
	var shiftPressed = 0;
	
	var evt = e?e:window.event;
	
	if (parseInt(navigator.appVersion)>3) {
		
		if (document.layers && navigator.appName=="Netscape")
			
			shiftPressed = (e.modifiers-0>3);
			
		else
			
			shiftPressed = e.shiftKey;
			
		if (shiftPressed) {
			
			if (smessage !== "") show_wccp_pro_message(smessage);
			
			var isFirefox = typeof InstallTrigger !== 'undefined';   /* Firefox 1.0+ */
			
			if (isFirefox) {
			evt.cancelBubble = true;
			if (evt.stopPropagation) evt.stopPropagation();
			if (evt.preventDefault()) evt.preventDefault();
			show_wccp_pro_message (smessage);
			wccp_pro_clear_any_selection();
			return false;
			}
			
			wccp_pro_clear_any_selection();
			return false;
		}
	}
	
	if(e.which === 2 ){
	var clickedTag_a = (e==null) ? event.srcElement.tagName : e.target.tagName;
	   show_wccp_pro_message(smessage);
       wccp_pro_clear_any_selection(); return false;
    }
	var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
	var checker_IMG = '<?php echo $wccp_pro_settings['img'];?>';
	if (elemtype == "IMG" && checker_IMG == 'checked' && e.detail == 2) {show_wccp_pro_message(alertMsg_IMG);wccp_pro_clear_any_selection();return false;}

    //elemtype must be merged by elemtype checker on function disable_copy & disable_hot_keys
	if (is_content_editable_element(elemtype) == false)
	{
		if (smessage !== "" && e.detail == 2)
			show_wccp_pro_message(smessage);
		
		if (isSafari)
		{
			return true;
		}
		else
		{
			wccp_pro_clear_any_selection(); return false;
		}
	}
	else
	{
		return true;
	}
}
////////////////////////////
function disable_copy_ie()
{
	wccp_pro_log_to_console_if_allowed("disable_copy_ie_function_started");
	
	var e = e || window.event;
	/*also there is no e.target property in IE.*/
	/*instead IE uses window.event.srcElement*/
  	var target = e.target || e.srcElement;
	
	var elemtype = window.event.srcElement.nodeName;
	
	elemtype = elemtype.toUpperCase();

	if(wccp_pro_iscontenteditable(e) == true) return true;
	
	if (apply_class_exclusion(e) == "Yes") return true;
	
	if (elemtype == "IMG") {show_wccp_pro_message(alertMsg_IMG);return false;}
	
	//elemtype must be merged by elemtype checker on function disable_copy & disable_hot_keys
	if (is_content_editable_element(elemtype) == false)
	{
		return false;
	}
}
function disable_drag_text(e)
{
	wccp_pro_log_to_console_if_allowed("disable_drag_text");
	
	/*var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);*/
	/*if (isSafari) {show_wccp_pro_message(alertMsg_IMG);return false;}*/
	
	var e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement*/
  	
	var target = e.target || e.srcElement;
	
	/*For contenteditable tags*/
	
	if (apply_class_exclusion(e) == "Yes") return true;

	var elemtype = e.target.nodeName;
	
	elemtype = elemtype.toUpperCase();
	
	var disable_drag_text_drop = '<?php echo $wccp_pro_settings['drag_drop'];?>';
	
	if (disable_drag_text_drop != "checked")  return true;
	
	if (window.location.href.indexOf("/user/") > -1) {
      return true; /*To allow users to drag & drop images when editing thier profiles*/
    }
	
	return false;
}

/*/////////////////special for safari Start////////////////*/
var onlongtouch;

var timer;

var touchduration = 1000; /*length of time we want the user to touch before we do something*/

var elemtype = "";

function touchstart(e)
{
	wccp_pro_log_to_console_if_allowed("touchstart");
	
	e = e || window.event;// also there is no e.target property in IE. instead IE uses window.event.srcElement
	
	var target = e.target || e.srcElement;

	var elemtype = e.target.nodeName;
	
	elemtype = elemtype.toUpperCase();
	
	//if (elemtype == "A") return;

	if (apply_class_exclusion(elemtype) == 'Yes') return;
	/*also there is no e.target property in IE.*/
	/*instead IE uses window.event.srcElement*/
	
	if(!wccp_pro_is_passive()) e.preventDefault();
	if (!timer) {
		timer = setTimeout(onlongtouch, touchduration);
	}
}

function touchend()
{
	wccp_pro_log_to_console_if_allowed("touchend");
	
    /*stops short touches from firing the event*/
    if (timer) {
        clearTimeout(timer);
        timer = null;
    }
	onlongtouch();
}

onlongtouch = function(e)/*this will clear the current selection if any_not_editable_thing selected*/
{
	wccp_pro_log_to_console_if_allowed("onlongtouch");
	
	if (is_content_editable_element(elemtype) == false)
	{
		if (window.getSelection) {
			if (window.getSelection().empty) { /*Chrome*/
			window.getSelection().empty();
			} else if (window.getSelection().removeAllRanges) {  /*Firefox*/
			window.getSelection().removeAllRanges();
			}
		} else if (document.selection) {  /*IE?*/
			var textRange = document.body.createTextRange();
			textRange.moveToElementText(element);
			textRange.select();

			document.selection.empty();
		}
		return false;
	}
};

document.addEventListener("DOMContentLoaded", function(event)
	{ 
		window.addEventListener("touchstart", touchstart, false);
		window.addEventListener("touchend", touchend, false);
	});


function wccp_pro_is_passive()
{
	wccp_pro_log_to_console_if_allowed("wccp_pro_is_passive");
	
	var cold = false,
	hike = function() {};

	try {
	var aid = Object.defineProperty({}, 'passive', {
	get() {cold = true}
	});
	window.addEventListener('test', hike, aid);
	window.removeEventListener('test', hike, aid);
	} catch (e) {}

	return cold;
}
/*/////////////////////////////////////////////////////////////////*/
function reEnable()
{
	return true;
}

if(navigator.userAgent.indexOf('MSIE')==-1) //If not IE
{
	document.ondragstart = disable_drag_text;
	document.onselectstart = call_disable_copy_WithDelay;
	document.onselectionchange = call_disable_copy_WithDelay;
	//document.onmousedown = disable_copy;
	//document.addEventListener('click', disable_copy, false);
	//document.addEventListener('click', set_current_clicked_element, false);
	document.addEventListener('mousedown', set_current_clicked_element, false);
	//document.onclick = reEnable;
}else
{
	document.onselectstart = disable_copy_ie;
}

var current_clicked_element = "";

var current_clicked_object = null;

function set_current_clicked_element(e)
{
	var e = e || window.event; // also there is no e.target property in IE. instead IE uses window.event.srcElement
  	
	var target = e.target || e.srcElement;

	var elemtype = e.target.nodeName;
	
	elemtype = elemtype.toUpperCase();
	
	current_clicked_element = elemtype;
	
	wccp_pro_log_to_console_if_allowed("current_clicked_element = " + current_clicked_element, arguments.callee.name);
}
</script>
<?php
}
/*//////////////////////////////////////////////////////////*/ ?>
<?php
function wccp_pro_images_overlay($wccp_pro_settings)
{
	global $pluginsurl;
	?>
	<script id="wccp_pro_images_overlay">
	window.addEventListener('load', function (){
		if(window.Zepto || !window.jQuery) jQuery = $;
		
		jQuery(document).ready(function() {

			function applyWccpProtection() {
				jQuery('img').not('.wccp_pro_overlay_protected_img, .wccp_protected').each(function() {
					var $img = jQuery(this);
					$img.addClass('wccp_protected');

					var el = $img[0];
					var imgPos = $img.css('position');
					var isAbsolute = (imgPos === 'absolute' || imgPos === 'fixed');
					var imgDisplay = $img.css('display');
					var displayType = (isAbsolute || imgDisplay === 'block') ? 'grid' : 'inline-grid';

					var $wrapper = jQuery('<div class="wccp-img-wrapper"></div>');

					if (isAbsolute) {
						// For absolutely positioned images, the wrapper must FULLY
						// replace the image in the DOM — taking ALL its positioning
						// properties so the image renders in exactly the same place.
						$wrapper.css({
							'display': displayType,
							'position': imgPos,
							'width': el.style.width || $img.attr('width') ? $img.css('width') : '100%',
							'height': el.style.height || $img.attr('height') ? $img.css('height') : '100%',
							'top': $img.css('top'),
							'bottom': $img.css('bottom'),
							'left': $img.css('left'),
							'right': $img.css('right'),
							'transform': $img.css('transform'),
							'margin': $img.css('margin'),
							'float': $img.css('float'),
							'z-index': $img.css('z-index'),
							'grid-template-areas': '"overlap"',
							'place-items': 'start',
							'padding': '0'
						});

						// Reset image: it now sits INSIDE the wrapper,
						// so remove all the positioning that the wrapper now owns
						$img.css({
							'position': 'relative',
							'top': 'auto',
							'bottom': 'auto',
							'left': 'auto',
							'right': 'auto',
							'transform': 'none',
							'margin': '0',
							'float': 'none',
							'width': '100%',
							'height': '100%',
							'grid-area': 'overlap',
							'pointer-events': 'none',
							'-webkit-user-drag': 'none',
							'user-drag': 'none',
							'min-width': '0',
							'min-height': '0'
						});

					} else {
						// For normal flow images, wrapper is just a relative shell
						$wrapper.css({
							'display': displayType,
							'position': 'relative',
							'width': $img.css('width'),
							'height': $img.css('height'),
							'margin': $img.css('margin'),
							'float': $img.css('float'),
							'flex': $img.css('flex'),
							'z-index': $img.css('z-index'),
							'grid-template-areas': '"overlap"',
							'place-items': 'start',
							'max-width': '100%',
							'padding': '0'
						});

						$img.css({
							'width': '100%',
							'height': '100%',
							'margin': '0',
							'transform': 'none',
							'float': 'none',
							'grid-area': 'overlap',
							'pointer-events': 'none',
							'-webkit-user-drag': 'none',
							'user-drag': 'none',
							'min-width': '0',
							'min-height': '0'
						});
					}

					$img.wrap($wrapper);

					// Overlay: always absolute inside the wrapper, sized to cover it fully
					var $overlay = jQuery('<img class="wccp_pro_overlay_protected_img" src="<?php echo $pluginsurl."/images/transparent.gif";?>" alt="" />');
					
					$overlay.css({
						'position': 'absolute',
						'width': '100%',
						'height': '100%',
						'object-fit': $img.css('object-fit') || 'fill',
						'border-radius': $img.css('border-radius'),
						'margin': '0',
						'padding': '0',
						'z-index': '99',
						'background-color': 'transparent',
						'min-width': '0',
						'min-height': '0'
					});

					$img.after($overlay);
				});
			}

			applyWccpProtection();

			// Re-sync on resize for responsive images
			var resizeTimer;
			window.addEventListener('resize', function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					jQuery('.wccp-img-wrapper').each(function() {
						var $wrapper = jQuery(this);
						var $img = $wrapper.find('img.wccp_protected');
						if ($img.length) {
							var rect = $img[0].getBoundingClientRect();
							$wrapper.css({
								'width': rect.width + 'px',
								'height': rect.height + 'px'
							});
						}
					});
				}, 100);
			});

			var observer = new MutationObserver(function(mutations) {
				var shouldApply = false;
				mutations.forEach(function(mutation) {
					if (mutation.addedNodes && mutation.addedNodes.length > 0) {
						shouldApply = true;
					}
				});
				if (shouldApply) applyWccpProtection();
			});

			observer.observe(document.body, { childList: true, subtree: true });
		});
	});
	
	(function() {
    function startOverlayGuard() {
        var target = document.body || document.documentElement;
        
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.removedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && node.classList.contains('wccp_pro_overlay_protected_img')) {
                        var wrapper = mutation.target;
                        if (wrapper.classList.contains('wccp-img-wrapper')) {
                            var protectedImg = wrapper.querySelector('img.wccp_protected');
                            if (protectedImg) {
                                var overlay = document.createElement('img');
                                overlay.className = 'wccp_pro_overlay_protected_img';
                                overlay.src = node.src;
                                overlay.alt = '';
                                overlay.setAttribute('style', node.getAttribute('style'));
                                protectedImg.insertAdjacentElement('afterend', overlay);
                            }
                        }
                    }
                });
            });
        });

        observer.observe(target, { childList: true, subtree: true });
    }

    if (document.body) {
        startOverlayGuard();
    } else {
        document.addEventListener('DOMContentLoaded', startOverlayGuard);
    }
})();
	</script>
	<script>
	(function() {
    function getScriptContent() {
        var script = document.getElementById('wccp_pro_images_overlay');
        return script ? script.outerHTML : null;
    }

    function restoreScript(originalHTML) {
        var existing = document.getElementById('wccp_pro_images_overlay');
        if (existing) existing.remove();

        var temp = document.createElement('div');
        temp.innerHTML = originalHTML;
        var newScript = temp.firstChild;

        // Re-create as a real executable script
        var executableScript = document.createElement('script');
        executableScript.id = 'wccp_pro_images_overlay';
        executableScript.textContent = newScript.textContent;
        document.head.appendChild(executableScript);
    }

    function startScriptGuard() {
        var target = document.body || document.documentElement;
        var originalHTML = getScriptContent();

        if (!originalHTML) return;

        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {

                // Case 1: script tag was removed
                mutation.removedNodes.forEach(function(node) {
                    if (node.nodeType === 1 && node.id === 'wccp_pro_images_overlay') {
                        restoreScript(originalHTML);
                    }
                });

                // Case 2: script content was modified
                if (
                    mutation.type === 'characterData' &&
                    mutation.target.parentNode &&
                    mutation.target.parentNode.id === 'wccp_pro_images_overlay'
                ) {
                    restoreScript(originalHTML);
                }

                // Case 3: script attributes were modified (e.g. id changed)
                if (
                    mutation.type === 'attributes' &&
                    mutation.target.id === 'wccp_pro_images_overlay'
                ) {
                    restoreScript(originalHTML);
                }

            });
        });

        observer.observe(document.documentElement, {
            childList: true,
            subtree: true,
            attributes: true,
            characterData: true,
            attributeFilter: ['id', 'src', 'type']
        });
    }

    if (document.body) {
        startScriptGuard();
    } else {
        document.addEventListener('DOMContentLoaded', startScriptGuard);
    }
})();
	</script>
	<style id="wccp_pro_style3">
	.wccp-img-wrapper {
		box-sizing: border-box;
		overflow: visible;
	}
	.wccp_pro_overlay_protected_img {
		opacity: 0.00<?php echo $wccp_pro_settings['dw_text_transparency'];?>;
		-webkit-touch-callout: none !important;
		-webkit-user-select: none !important;
		-khtml-user-select: none !important;
		-moz-user-select: none !important;
		-ms-user-select: none !important;
		user-select: none !important;
		-webkit-user-drag: none !important;
		user-drag: none !important;
	}
	</style>
	<?php
}
?>
<?php
function wccp_pro_video_overlay()
{
	?>
	<!--just for video protection -->
	<style id="wccp_pro_style4">
	.pointer_events_none{
		pointer-events: none;
	}
	.pointer_events_auto{
		pointer-events: auto;
	}
	</style>
	<script id="wccp_pro_video_overlay">	
	
	function play_stop_video(ev, period = 1000)
	{
		wccp_pro_log_to_console_if_allowed("play_stop_video");
		
		jQuery('Protectedwccpvideo').addClass("pointer_events_none");
		
		setTimeout(function(){ jQuery('Protectedwccpvideo').removeClass("pointer_events_none"); }, period);
	}
	
	function isEventSupported(eventName)
	{
		wccp_pro_log_to_console_if_allowed("isEventSupported");
		
		var el = document.createElement('div');
		eventName = 'on' + eventName;
		var isSupported = (eventName in el);
		if (!isSupported) {
			el.setAttribute(eventName, 'return;');
			isSupported = typeof el[eventName] == 'function';
		}
		el = null;
		return isSupported;
	}
	window.addEventListener('load', function (){
		if(window.Zepto || !window.jQuery) jQuery =  $;
		jQuery(document).ready(function()
		{
			wccp_pro_log_to_console_if_allowed("wheelEvent");
			
			// Check which wheel event is supported. Don't use both as it would fire each event 
			// in browsers where both events are supported.
			var wheelEvent = isEventSupported('mousewheel') ? 'mousewheel' : 'wheel';

			// bind the event to the desired element
			jQuery('body').on("mousewheel", function(e) {
				var oEvent = e.originalEvent,
					delta  = oEvent.deltaY || oEvent.wheelDelta;
					play_stop_video(this,1000);
			});

			jQuery('iframe').wrap('<div class="video-wrap-div"></div>');
			
			jQuery("iframe").each(function()
			{
				var iframe = jQuery(this);
				var iframeWidth = iframe.width();
				var iframeHeight = iframe.height();
				var newDiv = jQuery('<Protectedwccpvideo onclick="play_stop_video(this,1000)" class="protected_video_class"><div onmousemove="play_stop_video(this,100)" onclick="play_stop_video(this,1000)" class="Protectedwccpvideomiddle_class"></div></Protectedwccpvideo>');

				newDiv.width(iframeWidth);
				newDiv.height(iframeHeight);

				iframe.after(newDiv);
			});
			
			//Allow pdf and doc files
			try {
				jQuery('iframe[src*="officeapps"], iframe[src*="docs"],iframe[src*=".pdf"],iframe[src*=".docx"],iframe[src*=".pptx"]').unwrap('<div class="video-wrap-div"></div>');
			}
			catch(err) {
				//nothing to do
			}
		});
	});
	</script>
	<style id="wccp_pro_style5">
	.video-wrap-div{
		position: relative;
		height: 100%;
		width: 100%;
		min-height: -webkit-fill-available !important;
		min-width: -webkit-fill-available !important;
		min-height: -moz-available !important;
		min-width: -moz-available !important;
	}
	#player-embed{/* special style for some themes for video protection */
		height: 100% !important;
	}
	.Protectedwccpvideomiddle_class {
		background-color: #FF4136;
		width: 70px;
		height: 50px;
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
	}
	.protected_video_class{
		position: absolute;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		display: block;
		z-index: 999;
		border: 1px solid red;
		font-weight: bold;
		opacity: 0.0;
		text-align: center;
		transform: rotate(0deg);
	}
	</style>
	<style id="wccp_pro_style6">
	wccpvideo {
		background: transparent none repeat scroll 0 0;
		border: 2px solid #fff;
	}
	.protectionOverlay{
		background: #fff none repeat scroll 0 0;
		border: 2px solid #fff;
		opacity: 0.0;
	}
	</style>
	<!--just for iphones end -->
	<?php
}
?>