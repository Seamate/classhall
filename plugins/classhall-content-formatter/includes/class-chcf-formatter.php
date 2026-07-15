<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Formatter {
	private $protection;

	public function __construct() {
		$this->protection = new CHCF_Protection();
	}

	public function format( $content, $post, $settings ) {
		$changes = array();
		$tokens  = array();
		$work    = $this->protection->protect( (string) $content, $tokens );

		if ( ! empty( $settings['empty_paragraph_cleanup'] ) ) {
			$before = $work;
			$work   = preg_replace( '/<p>\s*(?:&nbsp;|\xC2\xA0|\s)*<\/p>/i', '', $work );
			if ( $work !== $before ) {
				$changes[] = $this->change( 'empty_paragraph', 'Empty paragraph cleanup', '', '', 0.99, 'Removed empty paragraph markup away from protected media and tables.' );
			}
		}

		if ( ! empty( $settings['paragraph_formatting'] ) || ! empty( $settings['heading_detection'] ) || ! empty( $settings['latex_conversion'] ) ) {
			$work = $this->format_blocks( $work, $post, $settings, $changes );
		}

		$work = $this->protection->restore( $work, $tokens );
		$work = $this->repair_obvious_invalid_wrapping( $work );

		return array(
			'content' => $work,
			'changes' => $changes,
		);
	}

	private function format_blocks( $content, $post, $settings, &$changes ) {
		$content = preg_replace( "/\r\n?/", "\n", $content );
		$parts   = preg_split( "/\n{2,}/", $content );
		$out     = array();
		$index   = 0;
		$ai_decisions = $this->ai_decisions_for_parts( $parts, $post, $settings );

		foreach ( $parts as $part ) {
			$index++;
			$block = trim( $part );
			if ( '' === $block ) {
				continue;
			}

			if ( $this->is_block_html( $block ) || $this->is_protected_token( $block ) ) {
				$out[] = $this->convert_inline_latex( $block, $settings, $changes, 'block_' . $index );
				continue;
			}

			$lines = array_values( array_filter( array_map( 'trim', explode( "\n", $block ) ), 'strlen' ) );
			foreach ( $lines as $line ) {
				$block_id = 'block_' . $index;
				if ( $this->is_blank_content_line( $line ) ) {
					continue;
				}

				if ( $this->is_block_html( $line ) || $this->is_html_tag_line( $line ) ) {
					$out[] = $this->convert_inline_latex( $line, $settings, $changes, $block_id );
					continue;
				}

				if ( isset( $ai_decisions[ $block_id ] ) && $this->ai_decision_matches( $ai_decisions[ $block_id ], $line ) ) {
					$decision = $ai_decisions[ $block_id ];
					if ( 'ignore' !== $decision['type'] ) {
						$out[] = $decision['replacement'];
						$changes[] = $this->change( $decision['type'], $block_id, $line, $decision['replacement'], (float) $decision['confidence'], 'AI: ' . $decision['reason'] );
						continue;
					}
				}

				$converted = $this->convert_inline_latex( $line, $settings, $changes, 'block_' . $index );

				if ( ! empty( $settings['heading_detection'] ) && $this->is_heading_candidate( $line, $post ) ) {
					$level = $this->heading_level( $line, $post );
					$text  = 1 === $level ? strtoupper( wp_strip_all_tags( $line ) ) : wp_strip_all_tags( $line );
					$html  = '<h' . $level . '>' . esc_html( $text ) . '</h' . $level . '>';
					$out[] = $html;
					$changes[] = $this->change( 'heading', 'block_' . $index, $line, $html, 0.94, 'Standalone concise topic phrase followed by lesson prose.' );
					continue;
				}

				if ( ! empty( $settings['paragraph_formatting'] ) && ! $this->is_block_html( $converted ) ) {
					$html = '<p>' . $converted . '</p>';
					$out[] = $html;
					$changes[] = $this->change( 'paragraph', 'block_' . $index, $line, $html, 0.97, 'Plain prose line was not wrapped in a block-level element.' );
					continue;
				}

				$out[] = $converted;
			}
		}

		return implode( "\n", $out );
	}

	private function ai_decisions_for_parts( array $parts, $post, array $settings ) {
		if ( empty( $settings['ai_enabled'] ) ) {
			return array();
		}

		$blocks = array();
		$index = 0;
		foreach ( $parts as $part ) {
			$index++;
			$line = trim( $part );
			if ( '' === $line || $this->is_blank_content_line( $line ) || $this->is_block_html( $line ) || $this->is_html_tag_line( $line ) || $this->is_protected_token( $line ) ) {
				continue;
			}

			$plain = wp_strip_all_tags( $line );
			if ( str_word_count( $plain ) > 18 ) {
				continue;
			}

			$blocks[] = array(
				'block_id' => 'block_' . $index,
				'text'     => $line,
			);
		}

		if ( ! $blocks ) {
			return array();
		}

		$provider = CHCF_AI_Provider_Factory::make( $settings );
		$response = $provider->classify_blocks( $post instanceof WP_Post ? $post->ID : 0, $blocks, $settings );
		if ( empty( $response['decisions'] ) || ! is_array( $response['decisions'] ) ) {
			return array();
		}

		$decisions = array();
		foreach ( $response['decisions'] as $decision ) {
			if ( empty( $decision['block_id'] ) || empty( $decision['type'] ) || ! isset( $decision['replacement'], $decision['confidence'] ) ) {
				continue;
			}
			if ( ! in_array( $decision['type'], array( 'heading', 'paragraph', 'latex', 'ignore' ), true ) ) {
				continue;
			}
			if ( (float) $decision['confidence'] < 0 || (float) $decision['confidence'] > 1 ) {
				continue;
			}
			$decisions[ sanitize_key( $decision['block_id'] ) ] = array(
				'type'        => sanitize_key( $decision['type'] ),
				'original'    => (string) $decision['original'],
				'replacement' => wp_kses_post( (string) $decision['replacement'] ),
				'confidence'  => (float) $decision['confidence'],
				'reason'      => sanitize_text_field( (string) $decision['reason'] ),
			);
		}

		return $decisions;
	}

	private function ai_decision_matches( array $decision, $line ) {
		if ( empty( $decision['original'] ) || trim( $decision['original'] ) !== trim( $line ) ) {
			return false;
		}

		if ( 'heading' === $decision['type'] && preg_match( '/<h[1-4]\b[^>]*>[\s\S]{1,220}<\/h[1-4]>/i', $decision['replacement'] ) ) {
			return true;
		}

		if ( 'paragraph' === $decision['type'] && preg_match( '/^<p\b[^>]*>[\s\S]*<\/p>$/i', $decision['replacement'] ) ) {
			return true;
		}

		if ( 'latex' === $decision['type'] && false !== strpos( $decision['replacement'], '\\(' ) ) {
			return true;
		}

		return 'ignore' === $decision['type'];
	}

	private function convert_inline_latex( $text, $settings, &$changes, $block_id ) {
		if ( empty( $settings['latex_conversion'] ) || false !== strpos( $text, '\\(' ) || false !== strpos( $text, '\\[' ) || false !== strpos( $text, '$$' ) ) {
			return $text;
		}

		$before = $text;
		$map = array(
			'×' => '\\times',
			'÷' => '\\div',
			'−' => '-',
			'√' => '\\sqrt',
			'²' => '^2',
			'³' => '^3',
			'⁻' => '^-',
			'₀' => '_0',
			'₁' => '_1',
			'₂' => '_2',
			'₃' => '_3',
			'₄' => '_4',
			'₅' => '_5',
			'₆' => '_6',
			'₇' => '_7',
			'₈' => '_8',
			'₉' => '_9',
		);
		$text = strtr( $text, $map );
		$text = preg_replace( '/(?<![\w])(\d+)\/(\d+)(?![\w])/', '\\(\\\\frac{$1}{$2}\\)', $text );
		$text = preg_replace( '/(?<![\w])\\\\sqrt\s*(\d+|[a-zA-Z])/', '\\(\\\\sqrt{$1}\\)', $text );
		$text = preg_replace( '/(?<!\\\\\()([a-zA-Z]\^[-]?\d+(?:\s*[+\-=]\s*\d*[a-zA-Z]?\^?\d*)*)/', '\\($1\\)', $text );
		$text = preg_replace( '/(?<!\\\\\()(\d+\s*(?:\\\\times|\\\\div|[+\-=])\s*\d+(?:\s*=\s*\d+)*)/', '\\($1\\)', $text );
		$text = preg_replace( '/(?<!\\\\\()(\d+\^\-\d+)/', '\\($1\\)', $text );

		if ( $text !== $before ) {
			$changes[] = $this->change( 'latex', $block_id, $before, $text, 0.90, 'Deterministic conversion of mathematical symbols, powers, roots, or fractions.' );
		}

		return $text;
	}

	private function is_heading_candidate( $line, $post ) {
		$plain = trim( wp_strip_all_tags( html_entity_decode( $line, ENT_QUOTES, get_bloginfo( 'charset' ) ) ) );
		if ( '' === $plain ) {
			return false;
		}

		$blocked = array( 'CONTENT', 'EVALUATION AND ASSIGNMENTS' );
		if ( in_array( strtoupper( $plain ), $blocked, true ) ) {
			return false;
		}

		if ( preg_match( '/[.!?;:]$/', $plain ) ) {
			return false;
		}

		if ( preg_match( '/^\d+[\.)]\s+/', $plain ) || preg_match( '/^(activity|exercise|question)\s+\d+/i', $plain ) ) {
			return false;
		}

		$word_count = str_word_count( $plain );
		if ( $word_count < 2 || $word_count > 12 ) {
			return false;
		}

		if ( $post instanceof WP_Post && 0 === strcasecmp( $plain, $post->post_title ) ) {
			return true;
		}

		return ! preg_match( '/\b(is|are|was|were|has|have|does|perform|takes|costs|contains)\b/i', $plain );
	}

	private function heading_level( $line, $post ) {
		$plain = wp_strip_all_tags( $line );
		if ( $post instanceof WP_Post && 0 === strcasecmp( trim( $plain ), $post->post_title ) ) {
			return 1;
		}

		if ( preg_match( '/^\(?[A-Z]\)|^\d+\./', trim( $plain ) ) ) {
			return 3;
		}

		return 2;
	}

	private function is_block_html( $html ) {
		return (bool) preg_match( '/^\s*<(p|h[1-6]|ul|ol|li|table|thead|tbody|tfoot|tr|td|th|blockquote|figure|figcaption|div|section|article|pre|code|form|details|summary|img|iframe)\b/i', $html );
	}

	private function is_html_tag_line( $html ) {
		return (bool) preg_match( '/^\s*<\/?(p|h[1-6]|ul|ol|li|table|thead|tbody|tfoot|tr|td|th|blockquote|figure|figcaption|div|section|article|pre|code|form|details|summary|img|iframe)\b[^>]*>\s*$/i', $html );
	}

	private function is_blank_content_line( $line ) {
		$line = html_entity_decode( (string) $line, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$line = str_replace( array( "\xc2\xa0", '&nbsp;' ), ' ', $line );
		$line = wp_strip_all_tags( $line );
		return '' === trim( $line );
	}

	private function is_protected_token( $html ) {
		return (bool) preg_match( '/^%%CHCF_PROTECTED_\d+%%$/', $html );
	}

	private function repair_obvious_invalid_wrapping( $html ) {
		$html = preg_replace( '/<p>\s*(<h[1-6]\b[^>]*>.*?<\/h[1-6]>)\s*/is', '$1', $html );
		$html = preg_replace( '/\s*<\/p>\s*(<\/?(?:ul|ol|table|figure)\b)/i', '$1', $html );
		$html = preg_replace( '/<p>\s*(<(?:ul|ol|table|figure)\b)/i', '$1', $html );
		$html = preg_replace( '/(<\/(?:ul|ol|table|figure)>)\s*<\/p>/i', '$1', $html );
		return $html;
	}

	private function change( $type, $block_id, $original, $proposed, $confidence, $reason ) {
		return array(
			'block_id'  => $block_id,
			'type'      => $type,
			'original'  => $original,
			'proposed'  => $proposed,
			'confidence'=> $confidence,
			'reason'    => $reason,
		);
	}
}
