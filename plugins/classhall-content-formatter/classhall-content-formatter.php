<?php
/**
 * Plugin Name: Classhall Content Formatter
 * Description: Private admin tool for safely formatting existing Classhall lesson content in resumable batches.
 * Version: 0.2.3
 * Author: Classhall
 * Text Domain: classhall-content-formatter
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CHCF_VERSION', '0.2.3' );
define( 'CHCF_PLUGIN_FILE', __FILE__ );
define( 'CHCF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CHCF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once CHCF_PLUGIN_DIR . 'includes/class-chcf-autoloader.php';
CHCF_Autoloader::register();

register_activation_hook( __FILE__, array( 'CHCF_Installer', 'activate' ) );

add_action( 'plugins_loaded', array( 'CHCF_Plugin', 'instance' ) );
