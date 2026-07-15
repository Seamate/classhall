<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_OpenAI_Provider implements CHCF_AI_Provider_Interface {
	public function classify_blocks( $post_id, array $blocks, array $settings ) {
		$api_key = get_option( $settings['api_key_option'] ?? 'chcf_api_key', '' );
		if ( '' === $api_key ) {
			return array(
				'post_id'   => absint( $post_id ),
				'decisions' => array(),
				'usage'     => array(),
				'error'     => 'OpenAI API key is not configured.',
			);
		}

		$endpoint = ! empty( $settings['endpoint'] ) ? $settings['endpoint'] : 'https://api.openai.com/v1/chat/completions';
		$body     = array(
			'model'           => ! empty( $settings['model'] ) ? $settings['model'] : 'gpt-4o-mini',
			'temperature'     => isset( $settings['temperature'] ) ? (float) $settings['temperature'] : 0,
			'max_tokens'      => isset( $settings['token_limit'] ) ? absint( $settings['token_limit'] ) : 1200,
			'messages'        => array(
				array(
					'role'    => 'system',
					'content' => 'You classify lesson-content blocks for safe HTML formatting. Return only JSON matching the schema. Do not rewrite full lessons. Preserve wording and British English.',
				),
				array(
					'role'    => 'user',
					'content' => wp_json_encode(
						array(
							'post_id' => absint( $post_id ),
							'blocks'  => $blocks,
							'rules'   => array(
								'CONTENT is not a heading.',
								'EVALUATION AND ASSIGNMENTS is not a heading.',
								'Use h2 for main sections, h3 for subsections, h4 for smaller subdivisions.',
								'Only identify genuine mathematical or scientific notation.',
							),
						)
					),
				),
			),
			'response_format' => array(
				'type'        => 'json_schema',
				'json_schema' => array(
					'name'   => 'classhall_formatter_decisions',
					'strict' => true,
					'schema' => $this->schema(),
				),
			),
		);

		$response = wp_remote_post(
			$endpoint,
			array(
				'timeout' => isset( $settings['timeout'] ) ? absint( $settings['timeout'] ) : 20,
				'headers' => array(
					'Authorization' => 'Bearer ' . $api_key,
					'Content-Type'  => 'application/json',
				),
				'body'    => wp_json_encode( $body ),
			)
		);

		if ( is_wp_error( $response ) ) {
			return array(
				'post_id'   => absint( $post_id ),
				'decisions' => array(),
				'usage'     => array(),
				'error'     => $response->get_error_message(),
			);
		}

		$decoded = json_decode( wp_remote_retrieve_body( $response ), true );
		$content = $decoded['choices'][0]['message']['content'] ?? '';
		$parsed  = json_decode( $content, true );

		if ( ! is_array( $parsed ) || empty( $parsed['decisions'] ) || ! is_array( $parsed['decisions'] ) ) {
			return array(
				'post_id'   => absint( $post_id ),
				'decisions' => array(),
				'usage'     => $decoded['usage'] ?? array(),
				'error'     => 'AI returned no valid decisions.',
			);
		}

		$parsed['usage'] = $decoded['usage'] ?? array();
		return $parsed;
	}

	private function schema() {
		return array(
			'type'                 => 'object',
			'additionalProperties' => false,
			'properties'           => array(
				'post_id'   => array( 'type' => 'integer' ),
				'decisions' => array(
					'type'  => 'array',
					'items' => array(
						'type'                 => 'object',
						'additionalProperties' => false,
						'properties'           => array(
							'block_id'       => array( 'type' => 'string' ),
							'type'           => array( 'type' => 'string', 'enum' => array( 'heading', 'paragraph', 'latex', 'ignore' ) ),
							'heading_level'  => array( 'type' => 'integer', 'enum' => array( 0, 1, 2, 3, 4 ) ),
							'original'       => array( 'type' => 'string' ),
							'replacement'    => array( 'type' => 'string' ),
							'confidence'     => array( 'type' => 'number' ),
							'reason'         => array( 'type' => 'string' ),
						),
						'required'             => array( 'block_id', 'type', 'heading_level', 'original', 'replacement', 'confidence', 'reason' ),
					),
				),
			),
			'required'             => array( 'post_id', 'decisions' ),
		);
	}
}
