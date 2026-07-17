<?php
/**
 * Sensei login form override.
 *
 * Replaces the default Sensei login box with the site's Ultimate Member login form.
 *
 * @package WordPress
 * @subpackage Kleo_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'sensei_login_form_before' );

$login_form = '';

if ( function_exists( 'UM' ) && method_exists( UM(), 'shortcodes' ) ) {
	$form_id = UM()->shortcodes()->core_login_form();

	if ( $form_id ) {
		$login_form = do_shortcode( '[ultimatemember form_id="' . absint( $form_id ) . '"]' );
	}
}

if ( $login_form ) {
	echo $login_form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
} elseif ( function_exists( 'um_get_core_page' ) ) {
	?>
	<p>
		<a class="button wp-element-button" href="<?php echo esc_url( um_get_core_page( 'login' ) ); ?>">
			<?php esc_html_e( 'Sign in to Classhall', 'kleo-child' ); ?>
		</a>
	</p>
	<?php
} else {
	wp_login_form(
		array(
			'redirect'       => function_exists( 'sensei_get_current_page_url' ) ? sensei_get_current_page_url() : home_url( '/' ),
			'remember'       => true,
			'label_username' => __( 'Username or Email', 'sensei-lms' ),
			'label_password' => __( 'Password', 'sensei-lms' ),
			'label_log_in'   => __( 'Login', 'sensei-lms' ),
		)
	);
}

do_action( 'sensei_login_form_after' );
