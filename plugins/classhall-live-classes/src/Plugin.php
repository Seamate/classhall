<?php
/**
 * Main plugin coordinator.
 */

namespace Classhall\LiveClasses;

use Classhall\LiveClasses\Admin\Admin;
use Classhall\LiveClasses\Api\Rest_Controller;
use Classhall\LiveClasses\Application\Reminder_Service;
use Classhall\LiveClasses\Database\Installer;
use Classhall\LiveClasses\Frontend\Shortcodes;
use Classhall\LiveClasses\Infrastructure\Cli;
use Classhall\LiveClasses\Infrastructure\Subject_Adapter;
use Classhall\LiveClasses\Integrations\WooCommerce;
use Classhall\LiveClasses\Security\Capabilities;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Plugin {
	const OPTION_KEY = 'classhall_live_settings';
	const CPT        = 'classhall_live_class';

	/**
	 * Singleton instance.
	 *
	 * @var self|null
	 */
	private static $instance = null;

	/**
	 * Get singleton instance.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Activation callback.
	 *
	 * @return void
	 */
	public static function activate() {
		Capabilities::add_admin_caps();
		Installer::migrate();
		self::register_post_type();
		self::register_rewrites();
		Reminder_Service::schedule();
		flush_rewrite_rules();
	}

	/**
	 * Deactivation callback.
	 *
	 * @return void
	 */
	public static function deactivate() {
		Reminder_Service::unschedule();
		flush_rewrite_rules();
	}

	/**
	 * Boot plugin hooks.
	 *
	 * @return void
	 */
	public function boot() {
		load_plugin_textdomain( 'classhall-live-classes', false, dirname( plugin_basename( CLASSHALL_LIVE_PLUGIN_FILE ) ) . '/languages' );

		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_rewrites' ) );
		add_action( 'init', array( $this, 'maybe_migrate' ), 5 );
		add_action( 'init', array( $this, 'maybe_flush_rewrites' ), 20 );
		add_action( 'init', array( Reminder_Service::class, 'schedule' ), 30 );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

		$subjects = new Subject_Adapter();
		( new Admin( $subjects ) )->register();
		( new Shortcodes( $subjects ) )->register();
		( new WooCommerce() )->register();
		( new Reminder_Service() )->register();
		( new Rest_Controller() )->register();

		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			Cli::register();
		}
	}

	/**
	 * Register custom post type for public class URLs.
	 *
	 * @return void
	 */
	public static function register_post_type() {
		register_post_type(
			self::CPT,
			array(
				'labels'              => array(
					'name'          => __( 'Live Classes', 'classhall-live-classes' ),
					'singular_name' => __( 'Live Class', 'classhall-live-classes' ),
				),
				'public'              => true,
				'has_archive'         => true,
				'show_in_rest'        => true,
				'menu_icon'           => 'dashicons-video-alt3',
				'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
				'rewrite'             => array( 'slug' => 'live-classes' ),
				'capability_type'     => 'post',
				'map_meta_cap'        => true,
				'exclude_from_search' => false,
			)
		);
	}

	/**
	 * Register public rewrite rules for live teacher profiles.
	 *
	 * @return void
	 */
	public static function register_rewrites() {
		add_rewrite_rule( '^live-teachers/?$', 'index.php?classhall_live_teachers_directory=1', 'top' );
		add_rewrite_rule( '^live-teachers/([^/]+)/?$', 'index.php?classhall_live_teacher_slug=$matches[1]', 'top' );
		add_rewrite_rule( '^live-class-join/([0-9a-fA-F-]+)/?$', 'index.php?classhall_live_join_uuid=$matches[1]', 'top' );
	}

	/**
	 * Run migrations when the stored version is stale.
	 *
	 * @return void
	 */
	public function maybe_migrate() {
		if ( get_option( 'classhall_live_db_version' ) !== CLASSHALL_LIVE_DB_VERSION ) {
			Installer::migrate();
		}
	}

	/**
	 * Flush rewrites once per plugin version when route rules change.
	 *
	 * @return void
	 */
	public function maybe_flush_rewrites() {
		if ( get_option( 'classhall_live_rewrite_version' ) !== CLASSHALL_LIVE_VERSION ) {
			flush_rewrite_rules( false );
			update_option( 'classhall_live_rewrite_version', CLASSHALL_LIVE_VERSION, false );
		}
	}

	/**
	 * Register assets but do not enqueue globally.
	 *
	 * @return void
	 */
	public function register_assets() {
		wp_register_style(
			'classhall-live-classes',
			CLASSHALL_LIVE_PLUGIN_URL . 'assets/css/frontend.css',
			array(),
			CLASSHALL_LIVE_VERSION
		);
		wp_register_script(
			'classhall-live-classes',
			CLASSHALL_LIVE_PLUGIN_URL . 'assets/js/frontend.js',
			array(),
			CLASSHALL_LIVE_VERSION,
			true
		);
	}

	/**
	 * Get settings with defaults.
	 *
	 * @return array
	 */
	public static function settings() {
		$defaults = array(
			'commission_percent'            => 20,
			'currency'                      => 'NGN',
			'minimum_price_minor'           => 100000,
			'maximum_capacity'              => 100,
			'booking_close_buffer_minutes'  => 30,
			'meeting_access_before_minutes' => 30,
			'meeting_access_after_minutes'  => 120,
			'minimum_top_rated_reviews'     => 5,
			'minimum_top_rated_completed'   => 3,
			'reminder_emails_enabled'       => 1,
			'reminder_windows_minutes'      => '1440,60',
			'reminder_batch_limit'          => 100,
			'review_moderation'             => 1,
			'allowed_platforms'             => array( 'google_meet', 'zoom', 'microsoft_teams', 'other' ),
			'class_approval_required'       => 1,
			'debug_logging'                 => 0,
			'delete_data_on_uninstall'      => 0,
		);

		return wp_parse_args( get_option( self::OPTION_KEY, array() ), $defaults );
	}
}
