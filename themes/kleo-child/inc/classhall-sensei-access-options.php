<?php
/**
 * Custom Sensei course access options.
 *
 * Keeps Sensei/WooCommerce paid-course enrolment tied only to the existing
 * linked course product while exposing separate term downloadable product links.
 *
 * @package Kleo_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const CLASSHALL_DOWNLOAD_PRODUCT_META_KEY = '_classhall_download_product_id';
const CLASSHALL_DOWNLOAD_PRODUCT_NONCE    = 'classhall_download_product_nonce';
const CLASSHALL_DOWNLOAD_PRODUCT_ACTION   = 'classhall_save_download_product';

add_action( 'add_meta_boxes_course', 'classhall_add_download_product_meta_box' );
add_action( 'save_post_course', 'classhall_save_download_product_meta', 10, 2 );
add_action( 'admin_enqueue_scripts', 'classhall_enqueue_download_product_admin_assets' );
add_action( 'sensei_single_course_content_inside_before', 'classhall_render_course_access_options', 29 );
add_action( 'wp_enqueue_scripts', 'classhall_enqueue_course_access_options_assets', 120 );
add_action( 'wp', 'classhall_restore_download_product_description', 30 );
add_filter( 'woocommerce_product_single_add_to_cart_text', 'classhall_download_product_add_to_cart_text', 120, 2 );
add_filter( 'woocommerce_product_add_to_cart_text', 'classhall_download_product_add_to_cart_text', 120, 2 );
add_action( 'wp_footer', 'classhall_download_product_add_to_cart_fallback_script', 120 );
add_filter( 'body_class', 'classhall_download_product_body_class' );

/**
 * Get the term download product field definitions.
 *
 * @return array
 */
function classhall_get_download_product_terms() {
	return array(
		'first'  => array(
			'label'    => __( 'First Term', 'kleo-child' ),
			'meta_key' => CLASSHALL_DOWNLOAD_PRODUCT_META_KEY,
			'field'    => 'classhall_download_product_id_first',
		),
		'second' => array(
			'label'    => __( 'Second Term', 'kleo-child' ),
			'meta_key' => '_classhall_download_product_id_second_term',
			'field'    => 'classhall_download_product_id_second',
		),
		'third'  => array(
			'label'    => __( 'Third Term', 'kleo-child' ),
			'meta_key' => '_classhall_download_product_id_third_term',
			'field'    => 'classhall_download_product_id_third',
		),
	);
}

/**
 * Add the downloadable product selectors to Sensei courses.
 *
 * @param WP_Post $post Course post.
 */
function classhall_add_download_product_meta_box( $post ) {
	if ( ! $post instanceof WP_Post || 'course' !== $post->post_type || ! function_exists( 'wc_get_product' ) ) {
		return;
	}

	add_meta_box(
		'classhall-download-product',
		__( 'Editable MS Word Download Products', 'kleo-child' ),
		'classhall_render_download_product_meta_box',
		'course',
		'side',
		'default'
	);
}

/**
 * Render the downloadable product selectors.
 *
 * @param WP_Post $post Course post.
 */
function classhall_render_download_product_meta_box( $post ) {
	wp_nonce_field( CLASSHALL_DOWNLOAD_PRODUCT_ACTION, CLASSHALL_DOWNLOAD_PRODUCT_NONCE );

	foreach ( classhall_get_download_product_terms() as $term_key => $term ) {
		$product_id = absint( get_post_meta( $post->ID, $term['meta_key'], true ) );
		$product    = $product_id && function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : false;
		?>
		<p>
			<label for="<?php echo esc_attr( $term['field'] ); ?>">
				<strong><?php echo esc_html( $term['label'] ); ?></strong>
			</label>
			<select
				id="<?php echo esc_attr( $term['field'] ); ?>"
				name="<?php echo esc_attr( $term['field'] ); ?>"
				class="wc-product-search"
				style="width: 100%;"
				data-placeholder="<?php echo esc_attr( sprintf( __( 'Search for %s downloadable product...', 'kleo-child' ), $term['label'] ) ); ?>"
				data-action="woocommerce_json_search_downloadable_products_and_variations"
				data-allow_clear="true"
			>
				<?php if ( classhall_is_wc_product( $product ) ) : ?>
					<option value="<?php echo esc_attr( $product->get_id() ); ?>" selected="selected">
						<?php echo esc_html( wp_strip_all_tags( $product->get_formatted_name() ) ); ?>
					</option>
				<?php endif; ?>
			</select>
		</p>
		<?php
	}
	?>
	<p class="description">
		<?php esc_html_e( 'Select the separate WooCommerce downloadable products for each term. These products will not grant course access.', 'kleo-child' ); ?>
	</p>
	<?php
}

