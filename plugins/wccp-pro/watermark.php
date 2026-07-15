<?php
// At the start of the script
ob_start();
// Declare global variables
global $watermark_caching, $watermark_type, $watermark_position, $watermark_r_text, $r_font_size_factor, $watermark_text, $watermarking_font_size_factor, $pure_watermark_stamp_image, $margin_left_factor, $margin_top_factor, $logo_size_over_image, $watermark_color, $watermark_r_color, $watermark_transparency, $watermark_rotation, $watermark_imagefilter, $watermark_signature, $home_path, $upload_dir, $baseurl, $wp_content_dir, $wccp_pro_plugin_folder_name, $image, $resized_generated_image, $font_file_array, $watermark_stamp_image, $width, $height, $img_type, $tw, $th, $pure_name, $thumbWidth, $thumbHeight, $watermark_position_x, $watermark_position_y;
//error_log("Contents of \$_SERVER: " . json_encode($_SERVER, JSON_PRETTY_PRINT));exit;
$watermarking_font_size_factor = "90";

include "watermarking-parameters.php";

if ($wccp_pro_plugin_folder_name == "") $wccp_pro_plugin_folder_name = "wccp-pro";// Will remove this line after 16.4 next updates

$font_file_array["english"] = $wp_content_dir . '/plugins/'.$wccp_pro_plugin_folder_name.'/fonts/LiberationSans-Regular.ttf';
$font_file_array["ukrainian"] = $wp_content_dir . '/plugins/'.$wccp_pro_plugin_folder_name.'/fonts/LiberationSans-Regular.ttf';
$font_file_array["arabic"] = $wp_content_dir . '/plugins/'.$wccp_pro_plugin_folder_name.'/fonts/AdobeArabic-Regular.otf';

include "word2uni.php";

//$watermark_caching = "no";
//phpinfo();
if (strpos(@ini_get('disable_functions'), 'set_time_limit') === false) { 
	if(function_exists('set_time_limit'))
	{
		@set_time_limit(60);
	}
}

$url = $_SERVER['HTTP_HOST'];

//$url = ir_get_domain($url);

$pure_src = '';

if (isset($_GET['src'])) $pure_src = $_GET['src'];

if($pure_src == '') exit;

if(isset($_GET['w'])) $watermark_signature = "_"  . $_GET['w']; //just for testing purposes

// Check if the string contains '__enc__'
if (strpos($pure_src, '__enc__') !== false)
{
	$pure_src = str_replace('__enc__', '', $pure_src);
	
	$pure_src = wccp_pro_decrypt_string($pure_src);
}

//error_log($pure_src);

//echo $pure_src; exit;

$http = "http://";

if (wccp_pro_isSSL()) $http = "https://";

$arr = explode("-", $watermark_position);

$watermark_position_x = $arr[1];

$watermark_position_y = $arr[0];

$watermark_stamp_image = $pure_watermark_stamp_image . '?x=wccp_pro_watermark_pass';

$pure_name = str_replace("/", "", $pure_src);

$abs_src = $http . $url . $pure_src . '?x=wccp_pro_watermark_pass';

$abs_src = $baseurl . $pure_src . '?x=wccp_pro_watermark_pass';

$pos = strrpos($pure_src, "."); //Find the position of the last occurrence of a substring in a string

$img_type = substr($pure_src,($pos + 1));

$relative_src = wccp_pro_get_image_relative_path($pure_src ,$wp_content_dir);

//---------------------------------------------------------------------
// Caching code start
//---------------------------------------------------------------------
if($watermark_caching == "checked")
{
	$cachefile = $upload_dir. '/wccp_pro_watermarked_images/'.$pure_name;

	if (file_exists($cachefile) && ! empty($pure_name)) {
		
		if($img_type == 'jpg' || $img_type == 'jpeg')
		{
			header("Content-type: image/jpeg");	 //header("Content-type: text/html");
		}

		if($img_type == 'png')
		{
			header("Content-type: image/png");	//header("Content-type: text/html");
		}
		
		if($img_type == 'webp')
		{
			header("Content-type: image/webp");	 //header("Content-type: text/html");
		}
		
		if($img_type == 'gif')
		{
			header("Content-type: image/gif");	 //header("Content-type: text/html");
		}
		
		readfile($cachefile);
		
		exit;
	}
}
//---------------------------------------------------------------------
// In case if imagecreatefromwebp() not exist, but the image exists
//---------------------------------------------------------------------
if (!file_exists($relative_src) || !is_file($relative_src)) {
        // Input image does not exist or is not a valid file
        //return false;
		$relative_src = 'None';
    }

