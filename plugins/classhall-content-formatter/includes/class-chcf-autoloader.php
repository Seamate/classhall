<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Autoloader {
	public static function register() {
		spl_autoload_register( array( __CLASS__, 'load' ) );
	}

	public static function load( $class ) {
		if ( 0 !== strpos( $class, 'CHCF_' ) ) {
			return;
		}

		$file = 'class-' . strtolower( str_replace( '_', '-', $class ) ) . '.php';
		$path = CHCF_PLUGIN_DIR . 'includes/' . $file;

		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}
