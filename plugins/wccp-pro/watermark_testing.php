<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$url = site_url();
$png_image_large = "/wp-content/uploads/wccp_pro_watermark_testing_images/PNG_500_280.png";
$png_image_medium = "/wp-content/uploads/wccp_pro_watermark_testing_images/PNG_300_170.png";
$png_image_small = "/wp-content/uploads/wccp_pro_watermark_testing_images/PNG_150_150.png";

$jpg_image_large = "/wp-content/uploads/wccp_pro_watermark_testing_images/JPG_500_280.jpg";
$jpg_image_medium = "/wp-content/uploads/wccp_pro_watermark_testing_images/JPG_300_170.jpg";
$jpg_image_small = "/wp-content/uploads/wccp_pro_watermark_testing_images/JPG_150_150.jpg";

$gif_image_large = "/wp-content/uploads/wccp_pro_watermark_testing_images/GIF_500_280.gif";
$gif_image_medium = "/wp-content/uploads/wccp_pro_watermark_testing_images/GIF_300_170.gif";
$gif_image_small = "/wp-content/uploads/wccp_pro_watermark_testing_images/GIF_150_150.gif";

$webp_image_large = "/wp-content/uploads/wccp_pro_watermark_testing_images/WEBP_500_280.webp";
$webp_image_medium = "/wp-content/uploads/wccp_pro_watermark_testing_images/WEBP_300_170.webp";
$webp_image_small = "/wp-content/uploads/wccp_pro_watermark_testing_images/WEBP_150_150.webp";

//Create a forced watermarking links 
$png_forced_image_url = $url . "/index.php?wccp-watermark=1&src=$png_image_large";
$jpg_forced_image_url = $url . "/index.php?wccp-watermark=1&src=$jpg_image_large";
$gif_forced_image_url = $url . "/index.php?wccp-watermark=1&src=$gif_image_large";
$webp_forced_image_url = $url . "/index.php?wccp-watermark=1&src=$webp_image_large";

$current_url = get_admin_url() . 'admin.php?page=wccp-options-pro_watermark_testing';
$wccp_pro_settings = wccp_pro_read_options_from_db('wccp_pro_settings');
$mysite_rule = $wccp_pro_settings['mysite_rule'];
$test_as_online_btn_status = ' disabled_link';
if($mysite_rule == "Watermark") $test_as_online_btn_status = '';
?>

<div class="Container"><!-- Main container -->
  <div class="controls_container"><!-- controls_container -->
    <h2>Watermark Settings Preview:</h2>
    <div class="row">
      <div class="col-md-6">
        <a href="<?php echo $current_url; ?>&test_type=f_o_w" id="show-grid" class="btn btn-block btn-sm btn-danger mb-0" type="submit">Forced operation of Watermark</a>
        <a href="<?php echo $current_url; ?>&test_type=test_as_online" id="change-container" class="btn btn-block btn-sm btn-primary mb-2" type="submit">Test as online (Large images)</a>
        <a href="<?php echo $current_url; ?>&test_type=test_for_medium_images" id="grid-theme" class="btn btn-block btn-sm btn-dark mb-2">Test as online (Medium images)</a>
      </div>
      <div class="col-md-6">
        <a href="<?php echo $current_url; ?>&test_type=test_for_small_images" id="show-grid" class="btn btn-block btn-sm btn-danger mb-0" type="submit">Test as online (Small images)</a>
        <a href="<?php echo $current_url; ?>&test_type=show_htaccess_content" id="change-container" class="btn btn-block btn-sm btn-primary mb-2" type="submit">Show (.htaccess) file content</a>
		<a href="<?php echo $current_url; ?>&test_type=server_data" id="grid-theme" class="btn btn-block btn-sm btn-dark mb-2">Server data</a>
      </div>
    </div>
  </div>

