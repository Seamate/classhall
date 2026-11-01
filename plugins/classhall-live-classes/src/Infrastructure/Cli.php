<?php
/**
 * WP-CLI commands.
 */

namespace Classhall\LiveClasses\Infrastructure;

use Classhall\LiveClasses\Application\Seeder;
use Classhall\LiveClasses\Database\Installer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Cli {
	/**
	 * Register CLI command.
	 *
	 * @return void
	 */
	public static function register() {
		\WP_CLI::add_command( 'classhall-live', __CLASS__ );
	}

	/**
	 * Run migrations.
	 *
	 * @return void
	 */
	public function migrate() {
		Installer::migrate();
		\WP_CLI::success( 'Classhall Live Classes migrations completed.' );
	}

	/**
	 * Check plugin health.
	 *
	 * @return void
	 */
	public function health() {
		\WP_CLI::line( 'Plugin version: ' . CLASSHALL_LIVE_VERSION );
		\WP_CLI::line( 'DB version: ' . get_option( 'classhall_live_db_version', 'not installed' ) );
		\WP_CLI::line( 'WooCommerce: ' . ( class_exists( 'WooCommerce' ) ? 'available' : 'missing' ) );
		\WP_CLI::line( 'Sensei course post type: ' . ( post_type_exists( 'course' ) ? 'available' : 'missing' ) );
	}

	/**
	 * Recalculate ratings placeholder.
	 *
	 * @return void
	 */
	public function recalc_ratings() {
		\WP_CLI::success( 'Rating recalculation command registered. Full aggregate rebuild is documented for staging rollout.' );
	}

	/**
	 * Reconcile bookings placeholder.
	 *
	 * ## OPTIONS
	 *
	 * [--dry-run]
	 *
	 * @param array $args Args.
	 * @param array $assoc_args Assoc args.
	 * @return void
	 */
	public function reconcile_bookings( $args, $assoc_args ) {
		unset( $args );
		$dry = ! empty( $assoc_args['dry-run'] );
		\WP_CLI::success( $dry ? 'Dry run completed; no booking records changed.' : 'Reconciliation hook completed.' );
	}

	/**
	 * Seed development data.
	 *
	 * ## OPTIONS
	 *
	 * [--dry-run]
	 *
	 * @param array $args Args.
	 * @param array $assoc_args Assoc args.
	 * @return void
	 */
	public function seed( $args, $assoc_args ) {
		unset( $args );
		$messages = ( new Seeder() )->seed( ! empty( $assoc_args['dry-run'] ) );
		foreach ( $messages as $message ) {
			\WP_CLI::line( $message );
		}
		\WP_CLI::success( 'Seed command completed.' );
	}
}

