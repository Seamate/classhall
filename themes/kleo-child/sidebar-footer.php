<?php
/**
 * Footer sidebar override for Kleo child theme.
 *
 * @package WordPress
 * @subpackage Kleo_Child
 */

$kleo_footer_hidden = apply_filters( 'kleo_footer_hidden', false );

if ( true === $kleo_footer_hidden ) {
    return;
}

if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) && ! is_active_sidebar( 'footer-4' ) ) {
    return;
}
?>

<div id="footer" class="footer-color border-top">
    <div class="container">
        <div class="template-page tpl-no">
            <div class="wrap-content">
                <div class="row">
                    <div class="col-sm-3">
                        <div id="footer-sidebar-1" class="footer-sidebar widget-area" role="complementary">
                            <?php
                            if ( function_exists( 'dynamic_sidebar' ) ) {
                                dynamic_sidebar( 'footer-1' );
                            }

                            if ( is_user_logged_in() && function_exists( 'classhall_logout_url' ) ) :
                                ?>
                                <div class="classhall-footer-logout-wrap">
                                    <a class="classhall-footer-logout" href="<?php echo esc_url( classhall_logout_url() ); ?>">
                                        <?php esc_html_e( 'Logout', 'kleo-child' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div id="footer-sidebar-2" class="footer-sidebar widget-area" role="complementary">
                            <?php
                            if ( function_exists( 'dynamic_sidebar' ) ) {
                                dynamic_sidebar( 'footer-2' );
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div id="footer-sidebar-3" class="footer-sidebar widget-area" role="complementary">
                            <?php
                            if ( function_exists( 'dynamic_sidebar' ) ) {
                                dynamic_sidebar( 'footer-3' );
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div id="footer-sidebar-4" class="footer-sidebar widget-area" role="complementary">
                            <?php
                            if ( function_exists( 'dynamic_sidebar' ) ) {
                                dynamic_sidebar( 'footer-4' );
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