if($img_type == 'webp' & !function_exists('imagecreatefromwebp') & $relative_src != 'None')
	{
		global $relative_src;
		
		header("Content-type: image/webp");	//header("Content-type: text/html");
		
		readfile($relative_src);
		
		exit;
	}
//---------------------------------------------------------------------
// Caching code end
//---------------------------------------------------------------------

$image = false;

error_reporting(-1);

ini_set('display_errors', 'On');

ini_set('memory_limit', '256M');

gc_enable(); // Enable garbage collection

if($watermark_signature == '' && $watermark_text == '' && $watermark_r_text == '' & $pure_watermark_stamp_image == '')
{
	$watermark_signature = "You have to save changes inside the plugin settings page first";
	
	$watermark_text = 'WATERMARKED';
	
	$watermark_r_text = 'Protected image';
}
if($watermarking_font_size_factor == '') $watermarking_font_size_factor = 80;

if($r_font_size_factor == '') $r_font_size_factor = 50;

if($watermark_transparency == '') $watermark_transparency = 80;

if($watermark_rotation == '') $watermark_rotation = 40;

if($watermark_position_x == '' && $watermark_position_y == '') {$watermark_position_x = "center"; $watermark_position_y = "center";}

try {
	if($img_type == 'jpg' || $img_type == 'jpeg')
	{
		header("Content-type: image/jpeg");	 //header("Content-type: text/html");
		if($relative_src != 'None') $image = imagecreatefromjpeg($relative_src);
		if($image) $image = wccp_pro_normalize_source_image($image, false);
	}

	if($img_type == 'gif')
	{
		header("Content-type: image/gif");	//header("Content-type: text/html");
		
		if($relative_src != 'None')
		{
			$image = imagecreatefromgif($relative_src);
			if($image) $image = wccp_pro_normalize_source_image($image, true);
		}
	}

	if($img_type == 'png')
	{
		header("Content-type: image/png");	//header("Content-type: text/html");
		if($relative_src != 'None')
		{
			$image = imagecreatefrompng($relative_src);
			if($image) $image = wccp_pro_normalize_source_image($image, true);
		}
	}
	
	if($img_type == 'webp' & function_exists('imagecreatefromwebp'))
	{
		header("Content-type: image/png");	//header("Content-type: text/html");
		
		if($relative_src != 'None')
		{
			$image = imagecreatefromwebp($relative_src);
			if($image) $image = wccp_pro_normalize_source_image($image, true);
		}
	}
	
	if($relative_src == 'None') $image = image_create_from_any($abs_src);
	if($image) $image = wccp_pro_normalize_source_image($image, ($img_type == 'png' || $img_type == 'gif' || $img_type == 'webp'));

} catch (Exception $e) {

	$msg_not_found = 'not found ' .  $e->getMessage();
}

$HTTP_ACCEPT_VALUE = '';

if(isset($_SERVER['HTTP_ACCEPT']))
{
	$HTTP_ACCEPT_VALUE = $_SERVER['HTTP_ACCEPT'];
}else
{
	$HTTP_ACCEPT_VALUE = 'html';
}

$H_T = strpos($HTTP_ACCEPT_VALUE, 'html');

if(isset($_SERVER['HTTP_REFERER'])) $referrerurl = $_SERVER['HTTP_REFERER'];

if(isset($referrerurl)){

	$is_google = strpos($referrerurl, 'google.com');

	//Redirected from google preview
	if($is_google && strpos($HTTP_ACCEPT_VALUE, 'html')){

		//$watermark_image = "watermarkgoogle.png";
	}

	//open from direct link
	if($referrerurl == '' && strpos($HTTP_ACCEPT_VALUE, 'html')){

		//$watermark_image = "watermarknorefere.png";
	}

	//preview inside google images search
	if($referrerurl == '' && strpos($HTTP_ACCEPT_VALUE, 'png')){

		//$watermark_image = "watermarkgoogle.png";
	}
}

$tw = false;

if ($image) $tw = @imagesx($image);

