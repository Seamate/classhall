<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface CHCF_AI_Provider_Interface {
	public function classify_blocks( $post_id, array $blocks, array $settings );
}
