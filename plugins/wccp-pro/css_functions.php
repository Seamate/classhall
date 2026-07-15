<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function wccp_pro_css_script()
{
?>
	<script id="wccp_pro_css_disable_selection">
	function wccp_pro_msieversion() 
		{
			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE");
			var msie2 = ua.indexOf("Edge");
			var msie3 = ua.indexOf("Trident");

		if (msie > -1 || msie2 > -1 || msie3 > -1) // If Internet Explorer, return version number
		{
			return "IE";
		}
		else  // If another browser, return 0
		{
			return "otherbrowser";
		}
	}
    
	var e = document.getElementsByTagName('H1')[0];
	if(e && wccp_pro_msieversion() == "IE")
	{
		e.setAttribute('unselectable',"on");
	}
	</script>
<?php
}
?>
<?php
function wccp_pro_css_inject($wccp_pro_settings)
{
	echo str_replace('\"', '"', $wccp_pro_settings['custom_css_code']);
}
?>