if(!$tw || !$image){
	
	//---------------------------------------------------------------------
	// This is what happen when image is not found
	//---------------------------------------------------------------------

    // Size of the font

    $watermarking_fontSize = 14;

    // Height of the image

    $height = 330;

    // Width of the image

    $width = 600;

    // Text

    $msg_not_found = 'Could not get image!';
    //$msg_not_found = $relative_src;

    $img_handle = imagecreate ($width, $height) or die ("Cannot Create image");

    // Set the Background Color RGB

    $backColor = imagecolorallocate($img_handle, 255, 255, 255);

    // Set the Text Color RGB

    $txtColor = imagecolorallocate($img_handle, 20, 92, 137); 

    $textbox = @imagettfbbox($watermarking_fontSize, 0, $font_file_array["english"], $msg_not_found) or die('Error in imagettfbbox function');

    $x = (int)(($width - $textbox[4])/2);

    $y = (int)(($height - $textbox[5])/2);

    imagettftext($img_handle, $watermarking_fontSize, 0, $x, $y, $txtColor, $font_file_array["english"] , $msg_not_found) or die('Error in imagettftext function');

    header('Content-Type: image/jpeg');

    imagejpeg($img_handle,NULL,100);

    if (isset($img_handle) && is_resource($img_handle)) imagedestroy($img_handle);
	
	exit;
}
if($image && $tw)
{
	$th = imagesy($image);

    $thumbWidth = 1900;  ///////here update the width of the hotlinked images//////

    if($tw <= $thumbWidth){

        $thumbWidth = $tw;
    }

    $thumbHeight = $th * ($thumbWidth / $tw);

    $resized_generated_image = imagecreatetruecolor((int)$thumbWidth, (int)$thumbHeight);
		
	if ($img_type == 'png' || $img_type == 'gif' || $img_type == 'webp') {
		imagealphablending($resized_generated_image, false);
		$transparent = imagecolorallocatealpha($resized_generated_image, 0, 0, 0, 127);
		imagefill($resized_generated_image, 0, 0, $transparent);
		imagesavealpha($resized_generated_image, true);
	} else {
		imagealphablending($resized_generated_image, true);
	}
	    
    // Height of the image

    $height = $thumbHeight;

    // Width of the image

    $width = $thumbWidth;
}

if($image && $tw <= 150)
{
	// Apply image new size - resizing
	resize_image();
	
	// Generate the image and view it
	generate_image();
}

if($image && $tw <= 300 && $tw>150)
{
	// Add watermark text
	apply_watermark_text();
	
	// Add Watermark repeated Text function
	apply_watermak_repeated_text();
	
	// Apply image new size - resizing
	resize_image();
	
	// Generate the image and view it
	generate_image();
}


if($image && $tw > 300)
{
	// Apply watermark effect (filter)
	apply_watermak_effect();

	// Apply watermark signature text
	apply_watermak_signature();

	// Add watermark text
	apply_watermark_text();

	// Add Watermark repeated Text function
	apply_watermak_repeated_text();
	
	// Apply watermark logo
	apply_watermark_logo();
	
	// Apply image new size - resizing
	resize_image();
	
	// Generate the image and view it
	generate_image();
}
// Call the function to print variable values