<?php if(!isset($_GET['test_type']) || (isset($_GET['test_type']) && $_GET['test_type'] == "f_o_w")){?>
<div class="Container">
<h4>Expected Results:</h4>
<p>You should see the below 4 images with full watermarking (depends on your choosen options) even if your watermarking options are set to (none), using this test you can check your watermarking results before applying it on your website</p>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $png_forced_image_url; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">PNG Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $jpg_forced_image_url; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">JPG Image:</h4>
		</div>
	</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $gif_forced_image_url; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">GIF Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $webp_forced_image_url; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">Webp Image:</h4>
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php } ?>


<?php if(isset($_GET['test_type']) && $_GET['test_type'] == "test_as_online"){
	
@setcookie("wccp_pro_functionality", "", time() - 3600, "/"); // Clear the admin exclusion cookie to allow test running successfully

?>
<div class="Container">
<h4>Expected Results:</h4>
<?php if($mysite_rule == "Watermark"){
	$expected_results_msg = "You should see the below 4 images with full watermarking (depends on your choosen options) inside the watermark settings tab";
	}else{
		$expected_results_msg = "You should see the below 4 images without watermarking (depends on your choosen options) inside the watermark settings tab";
	}
	if($wccp_pro_settings['mysite_rule'] == 'Watermark' && $wccp_pro_settings['force_watermarking_for_non_apache_servers'] == 'checked')
	{
		//Create a forced watermarking links 
		$png_image_large = site_url() . "/index.php?wccp-watermark=1&src=$png_image_large" . "&rnd=" . time();
		$jpg_image_large = site_url() . "/index.php?wccp-watermark=1&src=$jpg_image_large" . "&rnd=" . time();
		$gif_image_large = site_url() . "/index.php?wccp-watermark=1&src=$gif_image_large" . "&rnd=" . time();
		$webp_image_large = site_url() . "/index.php?wccp-watermark=1&src=$webp_image_large" . "&rnd=" . time();
	}else{
		$png_image_large = "..$png_image_large?rnd=" . time();
		$jpg_image_large = "..$jpg_image_large?rnd=" . time();
		$gif_image_large = "..$gif_image_large?rnd=" . time();
		$webp_image_large = "..$webp_image_large?rnd=" . time();
	}
?>
<p><?php echo $expected_results_msg; ?></p>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $png_image_large;?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">PNG Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $jpg_image_large; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">JPG Image:</h4>
		</div>
	</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $gif_image_large; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">GIF Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $webp_image_large; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">Webp Image:</h4>
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php } ?>

<?php if(isset($_GET['test_type']) && $_GET['test_type'] == "show_htaccess_content"){
	
@setcookie("wccp_pro_functionality", "", time() - 3600, "/"); // Clear the admin exclusion cookie to allow test running successfully

$htaccess_file = WP_CONTENT_DIR . '/.htaccess';

if (!file_exists( $htaccess_file )) return;

$f = @fopen( $htaccess_file, 'r' );
?>
<div class="Container">
<h4>The (.htaccess) file content:</h4>
<img src="../wp-content/uploads/wccp_pro_watermark_testing_images/htaccess-test/htaccess-fail.png?p=wccp_pro_watermark_pass&rnd=<?php echo time(); ?>" alt="testing image">
<p>This file is located inside your wp-content folder, our plugin write some rules inside it, all rules are excuted ay your web server to manage the flow of your images on your website</p>
<textarea placeholder=".htaccess file content" class="form-control htaccess_content" name="htaccess_content" id="htaccess_content"><?php echo fread($f,10000); ?></textarea>
</div>
<?php } ?>


