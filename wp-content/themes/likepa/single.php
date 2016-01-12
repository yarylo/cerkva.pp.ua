<?php
/**
 * The Template for displaying all single posts.
 *
 * @since likepa 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>
		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'loop', 'single' ); ?>

					<?php //comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_sidebar("1"); ?>
<?php get_footer(); ?>