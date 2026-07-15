<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Null_AI_Provider implements CHCF_AI_Provider_Interface {
	public function classify_blocks( $post_id, array $blocks, array $settings ) {
		return array(
			'post_id'   => absint( $post_id ),
			'decisions' => array(),
			'usage'     => array(),
		);
	}
}
