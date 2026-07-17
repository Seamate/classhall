<?php
/**
 * The Template for displaying all Quiz Questions.
 *
 * Override this template by copying it to yourtheme/sensei/single-quiz.php
 *
 * @author      Automattic
 * @package     Sensei
 * @category    Templates
 * @version     4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_sensei_header();

/**
 * Hook inside the single quiz post above the content
 *
 * @param integer $quiz_id
 *
 * @since  1.9.0
 *
 * @hooked Sensei_Quiz::the_title               - 20
 * @hooked Sensei_Quiz::the_user_status_message - 40
 * @hooked Sensei_Notices::maybe_print_notices  - 50
 */
do_action( 'sensei_single_quiz_content_inside_before', get_the_ID() );

?>

<?php if ( sensei_can_user_view_lesson() ) : ?>

	<?php if ( sensei_quiz_has_questions() ) : ?>

		<form method="POST" enctype="multipart/form-data" id="sensei-quiz-form">

			<?php

			/**
			 * Action inside before the question content on single-quiz page
			 *
			 * @hooked Sensei_Quiz::the_user_status_message  - 10
			 *
			 * @param string $the_quiz_id
			 */
			do_action( 'sensei_single_quiz_questions_before', get_the_id() );

			?>


			<ol id="sensei-quiz-list">

				<?php
				while ( sensei_quiz_has_questions() ) :
					sensei_setup_the_question();
					?>

					<li
						class="<?php sensei_the_question_class(); ?>"
						value="<?php echo esc_attr( sensei_get_the_question_number() ); ?>"
					>

						<?php

						/**
						 * Action inside before the question content on single-quiz page
						 *
						 * @hooked Sensei_Question::the_question_title        - 10
						 * @hooked Sensei_Question::the_question_description  - 20
						 * @hooked Sensei_Question::the_question_media        - 30
						 * @hooked Sensei_Question::the_question_hidden_field - 40
						 *
						 * @param string $the_question_id
						 *
						 * @since  1.9.0
						 */
						do_action( 'sensei_quiz_question_inside_before', sensei_get_the_question_id() );

						?>

						<?php sensei_the_question_content(); ?>

						<?php

						/**
						 * Action inside before the question content on single-quiz page
						 *
						 * @hooked Sensei_Question::the_answer_feedback
						 *
						 * @param string $the_question_id
						 */
						do_action( 'sensei_quiz_question_inside_after', sensei_get_the_question_id() );

						?>

					</li>

				<?php endwhile; ?>

			</ol>

			<?php

			/**
			 * Action inside before the question content on single-quiz page
			 *
			 * @param string $the_quiz_id
			 */
			do_action( 'sensei_single_quiz_questions_after', get_the_id() );

			?>

		</form>
	<?php else : ?>

		<div
			class="sensei-message alert"> <?php esc_html_e( 'There are no questions for this Quiz yet. Check back soon.', 'sensei-lms' ); ?></div>

	<?php endif; ?>

	<?php
	do_action( 'sensei_quiz_back_link', Sensei()->quiz->data->quiz_lesson );
	?>

<?php endif; // user can view lesson. ?>

<?php if ( ! is_user_logged_in() && ! sensei_can_user_view_lesson() ) : ?>

	<?php
	global $sensei_question_loop;

	$preview_limit = absint( apply_filters( 'classhall_public_quiz_preview_question_count', 3, get_the_ID() ) );

	if ( $preview_limit > 0 && ! empty( $sensei_question_loop['questions'] ) ) :
		$sensei_question_loop['questions']      = array_slice( $sensei_question_loop['questions'], 0, $preview_limit );
		$sensei_question_loop['current']        = -1;
		$sensei_question_loop['current_page']   = 1;
		$sensei_question_loop['posts_per_page'] = $preview_limit;
		?>

		<div class="classhall-quiz-preview sensei-message tick">
			<?php esc_html_e( 'Here are a few sample questions from this quiz. Sign up for the course to answer the full quiz and track your score.', 'kleo-child' ); ?>
		</div>

		<div id="sensei-quiz-form" class="classhall-quiz-preview-form">
			<ol id="sensei-quiz-list">

				<?php
				while ( sensei_quiz_has_questions() ) :
					sensei_setup_the_question();
					?>

					<li
						class="<?php sensei_the_question_class(); ?>"
						value="<?php echo esc_attr( sensei_get_the_question_number() ); ?>"
					>

						<?php
						do_action( 'sensei_quiz_question_inside_before', sensei_get_the_question_id() );
						sensei_the_question_content();
						?>

					</li>

				<?php endwhile; ?>

			</ol>
		</div>

	<?php endif; ?>

<?php endif; ?>

<?php

/**
 * Hook inside the single quiz post above the content
 *
 * @param integer $quiz_id
 *
 * @since 1.9.0
 */
do_action( 'sensei_single_quiz_content_inside_after', get_the_ID() );

get_sensei_footer();
