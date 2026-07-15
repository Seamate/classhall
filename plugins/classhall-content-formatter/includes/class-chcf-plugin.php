<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class CHCF_Plugin {
	const CAPABILITY = 'manage_options';
	const OPTION_SETTINGS = 'chcf_settings';

	private static $instance = null;

	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
		add_action( 'wp_ajax_chcf_start_run', array( $this, 'ajax_start_run' ) );
		add_action( 'wp_ajax_chcf_process_batch', array( $this, 'ajax_process_batch' ) );
		add_action( 'wp_ajax_chcf_pause_run', array( $this, 'ajax_pause_run' ) );
		add_action( 'wp_ajax_chcf_resume_run', array( $this, 'ajax_resume_run' ) );
		add_action( 'wp_ajax_chcf_stop_run', array( $this, 'ajax_stop_run' ) );
		add_action( 'wp_ajax_chcf_review_change', array( $this, 'ajax_review_change' ) );
		add_action( 'wp_ajax_chcf_rollback_run', array( $this, 'ajax_rollback_run' ) );
		add_action( 'admin_post_chcf_save_settings', array( $this, 'save_settings' ) );
		add_action( 'chcf_process_run', array( $this, 'process_scheduled_run' ) );
	}

	public function admin_menu() {
		add_management_page(
			__( 'Classhall Content Formatter', 'classhall-content-formatter' ),
			__( 'Classhall Content Formatter', 'classhall-content-formatter' ),
			self::CAPABILITY,
			'classhall-content-formatter',
			array( $this, 'render_admin_page' )
		);
	}

	public function admin_assets( $hook ) {
		if ( 'tools_page_classhall-content-formatter' !== $hook ) {
			return;
		}

		wp_enqueue_style( 'chcf-admin', CHCF_PLUGIN_URL . 'assets/admin.css', array(), CHCF_VERSION );
		wp_enqueue_script( 'chcf-admin', CHCF_PLUGIN_URL . 'assets/admin.js', array( 'jquery' ), CHCF_VERSION, true );
		wp_localize_script(
			'chcf-admin',
			'chcfAdmin',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'chcf_admin' ),
			)
		);
	}

	public function render_admin_page() {
		$repository = new CHCF_Repository();
		$runs       = $repository->get_recent_runs();
		$taxonomies = get_object_taxonomies( 'lesson', 'objects' );
		$settings   = $this->get_settings();

		include CHCF_PLUGIN_DIR . 'includes/view-admin-page.php';
	}

	public function ajax_start_run() {
		$this->verify_ajax();
		$provider_settings = self::get_settings();
		$run_settings      = CHCF_Request::settings_from_request( $_POST );
		$run_ai_enabled    = ! empty( $provider_settings['ai_enabled'] ) && ! empty( $run_settings['ai_enabled'] );
		$settings          = array_merge( $provider_settings, $run_settings );
		$settings['ai_enabled'] = $run_ai_enabled;
		$run_id   = ( new CHCF_Runner() )->create_run( $settings, get_current_user_id() );

		wp_send_json_success( array( 'run_id' => $run_id ) );
	}

	public function ajax_process_batch() {
		$this->verify_ajax();
		$run_id = isset( $_POST['run_id'] ) ? absint( $_POST['run_id'] ) : 0;
		wp_send_json_success( ( new CHCF_Runner() )->process_batch( $run_id ) );
	}

	public function ajax_pause_run() {
		$this->change_run_status( 'paused' );
	}

	public function ajax_resume_run() {
		$this->change_run_status( 'running' );
	}

	public function ajax_stop_run() {
		$this->change_run_status( 'stopped' );
	}

	public function ajax_review_change() {
		$this->verify_ajax();
		$change_id = isset( $_POST['change_id'] ) ? absint( $_POST['change_id'] ) : 0;
		$status    = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : '';

		if ( ! in_array( $status, array( 'approved', 'rejected' ), true ) ) {
			wp_send_json_error( array( 'message' => __( 'Invalid review status.', 'classhall-content-formatter' ) ), 400 );
		}

		( new CHCF_Repository() )->set_change_status( $change_id, $status, get_current_user_id() );
		wp_send_json_success();
	}

	public function ajax_rollback_run() {
		$this->verify_ajax();
		$run_id = isset( $_POST['run_id'] ) ? absint( $_POST['run_id'] ) : 0;
		wp_send_json_success( ( new CHCF_Rollback() )->rollback_run( $run_id ) );
	}

	public function process_scheduled_run( $run_id ) {
		( new CHCF_Runner() )->process_batch( absint( $run_id ) );
	}

	public function save_settings() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_die( esc_html__( 'Permission denied.', 'classhall-content-formatter' ) );
		}

		check_admin_referer( 'chcf_save_settings' );

		$settings = array(
			'ai_enabled'     => ! empty( $_POST['ai_enabled'] ),
			'provider'       => isset( $_POST['provider'] ) ? sanitize_key( wp_unslash( $_POST['provider'] ) ) : 'none',
			'model'          => isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : 'gpt-4o-mini',
			'endpoint'       => isset( $_POST['endpoint'] ) ? esc_url_raw( wp_unslash( $_POST['endpoint'] ) ) : 'https://api.openai.com/v1/chat/completions',
			'temperature'    => isset( $_POST['temperature'] ) ? (string) max( 0, min( 1, (float) $_POST['temperature'] ) ) : '0',
			'token_limit'    => isset( $_POST['token_limit'] ) ? max( 200, min( 4000, absint( $_POST['token_limit'] ) ) ) : 1200,
			'timeout'        => isset( $_POST['timeout'] ) ? max( 5, min( 120, absint( $_POST['timeout'] ) ) ) : 20,
			'max_ai_calls'   => isset( $_POST['max_ai_calls'] ) ? max( 0, min( 500, absint( $_POST['max_ai_calls'] ) ) ) : 0,
			'api_key_option' => 'chcf_api_key',
		);

		update_option( self::OPTION_SETTINGS, $settings, false );

		if ( isset( $_POST['api_key'] ) && '' !== trim( wp_unslash( $_POST['api_key'] ) ) ) {
			$api_key = trim( sanitize_text_field( wp_unslash( $_POST['api_key'] ) ) );
			if ( false === get_option( 'chcf_api_key', false ) ) {
				add_option( 'chcf_api_key', $api_key, '', false );
			} else {
				update_option( 'chcf_api_key', $api_key, false );
			}
		}

		wp_safe_redirect( add_query_arg( 'chcf_settings_saved', '1', wp_get_referer() ? wp_get_referer() : admin_url( 'tools.php?page=classhall-content-formatter' ) ) );
		exit;
	}

	public static function get_settings() {
		$defaults = array(
			'ai_enabled'      => false,
			'provider'        => 'none',
			'model'           => 'gpt-4o-mini',
			'endpoint'        => 'https://api.openai.com/v1/chat/completions',
			'temperature'     => '0',
			'token_limit'     => 1200,
			'timeout'         => 20,
			'max_ai_calls'    => 0,
			'api_key_option'  => 'chcf_api_key',
		);

		$options = get_option( self::OPTION_SETTINGS, array() );
		return wp_parse_args( is_array( $options ) ? $options : array(), $defaults );
	}

	private function change_run_status( $status ) {
		$this->verify_ajax();
		$run_id = isset( $_POST['run_id'] ) ? absint( $_POST['run_id'] ) : 0;
		( new CHCF_Repository() )->update_run_status( $run_id, $status );
		wp_send_json_success();
	}

	private function verify_ajax() {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'classhall-content-formatter' ) ), 403 );
		}

		check_ajax_referer( 'chcf_admin', 'nonce' );
	}
}