//---------------------------------------------------------------------
// Watermark Effect function
//---------------------------------------------------------------------
function apply_watermak_effect()
{
	global $watermark_imagefilter, $image, $img_type;
	
	if($img_type == 'gif') return;
	
	$watermark_effect = $watermark_imagefilter;
    
    if ($watermark_effect == 'Blur'){
    
		for ($x=1; $x<=25; $x++) imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR); /////////Here control the image Blur Effect/////////WORKING
    }
    
    if ($watermark_effect == 'Grayscale'){
    
		imagefilter($image, IMG_FILTER_GRAYSCALE);  /////////Here control the image GRAYSCALE or Not/////////WORKING
    }
    
    if ($watermark_effect == 'Negate'){
    
    	imagefilter($image, IMG_FILTER_NEGATE);  /////////Negate the image colores عكس ألوان الصورة/////////WORKING
    }
    
    if ($watermark_effect == 'Britness'){
    
    	imagefilter($image, IMG_FILTER_BRIGHTNESS, (-80));  /////////Here control the image britness/////////WORKING
    }
    //////////For more see php.net/manual/en/function.imagefilter.php//////////
}
//---------------------------------------------------------------------
// Watermark Signature function
//---------------------------------------------------------------------
function apply_watermak_signature()
{
	global $watermark_signature, $tw, $th, $watermark_transparency,$resized_generated_image, $font_file_array, $image, $img_type;
	
	if($watermark_signature == '') return;
	
	//if($img_type == 'gif') return; //exit when image type is gif
	
	$height = $th;
	
	$width = $tw;
	
	$signature_text = $watermark_signature;
	
	$signature_text = @text2uni($signature_text);
	
	$font_file = $font_file_array["english"];
	
	if (contains_arabic($signature_text)) { $font_file = $font_file_array["arabic"]; }
	
	$referrerurl = '';

	$transparent_back_top = imagecolorallocatealpha($image, 255, 255, 255, 20);
	
	$transparent_back = imagecolorallocatealpha($image, 255, 255, 255, 70);
	
	$x1 = 0;
	
	$y1 = (int) round($height * .85);
	
	$x2 = (int) round($width);
	
	$y2 = $y1 + (int) round($height/11);
	
	$watermarking_fontSize = (int) round(($height/11)/3);
	
	$back1_height = (int) round(($height/11)/13);
	
	$text_transparency = (int) round($watermark_transparency * 1.27);//number between 0 - 127
		
	$color_ar = html2rgb('#000000');
	
	$txtColor_transparent = imagecolorallocatealpha($resized_generated_image, $color_ar[0], $color_ar[1], $color_ar[2], $text_transparency);
	
	$rotation = 0;//+ values for counter-clockwise rotation
	
	$x = $x1 + 35;
	
	$y = $y2 - $watermarking_fontSize;
	
	if ($img_type == 'gif') {
		// Create a transparent layer for the text
		$temp_image = imagecreatetruecolor($width, $height);
		
		imagesavealpha($temp_image, true);

		// Fill the background with complete transparency
		$transparent_color = imagecolorallocatealpha($temp_image, 0, 0, 0, 127);
		
		imagefill($temp_image, 0, 0, $transparent_color);
		
		$transparent_back_top = imagecolorallocatealpha($temp_image, 255, 255, 255, 20);

		$transparent_back = imagecolorallocatealpha($temp_image, 255, 255, 255, 70);
		
		imagefilledrectangle($temp_image, $x1, $y1-$back1_height, $x2, (int) round($y2-($height/11)), $transparent_back_top);
	
		imagefilledrectangle($temp_image, $x1, $y1, $x2, $y2, $transparent_back);

		// Render the signature text on the transparent layer
		imagettftext($temp_image, (int)$watermarking_fontSize, -$rotation, (int)$x, (int)$y, $txtColor_transparent, $font_file, $signature_text);
		
		// Merge the text layer onto the original image
		imagecopymerge_alpha($image, $temp_image, 0, 0, 0, 0, $width, $height, 100);
		
		// Clean up resources
		if (isset($temp_image) && is_resource($temp_image)) imagedestroy($temp_image);
	}else{
		imagefilledrectangle($image, $x1, $y1-$back1_height, $x2, (int) round($y2-($height/11)), $transparent_back_top);
		
		imagefilledrectangle($image, $x1, $y1, $x2, $y2, $transparent_back);
		
		ImageAlphaBlending($image, true);
		
		imagettftext($image, $watermarking_fontSize, $rotation, $x, $y, $txtColor_transparent, $font_file , $signature_text) or die('Error in imagettftext function'); //the 1st number after fontsize is rotation *******
	}
}
//---------------------------------------------------------------------
// Add Watermark main Text function
//---------------------------------------------------------------------
function apply_watermark_text()
{
    global $watermark_text, $watermark_transparency, $watermark_color, $resized_generated_image, $watermark_rotation, $tw, $th, $font_file_array, $watermarking_font_size_factor, $watermark_position_x, $watermark_position_y, $image, $img_type;

    $height = $th;
    $width = $tw;

    $text_transparency = $watermark_transparency * 1.27; // Convert to alpha transparency (0-127)
    $color_ar = html2rgb($watermark_color); // Convert color from hex to RGB
    $watermarking_fontSize = $height / 8 * $watermarking_font_size_factor / 100;
	$txtColor_transparent = imagecolorallocatealpha($image, $color_ar[0], $color_ar[1], $color_ar[2], (int)$text_transparency);
// Set the text color (RGBA)

    $rotation = $watermark_rotation; // Rotation angle (degrees)
	
	$font_file = $font_file_array["english"];
	
	$watermark_text = @text2uni($watermark_text);
	
	if (contains_arabic($watermark_text)) { $font_file = $font_file_array["arabic"]; }

    // Get text box dimensions
    $textbox = imagettfbbox($watermarking_fontSize, -$rotation, $font_file, $watermark_text) or die('Error in imagettfbbox function');

    // Calculate position
	$x = ($width - $textbox[4]) / 2;
    $y = ($height - $textbox[5]) / 2;
        
    $watermark_text_position_y = $watermark_position_y;
    
    switch ($watermark_text_position_y) {
        case "top":
            $y = ($watermarking_fontSize + $textbox[3]) + $height * 0.02;
            break;
        case "center":
            $y = ($height - $textbox[5]) / 2;
            break;
        case "bottom":
            $y = $height - $watermarking_fontSize / 2 - $height * 0.02;
            break;
    }
    
    $watermark_text_position_x = $watermark_position_x;
    
    switch ($watermark_text_position_x) {
        case "left":
            $x = $textbox[0] + $width * 0.02;
            break;
        case "center":
            $x = ($width - $textbox[4]) / 2;
            break;
        case "right":
            $x = ($width - $textbox[4]) - $width * 0.02;
            break;
    }
	if ($img_type == 'gif') {
		// Create a transparent layer for the text
		$temp_image = imagecreatetruecolor($width, $height);
		imagesavealpha($temp_image, true);

		// Fill the background with complete transparency
		$transparent_color = imagecolorallocatealpha($temp_image, 0, 0, 0, 127);
		imagefill($temp_image, 0, 0, $transparent_color);

		// Allocate text color with transparency
		$txtColor_transparent = imagecolorallocatealpha(
			$temp_image,
			$color_ar[0],
			$color_ar[1],
			$color_ar[2],
			(int)$text_transparency
		);

		// Render the rotated text on the transparent layer
		imagettftext($temp_image, (int)$watermarking_fontSize, -$rotation, (int)$x, (int)$y, $txtColor_transparent, $font_file, $watermark_text);
		
		// Merge the text layer onto the original image
		imagecopymerge_alpha($image, $temp_image, 0, 0, 0, 0, $width, $height, 100);
		
		// Clean up resources
		if (isset($temp_image) && is_resource($temp_image)) imagedestroy($temp_image);
	}else{
		// Non-GIF images: render text directly on the image
        imagettftext($image, (int)$watermarking_fontSize, -$rotation, (int)$x, (int)$y, $txtColor_transparent, $font_file, $watermark_text) or die('Error in imagettftext function');
    }
}

