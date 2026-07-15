<?php
function rcs_get_attachment_id_from_url($attachment_url){
	global $wpdb;
	$upload_dir_paths = wp_upload_dir();
	if(strpos($attachment_url, $upload_dir_paths['baseurl']) !== false){
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
		
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
		
		$attachment_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM ".$wpdb->posts." wposts, ".$wpdb->postmeta." wpostmeta 
														WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' 
														AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));
														
		return $attachment_id;
	}
	return false;
}

function get_medium_image(){
	$attch_url = (isset($_POST['attch_url']))? $_POST['attch_url'] : '';
	if(!empty($attch_url)){
		$attch_id = rcs_get_attachment_id_from_url(urldecode($attch_url));
		if($attch_id){
			$img = wp_get_attachment_image_src($attch_id, 'medium');
			if(empty($img[0])){
				$img = wp_get_attachment_image_src($attch_id, 'small');
			}
			echo $attch_id.'--++##++--'.$img[0];
		}
	}
	die();
}
add_action('wp_ajax_RCS_GET_MEDIUM_IMG_I', 'get_medium_image');
?>