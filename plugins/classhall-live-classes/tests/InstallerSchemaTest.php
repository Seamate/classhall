<?php
/**
 * Static schema tests.
 */

use Classhall\LiveClasses\Database\Installer;
use PHPUnit\Framework\TestCase;

final class InstallerSchemaTest extends TestCase {
	public function test_schema_uses_dynamic_prefix() {
		$sql = implode( "\n", Installer::schema( 'wp_test_', 'DEFAULT CHARSET=utf8mb4' ) );

		$this->assertStringContainsString( 'wp_test_classhall_live_bookings', $sql );
		$this->assertStringNotContainsString( 'CREATE TABLE wp_classhall_live_bookings', $sql );
	}

	public function test_booking_idempotency_indexes_exist() {
		$sql = implode( "\n", Installer::schema( 'wp_test_', 'DEFAULT CHARSET=utf8mb4' ) );

		$this->assertStringContainsString( 'UNIQUE KEY order_item_booking (order_id, order_item_id)', $sql );
		$this->assertStringContainsString( 'confirmed_seats INT UNSIGNED NOT NULL DEFAULT 0', $sql );
	}
}