<?php if(isset($_GET['test_type']) && $_GET['test_type'] == "server_data"){
// Collect data
$serverType = getServerType();
$gdSupport = checkGDSupport();
$imageMagickSupport = checkImageMagickSupport();
$phpSettings = getPHPSettings();
$fileSystem = checkFileSystem();
?>
<div class="Container">
<h4>The server data:</h4>
<style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

    <table>
        <tr>
            <th>Feature</th>
            <th>Status</th>
            <th>Details</th>
        </tr>
        <!-- Server Type -->
        <tr>
            <td>Server Type</td>
            <td><?php echo htmlspecialchars($serverType); ?></td>
            <td><?php echo check_server_type_details(); ?></td>
        </tr>
        <!-- GD Library -->
        <tr>
            <td>GD Library</td>
            <td><?php echo $gdSupport ? 'Enabled' : 'Not Enabled'; ?></td>
            <td>
                <?php
                if ($gdSupport) {
                    echo "Version: " . htmlspecialchars($gdSupport['version']) . "<br>";
                    echo "Supported Formats: " . htmlspecialchars($gdSupport['supportedFormats']);
                } else {
                    echo "GD Library is not installed.";
                }
                ?>
            </td>
        </tr>
        <!-- ImageMagick -->
        <tr>
            <td>ImageMagick</td>
            <td><?php echo $imageMagickSupport ? 'Enabled' : 'Not Enabled'; ?></td>
            <td>
                <?php
                if ($imageMagickSupport) {
                    echo "Version: " . htmlspecialchars($imageMagickSupport['version']) . "<br>";
                    echo "Supported Formats: " . htmlspecialchars($imageMagickSupport['supportedFormats']);
                } else {
                    echo "ImageMagick is not installed.";
                }
                ?>
            </td>
        </tr>
        <!-- PHP Settings -->
        <?php foreach ($phpSettings as $setting => $value): ?>
        <tr>
            <td><?php echo htmlspecialchars($setting); ?></td>
            <td><?php echo htmlspecialchars($value); ?></td>
            <td>N/A</td>
        </tr>
        <?php endforeach; ?>
        <!-- File System -->
        <?php foreach ($fileSystem as $fsFeature => $fsStatus): ?>
        <tr>
            <td><?php echo htmlspecialchars($fsFeature); ?></td>
            <td><?php echo htmlspecialchars($fsStatus); ?></td>
            <td>N/A</td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php } ?>

<?php if(isset($_GET['test_type']) && $_GET['test_type'] == "test_for_small_images"){
	
@setcookie("wccp_pro_functionality", "", time() - 3600, "/"); // Clear the admin exclusion cookie to allow test running successfully

if($wccp_pro_settings['mysite_rule'] == 'Watermark' && $wccp_pro_settings['force_watermarking_for_non_apache_servers'] == 'checked')
	{
		//Create a forced watermarking links 
		$png_image_small = site_url() . "/index.php?wccp-watermark=1&src=$png_image_small" . "&rnd=" . time();
		$jpg_image_small = site_url() . "/index.php?wccp-watermark=1&src=$jpg_image_small" . "&rnd=" . time();
		$gif_image_small = site_url() . "/index.php?wccp-watermark=1&src=$gif_image_small" . "&rnd=" . time();
		$webp_image_small = site_url() . "/index.php?wccp-watermark=1&src=$webp_image_small" . "&rnd=" . time();
	}else{
		$png_image_small = "..$png_image_small?rnd=" . time();
		$jpg_image_small = "..$jpg_image_small?rnd=" . time();
		$gif_image_small = "..$gif_image_small?rnd=" . time();
		$webp_image_small = "..$webp_image_small?rnd=" . time();
	}
?>
<div class="Container">
<h4>Expected Results:</h4>
<p>Small images must not be watermarked, everything is good if you see the below images without watermarking</p>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $png_image_small; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">PNG Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $jpg_image_small; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">JPG Image:</h4>
		</div>
	</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $gif_image_small; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">GIF Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $webp_image_small; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">Webp Image:</h4>
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php } ?>

