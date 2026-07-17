<?php
$classhall_summer_page_url    = home_url( '/summer-classes/' );
$classhall_summer_image_url   = 'https://classhall.com/wp-content/uploads/2026/07/Classhall-Summer-Classes-1.jpg';
?>
<section class="ch-summer-banner" aria-labelledby="classhall-summer-banner-title">
	<div class="ch-shell">
		<a class="ch-summer-banner-card" href="<?php echo esc_url( $classhall_summer_page_url ); ?>" aria-label="<?php esc_attr_e( 'View Classhall Summer Classes details', 'kleo-child' ); ?>">
			<span class="ch-summer-banner-copy">
				<span class="ch-summer-kicker"><?php esc_html_e( 'Live Summer Classes via Google Meet / Zoom', 'kleo-child' ); ?></span>
				<strong id="classhall-summer-banner-title"><?php esc_html_e( 'English, Mathematics, Coding & AI', 'kleo-child' ); ?></strong>
				<span class="ch-summer-meta"><?php esc_html_e( '27 July - 28 August 2026 | Monday to Friday | 10 am - 4 pm', 'kleo-child' ); ?></span>
				<span class="ch-summer-price-row">
					<span><?php esc_html_e( 'Early bird', 'kleo-child' ); ?> <b>₦40,000</b></span>
					<span><?php esc_html_e( 'Regular', 'kleo-child' ); ?> <b>₦45,000</b></span>
				</span>
				<span class="ch-summer-banner-actions">
					<span class="ch-summer-banner-button"><?php esc_html_e( 'Reserve a Seat', 'kleo-child' ); ?></span>
					<span class="ch-summer-banner-link"><?php esc_html_e( 'View details', 'kleo-child' ); ?></span>
				</span>
			</span>
			<span class="ch-summer-banner-media">
				<img src="<?php echo esc_url( $classhall_summer_image_url ); ?>" alt="<?php esc_attr_e( 'Classhall Summer Classes for English, Mathematics, Coding and AI', 'kleo-child' ); ?>" loading="lazy" decoding="async">
			</span>
		</a>
	</div>
</section>
