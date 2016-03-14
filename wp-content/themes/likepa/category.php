<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @since likepa 1.0
 */

get_header(); ?>

<?php get_sidebar(); ?>


		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>
				<header class="page-header">
				
					<h1 class="page-title"><?php
						printf( __( 'Архів категорії: %s', 'likepa' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					?></h1>

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>
				</header>

				<?php likepa_content_nav( 'nav-above' ); ?>
				<?php if(function_exists('sticky_slider')) { sticky_slider(); } ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if ($_SESSION['unset_post'] > 0 &&  $_SESSION['unset_post'] != get_the_ID()) :?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 -----------------------------------------------------------*/
						get_template_part( 'loop', get_post_format() );
					?>

					<?php endif; ?>
				<?php endwhile; ?>

				<?php likepa_pagination(); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Нічого не знайдено', 'likepa' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Вибачення, але нічого не знайдено для вказаного архіву. Можливо, пошук допоможе знайти статті.', 'likepa' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar('1'); ?>
<?php get_footer(); ?>
