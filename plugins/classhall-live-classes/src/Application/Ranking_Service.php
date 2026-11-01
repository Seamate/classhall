<?php
/**
 * Teacher ranking service.
 */

namespace Classhall\LiveClasses\Application;

use Classhall\LiveClasses\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Ranking_Service {
	/**
	 * Calculate a Phase 1 teacher ranking score.
	 *
	 * @param float $average_rating Average rating.
	 * @param int   $rating_count Rating count.
	 * @param int   $completed_count Completed classes.
	 * @param int   $upcoming_count Upcoming classes.
	 * @param bool  $verified Verified.
	 * @param float $cancellation_rate Cancellation rate from 0 to 1.
	 * @return float
	 */
	public function score( $average_rating, $rating_count, $completed_count, $upcoming_count, $verified, $cancellation_rate ) {
		$global_mean = 4.2;
		$minimum     = max( 1, absint( Plugin::settings()['minimum_top_rated_reviews'] ) );
		$bayesian    = ( ( $rating_count / ( $rating_count + $minimum ) ) * $average_rating ) + ( ( $minimum / ( $rating_count + $minimum ) ) * $global_mean );
		$review      = min( 1, $rating_count / 20 );
		$completed   = min( 1, $completed_count / 20 );
		$availability= min( 1, $upcoming_count / 5 );
		$new_bonus   = $rating_count < 3 ? 0.5 : 0;
		$verified_bonus = $verified ? 1 : 0;

		$score = ( $bayesian * 0.45 ) + ( $completed * 0.15 ) + ( $review * 0.15 ) + ( $availability * 0.10 ) + ( $verified_bonus * 0.10 ) + ( $new_bonus * 0.05 ) - ( max( 0, min( 1, $cancellation_rate ) ) * 0.25 );

		return round( $score, 4 );
	}

	/**
	 * Whether a teacher can be labelled Top Rated.
	 *
	 * @param int $rating_count Rating count.
	 * @param int $completed_count Completed count.
	 * @return bool
	 */
	public function is_top_rated( $rating_count, $completed_count ) {
		$settings = Plugin::settings();
		return $rating_count >= absint( $settings['minimum_top_rated_reviews'] ) && $completed_count >= absint( $settings['minimum_top_rated_completed'] );
	}
}