/**
 * Load WooCommerce enhanced select assets for the admin selector.
 *
 * @param string $hook_suffix Current admin hook.
 */
function classhall_enqueue_download_product_admin_assets( $hook_suffix ) {
	if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'course' !== $screen->post_type ) {
		return;
	}

	if ( function_exists( 'WC' ) ) {
		wp_enqueue_script( 'wc-enhanced-select' );
		wp_enqueue_style( 'woocommerce_admin_styles' );
	}
}

/**
 * Save the selected downloadable product ID.
 *
 * @param int     $post_id Course ID.
 * @param WP_Post $post    Course post.
 */
function classhall_save_download_product_meta( $post_id, $post ) {
	if ( ! $post instanceof WP_Post || 'course' !== $post->post_type ) {
		return;
	}

	if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) ) {
		return;
	}

	if (
		! isset( $_POST[ CLASSHALL_DOWNLOAD_PRODUCT_NONCE ] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ CLASSHALL_DOWNLOAD_PRODUCT_NONCE ] ) ), CLASSHALL_DOWNLOAD_PRODUCT_ACTION )
	) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( classhall_get_download_product_terms() as $term ) {
		$product_id = isset( $_POST[ $term['field'] ] ) ? absint( wp_unslash( $_POST[ $term['field'] ] ) ) : 0;

		if ( ! $product_id ) {
			delete_post_meta( $post_id, $term['meta_key'] );
			continue;
		}

		$product = function_exists( 'wc_get_product' ) ? wc_get_product( $product_id ) : false;
		if ( ! classhall_is_valid_download_product_for_admin( $product ) ) {
			delete_post_meta( $post_id, $term['meta_key'] );
			continue;
		}

		update_post_meta( $post_id, $term['meta_key'], $product->get_id() );
	}
}

/**
 * Validate a product for admin selection.
 *
 * @param mixed $product Product object.
 * @return bool
 */
function classhall_is_valid_download_product_for_admin( $product ) {
	if ( ! classhall_is_wc_product( $product ) ) {
		return false;
	}

	if ( ! current_user_can( 'edit_post', $product->get_id() ) ) {
		return false;
	}

	return 'publish' === get_post_status( $product->get_id() )
		&& $product->is_downloadable()
		&& ! classhall_is_product_linked_to_sensei_course( $product->get_id() );
}

/**
 * Render the access selector and suppress Sensei's default duplicate output.
 *
 * @param int $course_id Course ID.
 */
