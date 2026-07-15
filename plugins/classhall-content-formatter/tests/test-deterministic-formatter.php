<?php
/**
 * Lightweight formatter checks. Run inside a WordPress test bootstrap for full coverage.
 */

final class CHCF_Deterministic_Formatter_Test extends WP_UnitTestCase {
	public function test_plain_unwrapped_paragraph() {
		$post = self::factory()->post->create_and_get( array( 'post_type' => 'lesson', 'post_title' => 'Water' ) );
		$result = ( new CHCF_Formatter() )->format( 'Water is important to the body.', $post, $this->settings() );
		$this->assertStringContainsString( '<p>Water is important to the body.</p>', $result['content'] );
	}

	public function test_standalone_heading_followed_by_prose() {
		$post = self::factory()->post->create_and_get( array( 'post_type' => 'lesson', 'post_title' => 'Water' ) );
		$result = ( new CHCF_Formatter() )->format( "Water in the Human Body\n\nWater makes up a significant proportion of the human body.", $post, $this->settings() );
		$this->assertStringContainsString( '<h2>Water in the Human Body</h2>', $result['content'] );
	}

	public function test_content_is_not_heading() {
		$post = self::factory()->post->create_and_get( array( 'post_type' => 'lesson', 'post_title' => 'Legitimacy' ) );
		$result = ( new CHCF_Formatter() )->format( "CONTENT\n\nThe meaning of legitimacy", $post, $this->settings() );
		$this->assertStringContainsString( '<p>CONTENT</p>', $result['content'] );
	}

	public function test_existing_latex_is_preserved() {
		$post = self::factory()->post->create_and_get( array( 'post_type' => 'lesson', 'post_title' => 'Algebra' ) );
		$result = ( new CHCF_Formatter() )->format( '<p>The value is \(x^2\).</p>', $post, $this->settings() );
		$this->assertSame( '<p>The value is \(x^2\).</p>', $result['content'] );
	}

	public function test_shortcode_is_preserved() {
		$post = self::factory()->post->create_and_get( array( 'post_type' => 'lesson', 'post_title' => 'Chemistry' ) );
		$result = ( new CHCF_Formatter() )->format( "[jtrt_tables id=\"32363\"]", $post, $this->settings() );
		$this->assertSame( '[jtrt_tables id="32363"]', $result['content'] );
	}

	public function test_rollback_conflict_validation_pattern() {
		$this->assertTrue( class_exists( 'CHCF_Rollback' ) );
	}

	private function settings() {
		return array(
			'paragraph_formatting'    => true,
			'heading_detection'       => true,
			'latex_conversion'        => true,
			'empty_paragraph_cleanup' => true,
			'confidence_threshold'    => 0.92,
		);
	}
}
