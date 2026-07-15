<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Validator {
	private $protection;

	public function __construct() {
		$this->protection = new CHCF_Protection();
	}

	public function validate( $original, $updated ) {
		$errors = array();
		$before = $this->protection->snapshot( $original );
		$after  = $this->protection->snapshot( $updated );

		foreach ( array( 'images', 'links', 'shortcodes' ) as $key ) {
			if ( $before[ $key ] !== $after[ $key ] ) {
				$errors[] = 'Protected ' . $key . ' changed.';
			}
		}

		if ( $before['blocks_open'] !== $after['blocks_open'] || $before['blocks_close'] !== $after['blocks_close'] ) {
			$errors[] = 'Gutenberg block markers changed.';
		}

		if ( 0 !== substr_count( $updated, '\\(' ) - substr_count( $updated, '\\)' ) ) {
			$errors[] = 'Inline MathJax delimiters are unbalanced.';
		}

		if ( 0 !== substr_count( $updated, '\\[' ) - substr_count( $updated, '\\]' ) ) {
			$errors[] = 'Display MathJax delimiters are unbalanced.';
		}

		if ( preg_match( '/\\\\\([^)]*\\\\\(/', $updated ) ) {
			$errors[] = 'Nested inline MathJax delimiter detected.';
		}

		if ( $before['tables'] !== $after['tables'] ) {
			$errors[] = 'Table structure counts changed.';
		}

		if ( $before['iframes'] !== $after['iframes'] || $before['scripts'] !== $after['scripts'] ) {
			$errors[] = 'Script or iframe counts changed.';
		}

		if ( preg_match( '/<p\b[^>]*>[\s\S]*<p\b/i', $updated ) ) {
			$errors[] = 'Nested paragraph markup detected.';
		}

		if ( preg_match( '/<p\b[^>]*>[\s\S]*<h[1-6]\b/i', $updated ) ) {
			$errors[] = 'Heading appears inside a paragraph.';
		}

		if ( preg_match_all( '/<h[1-6]\b[^>]*>([\s\S]*?)<\/h[1-6]>/i', $updated, $matches ) ) {
			foreach ( $matches[1] as $heading ) {
				if ( str_word_count( wp_strip_all_tags( $heading ) ) > 18 ) {
					$errors[] = 'Heading contains a long paragraph.';
					break;
				}
			}
		}

		$plain_before = $this->normalise_plain_text( $original );
		$plain_after  = $this->normalise_plain_text( $updated );
		if ( strlen( $plain_before ) > 0 && strlen( $plain_after ) < ( strlen( $plain_before ) * 0.90 ) ) {
			$errors[] = 'Plain text became unexpectedly shorter.';
		}

		return $errors;
	}

	private function normalise_plain_text( $html ) {
		return preg_replace( '/\s+/', ' ', trim( wp_strip_all_tags( strip_shortcodes( $html ) ) ) );
	}
}
