<?php
/**
 * Plugin Name: Kleo Live Classes
 * Description: Lets teachers create paid live classes with WooCommerce enrolment, commission tracking, and student schedules.
 * Version: 0.1.0
 * Author: OpenAI Codex
 * Text Domain: kleo-live-classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'KLC_PLUGIN_FILE', __FILE__ );
define( 'KLC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'KLC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once KLC_PLUGIN_PATH . 'includes/class-klc-plugin.php';

register_activation_hook( __FILE__, array( 'KLC_Plugin', 'activate' ) );

KLC_Plugin::instance();
