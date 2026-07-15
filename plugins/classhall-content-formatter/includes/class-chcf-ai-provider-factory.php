<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_AI_Provider_Factory {
	public static function make( array $settings ) {
		if ( empty( $settings['ai_enabled'] ) || 'openai' !== ( $settings['provider'] ?? 'none' ) ) {
			return new CHCF_Null_AI_Provider();
		}

		return new CHCF_OpenAI_Provider();
	}
}
