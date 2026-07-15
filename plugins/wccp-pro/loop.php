<div id="loop_1">
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include "watermarking-parameters.php";

$args = array(
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'orderby' => 'post_date',
        'order' => 'desc',
        'posts_per_page' => '30',
        'post_status'    => 'inherit'
         );

     $loop = new WP_Query( $args );

$default_image_sizes = wccp_pro_get_all_image_sizes();


$full_image_url_js_array = "";

while ( $loop->have_posts() ) : $loop->the_post();

	foreach ( $default_image_sizes as $sizename=>$size_values )
	{
		$image = wp_get_attachment_image_src( get_the_ID(), $sizename );

		$full_image_url = '"' . wccp_pro_get_pure_src($image[0]) . '",';
		
		$full_image_url_js_array = $full_image_url_js_array . $full_image_url;
	}

endwhile;

$full_image_url_js_array = '[' . $full_image_url_js_array . ']';

function wccp_pro_get_pure_src($src)
{
	$pure_src = str_replace(get_site_url(), "", $src);
	
	$full_image_url = get_site_url() . "/wp-content/plugins/".wccp_pro_plugin_folder_name()."/watermark.php?&src=" . $pure_src;
	
	//echo '<button onclick=wccp_pro_watermark_image("' . $full_image_url . '"); style="width: 100%;display: block">'.__('watermark this image' )."</button><br>";
	
	return $full_image_url;
}

function wccp_pro_get_all_image_sizes()
{
    global $_wp_additional_image_sizes;

    $default_image_sizes = get_intermediate_image_sizes();

    foreach ( $default_image_sizes as $size ) {
        $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
        $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
        $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
    }

    if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
        $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
    }

    return $image_sizes;
}
?>
</div>
<script>
var images_array = <?php echo $full_image_url_js_array; ?>;

function wccp_pro_js_sleep(ms)
{
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function do_watermark_call(new_image_index)
{
	if(new_image_index >= images_array.length) return;
	
	var x = await wccp_pro_js_sleep(200);
	
	let new_percent = new_image_index / images_array.length * 100;
	
	demo.set((new_percent+1).toFixed(0));
	
	await wccp_pro_watermark_image(images_array[new_image_index] , new_image_index);
}

window.addEventListener("load", () => {
  do_watermark_call(0); //0 to start from the first item
});

</script>

<div class="widget-wrap">
  <div id="preloader">
	<div id="loader"></div>
  </div>
  <h1>Watermarking Percent</h1>

  <div id="demo"></div>
  
  <div><span id="requestAnimationFrame"></span></div>

</div>

<script>
function progbar (instance) {
  // (A) WRAPPER CSS 
  instance.classList.add("prog-wrap");

  // (B) CREATE PROGRESS BAR
  instance.innerHTML = '<div class="prog-bar"></div><div class="prog-percent">0%</div>';
  instance.hbar = instance.querySelector(".prog-bar");
  instance.hpercent = instance.querySelector(".prog-percent");

  // (C) SET PROGRESS
  instance.set = (percent) => {
    instance.hbar.style.width = percent + "%";
    instance.hpercent.innerHTML = percent + "%";
  };

  // (D) RETURN RESULT
  return instance;
}

// (E) ATTACH PROGRESS BAR
window.addEventListener("load", () => {
  // (E1) PROGRESS BAR
  let demo = progbar(document.getElementById("demo"));
  //demo.set(30);
  
});
</script>

<style>
/* (A) PROGRESS BAR WRAPPER */
* {
  font-family: arial, sans-serif;
  box-sizing: border-box;
}
.prog-wrap {
  position: relative;
  border: 1px solid #acb2d8;
  background: rgba(255, 255, 255, 0.3);
}
.prog-wrap, .prog-bar, .prog-percent { height: 30px; }

/* (B) PROGRESS BAR & PERCENTAGE */
.prog-bar, .prog-percent {
  position: absolute;
  top: 0; left: 0;
}

/* (C) PERCENTAGE INDICATOR */
.prog-percent {
  display: flex;
  align-items: center; justify-content: center;
  width: 100%;
  z-index: 2;
}

/* (D) PROGRESS BAR */
.prog-bar {
  width: 0;
  background: rgba(255, 47, 47, 0.5);
  transition: width 0.5s;
}

/* (X) DOES NOT MATTER */
/* TEST CONTROLS */
#demoA { margin-top: 20px; }
#demoA input, #demoA button { padding: 10px; }

/* PAGE & BODY */
body {
  display: flex;
  align-items: center; justify-content: center;
  min-height: 100vh;
  background-image: url(https://images.unsplash.com/photo-1519750783826-e2420f4d687f?crop=entropy&cs=srgb&fm=jpg&ixid=MnwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHx8MTY0MzU0MzQ1OA&ixlib=rb-1.2.1&q=85);
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
}

/* WIDGET */
.widget-wrap {
  min-width: 500px;
  padding: 30px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.4);
}

/* SVG */
#load {
  width: 100%; height:100px;
  background-image: url('data:image/svg+xml;utf8,<svg viewBox="0 0 512 512" width="100" xmlns="http://www.w3.org/2000/svg"><path d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z" /></svg>');
  background-repeat: no-repeat;
  background-position: center;
}

/* FOOTER */
#code-boxx {
  font-weight: 600;
  margin-top: 50px;
}
#code-boxx a {
  display: inline-block;
  padding: 5px;
  text-decoration: none;
  background: #b90a0a;
  color: #fff;
}
#code-boxx , h1 { text-align: center; }

/* loading css */
body {
  background-color: #222;
}
#preloader {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
#loader {
    display: block;
    position: relative;
    left: 50%;
    top: 50%;
    width: 150px;
    height: 150px;
    margin: -10px 0 0 -75px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #9370DB;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
}
#loader:before {
    content: "";
    position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #BA55D3;
    -webkit-animation: spin 3s linear infinite;
    animation: spin 3s linear infinite;
}
#loader:after {
    content: "";
    position: absolute;
    top: 15px;
    left: 15px;
    right: 15px;
    bottom: 15px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-top-color: #FF00FF;
    -webkit-animation: spin 1.5s linear infinite;
    animation: spin 1.5s linear infinite;
}
@-webkit-keyframes spin {
    0%   {
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}
@keyframes spin {
    0%   {
        -webkit-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        -ms-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

</style>