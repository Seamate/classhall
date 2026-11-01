<?php
/**
 * Ranking tests.
 */

use Classhall\LiveClasses\Application\Ranking_Service;
use PHPUnit\Framework\TestCase;

if ( ! function_exists( 'get_option' ) ) {
	function get_option( $key, $default = false ) {
		if ( 'classhall_live_settings' === $key ) {
			return array(
				'minimum_top_rated_reviews'   => 5,
				'minimum_top_rated_completed' => 3,
			);
		}

		return $default;
	}
}

if ( ! function_exists( 'wp_parse_args' ) ) {
	function wp_parse_args( $args, $defaults = array() ) {
		return array_merge( $defaults, (array) $args );
	}
}

if ( ! function_exists( 'absint' ) ) {
	function absint( $maybeint ) {
		return abs( (int) $maybeint );
	}
}

final class RankingServiceTest extends TestCase {
	public function test_new_teacher_receives_discovery_support() {
		$ranking = new Ranking_Service();
		$new     = $ranking->score( 0, 0, 0, 1, true, 0 );
		$inactive = $ranking->score( 4.2, 1, 0, 0, false, 0.5 );

		$this->assertGreaterThan( $inactive, $new );
	}

	public function test_top_rated_requires_minimums() {
		$ranking = new Ranking_Service();

		$this->assertFalse( $ranking->is_top_rated( 4, 3 ) );
		$this->assertTrue( $ranking->is_top_rated( 5, 3 ) );
	}
}