function classhall_render_course_access_options( $course_id ) {
	$course_id             = absint( $course_id );
	$subscription_product  = classhall_get_course_subscription_product( $course_id );
	$download_products     = classhall_get_course_download_products( $course_id );
	$is_user_enrolled     = classhall_is_current_user_enrolled_in_course( $course_id );
	$subscription_markup   = ( $subscription_product && ! $is_user_enrolled ) ? classhall_get_subscription_action_markup( $course_id, $subscription_product ) : '';
	$has_subscription_card = $subscription_product && '' !== trim( $subscription_markup );
	$has_download_card     = ! empty( $download_products );

	if ( ! $has_subscription_card && ! $has_download_card ) {
		return;
	}

	remove_action( 'sensei_single_course_content_inside_before', array( 'Sensei_Course', 'the_course_enrolment_actions' ), 30 );

	echo '<section class="classhall-course-access-options" aria-labelledby="classhall-access-options-title-' . esc_attr( $course_id ) . '">';
	echo '<h2 id="classhall-access-options-title-' . esc_attr( $course_id ) . '">' . esc_html__( 'Choose Your Access Option', 'kleo-child' ) . '</h2>';
	echo '<div class="classhall-course-access-options__grid">';

	if ( $has_subscription_card ) {
		classhall_render_subscription_option( $course_id, $subscription_product, $subscription_markup );
	}

	if ( $has_download_card ) {
		classhall_render_download_option( $course_id, $download_products );
	}

	echo '</div>';
	echo '</section>';

	if ( current_user_can( 'edit_post', $course_id ) ) {
		$missing_terms = classhall_get_missing_download_product_terms( $course_id );
		if ( ! empty( $missing_terms ) ) {
			echo '<p class="classhall-access-admin-notice">' . esc_html( sprintf( __( 'Admin notice: missing valid downloadable products for %s.', 'kleo-child' ), implode( ', ', $missing_terms ) ) ) . '</p>';
		}
	}
}

/**
 * Get the linked Sensei subscription product.
 *
 * @param int $course_id Course ID.
 * @return WC_Product|false
 */
function classhall_get_course_subscription_product( $course_id ) {
	if ( ! class_exists( 'Sensei_WC' ) || ! method_exists( 'Sensei_WC', 'get_purchasable_products' ) || ! function_exists( 'wc_get_product' ) ) {
		return false;
	}

	$products = Sensei_WC::get_purchasable_products( $course_id );
	if ( empty( $products ) ) {
		return false;
	}

	foreach ( $products as $product ) {
		if ( classhall_is_wc_product( $product ) && classhall_is_subscription_product( $product ) ) {
			return $product;
		}
	}

	return classhall_is_wc_product( $products[0] ) ? $products[0] : false;
}

/**
 * Check for a WooCommerce product object without requiring WooCommerce to be active.
 *
 * @param mixed $product Product object.
 * @return bool
 */
function classhall_is_wc_product( $product ) {
	return is_object( $product ) && is_a( $product, 'WC_Product' );
}

/**
 * Check if a product is a subscription product.
 *
 * @param mixed $product Product object.
 * @return bool
 */
function classhall_is_subscription_product( $product ) {
	if ( ! classhall_is_wc_product( $product ) ) {
		return false;
	}

	return $product->is_type( array( 'subscription', 'variable-subscription', 'subscription_variation' ) )
		|| ( class_exists( 'WC_Subscriptions_Product' ) && WC_Subscriptions_Product::is_subscription( $product ) );
}

/**
 * Check whether the current user already has Sensei access to the course.
 *
 * @param int $course_id Course ID.
 * @return bool
 */
function classhall_is_current_user_enrolled_in_course( $course_id ) {
	$course_id = absint( $course_id );
	$user_id   = get_current_user_id();

	if ( ! $course_id || ! $user_id ) {
		return false;
	}

	if ( class_exists( 'Sensei_Course' ) && method_exists( 'Sensei_Course', 'is_user_enrolled' ) ) {
		return Sensei_Course::is_user_enrolled( $course_id, $user_id );
	}

	return false;
}

/**
 * Capture Sensei's original add-to-cart action for the linked course product.
 *
 * @param int        $course_id Course ID.
 * @param mixed      $product   Product object.
 * @return string
 */
function classhall_get_subscription_action_markup( $course_id, $product ) {
	if ( ! classhall_is_wc_product( $product ) || ! class_exists( 'Sensei_WC' ) || ! method_exists( 'Sensei_WC', 'the_add_to_cart_button_html' ) ) {
		return '';
	}

	ob_start();
	add_filter( 'sensei_wc_paid_courses_add_to_cart_button_text', 'classhall_subscription_button_text', 99 );
	Sensei_WC::the_add_to_cart_button_html( $course_id, $product, __( 'Subscribe Now', 'kleo-child' ) );
	remove_filter( 'sensei_wc_paid_courses_add_to_cart_button_text', 'classhall_subscription_button_text', 99 );

	return (string) ob_get_clean();
}

