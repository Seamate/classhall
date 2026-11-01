<?php
/**
 * Plugin Name: Classhall Live Classes
 * Description: Live teacher-led classes for Classhall subjects with WooCommerce checkout, secure bookings, reviews, and manual payouts.
 * Version: 0.2.01
 * Author: Classhall
 * Text Domain: classhall-live-classes
 * Domain Path: /languages
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CLASSHALL_LIVE_VERSION', '0.2.01' );
define( 'CLASSHALL_LIVE_DB_VERSION', '0.1.3' );
define( 'CLASSHALL_LIVE_PLUGIN_FILE', __FILE__ );
define( 'CLASSHALL_LIVE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CLASSHALL_LIVE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

$classhall_live_autoload = CLASSHALL_LIVE_PLUGIN_DIR . 'vendor/autoload.php';
if ( file_exists( $classhall_live_autoload ) ) {
	require_once $classhall_live_autoload;
} else {
	require_once CLASSHALL_LIVE_PLUGIN_DIR . 'src/Support/Autoloader.php';
	\Classhall\LiveClasses\Support\Autoloader::register();
}

register_activation_hook( __FILE__, array( \Classhall\LiveClasses\Plugin::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( \Classhall\LiveClasses\Plugin::class, 'deactivate' ) );

add_action(
	'plugins_loaded',
	static function() {
		\Classhall\LiveClasses\Plugin::instance()->boot();
	}
);