//---------------------------------------------------------------------
// Add Watermark repeated Text function
//---------------------------------------------------------------------
function apply_watermak_repeated_text()
{
    global $watermark_transparency, $resized_generated_image, $watermark_rotation, $watermark_r_text, 
           $watermark_r_color, $tw, $th, $font_file_array, $r_font_size_factor, $image, $img_type;

    // Skip if no text is set
    if (empty($watermark_r_text)) {
        return;
    }

    $height = $th;
    $width = $tw;

    // Pre-calculate values outside the loops
    $text_transparency = (int)($watermark_transparency * 1.27);
    $color_ar = html2rgb($watermark_r_color);
    $rotation = (int)$watermark_rotation;
    $small_fontsize = (int)($height / 25 * $r_font_size_factor / 100);
    
    // Calculate step sizes once
    $width_step = (int)($width * 0.2);
    $height_step = (int)($height * 0.2);
    
    // Get font file once
    $font_file = $font_file_array["english"];
    $watermark_r_text = @text2uni($watermark_r_text);
    if (contains_arabic($watermark_r_text)) {
        $font_file = $font_file_array["arabic"];
    }

    if ($img_type == 'gif') {
        // Create a temporary transparent layer for GIF support
        $temp_image = imagecreatetruecolor($width, $height);
        imagesavealpha($temp_image, true);

        // Fill the background with full transparency
        $transparent_color = imagecolorallocatealpha($temp_image, 0, 0, 0, 127);
        imagefill($temp_image, 0, 0, $transparent_color);

        // Allocate text color with transparency
        $txtColor_transparent = imagecolorallocatealpha(
            $temp_image,
            $color_ar[0],
            $color_ar[1],
            $color_ar[2],
            (int)$text_transparency
        );

		// Calculate step sizes once
		$width_step = (int)($width * 0.2);
		$height_step = (int)($height * 0.2);

        // Render repeated text on the transparent layer
        for ($w = 0; $w < $width; $w += $width_step) {
            for ($h = 0; $h < $height; $h += $height_step) {
                imagettftext($temp_image, (int)$small_fontsize, (int)$rotation, (int)$w, (int)$h, $txtColor_transparent, $font_file, $watermark_r_text)
                    or die('Error in imagettftext function');
            }
        }

        // Merge the text layer onto the original GIF image
        imagecopymerge_alpha($image, $temp_image, 0, 0, 0, 0, $width, $height, 100);

        // Clean up resources
        if (isset($temp_image) && is_resource($temp_image)) imagedestroy($temp_image);
    } else {
        // Non-GIF images: render text directly on the image
        $txtColor_transparent = imagecolorallocatealpha(
            $image,
            $color_ar[0],
            $color_ar[1],
            $color_ar[2],
            (int)$text_transparency
        );

        for ($w = 0; $w < $width; $w += $width_step) {
            for ($h = 0; $h < $height; $h += $height_step) {
                imagettftext($image, (int)$small_fontsize, (int)$rotation, (int)$w, (int)$h, $txtColor_transparent, $font_file, $watermark_r_text)
                    or die('Error in imagettftext function');
            }
        }
    }
}