/**
 * Force the visible Sensei paid-course action label for this component.
 *
 * @return string
 */
function classhall_subscription_button_text() {
	return __( 'Subscribe Now', 'kleo-child' );
}

/**
 * Keep downloadable product descriptions visible on single product pages.
 */
function classhall_restore_download_product_description() {
	if ( is_admin() || ! function_exists( 'is_product' ) || ! is_product() || ! function_exists( 'wc_get_product' ) ) {
		return;
	}

	$product = wc_get_product( get_queried_object_id() );
	if ( ! classhall_is_wc_product( $product ) || ! $product->is_downloadable() ) {
		return;
	}

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 35 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

	if ( false === has_action( 'woocommerce_single_product_summary', 'classhall_render_download_product_full_description' ) ) {
		add_action( 'woocommerce_single_product_summary', 'classhall_render_download_product_full_description', 35 );
	}
}

/**
 * Render the full product description for downloadable products.
 */
function classhall_render_download_product_full_description() {
	if ( ! function_exists( 'wc_get_product' ) ) {
		return;
	}

	$product = wc_get_product( get_queried_object_id() );
	if ( ! classhall_is_wc_product( $product ) || ! $product->is_downloadable() ) {
		return;
	}

	$content = get_post_field( 'post_content', $product->get_id() );
	if ( '' === trim( $content ) ) {
		return;
	}
	?>
	<div class="classhall-download-product-full-description woocommerce-product-details__full-description entry-content" style="padding-right: clamp(18px, 2.5vw, 36px); padding-left: clamp(18px, 2.5vw, 36px); box-sizing: border-box;">
		<h2><?php esc_html_e( 'Description', 'woocommerce' ); ?></h2>
		<?php echo wp_kses_post( do_shortcode( wpautop( $content ) ) ); ?>
	</div>
	<?php
}

/**
 * Use the standard cart label for downloadable products.
 *
 * @param string $text    Existing button text.
 * @param mixed  $product Product object.
 * @return string
 */
function classhall_download_product_add_to_cart_text( $text, $product = null ) {
	if ( ! classhall_is_wc_product( $product ) && function_exists( 'wc_get_product' ) ) {
		$product = wc_get_product( get_the_ID() );
	}

	if ( classhall_is_wc_product( $product ) && $product->is_downloadable() ) {
		return __( 'Add to Cart', 'woocommerce' );
	}

	return $text;
}

/**
 * Normalize any rendered button text missed by PHP filters.
 */
function classhall_download_product_add_to_cart_fallback_script() {
	if ( ! classhall_is_downloadable_product_page() ) {
		return;
	}
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.single_add_to_cart_button, form.cart button, form.cart input[type="submit"]').forEach(function (button) {
			if (button.matches('input')) {
				if ((button.value || '').replace(/\s+/g, ' ').trim() === 'Add Subject') {
					button.value = 'Add to Cart';
				}
				return;
			}

			if ((button.textContent || '').replace(/\s+/g, ' ').trim() === 'Add Subject') {
				button.textContent = 'Add to Cart';
			}
		});
	});
	</script>
	<?php
}

/**
 * Check whether the current page is a single downloadable product.
 *
 * @return bool
 */
function classhall_is_downloadable_product_page() {
	static $is_downloadable_product_page = null;

	if ( null !== $is_downloadable_product_page ) {
		return $is_downloadable_product_page;
	}

	$is_downloadable_product_page = false;

	if ( is_admin() || ! function_exists( 'is_product' ) || ! function_exists( 'wc_get_product' ) || ! did_action( 'wp' ) || ! is_product() ) {
		return false;
	}

	$product = wc_get_product( get_queried_object_id() );

	$is_downloadable_product_page = classhall_is_wc_product( $product ) && $product->is_downloadable();

	return $is_downloadable_product_page;
}

/**
 * Add a body class for downloadable product page styling.
 *
 * @param array $classes Body classes.
 * @return array
 */
function classhall_download_product_body_class( $classes ) {
	if ( classhall_is_downloadable_product_page() ) {
		$classes[] = 'classhall-download-product-page';
	}

	return $classes;
}

