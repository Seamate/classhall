<?php
/**
 * The template for displaying a single Sensei question.
 *
 * @package WordPress
 * @subpackage Kleo_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_sensei_header();

global $post, $sensei_question_loop;

$question_id = get_the_ID();
$quiz_ids    = get_post_meta( $question_id, '_quiz_id', false );
$quiz_id     = ! empty( $quiz_ids ) ? absint( $quiz_ids[0] ) : 0;
$lesson_id   = $quiz_id && isset( Sensei()->quiz ) ? absint( Sensei()->quiz->get_lesson_id( $quiz_id ) ) : 0;
$old_post    = $post;
$old_loop    = $sensei_question_loop;

if ( $quiz_id ) {
	$post = get_post( $quiz_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
	setup_postdata( $post );
}

$sensei_question_loop = array(
	'current'          => 0,
	'current_question' => get_post( $question_id ),
	'current_page'     => 1,
	'posts_per_page'   => 1,
	'questions'        => array( get_post( $question_id ) ),
	'questions_asked'  => array( $question_id ),
	'quiz_id'          => $quiz_id,
	'total'            => 1,
	'total_pages'      => 1,
);
?>

<article <?php post_class( array( 'classhall-single-question', 'sensei', 'question' ), $question_id ); ?>>
	<div class="classhall-single-question-inner">
		<?php if ( class_exists( 'Sensei_Question' ) ) : ?>
			<?php do_action( 'sensei_quiz_question_inside_before', $question_id ); ?>
			<?php sensei_the_question_content(); ?>
			<?php do_action( 'sensei_quiz_question_inside_after', $question_id ); ?>
		<?php else : ?>
			<h1><?php echo esc_html( get_the_title( $question_id ) ); ?></h1>
			<?php echo apply_filters( 'the_content', get_post_field( 'post_content', $question_id ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>

		<?php if ( $quiz_id ) : ?>
			<p class="classhall-single-question-back">
				<a href="<?php echo esc_url( get_permalink( $quiz_id ) ); ?>">
					<?php esc_html_e( 'Back to quiz', 'kleo-child' ); ?>
				</a>
			</p>
		<?php elseif ( $lesson_id ) : ?>
			<p class="classhall-single-question-back">
				<a href="<?php echo esc_url( get_permalink( $lesson_id ) ); ?>">
					<?php esc_html_e( 'Back to lesson', 'kleo-child' ); ?>
				</a>
			</p>
		<?php endif; ?>
	</div>
</article>

<?php
$sensei_question_loop = $old_loop;

if ( $quiz_id ) {
	wp_reset_postdata();
	$post = $old_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
}

$related_question_ids = array();

if ( $quiz_id ) {
	$related_from_quiz = new WP_Query(
		array(
			'post_type'              => 'question',
			'post_status'            => 'publish',
			'posts_per_page'         => 5,
			'post__not_in'           => array( $question_id ),
			'fields'                 => 'ids',
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'meta_query'             => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'     => '_quiz_id',
					'value'   => $quiz_id,
					'compare' => '=',
				),
			),
		)
	);

	$related_question_ids = $related_from_quiz->posts;
	wp_reset_postdata();
}

if ( count( $related_question_ids ) < 5 ) {
	$related_fallback = new WP_Query(
		array(
			'post_type'              => 'question',
			'post_status'            => 'publish',
			'posts_per_page'         => 5 - count( $related_question_ids ),
			'post__not_in'           => array_merge( array( $question_id ), $related_question_ids ),
			'fields'                 => 'ids',
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		)
	);

	$related_question_ids = array_merge( $related_question_ids, $related_fallback->posts );
	wp_reset_postdata();
}

if ( ! empty( $related_question_ids ) ) :
	?>
	<section class="classhall-related-questions" aria-labelledby="classhall-related-questions-title">
		<h2 id="classhall-related-questions-title"><?php esc_html_e( 'Related Questions', 'kleo-child' ); ?></h2>
		<ol>
			<?php foreach ( array_slice( $related_question_ids, 0, 5 ) as $related_question_id ) : ?>
				<li>
					<a href="<?php echo esc_url( get_permalink( $related_question_id ) ); ?>">
						<?php
						$related_title = get_the_title( $related_question_id );

						if ( function_exists( 'classhall_normalize_question_latex_markup' ) && function_exists( 'classhall_question_title_allowed_html' ) ) {
							echo wp_kses( classhall_normalize_question_latex_markup( $related_title ), classhall_question_title_allowed_html() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						} else {
							echo esc_html( $related_title );
						}
						?>
					</a>
				</li>
			<?php endforeach; ?>
		</ol>
	</section>
	<?php
endif;

get_sensei_footer();