//---------------------------------------------------------------------
// Watermark Logo function
//---------------------------------------------------------------------
function apply_watermark_logo()
{
    global $pure_watermark_stamp_image, $resized_generated_image, $watermark_stamp_image, $margin_left_factor, $margin_top_factor, $width, $height, $image, $logo_size_over_image, $img_type, $th, $tw; 

    $height = $th;
    $width = $tw;

    $stamp = false; // Logo object

    if ($pure_watermark_stamp_image != '') { // Check logo path
        $dot_pos = strrpos($pure_watermark_stamp_image, ".");
        $stamp_extension = substr($pure_watermark_stamp_image, ($dot_pos + 1));

        // Load the PNG logo
        if ($stamp_extension == 'png') {
            $stamp = imagecreatefrompng($watermark_stamp_image);
            imagesavealpha($stamp, true); // Preserve alpha transparency
        }

        if (!$stamp) return;

        // Resize the PNG logo
        $stamp_size_percent = $logo_size_over_image / 100;
        $stamp_width = imagesx($stamp);
        $stamp_height = imagesy($stamp);

        $new_stamp_width_factor = min($width, $height);
        $new_stamp_width = $new_stamp_width_factor * $stamp_size_percent;
        $new_stamp_height = $stamp_height / ($stamp_width / $new_stamp_width);

        $resized_stamp = imagecreatetruecolor((int)$new_stamp_width, (int)$new_stamp_height);
        imagealphablending($resized_stamp, false);
        imagesavealpha($resized_stamp, true); // Ensure resized PNG has transparency

        // Copy and resize the logo
        imagecopyresampled($resized_stamp, $stamp, 0, 0, 0, 0, (int)$new_stamp_width, (int)$new_stamp_height, $stamp_width, $stamp_height);

        $sx = imagesx($resized_stamp);
        $sy = imagesy($resized_stamp);

        // Calculate margins for the stamp
        $margin_left = $width * $margin_left_factor / 100 - ($sx * ($margin_left_factor / 100));
        $margin_left = max(1, $margin_left);

        $margin_top = $height * $margin_top_factor / 100 - ($sy * ($margin_top_factor / 100));
        $margin_top = max(1, $margin_top);

        // Blend the PNG logo over the GIF main image & Ensure transparency for the GIF base image
        if ($img_type == 'gif')
		{
            imagecopymerge_alpha($image, $resized_stamp, (int)$margin_left, (int)$margin_top, 0, 0, $sx, $sy,100);
        }else
		{
			imagecopy($image, $resized_stamp, (int)$margin_left, (int)$margin_top, 0, 0, $sx, $sy);
		}
		
        // Clean up resources
        if (isset($stamp) && is_resource($stamp)) imagedestroy($stamp);
        if (isset($resized_stamp) && is_resource($resized_stamp)) imagedestroy($resized_stamp);
    }
}
//---------------------------------------------------------------------
// Apply image new size - resizing
//---------------------------------------------------------------------
function resize_image()
{
	global $resized_generated_image, $image, $thumbWidth, $thumbHeight, $tw, $th, $img_type;
	
	// Only resize if necessary
	if ($tw != $thumbWidth || $th != $thumbHeight) {
		if (function_exists('imagecopyresampled')) {
			imagecopyresampled($resized_generated_image, $image, 0, 0, 0, 0, 
				(int)$thumbWidth, (int)$thumbHeight, (int)$tw, (int)$th);
		} else {
			imagecopyresized($resized_generated_image, $image, 0, 0, 0, 0, 
				(int)$thumbWidth, (int)$thumbHeight, (int)$tw, (int)$th);
		}
	} else {
		// Just copy if no resize needed
		imagecopy($resized_generated_image, $image, 0, 0, 0, 0, $tw, $th);
	}
}
//---------------------------------------------------------------------
// Inject a 4-Pixel "Barcode" Signature (WCCP)
//---------------------------------------------------------------------
function wccp_pro_apply_pixel_barcode($resized_generated_image)
{
    global $image, $img_type;
    
    // Select the correct image resource based on how generate_image() outputs them
    $target_image = ($img_type == 'gif') ? $image : $resized_generated_image;
    
    // Check if image is valid (Supports PHP 7 resources and PHP 8+ GdImage objects)
    if (!$target_image || (!is_resource($target_image) && !is_object($target_image))) {
        return;
    }

    $w = imagesx($target_image);
    $h = imagesy($target_image);

    // Don't apply to abnormally small images
    if ($w < 10 || $h < 10) return; 

    // Define our 4-pixel signature array (R, G, B)
    // The Red channel spells "WCCP" in ASCII (87, 67, 67, 80)
    $signature_colors = array(
        array(87, 10, 250),  // Pixel 1 (W)
        array(67, 15, 245),  // Pixel 2 (C)
        array(67, 20, 240),  // Pixel 3 (C)
        array(80, 25, 235)   // Pixel 4 (P)
    );

    $num_pixels = count($signature_colors);
    $start_x = $w - $num_pixels;
    $y = $h - 1; // Absolute bottom row

    // Draw the 4 pixels
    foreach ($signature_colors as $index => $rgb) {
        $color = imagecolorallocate($target_image, $rgb[0], $rgb[1], $rgb[2]);
        imagesetpixel($target_image, $start_x + $index, $y, $color);
    }
	return $target_image;
}
//---------------------------------------------------------------------
// Generate the image and view it
//---------------------------------------------------------------------
function generate_image()
{
	global $resized_generated_image, $image, $img_type, $upload_dir, $pure_name, $upload_dir, $watermark_caching;
	
	// ---> ADD THE BARCODE CALL HERE <---
    $resized_generated_image = wccp_pro_apply_pixel_barcode($resized_generated_image);

	$cachedir = $upload_dir. '/wccp_pro_watermarked_images/';
	
	$use_cache = false;

	if($cachedir !== false AND is_dir($cachedir) AND is_writable($cachedir) AND $watermark_caching == "checked")
		{
			$use_cache = true;
		}

	//for faster performance, ob_end_clean() is used before the output
	ob_end_clean();

    if($img_type == 'png' || $img_type == 'webp')
	{
        imagealphablending($resized_generated_image,TRUE);
		
		imagesavealpha($resized_generated_image,true);

        if($use_cache)imagepng($resized_generated_image, $cachedir . $pure_name, 1); //Save image to local cache storage
		
		imagepng($resized_generated_image, NULL, 1); //Render image to browser
    }
	
	if($img_type == 'gif')
	{
		// Preserve transparency
        imagealphablending($image, true);
		
        imagesavealpha($image, true);
		
		header("Content-Type: image/gif");
		
		if($use_cache)imagegif($image, $cachedir . $pure_name); //Save image to local cache storage

		imagegif($image); //Render image to browser
    }

    if($img_type == 'jpg' || $img_type == 'jpeg')
	{
        if($use_cache)imagejpeg($resized_generated_image, $cachedir . $pure_name, 90); ////Jpeg quality from 0 - 100// + //Save image to local cache storage

		imagejpeg($resized_generated_image, NULL, 70); ////Here to generate image withot save it to cache directory, The jpeg quality from 0 - 100
    }
	
	// Free memory after output
	if (isset($resized_generated_image) && is_resource($resized_generated_image)) imagedestroy($resized_generated_image);

    if (isset($image) && is_resource($image)) imagedestroy($image);
}
//---------------------------------------------------------------------
// * PNG ALPHA CHANNEL SUPPORT for imagecopymerge() php.net/manual/en/function.imagecopymerge.php
//---------------------------------------------------------------------
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{
	$pct = max(0, min(100, (int)$pct));

	if ($pct === 100) {
		imagealphablending($dst_im, true);
		imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
		return true;
	}

	$cut = imagecreatetruecolor($src_w, $src_h);
	imagealphablending($cut, false);
	$transparent = imagecolorallocatealpha($cut, 0, 0, 0, 127);
	imagefill($cut, 0, 0, $transparent);
	imagesavealpha($cut, true);

	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
	
	if (isset($cut) && is_resource($cut)) imagedestroy($cut);

	return true;
}
//---------------------------------------------------------------------
// Normalize source images so watermarks also work on indexed/palette PNGs
//---------------------------------------------------------------------
function wccp_pro_normalize_source_image($img, $preserve_alpha = true)
{
	if (!$img) return false;

	if (function_exists('imagepalettetotruecolor') && !imageistruecolor($img)) {
		@imagepalettetotruecolor($img);
	}

	if (!imageistruecolor($img)) {
		$width = imagesx($img);
		$height = imagesy($img);
		$normalized = imagecreatetruecolor($width, $height);

		if ($preserve_alpha) {
			imagealphablending($normalized, false);
			$transparent = imagecolorallocatealpha($normalized, 0, 0, 0, 127);
			imagefill($normalized, 0, 0, $transparent);
			imagesavealpha($normalized, true);
		}

		$transparentIndex = imagecolortransparent($img);
		if ($transparentIndex >= 0) {
			$transparentColor = imagecolorsforindex($img, $transparentIndex);
			$transparent = imagecolorallocatealpha($normalized, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue'], 127);
			imagefill($normalized, 0, 0, $transparent);
			imagecolortransparent($normalized, $transparent);
		}

		imagecopy($normalized, $img, 0, 0, 0, 0, $width, $height);
		if (isset($img) && is_resource($img)) imagedestroy($img);
		$img = $normalized;
	}

	if ($preserve_alpha) {
		imagealphablending($img, true);
		imagesavealpha($img, true);
	}

	return $img;
}
//---------------------------------------------------------------------
//Convert HTML Colors into RGB Colors
//---------------------------------------------------------------------
function html2rgb($color)
{
    if ($color[0] == '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
    else
        return false;

    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

    return array($r, $g, $b);
}

//---------------------------------------------------------------------
//Get the domain name without www
//---------------------------------------------------------------------
function ir_get_domain($url)
{
	$nowww = preg_replace('/www\./','',$url);
	
	$domain = parse_url($nowww);
	
	preg_match("/[^\.\/]+\.[^\.\/]+$/", $nowww, $matches);
	
	if(count($matches) > 0)
	{
		return $matches[0];
	}
	else
	{
		return FALSE;
	}
}
//---------------------------------------------------------------------
//Get the domain name without www
//---------------------------------------------------------------------
function wccp_pro_isSSL() {
  return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}
//---------------------------------------------------------------------
//Get wccp_pro_get_image_relative_path
//---------------------------------------------------------------------
function wccp_pro_get_image_relative_path($watermark_file, $upload_dir)
{	
	//Example $upload_dir >>   /home3/main-host-holder/website-folder.com/

	if(isset($watermark_file) && isset($upload_dir))
	{
		$watermark_file = $upload_dir . '/' . $watermark_file;
		
		$watermark_file = str_replace("//", "/", $watermark_file);
		
		$watermark_file = str_replace("/wp-content/wp-content/", "/wp-content/", $watermark_file);
		
		$watermark_file = str_replace("wp-content/uploads/wp-content/uploads/", "wp-content/uploads/", $watermark_file);
	}
	else
	{
		$watermark_file = 'None';
	}
	return $watermark_file;
}

//---------------------------------------------------------------------
//Get the domain name without www
//---------------------------------------------------------------------
function image_create_from_any($abs_src)
{
	$options = array( CURLOPT_RETURNTRANSFER => true, // return web page
		CURLOPT_HEADER => false, // don't return headers 
		CURLOPT_FOLLOWLOCATION => false, // follow redirects 
		CURLOPT_AUTOREFERER => true, // set referer on redirect 
		CURLOPT_CONNECTTIMEOUT => 5, // timeout on connect 
		CURLOPT_TIMEOUT => 5, // timeout on response 
		CURLOPT_MAXREDIRS => 0, // stop after 10 redirects 
		); 

		$ch = curl_init( $abs_src ); 
		curl_setopt_array( $ch, $options ); 
		$image = curl_exec( $ch );
		

		//$err = curl_errno( $ch ); // helpful for troubleshooting 
		//$errmsg = curl_error( $ch ); // helpful for troubleshooting 
		curl_close( $ch );

		$image = @imagecreatefromstring($image); // to build as image
		
		if($image) imagesavealpha($image,true);
		
		return $image;
}

//---------------------------------------------------------------------
//Define a function to detect Arabic characters in a string in PHP
//---------------------------------------------------------------------
function contains_arabic($string) {
    // Regular expression to match Arabic characters
    return preg_match('/[\p{Arabic}]/u', $string) === 1;
}

// After processing each image
function cleanup_resources() {
    global $image, $resized_generated_image, $stamp;
    
    if (isset($image) && is_resource($image)) {
        imagedestroy($image);
    }
    if (isset($resized_generated_image) && is_resource($resized_generated_image)) {
        imagedestroy($resized_generated_image);
    }
    if (isset($stamp) && is_resource($stamp)) {
        imagedestroy($stamp);
    }
    
    gc_collect_cycles(); // Force garbage collection
}

// Cache font paths globally
global $font_paths;
$font_paths = array();

function get_font_path($type) {
    global $font_paths, $wp_content_dir, $wccp_pro_plugin_folder_name;
    
    if (!isset($font_paths[$type])) {
        $font_paths[$type] = $wp_content_dir . '/plugins/' . 
            $wccp_pro_plugin_folder_name . '/fonts/' . 
            ($type === 'arabic' ? 'AdobeArabic-Regular.otf' : 'LiberationSans-Regular.ttf');
    }
    return $font_paths[$type];
}

function check_cache($pure_name) {
    global $cachedir, $watermark_caching;
    
    static $cache_exists = array();
    
    if ($watermark_caching !== "checked") {
        return false;
    }
    
    if (!isset($cache_exists[$pure_name])) {
        $cache_exists[$pure_name] = file_exists($cachedir . $pure_name);
    }
    
    return $cache_exists[$pure_name];
}
?>