/**
 * Get the selected separate downloadable products for visitors.
 *
 * @param int $course_id Course ID.
 * @return array
 */
function classhall_get_course_download_products( $course_id ) {
	static $products = array();

	$download_products = array();

	foreach ( classhall_get_download_product_terms() as $term_key => $term ) {
		$product_id = absint( get_post_meta( $course_id, $term['meta_key'], true ) );
		if ( ! $product_id || ! function_exists( 'wc_get_product' ) ) {
			continue;
		}

		if ( ! array_key_exists( $product_id, $products ) ) {
			$product = wc_get_product( $product_id );
			if (
				! classhall_is_wc_product( $product )
				|| 'publish' !== get_post_status( $product->get_id() )
				|| ! $product->is_downloadable()
				|| ! $product->is_visible()
				|| classhall_is_product_linked_to_sensei_course( $product->get_id() )
			) {
				$products[ $product_id ] = false;
			} else {
				$products[ $product_id ] = $product;
			}
		}

		if ( classhall_is_wc_product( $products[ $product_id ] ) ) {
			$download_products[ $term_key ] = array(
				'label'   => $term['label'],
				'product' => $products[ $product_id ],
			);
		}
	}

	return $download_products;
}

/**
 * Get labels for terms that do not have a valid download product.
 *
 * @param int $course_id Course ID.
 * @return array
 */
function classhall_get_missing_download_product_terms( $course_id ) {
	$valid_terms    = array_keys( classhall_get_course_download_products( $course_id ) );
	$missing_terms  = array();
	$product_terms  = classhall_get_download_product_terms();

	foreach ( $product_terms as $term_key => $term ) {
		if ( ! in_array( $term_key, $valid_terms, true ) ) {
			$missing_terms[] = $term['label'];
		}
	}

	return $missing_terms;
}

/**
 * Check whether a product is already tied to Sensei paid-course access.
 *
 * @param int $product_id Product ID.
 * @return bool
 */
