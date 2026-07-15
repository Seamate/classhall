<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Protection {
	public function snapshot( $html ) {
		return array(
			'images'       => $this->attributes( $html, 'img', 'src' ),
			'links'        => $this->attributes( $html, 'a', 'href' ),
			'shortcodes'   => $this->shortcodes( $html ),
			'blocks_open'  => substr_count( $html, '<!-- wp:' ),
			'blocks_close' => substr_count( $html, '<!-- /wp:' ),
			'latex_inline' => substr_count( $html, '\\(' ) + substr_count( $html, '\\)' ),
			'latex_block'  => substr_count( $html, '\\[' ) + substr_count( $html, '\\]' ) + substr_count( $html, '$$' ),
			'tables'       => array(
				'table' => preg_match_all( '/<table\b/i', $html ),
				'tr'    => preg_match_all( '/<tr\b/i', $html ),
				'td'    => preg_match_all( '/<td\b/i', $html ),
				'th'    => preg_match_all( '/<th\b/i', $html ),
			),
			'iframes'      => preg_match_all( '/<iframe\b/i', $html ),
			'scripts'      => preg_match_all( '/<script\b/i', $html ),
		);
	}

	public function protect( $html, &$tokens ) {
		$tokens = array();
		$patterns = array(
			'/<!--\s*\/?wp:[\s\S]*?-->/',
			'/\[[A-Za-z0-9_-]+[^\]]*\]/',
			'/\\\\\([\s\S]*?\\\\\)/',
			'/\\\\\[[\s\S]*?\\\\\]/',
			'/\$\$[\s\S]*?\$\$/',
			'/\\\\begin\{[^}]+\}[\s\S]*?\\\\end\{[^}]+\}/',
			'/<table\b[\s\S]*?<\/table>/i',
			'/<ul\b[\s\S]*?<\/ul>/i',
			'/<ol\b[\s\S]*?<\/ol>/i',
			'/<figure\b[\s\S]*?<\/figure>/i',
			'/<pre\b[\s\S]*?<\/pre>/i',
			'/<code\b[\s\S]*?<\/code>/i',
			'/<script\b[\s\S]*?<\/script>/i',
			'/<style\b[\s\S]*?<\/style>/i',
			'/<iframe\b[\s\S]*?<\/iframe>/i',
		);

		foreach ( $patterns as $pattern ) {
			$html = preg_replace_callback(
				$pattern,
				function ( $match ) use ( &$tokens ) {
					$key = '%%CHCF_PROTECTED_' . count( $tokens ) . '%%';
					$tokens[ $key ] = $match[0];
					return $key;
				},
				$html
			);
		}

		return $html;
	}

	public function restore( $html, $tokens ) {
		return strtr( $html, $tokens );
	}

	private function attributes( $html, $tag, $attribute ) {
		$values = array();
		if ( preg_match_all( '/<' . preg_quote( $tag, '/' ) . '\b[^>]*\s' . preg_quote( $attribute, '/' ) . '\s*=\s*(["\'])(.*?)\1/i', $html, $matches ) ) {
			$values = $matches[2];
		}

		sort( $values );
		return $values;
	}

	private function shortcodes( $html ) {
		$names = array();
		if ( preg_match_all( '/\[\/?([A-Za-z0-9_-]+)/', $html, $matches ) ) {
			$names = $matches[1];
		}

		sort( $names );
		return $names;
	}
}
