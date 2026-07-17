<?php
/**
 * Single Sensei question template delegate.
 *
 * @package WordPress
 * @subpackage Kleo_Child
 */

$question_template = get_stylesheet_directory() . '/sensei/single-question.php';

if ( file_exists( $question_template ) ) {
	require $question_template;
	return;
}

get_header();

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer();
