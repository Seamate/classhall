<?php
$classhall_support_email    = 'hi@classhall.com';
$classhall_whatsapp_display = '+234 704 596 7535';
$classhall_whatsapp_url     = 'https://wa.me/2347045967535';
$classhall_logo_url         = 'https://classhall.com/wp-content/uploads/2026/07/classhall-logo.png';
$classhall_logo_id          = function_exists( 'attachment_url_to_postid' ) ? attachment_url_to_postid( $classhall_logo_url ) : 0;

$classhall_class_menu = array(
	'Primary' => array(
		'category' => '/class-bundles/',
		'subjects' => array(
			array( 'Primary Mathematics', '/class-bundles/' ),
			array( 'Primary English', '/class-bundles/' ),
			array( 'Primary Basic Science', '/class-bundles/' ),
			array( 'Primary Social Studies', '/class-bundles/' ),
			array( 'Primary Civic Education', '/class-bundles/' ),
			array( 'Primary Creative Arts', '/class-bundles/' ),
		),
	),
	'JSS 1' => array(
		'category' => '/subject-category/jss1/',
		'subjects' => array(
			array( 'JSS1 Agricultural Science', '/subject/agricultural-science-jss1-upper-basic-7/' ),
			array( 'JSS1 Basic Science', '/subject/basic-science-jss1-upper-basic-7/' ),
			array( 'JSS1 Basic Technology', '/subject/basic-technology-jss1-upper-basic-7/' ),
			array( 'JSS1 Business Studies', '/subject/business-studies-jss1-upper-basic-7/' ),
			array( 'JSS1 Christian Religious Studies (CRS)', '/subject/christian-religious-studies-jss1-upper-basic-7/' ),
			array( 'JSS1 Civic Education', '/subject/civic-education-jss1-upper-basic-7/' ),
			array( 'JSS1 Computer Studies', '/subject/computer-studies-jss1-upper-basic-7/' ),
			array( 'JSS1 Cultural and Creative Arts', '/subject/cultural-and-creative-art-jss1-upper-basic-7/' ),
			array( 'JSS1 English Studies', '/subject/english-studies-jss1-upper-basic-7/' ),
			array( 'JSS1 Home Economics', '/subject/home-economics-jss1-upper-basic-7/' ),
			array( 'JSS1 Mathematics', '/subject/mathematics-jss1-upper-basic-7/' ),
			array( 'JSS1 Music', '/subject/music-jss1-upper-basic-7/' ),
			array( 'JSS1 Physical and Health Education (PHE)', '/subject/physical-health-education-jss1-upper-basic-7/' ),
			array( 'JSS1 Social Studies', '/subject/social-studies-jss1-upper-basic-7/' ),
		),
	),
	'JSS 2' => array(
		'category' => '/subject-category/jss2/',
		'subjects' => array(
			array( 'JSS2 Agricultural Science', '/subject/agricultural-science-jss2-upper-basic-8/' ),
			array( 'JSS2 Basic Science', '/subject/basic-science-jss2-upper-basic-8/' ),
			array( 'JSS2 Basic Technology', '/subject/basic-technology-jss2-upper-basic-8/' ),
			array( 'JSS2 Business Studies', '/subject/business-studies-jss2-upper-basic-8/' ),
			array( 'JSS2 Christian Religious Studies (CRS)', '/subject/christian-religious-studies-jss2-upper-basic-8/' ),
			array( 'JSS2 Civic Education', '/subject/civic-education-jss2-upper-basic-8/' ),
			array( 'JSS2 Computer Studies', '/subject/computer-studies-jss2-upper-basic-8/' ),
			array( 'JSS2 Cultural and Creative Arts', '/subject/cultural-and-creative-art-jss2-upper-basic-8/' ),
			array( 'JSS2 English Studies', '/subject/english-studies-jss2-upper-basic-8/' ),
			array( 'JSS2 Home Economics', '/subject/home-economics-jss2-upper-basic-8/' ),
			array( 'JSS2 Mathematics', '/subject/mathematics-jss2-upper-basic-8/' ),
			array( 'JSS2 Music', '/subject/music-jss2-upper-basic-8/' ),
			array( 'JSS2 Physical and Health Education (PHE)', '/subject/physical-health-education-jss2-upper-basic-8/' ),
			array( 'JSS2 Social Studies', '/subject/social-studies-jss2-upper-basic-8/' ),
		),
	),
	'JSS 3' => array(
		'category' => '/subject-category/jss3/',
		'subjects' => array(
			array( 'JSS3 Agricultural Science', '/subject/agricultural-science-jss3-upper-basic-9/' ),
			array( 'JSS3 Basic Science', '/subject/basic-science-jss3-upper-basic-9/' ),
			array( 'JSS3 Basic Technology', '/subject/basic-technology-jss3-upper-basic-9/' ),
			array( 'JSS3 Business Studies', '/subject/business-studies-jss3-upper-basic-9/' ),
			array( 'JSS3 Christian Religious Studies (CRS)', '/subject/christian-religious-studies-jss3-upper-basic-9/' ),
			array( 'JSS3 Civic Education', '/subject/civic-education-jss3-upper-basic-9/' ),
			array( 'JSS3 Computer Studies', '/subject/computer-studies-jss3-upper-basic-9/' ),
			array( 'JSS3 Cultural and Creative Arts', '/subject/cultural-and-creative-art-jss-3-upper-basic-9/' ),
			array( 'JSS3 English Studies', '/subject/english-studies-jss3-upper-basic-9/' ),
			array( 'JSS3 Home Economics', '/subject/home-economics-jss3-upper-basic-9/' ),
			array( 'JSS3 Mathematics', '/subject/mathematics-jss3-upper-basic-9/' ),
			array( 'JSS3 Music', '/subject/music-jss3-upper-basic-9/' ),
			array( 'JSS3 Physical and Health Education (PHE)', '/subject/physical-health-education-jss3-upper-basic-9/' ),
			array( 'JSS3 Social Studies', '/subject/social-studies-jss3-upper-basic-9/' ),
		),
	),
	'SS 1' => array(
		'category' => '/subject-category/ss1/',
		'subjects' => array(
			array( 'SS1 Biology', '/subject/biology-ss1/' ),
			array( 'SS1 Chemistry', '/subject/chemistry-ss1/' ),
			array( 'SS1 Civic Education', '/subject/civic-education-ss1/' ),
			array( 'SS1 Commerce', '/subject/commerce-ss1/' ),
			array( 'SS1 Computer Science/ICT', '/subject/computer-science-ict-ss1/' ),
			array( 'SS1 Economics', '/subject/economics-ss1/' ),
			array( 'SS1 English Language', '/subject/english-language-ss1/' ),
			array( 'SS1 Financial Accounting', '/subject/financial-accounting-ss1/' ),
			array( 'SS1 General Mathematics', '/subject/general-mathematics-ss1/' ),
			array( 'SS1 Geography', '/subject/geography-ss1/' ),
			array( 'SS1 Government', '/subject/government-ss1/' ),
			array( 'SS1 Literature in English', '/subject/literature-in-english-ss1/' ),
			array( 'SS1 Physics', '/subject/physics-ss1/' ),
		),
	),
	'SS 2' => array(
		'category' => '/subject-category/ss2/',
		'subjects' => array(
			array( 'SS2 Biology', '/subject/biology-ss2/' ),
			array( 'SS2 Chemistry', '/subject/chemistry-ss2/' ),
			array( 'SS2 Civic Education', '/subject/civic-education-ss2/' ),
			array( 'SS2 Commerce', '/subject/commerce-ss2/' ),
			array( 'SS2 Computer Science/ICT', '/subject/computer-science-ict-ss2/' ),
			array( 'SS2 Economics', '/subject/economics-ss2/' ),
			array( 'SS2 English Language', '/subject/english-language-ss2/' ),
			array( 'SS2 Financial Accounting', '/subject/financial-accounting-ss2/' ),
			array( 'SS2 General Mathematics', '/subject/general-mathematics-ss2/' ),
			array( 'SS2 Geography', '/subject/geography-ss2/' ),
			array( 'SS2 Government', '/subject/government-ss2/' ),
			array( 'SS2 Literature in English', '/subject/literature-in-english-ss2/' ),
			array( 'SS2 Physics', '/subject/physics-ss2/' ),
		),
	),
	'SS 3' => array(
		'category' => '/subject-category/ss3/',
		'subjects' => array(
			array( 'SS3 Biology', '/subject/biology-ss3/' ),
			array( 'SS3 Chemistry', '/subject/chemistry-ss3/' ),
			array( 'SS3 Civic Education', '/subject/civic-education-ss3/' ),
			array( 'SS3 Commerce', '/subject/commerce-ss3/' ),
			array( 'SS3 Computer Science/ICT', '/subject/computer-science-ict-ss3/' ),
			array( 'SS3 Economics', '/subject/economics-ss3/' ),
			array( 'SS3 English Language', '/subject/english-language-ss3/' ),
			array( 'SS3 Financial Accounting', '/subject/financial-accounting-ss3/' ),
			array( 'SS3 General Mathematics', '/subject/general-mathematics-ss3/' ),
			array( 'SS3 Geography', '/subject/geography-ss3/' ),
			array( 'SS3 Government', '/subject/government-ss3/' ),
			array( 'SS3 Physics', '/subject/physics-ss3/' ),
			array( 'SS3 Literature in English', '/subject/literature-in-english-ss3/' ),
		),
	),
);
?>
<style id="classhall-home-layout-stability">
	#classhall-home .ch-math-lesson {
		--ch-phone-viewport: 460px;
	}

	#classhall-home .ch-math-scroll {
		height: var(--ch-phone-viewport);
		overflow: hidden;
	}

	#classhall-home .ch-math-scroll-content {
		animation: classhall-math-phone-scroll 26s linear infinite;
		will-change: transform;
	}

	@keyframes classhall-math-phone-scroll {
		0%,
		10% {
			transform: translate3d(0, 0, 0);
		}

		90%,
		100% {
			transform: translate3d(0, calc(-100% + var(--ch-phone-viewport)), 0);
		}
	}

	@media (min-width: 981px) {
		#classhall-home .ch-hero-grid {
			grid-template-columns: minmax(0, .95fr) minmax(360px, .78fr) !important;
			gap: clamp(32px, 6vw, 86px) !important;
		}

		#classhall-home .ch-hero-visual {
			min-height: 640px;
			transform: translateY(-36px);
		}

		#classhall-home .ch-math-lesson {
			height: auto;
			min-height: 0;
		}

		#classhall-home .ch-math-phone-screen {
			height: auto;
		}

		#classhall-home .ch-math-scroll {
			height: var(--ch-phone-viewport);
			overflow: hidden;
		}
	}

	@media (max-width: 980px) {
		#classhall-home .ch-hero {
			padding: 34px 0 46px !important;
		}

		#classhall-home .ch-hero-grid {
			grid-template-columns: 1fr !important;
			gap: 26px !important;
			width: min(100% - 28px, 1120px) !important;
		}

		#classhall-home .ch-hero-visual {
			height: auto !important;
			min-height: 0 !important;
			transform: none !important;
		}

		#classhall-home .ch-math-lesson {
			--ch-phone-viewport: 460px !important;
			height: auto !important;
			min-height: 0 !important;
		}

		#classhall-home .ch-math-phone-screen {
			height: auto !important;
		}

		#classhall-home .ch-math-scroll {
			height: var(--ch-phone-viewport) !important;
			overflow: hidden !important;
		}

		#classhall-home .ch-math-scroll-content {
			animation: classhall-math-phone-scroll 26s linear infinite !important;
			will-change: transform;
		}
	}
