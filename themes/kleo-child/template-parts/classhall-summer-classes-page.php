<?php
$classhall_summer_payment_url = function_exists( 'classhall_get_summer_classes_checkout_url' ) ? classhall_get_summer_classes_checkout_url() : home_url( '/product/summer-classes/' );
$classhall_summer_image_url   = 'https://classhall.com/wp-content/uploads/2026/07/Classhall-Summer-Classes-1.jpg';
?>
<main id="classhall-summer" class="classhall-summer">
	<section class="chs-hero" aria-labelledby="classhall-summer-title">
		<div class="chs-shell chs-hero-grid">
			<div class="chs-copy">
				<p class="chs-kicker"><?php esc_html_e( 'Live Classes via Google Meet / Zoom', 'kleo-child' ); ?></p>
				<h1 id="classhall-summer-title"><?php esc_html_e( 'Help your child enter the new school year sharper, bolder, and future-ready.', 'kleo-child' ); ?></h1>
				<p class="chs-lead"><?php esc_html_e( 'Four weeks of focused online learning in English Language, Mathematics, Coding and Artificial Intelligence via Google Meet / Zoom, taught in a structured Classhall environment that builds mastery of the most important subjects.', 'kleo-child' ); ?></p>
				<div class="chs-hero-actions">
					<a class="chs-button chs-button-primary" href="<?php echo esc_url( $classhall_summer_payment_url ); ?>"><?php esc_html_e( 'Enroll and Pay Now', 'kleo-child' ); ?></a>
					<a class="chs-button chs-button-secondary" href="#summer-details"><?php esc_html_e( 'See Class Details', 'kleo-child' ); ?></a>
				</div>
			</div>

			<a class="chs-hero-image" href="<?php echo esc_url( $classhall_summer_payment_url ); ?>" aria-label="<?php esc_attr_e( 'Pay for Classhall Summer Classes', 'kleo-child' ); ?>">
				<img src="<?php echo esc_url( $classhall_summer_image_url ); ?>" alt="<?php esc_attr_e( 'Classhall Summer Classes flyer', 'kleo-child' ); ?>" decoding="async" fetchpriority="high">
			</a>
		</div>
	</section>

	<section id="summer-details" class="chs-details" aria-label="<?php esc_attr_e( 'Summer class details', 'kleo-child' ); ?>">
		<div class="chs-shell chs-detail-grid">
			<article>
				<span><?php esc_html_e( 'Dates', 'kleo-child' ); ?></span>
				<strong><?php esc_html_e( '27 July - 28 August 2026', 'kleo-child' ); ?></strong>
			</article>
			<article>
				<span><?php esc_html_e( 'Time and venue', 'kleo-child' ); ?></span>
				<strong><?php esc_html_e( '10 am - 4 pm, Monday to Friday. Live classes on Google Meet / Zoom', 'kleo-child' ); ?></strong>
			</article>
			<article>
				<span><?php esc_html_e( 'Subjects', 'kleo-child' ); ?></span>
				<strong><?php esc_html_e( 'English, Mathematics, Coding & AI', 'kleo-child' ); ?></strong>
			</article>
			<article class="chs-price-card">
				<span><?php esc_html_e( 'Early bird', 'kleo-child' ); ?></span>
				<strong>₦40,000</strong>
				<em><?php esc_html_e( 'Regular price ₦45,000', 'kleo-child' ); ?></em>
			</article>
		</div>
	</section>

	<section class="chs-section" aria-labelledby="summer-outcomes-title">
		<div class="chs-shell">
			<div class="chs-section-head">
				<p class="chs-kicker"><?php esc_html_e( 'What learners gain', 'kleo-child' ); ?></p>
				<h2 id="summer-outcomes-title"><?php esc_html_e( 'Mastery of the most important areas in English, Mathematics and Coding & AI.', 'kleo-child' ); ?></h2>
			</div>
			<div class="chs-outcome-grid">
				<article>
					<h3><?php esc_html_e( 'Stronger English skills', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Reading, comprehension, grammar, writing, and spoken English (Phonetics).', 'kleo-child' ); ?></p>
				</article>
				<article>
					<h3><?php esc_html_e( 'Sound Mathematical foundation', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Guided practice that strengthens number sense, problem solving, and exam readiness.', 'kleo-child' ); ?></p>
				</article>
				<article>
					<h3><?php esc_html_e( 'Coding & AI essentials', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Hands-on exposure to creative computing, logic, responsible AI use, and future-proof digital skills.', 'kleo-child' ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<section class="chs-cta" aria-labelledby="summer-payment-title">
		<div class="chs-shell chs-cta-panel">
			<div>
				<p class="chs-kicker"><?php esc_html_e( 'Limited summer seats', 'kleo-child' ); ?></p>
				<h2 id="summer-payment-title"><?php esc_html_e( 'Secure your child\'s place today.', 'kleo-child' ); ?></h2>
				<p><?php esc_html_e( 'Pay online through the Classhall product page and complete registration for the 2026 summer programme.', 'kleo-child' ); ?></p>
			</div>
			<a class="chs-button chs-button-primary" href="<?php echo esc_url( $classhall_summer_payment_url ); ?>"><?php esc_html_e( 'Proceed to Payment', 'kleo-child' ); ?></a>
		</div>
	</section>
</main>
