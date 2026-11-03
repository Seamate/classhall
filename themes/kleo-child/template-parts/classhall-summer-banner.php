<?php
$home_lessons_page = ! empty( $args['home_lessons_page'] );
if ( empty( $GLOBALS['classhall_allow_summer_banner'] ) && ! $home_lessons_page ) {
    return;
}
?>
<section class="ch-home-promo" aria-labelledby="ch-home-promo-title">
    <div class="ch-shell">
        <?php if ( $home_lessons_page ) : ?>
            <div class="ch-home-promo-link">
        <?php else : ?>
            <a class="ch-home-promo-link" href="<?php echo esc_url( home_url( '/online-classes/' ) ); ?>">
        <?php endif; ?>
            <img class="ch-home-promo-photo" src="https://classhall.com/wp-content/uploads/2026/09/classhall-home-lessons.webp" alt="Teacher helping three primary school pupils learn" width="921" height="614" loading="lazy" decoding="async">
            <div class="ch-home-promo-copy">
                <span class="ch-home-eyebrow"><?php esc_html_e( 'Build confidence in every subject', 'kleo-child' ); ?></span>
                <?php if ( $home_lessons_page ) : ?>
                    <h1 id="ch-home-promo-title"><?php esc_html_e( 'Online', 'kleo-child' ); ?> <span><?php esc_html_e( 'Classes', 'kleo-child' ); ?></span></h1>
                <?php else : ?>
                    <h2 id="ch-home-promo-title"><?php esc_html_e( 'Online', 'kleo-child' ); ?> <span><?php esc_html_e( 'Classes', 'kleo-child' ); ?></span></h2>
                <?php endif; ?>
                <p class="ch-home-promo-age"><?php esc_html_e( 'Primary 1 - 6 | JSS1 - SS3', 'kleo-child' ); ?></p>
                <p class="ch-home-promo-platform"><?php esc_html_e( 'Learn from home via Google Meet', 'kleo-child' ); ?></p>
                <p><?php esc_html_e( 'Mathematics, English Language and Sciences', 'kleo-child' ); ?></p>
                <div class="ch-home-promo-facts">
                    <span class="ch-home-promo-time"><small><?php esc_html_e( 'Lesson time', 'kleo-child' ); ?></small><strong><?php esc_html_e( 'Weekdays, 4:30 - 6:30 pm', 'kleo-child' ); ?></strong></span>
                    <span><small><?php esc_html_e( 'Primary 1 - JSS3 monthly', 'kleo-child' ); ?></small><strong>&#8358;15,000</strong></span>
                    <span><small><?php esc_html_e( 'SS1 - SS3 Sciences monthly', 'kleo-child' ); ?></small><strong>&#8358;25,000</strong></span>
                </div>
                <?php if ( ! $home_lessons_page ) : ?>
                    <span class="chl-home-button"><?php esc_html_e( 'Enrol your child', 'kleo-child' ); ?> <span aria-hidden="true">&rarr;</span></span>
                <?php endif; ?>
            </div>
        <?php if ( $home_lessons_page ) : ?>
            </div>
        <?php else : ?>
            </a>
        <?php endif; ?>
    </div>
</section>