</style>
<main id="classhall-home" class="classhall-home" style="background:#fff;color:#172033;overflow-x:clip;">
	<section class="ch-hero" aria-labelledby="classhall-home-title" style="position:relative;overflow:hidden;padding:clamp(52px,7vw,92px) 0 clamp(58px,7vw,96px);background:#f8fafc;">
		<div class="ch-shell ch-hero-grid" style="display:grid;grid-template-columns:minmax(0,.95fr) minmax(360px,.78fr);gap:clamp(32px,6vw,86px);align-items:center;width:min(100% - 40px,1120px);margin:0 auto;">
			<div class="ch-hero-copy" style="align-self:center;">
				<div class="ch-hero-brand" style="display:grid;grid-template-columns:58px auto;align-items:center;gap:13px;margin-bottom:26px;">
					<?php
					if ( $classhall_logo_id ) {
						echo wp_get_attachment_image(
							$classhall_logo_id,
							array( 58, 58 ),
							false,
							array(
								'alt'           => 'Classhall',
								'loading'       => 'eager',
								'decoding'      => 'async',
								'fetchpriority' => 'high',
								'style'         => 'width:58px;height:58px;',
							)
						);
					} else {
						?>
						<img src="<?php echo esc_url( $classhall_logo_url ); ?>" width="58" height="58" alt="Classhall" loading="eager" decoding="async" fetchpriority="high" style="width:58px;height:58px;">
						<?php
					}
					?>
					<span class="ch-brand-text" style="display:grid;gap:2px;">
						<strong style="color:#0f172a;font-size:24px;font-weight:900;line-height:1;">Classhall</strong>
						<em style="color:#2563eb;font-size:14px;font-style:normal;font-weight:850;line-height:1.15;">...activate learning</em>
					</span>
				</div>

				<h1 id="classhall-home-title" style="max-width:720px;margin:0;color:#0f172a;font-size:clamp(28px,3.1vw,40px);line-height:1.14;font-weight:800;letter-spacing:0;">Structured digital curriculum and content for teachers and students</h1>
				<p class="ch-lead" style="display:block;max-width:710px;margin:22px 0 0;color:#334155;font-size:clamp(18px,1.65vw,23px);line-height:1.68;opacity:1;visibility:visible;transform:none;">Curriculum-aligned lesson notes, lesson plans, assessments, and interactive learning resources designed to help teachers save time and students achieve more.</p>

				<p class="ch-trust-badge">Trusted by <strong style="color:#92400e;">76,000+</strong> teachers and students across Nigeria and beyond.</p>

				<div class="ch-actions" aria-label="Homepage actions">
					<a class="ch-button ch-button-primary" href="<?php echo esc_url( home_url( '/classhall-user-register-protected-7047324/' ) ); ?>">Get Started</a>
					<a class="ch-button ch-button-secondary" href="<?php echo esc_url( home_url( '/classhall-user-login-protected/' ) ); ?>">Sign In</a>
				</div>
			</div>

			<div class="ch-hero-visual" aria-label="Sample Classhall mathematics lesson">
				<article class="ch-math-lesson">
					<div class="ch-phone-status">
						<span>JSS3&nbsp;Mathematics <em>First Term</em></span>
						<span class="ch-phone-progress" role="progressbar" aria-label="Lesson progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="62">
							<span></span>
						</span>
					</div>

					<div class="ch-phone-tabs" aria-label="Classhall resource preview">
						<span class="is-active">Lesson Note</span>
						<span>Lesson Plan</span>
						<span>Quiz</span>
					</div>

					<div class="ch-math-phone-screen">
						<header>
							<p>Lesson</p>
							<h2>Equations Involving Fractions</h2>
						</header>

						<div class="ch-math-scroll" aria-label="Scrolling lesson note preview">
							<div class="ch-math-scroll-content">
								<div class="ch-math-step">
									<span>Introduction</span>
									<p>Equations such as \( \frac{2}{3} + x = 1 \), \( \frac{3x}{2} + \frac{3}{5} = 10 \), and \( \frac{2y}{5} - \frac{3}{5} \) are equations involving fractions.</p>
									<p>To solve them, find the L.C.M of the denominators and multiply each term by the L.C.M to clear the fractions.</p>
								</div>

								<div class="ch-math-step">
									<span>Example&nbsp;\(1\)</span>
									<p>Solve the equation:</p>
									<p class="ch-equation">\( \frac{x - 4}{5} = 2 - \frac{x}{2} \)</p>
								</div>

								<div class="ch-math-step">
									<span>Step&nbsp;\(1\)</span>
									<p>The denominators are \(5\) and \(2\). The L.C.M of \(5\) and \(2\) is \(10\).</p>
								</div>

								<div class="ch-math-step">
									<span>Step&nbsp;\(2\)</span>
									<p>Multiply each term by the L.C.M:</p>
									<p class="ch-equation">\( 10 \times \frac{x - 4}{5} = (2 \times 10) - \left(10 \times \frac{x}{2}\right) \)</p>
									<p class="ch-equation">\( 2(x - 4) = 20 - 5x \)</p>
								</div>

								<div class="ch-math-step">
									<span>Step&nbsp;\(3\)</span>
									<p>Expand and collect like terms:</p>
									<p class="ch-equation">\( 2x - 8 = 20 - 5x \)</p>
									<p class="ch-equation">\( 2x + 5x = 20 + 8 \)</p>
									<p class="ch-equation">\( 7x = 28 \)</p>
								</div>

								<p class="ch-math-note">Thus, \( x = \frac{28}{7} = 4 \).</p>
							</div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</section>

	<?php
	$GLOBALS['classhall_allow_summer_banner'] = true;
	get_template_part( 'template-parts/classhall-summer-banner' );
	unset( $GLOBALS['classhall_allow_summer_banner'] );
	?>

	<section id="classhall-core-features" class="ch-core-features" aria-labelledby="classhall-core-features-title">
		<div class="ch-shell">
			<div class="ch-core-features-head">
				<p class="ch-core-features-label"><?php esc_html_e( 'Built for Better Learning', 'kleo-child' ); ?></p>
				<h2 id="classhall-core-features-title"><?php esc_html_e( 'Why Teachers and Students Choose Classhall', 'kleo-child' ); ?></h2>
				<p><?php esc_html_e( 'Classhall combines curriculum-aligned content with thoughtful design to make teaching easier and learning more effective. Every lesson is professionally structured, regularly updated, and designed to help teachers teach with confidence and students learn with clarity.', 'kleo-child' ); ?></p>
			</div>

			<div class="ch-core-features-grid">
				<article class="ch-core-feature-card">
					<span class="ch-core-feature-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" focusable="false">
							<path d="M5 4.5h10.5a2.5 2.5 0 0 1 2.5 2.5v12.5H7.5A2.5 2.5 0 0 1 5 17V4.5z"></path>
							<path d="M8 8h7M8 11.5h7M8 15h4"></path>
						</svg>
					</span>
					<h3><?php esc_html_e( 'Structured & curriculum-aligned', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Lessons are carefully organised and aligned with the approved curriculum for effective teaching and learning.', 'kleo-child' ); ?></p>
				</article>

				<article class="ch-core-feature-card">
					<span class="ch-core-feature-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" focusable="false">
							<path d="M12 4.5 4.5 8l7.5 3.5L19.5 8 12 4.5z"></path>
							<path d="M7 10v4.5c0 1.9 2.2 3.5 5 3.5s5-1.6 5-3.5V10"></path>
						</svg>
					</span>
					<h3><?php esc_html_e( '100% teacher-made', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Every lesson is created and reviewed by experienced teachers to ensure accuracy, relevance, and classroom practicality.', 'kleo-child' ); ?></p>
				</article>

				<article class="ch-core-feature-card">
					<span class="ch-core-feature-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" focusable="false">
							<path d="M5 17h14"></path>
							<path d="M7 7h4l-4 10h4"></path>
							<path d="M15 8.5c1.8 0 3 1.1 3 2.7S16.8 14 15 14h-1V8.5h1z"></path>
						</svg>
					</span>
					<h3><?php esc_html_e( 'Advanced mathematical & scientific notation', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Complex equations, formulas, and scientific expressions are presented with textbook-quality clarity and precision.', 'kleo-child' ); ?></p>
				</article>

				<article class="ch-core-feature-card">
					<span class="ch-core-feature-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" focusable="false">
							<path d="M5 6h14M5 12h10M5 18h7"></path>
							<path d="M17 12h2M14 18h5"></path>
						</svg>
					</span>
					<h3><?php esc_html_e( 'Clear visual hierarchy', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Well-organised headings and sections make lessons easy to follow, navigate, and revise.', 'kleo-child' ); ?></p>
				</article>

				<article class="ch-core-feature-card">
					<span class="ch-core-feature-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" focusable="false">
							<path d="M19 12a7 7 0 1 1-2.1-5"></path>
							<path d="M19 5v5h-5"></path>
							<path d="M12 8v4l2.5 2"></path>
						</svg>
					</span>
					<h3><?php esc_html_e( 'Regularly updated content', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Lessons and learning resources are regularly improved to remain current, accurate, and relevant.', 'kleo-child' ); ?></p>
				</article>

				<article class="ch-core-feature-card">
					<span class="ch-core-feature-icon" aria-hidden="true">
						<svg viewBox="0 0 24 24" focusable="false">
							<rect x="4" y="5" width="16" height="14" rx="2"></rect>
							<path d="m7 16 3.2-3.2 2.3 2.3L15.8 11 20 16"></path>
							<path d="M8.5 8.8h.01"></path>
						</svg>
					</span>
					<h3><?php esc_html_e( 'Media-rich & illustrative', 'kleo-child' ); ?></h3>
					<p><?php esc_html_e( 'Images, diagrams, tables, charts, and examples make difficult concepts easier to understand.', 'kleo-child' ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<section class="ch-collage-strip" aria-label="Classhall learning resources">
		<div class="ch-collage-row ch-collage-row-left">
			<div class="ch-collage-track">
				<img src="<?php echo esc_url( 'https://classhall.com/wp-content/uploads/2026/07/first-collage.jpg' ); ?>" width="3000" height="320" alt="Educational resources available on Classhall" loading="lazy" decoding="async">
				<img src="<?php echo esc_url( 'https://classhall.com/wp-content/uploads/2026/07/first-collage.jpg' ); ?>" width="3000" height="320" alt="" loading="lazy" decoding="async" aria-hidden="true">
			</div>
		</div>

		<div class="ch-collage-row ch-collage-row-right">
			<div class="ch-collage-track">
				<img src="<?php echo esc_url( 'https://classhall.com/wp-content/uploads/2026/07/second-collage.jpg' ); ?>" width="3000" height="320" alt="Classhall learning resources across subjects" loading="lazy" decoding="async">
				<img src="<?php echo esc_url( 'https://classhall.com/wp-content/uploads/2026/07/second-collage.jpg' ); ?>" width="3000" height="320" alt="" loading="lazy" decoding="async" aria-hidden="true">
			</div>
		</div>
	</section>

	<section class="ch-section ch-section-muted" aria-labelledby="classhall-benefits-title">
		<div class="ch-shell ch-two-column">
			<div class="ch-section-head ch-section-head-left">
				<p class="ch-eyebrow">For students and teachers</p>
				<h2 id="classhall-benefits-title">Simple tools for teaching and consistent study</h2>
				<p>Every page is designed to help learners find a subject, read a lesson, test understanding, and help teachers prepare lessons, evaluation, and exam questions faster.</p>
			</div>

			<div class="ch-feature-list">
				<article>
					<h3>Lesson plans and notes</h3>
					<p>Clear topics arranged by class, subject, term, and lesson so teachers can prepare and students can learn without confusion.</p>
				</article>
				<article>
					<h3>Evaluation and exam questions</h3>
					<p>Practice and assessment questions help learners prepare for continuous assessment, term exams, WAEC, NECO, and more.</p>
				</article>
				<article>
					<h3>Progress tracking</h3>
					<p>Students can see completed lessons and continue learning with a more organised dashboard.</p>
				</article>
			</div>
		</div>
	</section>

	<section class="ch-section" aria-labelledby="classhall-impact-title">
		<div class="ch-shell ch-impact-panel">
			<div>
				<p class="ch-eyebrow">Partnership impact</p>
				<h2 id="classhall-impact-title">Supporting learning beyond the classroom</h2>
				<p>In 2020, Classhall partnered with Data Science Nigeria and E-malezi Kenya to execute Mastercard's Learn at Home initiative, which targeted 1 million children across Nigeria and Kenya.</p>
			</div>
			<div class="ch-impact-stat" aria-label="Learn at Home reach target">
				<strong>1M</strong>
				<span>children targeted</span>
			</div>
		</div>
	</section>

	<section class="ch-section ch-subjects-with-menu" aria-labelledby="classhall-bundles-title">
		<div class="ch-shell">
			<div class="ch-class-menu-section ch-class-menu-section--embedded">
				<div class="ch-class-menu-head">
					<p class="ch-eyebrow">Subjects by class</p>
					<h2 id="classhall-menu-title">Find your subject</h2>
				</div>

				<nav class="ch-class-menu" aria-label="Class subject menu">
					<ul>
						<?php foreach ( $classhall_class_menu as $class_label => $class_group ) : ?>
							<li>
								<details>
									<summary>
										<?php echo esc_html( $class_label ); ?>
										<span aria-hidden="true"></span>
									</summary>
									<div class="ch-class-dropdown">
									<a class="ch-class-view-all" href="<?php echo esc_url( home_url( $class_group['category'] ) ); ?>">View all <?php echo esc_html( $class_label ); ?> subjects</a>
									<ul>
										<?php foreach ( $class_group['subjects'] as $subject ) : ?>
											<li>
												<a href="<?php echo esc_url( home_url( $subject[1] ) ); ?>"><?php echo esc_html( $subject[0] ); ?></a>
											</li>
										<?php endforeach; ?>
									</ul>
									</div>
								</details>
							</li>
						<?php endforeach; ?>
					</ul>
				</nav>
			</div>

			<div class="ch-bundle-panel" style="background:#ffffff;color:#0f172a;">
				<div>
				<p class="ch-eyebrow" style="color:#1e40af;">Subject Coverage</p>
				<h2 id="classhall-bundles-title" style="color:#0f172a;">Subjects covered on Classhall</h2>
				<p style="color:#334155;">Classhall brings lesson plans, notes, evaluation, and exam practice together across the subjects learners and teachers use most.</p>
				<ul class="ch-subject-list" aria-label="Subjects on Classhall" style="color:#0f172a;">
					<li>Primary Mathematics</li>
					<li>Primary English</li>
					<li>Primary Basic Science</li>
					<li>Primary Social Studies</li>
					<li>Primary Civic Education</li>
					<li>Primary Creative Arts</li>
					<li>Agricultural Science</li>
					<li>Beauty and Cosmetology</li>
					<li>Basic Science</li>
					<li>Basic Technology</li>
					<li>Business Studies</li>
					<li>Catering Craft</li>
					<li>Christian Religious Studies</li>
					<li>Civic Education</li>
					<li>Clothing and Textile</li>
					<li>Computer Studies</li>
					<li>Computer Hardware and GSM Repairs</li>
					<li>Data Processing</li>
					<li>Cultural and Creative Arts</li>
					<li>Dyeing and Bleaching</li>
					<li>English Studies</li>
					<li>Fashion Design and Garment Making</li>
					<li>Foods and Nutrition</li>
					<li>French</li>
					<li>GSM Maintenance</li>
					<li>Health Education</li>
					<li>Home Economics</li>
					<li>History</li>
					<li>Insurance</li>
					<li>Intermediate Science</li>
					<li>Islamic Studies</li>
					<li>Marketing</li>
					<li>Mathematics</li>
					<li>Music</li>
					<li>Office Practice</li>
					<li>Photography</li>
					<li>Physical and Health Education</li>
					<li>Physical Education</li>
					<li>Security Education</li>
					<li>Social Studies</li>
					<li>Store Keeping</li>
					<li>Textile Trade</li>
					<li>Biology</li>
					<li>Chemistry</li>
					<li>Commerce</li>
					<li>Computer Science/ICT</li>
					<li>Economics</li>
					<li>English Language</li>
					<li>Financial Accounting</li>
					<li>General Mathematics</li>
					<li>Geography</li>
					<li>Government</li>
					<li>Literature in English</li>
					<li>Physics</li>
					<li>Animal Husbandry</li>
				</ul>
			</div>
			<a class="ch-button ch-button-primary" href="<?php echo esc_url( home_url( '/classhall-user-register-protected-7047324/' ) ); ?>" style="background:#1d4ed8;border-color:#1d4ed8;color:#ffffff;">Sign up</a>
			</div>
		</div>
	</section>

	<script>
		document.addEventListener('DOMContentLoaded', function () {
			var menu = document.querySelector('#classhall-home .ch-class-menu');

			if (!menu) {
				return;
			}

			var groups = Array.prototype.slice.call(menu.querySelectorAll('details'));

			groups.forEach(function (group) {
				group.addEventListener('toggle', function () {
					if (!group.open) {
						return;
					}

					groups.forEach(function (otherGroup) {
						if (otherGroup !== group) {
							otherGroup.open = false;
						}
					});
				});
			});

			document.addEventListener('click', function (event) {
				if (menu.contains(event.target)) {
					return;
				}

				groups.forEach(function (group) {
					group.open = false;
				});
			});

			document.addEventListener('keydown', function (event) {
				if (event.key !== 'Escape') {
					return;
				}

				groups.forEach(function (group) {
					group.open = false;
				});
			});
		});
	</script>

	<style id="classhall-prefooter-contrast-fix">
		#classhall-home .ch-prefooter,
		#classhall-home .ch-prefooter * {
			color: #ffffff !important;
		}

		#classhall-home .ch-prefooter {
			background: #1e3a8a !important;
		}

		#classhall-home .ch-prefooter .ch-button {
			background: #ffffff !important;
			border-color: #ffffff !important;
			color: #172554 !important;
		}

		#classhall-home .ch-bundle-panel,
		#classhall-home .ch-bundle-panel h2,
		#classhall-home .ch-bundle-panel p,
		#classhall-home .ch-bundle-panel li,
		#classhall-home .ch-bundle-panel span {
			background: #ffffff !important;
			color: #0f172a !important;
		}

		#classhall-home .ch-bundle-panel .ch-eyebrow {
			color: #1e40af !important;
		}

		#classhall-home .ch-bundle-panel .ch-button-primary {
			background: #1d4ed8 !important;
			border-color: #1d4ed8 !important;
			color: #ffffff !important;
		}
	</style>

	<section class="ch-prefooter" aria-label="Classhall footer links" style="background:#1e3a8a;color:#ffffff;">
		<div class="ch-shell ch-prefooter-grid">
			<div class="ch-prefooter-brand" style="background:#1e3a8a;color:#ffffff;">
				<h2 style="color:#ffffff;background:#1e3a8a;">About Classhall</h2>
				<p style="color:#ffffff;background:#1e3a8a;">Classhall provides structured class lesson notes, lesson plans, CATs, and exam questions in line with the revised NERDC curriculum.</p>
				<div class="ch-footer-actions">
					<a class="ch-button ch-button-primary" href="<?php echo esc_url( home_url( '/classhall-user-register-protected-7047324/' ) ); ?>">Get Started</a>
					<a class="ch-button ch-button-secondary" href="<?php echo esc_url( home_url( '/subjects-catalogue/' ) ); ?>">Browse Subjects</a>
					<?php if ( is_user_logged_in() && function_exists( 'classhall_logout_url' ) ) : ?>
						<a class="ch-button ch-button-secondary ch-button-logout" href="<?php echo esc_url( classhall_logout_url() ); ?>">Logout</a>
					<?php endif; ?>
				</div>
			</div>

			<nav class="ch-prefooter-column" aria-label="Quick links" style="background:#1e3a8a;color:#ffffff;">
				<h3>Quick Links</h3>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/smartclass/' ) ); ?>" style="color:#ffffff;">SmartClass</a></li>
					<li><a href="<?php echo esc_url( home_url( '/subjects-catalogue/' ) ); ?>" style="color:#ffffff;">Subjects catalogue</a></li>
					<li><a href="<?php echo esc_url( home_url( '/subscriptions/' ) ); ?>" style="color:#ffffff;">Subscriptions</a></li>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="color:#ffffff;">Blog</a></li>
					<li><a href="<?php echo esc_url( home_url( '/faqs/' ) ); ?>" style="color:#ffffff;">FAQs</a></li>
				</ul>
			</nav>

			<nav class="ch-prefooter-column" aria-label="Class bundle links" style="background:#1e3a8a;color:#ffffff;">
				<h3>Class bundles</h3>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/subscriptions/' ) ); ?>" style="color:#ffffff;">Primary</a></li>
					<li><a href="<?php echo esc_url( home_url( '/jss1-subscription-plans/' ) ); ?>" style="color:#ffffff;">JSS1 bundle</a></li>
					<li><a href="<?php echo esc_url( home_url( '/jss2-subscription-plans/' ) ); ?>" style="color:#ffffff;">JSS2 bundle</a></li>
					<li><a href="<?php echo esc_url( home_url( '/jss3-subscription-plans/' ) ); ?>" style="color:#ffffff;">JSS3 bundle</a></li>
					<li><a href="<?php echo esc_url( home_url( '/ss1-subscription-plans/' ) ); ?>" style="color:#ffffff;">SS1 bundle</a></li>
					<li><a href="<?php echo esc_url( home_url( '/ss2-subscription-plans/' ) ); ?>" style="color:#ffffff;">SS2 bundle</a></li>
					<li><a href="<?php echo esc_url( home_url( '/ss3-subscription-plans/' ) ); ?>" style="color:#ffffff;">SS3 bundle</a></li>
				</ul>
			</nav>

			<div class="ch-prefooter-column ch-support-card">
				<h3>Contact and support</h3>
				<ul>
					<li>
						<a class="ch-contact-link" href="<?php echo esc_url( 'mailto:' . $classhall_support_email ); ?>">
							<span class="ch-contact-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" focusable="false">
									<path d="M4 6h16v12H4z"></path>
									<path d="m4 7 8 6 8-6"></path>
								</svg>
							</span>
							<span><?php echo esc_html( $classhall_support_email ); ?></span>
						</a>
					</li>
					<li>
						<a class="ch-contact-link" href="<?php echo esc_url( $classhall_whatsapp_url ); ?>" target="_blank" rel="noopener noreferrer">
							<span class="ch-contact-icon ch-contact-icon-whatsapp" aria-hidden="true">
								<svg viewBox="0 0 24 24" focusable="false">
									<path d="M6.6 19.2 4 20l.8-2.5a8 8 0 1 1 1.8 1.7z"></path>
									<path d="M9 8.8c.3 2.8 2.4 5 5.2 5.2l1.2-1.2 2.1 1.1c-.4 1.5-1.5 2.3-3 2.3-4.2 0-7.7-3.5-7.7-7.7 0-1.5.8-2.6 2.3-3l1.1 2.1z"></path>
								</svg>
							</span>
							<span><?php echo esc_html( $classhall_whatsapp_display ); ?></span>
						</a>
					</li>
					<li>
						<a class="ch-contact-link" href="https://www.facebook.com/officialclasshall" target="_blank" rel="noopener noreferrer">
							<span class="ch-contact-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" focusable="false">
									<path d="M14 8h2V5h-2c-2.2 0-4 1.8-4 4v2H8v3h2v6h3v-6h2.4l.6-3h-3V9c0-.6.4-1 1-1z"></path>
								</svg>
							</span>
							<span>Facebook</span>
						</a>
					</li>
					<li>
						<a class="ch-contact-link" href="https://www.youtube.com/channel/UCcKNvELvLoV3Z9mFdaVggGg" target="_blank" rel="noopener noreferrer">
							<span class="ch-contact-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" focusable="false">
									<path d="M21 8.5a3 3 0 0 0-2.1-2.1C17 6 12 6 12 6s-5 0-6.9.4A3 3 0 0 0 3 8.5 31 31 0 0 0 3 15.5a3 3 0 0 0 2.1 2.1C7 18 12 18 12 18s5 0 6.9-.4a3 3 0 0 0 2.1-2.1 31 31 0 0 0 0-7z"></path>
									<path d="m10 9 5 3-5 3z"></path>
								</svg>
							</span>
							<span>YouTube</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</section>
</main>