function classhall_is_product_linked_to_sensei_course( $product_id ) {
	if ( ! post_type_exists( 'course' ) ) {
		return false;
	}

	$linked_courses = get_posts(
		array(
			'post_type'              => 'course',
			'post_status'            => 'any',
			'posts_per_page'         => 1,
			'fields'                 => 'ids',
			'meta_key'               => '_course_woocommerce_product',
			'meta_value'             => absint( $product_id ),
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	return ! empty( $linked_courses );
}

/**
 * Render the subscription option.
 *
 * @param int        $course_id Course ID.
 * @param mixed      $product   Subscription product.
 * @param string     $action    Captured Sensei action markup.
 */
function classhall_render_subscription_option( $course_id, $product, $action ) {
	$panel_id = 'classhall-subscription-info-' . $course_id;
	?>
	<article class="classhall-access-option classhall-access-option--subscription">
		<div class="classhall-access-option__heading">
			<h3 class="classhall-access-option__title">
				<?php esc_html_e( 'Subscribe', 'kleo-child' ); ?>
				<span class="classhall-access-option__subtitle"><?php esc_html_e( '(All academic terms)', 'kleo-child' ); ?></span>
			</h3>
			<?php classhall_access_info_button( $panel_id, __( 'More information about online subscription', 'kleo-child' ) ); ?>
		</div>
		<div class="classhall-access-option__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		<div class="classhall-access-option__action"><?php echo $action; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		<div id="<?php echo esc_attr( $panel_id ); ?>" class="classhall-access-info-panel" hidden>
			<?php esc_html_e( 'This option gives you online access to the content and all updates released while your subscription remains active. Editable Microsoft Word files are not included.', 'kleo-child' ); ?>
		</div>
	</article>
	<?php
}

/**
 * Render the downloadable product option.
 *
 * @param int        $course_id Course ID.
 * @param array      $downloads Term download products.
 */
function classhall_render_download_option( $course_id, $downloads ) {
	$panel_id = 'classhall-download-info-' . $course_id;
	?>
	<article class="classhall-access-option classhall-access-option--download">
		<div class="classhall-access-option__heading">
			<h3 class="classhall-access-option__title"><?php esc_html_e( 'Editable MS Word Download', 'kleo-child' ); ?></h3>
			<?php classhall_access_info_button( $panel_id, __( 'More information about the editable Word download', 'kleo-child' ) ); ?>
		</div>
		<div class="classhall-access-option__terms">
			<?php foreach ( $downloads as $download ) : ?>
				<?php
				$data = classhall_get_download_product_frontend_data( $download['product'] );
				?>
				<div class="classhall-access-option__term">
					<a class="classhall-access-option__button classhall-access-option__button--term" href="<?php echo esc_url( $data['permalink'] ); ?>">
						<?php echo esc_html( sprintf( __( 'Download %s', 'kleo-child' ), $download['label'] ) ); ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
		<div id="<?php echo esc_attr( $panel_id ); ?>" class="classhall-access-info-panel" hidden>
			<?php esc_html_e( 'This option gives you a one-time download of the complete, editable Microsoft Word files. It does not include online access or future content updates.', 'kleo-child' ); ?>
		</div>
	</article>
	<?php
}

/**
 * Retrieve the WooCommerce data used to validate and render the download option.
 *
 * Descriptions, excerpts, images, galleries, and add-to-cart forms are
 * intentionally not read or rendered on the Sensei course page.
 *
 * @param mixed $product Download product.
 * @return array
 */
function classhall_get_download_product_frontend_data( $product ) {
	return array(
		'id'             => $product->get_id(),
		'title'          => $product->get_name(),
		'permalink'      => get_permalink( $product->get_id() ),
		'price_html'     => $product->get_price_html(),
		'regular_price'  => $product->get_regular_price(),
		'sale_price'     => $product->get_sale_price(),
		'status'         => get_post_status( $product->get_id() ),
		'type'           => $product->get_type(),
		'is_downloadable' => $product->is_downloadable(),
		'stock_status'   => $product->get_stock_status(),
		'is_purchasable' => $product->is_purchasable(),
	);
}

/**
 * Render an accessible info icon button.
 *
 * @param string $panel_id   Controlled panel ID.
 * @param string $aria_label Button label.
 */
function classhall_access_info_button( $panel_id, $aria_label ) {
	?>
	<button
		type="button"
		class="classhall-access-info"
		aria-label="<?php echo esc_attr( $aria_label ); ?>"
		aria-expanded="false"
		aria-controls="<?php echo esc_attr( $panel_id ); ?>"
	>
		<svg width="18" height="18" viewBox="0 0 20 20" aria-hidden="true" focusable="false">
			<path d="M10 9v6"></path>
			<path d="M10 5h.01"></path>
		</svg>
	</button>
	<?php
}

/**
 * Load frontend assets only on eligible course pages.
 */
function classhall_enqueue_course_access_options_assets() {
	if ( is_admin() || ! function_exists( 'is_singular' ) ) {
		return;
	}

	$course_id = 0;

	if ( is_singular( 'course' ) ) {
		$course_id = get_queried_object_id();
	} elseif ( is_singular( 'lesson' ) && function_exists( 'classhall_get_lesson_subject_id' ) ) {
		$course_id = classhall_get_lesson_subject_id( get_queried_object_id() );
	}

	if ( ! $course_id || ( ! classhall_get_course_subscription_product( $course_id ) && empty( classhall_get_course_download_products( $course_id ) ) ) ) {
		return;
	}

	$css_path = get_stylesheet_directory() . '/assets/css/sensei-course-access-options.css';
	$js_path  = get_stylesheet_directory() . '/assets/js/sensei-course-access-options.js';

	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'classhall-sensei-course-access-options',
			get_stylesheet_directory_uri() . '/assets/css/sensei-course-access-options.css',
			array(),
			filemtime( $css_path )
		);
	}

	if ( file_exists( $js_path ) ) {
		wp_enqueue_script(
			'classhall-sensei-course-access-options',
			get_stylesheet_directory_uri() . '/assets/js/sensei-course-access-options.js',
			array(),
			filemtime( $js_path ),
			true
		);
	}
}
