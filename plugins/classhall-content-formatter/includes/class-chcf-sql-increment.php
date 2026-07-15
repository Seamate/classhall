<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_SQL_Increment {
	public $amount;

	public function __construct( $amount ) {
		$this->amount = absint( $amount );
	}
}
