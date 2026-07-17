<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Kleo_Child
 */

get_header();

if ( kleo_postmeta_enabled() ) {
	$meta_status = ' with-meta';

	if ( sq_option( 'blog_single_meta', 'left' ) === 'inline' ) {
		$meta_status .= ' inline-meta';
	}

	add_filter(
		'kleo_main_template_classes',
		function ( $cls ) use ( $meta_status ) {
			$cls .= $meta_status;
			return $cls;
		}
	);
}

$related = sq_option( 'related_posts', 1 );

if ( ! is_singular( 'post' ) ) {
	$related = sq_option( 'related_custom_posts', 0 );
}

if ( get_cfield( 'related_posts' ) !== '' ) {
	$related = get_cfield( 'related_posts' );
}
?>

<?php get_template_part( 'page-parts/general-title-section' ); ?>

<?php get_template_part( 'page-parts/general-before-wrap' ); ?>

<?php while ( have_posts() ) : ?>
	<?php the_post(); ?>

	<?php get_template_part( 'content', get_post_format() ); ?>

	<?php get_template_part( 'page-parts/posts-social-share' ); ?>

	<?php
	if ( sq_option( 'post_navigation', 1 ) == 1 ) :
		kleo_post_nav();
	endif;
	?>

	<?php
	if ( function_exists( 'classhall_render_related_posts_after_post_navigation' ) ) {
		classhall_render_related_posts_after_post_navigation( get_the_ID(), $related );
	} elseif ( $related == 1 ) {
		get_template_part( 'page-parts/posts-related' );
	}
	?>

	<?php
	if ( comments_open() || get_comments_number() ) {
		comments_template( '', true );
	}
	?>

<?php endwhile; ?>

<?php get_template_part( 'page-parts/general-after-wrap' ); ?>

<?php get_footer(); ?>