<?php if(isset($_GET['test_type']) && $_GET['test_type'] == "test_for_medium_images"){
	
@setcookie("wccp_pro_functionality", "", time() - 3600, "/"); // Clear the admin exclusion cookie to allow test running successfully

if($wccp_pro_settings['mysite_rule'] == 'Watermark' && $wccp_pro_settings['force_watermarking_for_non_apache_servers'] == 'checked')
	{
		//Create a forced watermarking links 
		$png_image_medium = site_url() . "/index.php?wccp-watermark=1&src=$png_image_medium" . "&rnd=" . time();
		$jpg_image_medium = site_url() . "/index.php?wccp-watermark=1&src=$jpg_image_medium" . "&rnd=" . time();
		$gif_image_medium = site_url() . "/index.php?wccp-watermark=1&src=$gif_image_medium" . "&rnd=" . time();
		$webp_image_medium = site_url() . "/index.php?wccp-watermark=1&src=$webp_image_medium" . "&rnd=" . time();
	}else{
		$png_image_medium = "..$png_image_medium?rnd=" . time();
		$jpg_image_medium = "..$jpg_image_medium?rnd=" . time();
		$gif_image_medium = "..$gif_image_medium?rnd=" . time();
		$webp_image_medium = "..$webp_image_medium?rnd=" . time();
	}	
?>
<div class="Container">
<h4>Expected Results:</h4>
<?php if($mysite_rule == "Watermark"){
	$expected_results_msg = "Medium images are watermarked but without watermarking logo, also without watermarking signature, this is the best practice to show watermark in good appearance over medim images";
	}else{
		$expected_results_msg = "You should see the below 4 images without watermarking (depends on your choosen options) inside the watermark settings tab";
	}
?>
<p><?php echo $expected_results_msg; ?></p>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $png_image_medium; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">PNG Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $jpg_image_medium; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">JPG Image:</h4>
		</div>
	</div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $gif_image_medium; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">GIF Image:</h4>
		</div>
	</div>
</div>
<div class="col-md-6 col-12">
	<div class="card bg-light text-white">
		<img class="card-img" src="<?php echo $webp_image_medium; ?>" alt="Card image">
		<div class="card-img-overlay">
			<h2 class="card-title">Webp Image:</h4>
		</div>
	</div>
</div>
</div>
</div>
</div>
<?php } ?>
<?php
// Function to fetch the server header
function fetch_server_header($url) {
    // Get headers for the given URL
    $headers = get_headers($url, 1); // 1 for associative array

    if (!$headers) {
        return "<p style='color: red;'><strong>Failed to retrieve headers for URL: $url</strong></p>";
    }

    // Check if the 'Server' header exists and get its value
	$server = isset($headers['Server']) ? $headers['Server'] : 'Server type is not recognized';

    // Determine the color based on the server type
    $color = 'orange';
    if (stripos($server, 'apache') !== false) {
        $color = 'green';
    } elseif (stripos($server, 'nginx') !== false) {
        $color = 'red';
    }

    // Return the styled result
    return "Server type retrieved from the testing image header is: <span style='color: $color;'><strong>$server</strong></span>";
}

function check_server_type_details()
{
	// Check for server software
	$server_software = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';

	// Check for reverse proxy headers (common with Nginx)
	$via = $_SERVER['HTTP_VIA'] ?? null;
	
	$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? null;
	
	$server_type_details = "";

	$server_type_details.= "Server Software: $server_software<br>";

	if ($via || $proxy) {
		$server_type_details.= "It seems the server is behind a reverse proxy (possibly Nginx).<br>";
		if (strpos($server_software, 'Apache') !== false) {
			$server_type_details.= "Requests may still be handled by Apache after passing through Nginx.<br>";
		}
	} else {
		$server_type_details.= "No reverse proxy detected.<br>";
	}

	// URL to fetch headers for
	$url = home_url() . "/wp-content/uploads/wccp_pro_watermark_testing_images/htaccess-test/
	htaccess-fail.png?p=wccp_pro_watermark_pass&rnd=".time(); // target URL

	// Call the function to knpw the server type from the fetched image response
	$server_type_details = $server_type_details . "<br>" . fetch_server_header($url);

	return $server_type_details;
}

// Helper function to get server type
function getServerType() {
    return $_SERVER['SERVER_SOFTWARE'] ?? "Unknown";
}

