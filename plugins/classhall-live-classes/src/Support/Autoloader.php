<?php
/**
 * Minimal PSR-4 autoloader used when Composer autoload is unavailable.
 */

namespace Classhall\LiveClasses\Support;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Autoloader {
	/**
	 * Register the autoloader.
	 *
	 * @return void
	 */
	public static function register() {
		spl_autoload_register( array( __CLASS__, 'load' ) );
	}

	/**
	 * Load a plugin class.
	 *
	 * @param string $class Fully qualified class name.
	 * @return void
	 */
	public static function load( $class ) {
		$prefix = 'Classhall\\LiveClasses\\';
		if ( 0 !== strpos( $class, $prefix ) ) {
			return;
		}

		$relative = substr( $class, strlen( $prefix ) );
		$file     = CLASSHALL_LIVE_PLUGIN_DIR . 'src/' . str_replace( '\\', '/', $relative ) . '.php';

		if ( file_exists( $file ) ) {
			require_once $file;
		}
	}
}

