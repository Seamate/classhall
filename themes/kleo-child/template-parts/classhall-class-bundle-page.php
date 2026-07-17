<?php
/**
 * Custom class bundle pricing page.
 *
 * @package WordPress
 * @subpackage Kleo_Child
 */

$classhall_bundle = function_exists( 'classhall_get_current_bundle_page_config' )
    ? classhall_get_current_bundle_page_config()
    : null;

if ( ! $classhall_bundle ) {
    get_template_part( 'page' );
    return;
}

$class_label = $classhall_bundle['class_label'];
$plans       = $classhall_bundle['plans'];
$resume_plan = '';

if (
    is_user_logged_in()
    && ! empty( $_GET['classhall_resume_bundle_plan'] )
    && ! empty( $_GET['classhall_bundle_resume_token'] )
) {
    $resume_candidate = sanitize_key( wp_unslash( $_GET['classhall_resume_bundle_plan'] ) );
    $resume_token     = sanitize_text_field( wp_unslash( $_GET['classhall_bundle_resume_token'] ) );

    if (
        function_exists( 'classhall_is_valid_bundle_plan_token' )
        && classhall_is_valid_bundle_plan_token( $resume_candidate, $resume_token )
    ) {
        $resume_plan = $resume_candidate;
    }
}

get_header();
?>

<main id="classhall-bundle-page" class="classhall-bundle-page" data-resume-plan="<?php echo esc_attr( $resume_plan ); ?>">
    <section class="ch-bundle-pricing" aria-labelledby="classhall-bundle-title">
        <div class="ch-bundle-shell">
            <div class="ch-bundle-section-head">
                <p class="ch-bundle-kicker"><?php echo esc_html( $class_label ); ?> bundle plans</p>
                <h1 id="classhall-bundle-title"><?php echo esc_html( $class_label ); ?> All Subjects Bundle</h1>
                <p>Get structured lesson notes, lesson plans, assessments, and learning resources for all subjects in this class. Select a plan below to get started.</p>
            </div>

            <div class="ch-bundle-plan-grid">
                <?php foreach ( $plans as $plan ) : ?>
                    <?php
                    $add_url = ! empty( $plan['key'] ) && function_exists( 'classhall_get_bundle_plan_add_url' )
                        ? classhall_get_bundle_plan_add_url( $plan['key'] )
                        : '';
                    $login_url = ! empty( $plan['key'] ) && function_exists( 'classhall_get_bundle_plan_prepare_login_url' )
                        ? classhall_get_bundle_plan_prepare_login_url( $plan['key'] )
                        : '';
                    $select_url = is_user_logged_in() ? $add_url : $login_url;

                    if ( ! $select_url ) {
                        $select_url = $add_url ? $add_url : $plan['url'];
                    }
                    ?>
                    <article class="ch-bundle-plan-card">
                        <div>
                            <h2><?php echo esc_html( $plan['name'] ); ?></h2>
                            <p class="ch-bundle-duration"><?php echo esc_html( $plan['duration'] ); ?></p>
                            <p><?php echo esc_html( $plan['description'] ); ?></p>
                        </div>

                        <a
                            class="ch-bundle-select"
                            href="<?php echo esc_url( $select_url ); ?>"
                            data-plan-key="<?php echo esc_attr( $plan['key'] ); ?>"
                            data-add-url="<?php echo esc_url( $add_url ); ?>"
                            data-login-url="<?php echo esc_url( $login_url ); ?>"
                        >Select</a>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="ch-bundle-progress" role="status" aria-live="polite" hidden>
                <span class="ch-bundle-spinner" aria-hidden="true"></span>
                <div>
                    <strong>Adding subjects to your cart</strong>
                    <p>Please wait. This can take a little while because every subject in the bundle is being added.</p>
                </div>
            </div>

        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var page = document.getElementById('classhall-bundle-page');

    if (!page) {
        return;
    }

    var progress = page.querySelector('.ch-bundle-progress');
    var buttons = Array.prototype.slice.call(page.querySelectorAll('.ch-bundle-select'));
    var progressTitle = progress ? progress.querySelector('strong') : null;
    var progressText = progress ? progress.querySelector('p') : null;
    var resumePlan = page.getAttribute('data-resume-plan') || '';

    function resetBundleProgress() {
        buttons.forEach(function (item) {
            item.removeAttribute('aria-disabled');
            item.classList.remove('is-loading');
            item.textContent = 'Select';
        });

        if (progress) {
            progress.hidden = true;
        }

        if (progressTitle) {
            progressTitle.textContent = 'Adding subjects to your cart';
        }

        if (progressText) {
            progressText.textContent = 'Please wait. This can take a little while because every subject in the bundle is being added.';
        }
    }

    buttons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            var isForcedAdd = button.getAttribute('data-force-add') === 'true';
            var isLoggedIn = isForcedAdd || document.body.classList.contains('logged-in');
            var addTarget = button.getAttribute('data-add-url');
            var loginTarget = button.getAttribute('data-login-url');
            var target = isLoggedIn && addTarget ? addTarget : button.getAttribute('href');

            if (!isLoggedIn && loginTarget) {
                target = loginTarget;
            }

            if (!target || button.getAttribute('aria-disabled') === 'true') {
                event.preventDefault();
                return;
            }

            event.preventDefault();

            buttons.forEach(function (item) {
                item.setAttribute('aria-disabled', 'true');
                item.classList.add('is-loading');
            });

            button.textContent = isLoggedIn ? 'Adding subjects...' : 'Redirecting...';

            if (progress) {
                if (!isLoggedIn) {
                    if (progressTitle) {
                        progressTitle.textContent = 'Redirecting you to sign in';
                    }

                    if (progressText) {
                        progressText.textContent = 'Please sign in first. After login, we will continue adding the bundle to your cart.';
                    }
                }

                progress.hidden = false;
                progress.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            window.requestAnimationFrame(function () {
                window.setTimeout(function () {
                    window.location.href = target;
                }, 120);
            });
        });
    });

    window.addEventListener('pageshow', resetBundleProgress);

    if (resumePlan) {
        window.setTimeout(function () {
            var resumeButton = page.querySelector('.ch-bundle-select[data-plan-key="' + resumePlan.replace(/"/g, '\\"') + '"]');

            if (resumeButton) {
                resumeButton.setAttribute('data-force-add', 'true');
                resumeButton.click();
            }
        }, 350);
    }
});
</script>

<?php
get_footer();