// Helper function to check GD support
function checkGDSupport() {
    if (extension_loaded('gd')) {
        $gdInfo = gd_info();
        $supportedFormats = [];
        foreach ($gdInfo as $feature => $enabled) {
            if (is_bool($enabled) && $enabled) {
                $supportedFormats[] = $feature;
            }
        }
        return [
            'version' => $gdInfo['GD Version'] ?? 'Unknown',
            'supportedFormats' => implode(', ', $supportedFormats),
        ];
    }
    return false;
}

// Helper function to check ImageMagick support
function checkImageMagickSupport() {
    if (extension_loaded('imagick')) {
        $imagick = new Imagick();
        return [
            'version' => $imagick->getVersion()['versionString'] ?? 'Unknown',
            'supportedFormats' => implode(', ', $imagick->queryFormats()),
        ];
    }
    return false;
}

// Check PHP settings
function getPHPSettings() {
    return [
        'PHP Version' => phpversion(),
        'Memory Limit' => ini_get('memory_limit'),
        'Max Execution Time' => ini_get('max_execution_time') . " seconds",
        'Upload Max Filesize' => ini_get('upload_max_filesize'),
        'Post Max Size' => ini_get('post_max_size'),
        'Default Temp Directory' => sys_get_temp_dir(),
    ];
}

// Check file system capabilities
function checkFileSystem() {
    $testFile = sys_get_temp_dir() . '/test_image_processing.txt';
    $canWrite = @file_put_contents($testFile, "test") !== false;
    @unlink($testFile);

    return [
        'Can Write to Temp Directory' => $canWrite ? 'Yes' : 'No',
        'Temp Directory Path' => sys_get_temp_dir(),
    ];
}
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Get the current URL and extract the "test_type" parameter
  const urlParams = new URLSearchParams(window.location.search);
  const testType = urlParams.get("test_type");

  // Define the parent container for your buttons
  const container = document.querySelector(".controls_container");

  if (container) {
    // Helper function to add the "clicked_btn" class within the container
    const addClickedClass = (selector) => {
      const activeButton = container.querySelector(selector); // Search only inside the container
      if (activeButton) {
        activeButton.classList.add("clicked_btn");
        console.log("Class 'clicked_btn' added to:", activeButton);
      } else {
        console.log("No matching button found for selector:", selector);
      }
    };

    // Add the class to the corresponding button based on "test_type"
    if (testType) {
      addClickedClass(`a[href*="test_type=${testType}"]`);
    } else {
      // Default to "test_type=f_o_w" if no "test_type" parameter is found
      addClickedClass(`a[href*="test_type=f_o_w"]`);
    }
  } else {
    console.error("Container with class 'controls_container' not found.");
  }
});
</script>


<style>
.card {
	padding: 0px !important;
	display: -webkit-box;
}
.card-title {
    background-color: #ffffff75;
    border-radius: 4px;
    padding: 9px;
    font-size: inherit;
    width: fit-content;
}
.Container {
	width: -webkit-fill-available;
	max-width: 95%;
}
.controls_container {
	width: auto;
	max-width: 95%;
}
.clicked_btn {
    position: relative;
    padding-left: 35px; /* Adjust for icon spacing */
}
.clicked_btn:before {
    content: '\f147'; /* Unicode for Dashicon you want (e.g., f147 for a checkmark) */
    font-family: 'Dashicons';
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
}
.disabled_link{
	pointer-events: none;
	opacity: 0.7;
	cursor: default;
}
.card-img{
    min-width: -webkit-fill-available;
    min-height: -webkit-fill-available;
}
.default-image-if-fallback {
    min-height: 15vw;
    //aspect-ratio: 7 / 4;
    object-fit: cover; /* Ensures image covers the container */
    background-image: url('../wp-content/plugins/<?php echo wccp_pro_plugin_folder_name(); ?>/images/A-red-deer-in-Richmond-Park-London-20180410.jpg'); /* Fallback image */
    background-size: cover; /* Covers the element with the default image */
    background-position: center;
}

textarea.htaccess_content {
    height: 40vw;
	min-height: 300px;
	max-height: 490px;
}

@media (min-width: 1340px) {
    .Container, .controls_container {
	max-width: 1033px;
	}
}
</style>
