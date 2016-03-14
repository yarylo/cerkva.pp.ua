<?php
/**
 * The template for displaying Search Results pages.
 *
 * @since likepa 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>
		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Результат пошуку на запит: "%s"', 'likepa' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>

				<?php likepa_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 -----------------------------------------------------------*/
						add_filter('post_class','jrh_post_names');
						get_template_part( 'loop', get_post_format() );
					?>

				<?php endwhile; ?>
                <?php // Display navigation when applicable  ?>
				<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<?php // add page navigation to indexes  ?>
				<?php if (function_exists("likepa_pagination")) {
					likepa_pagination($wp_query->max_num_pages);
				} 
				
				endif; ?>
				<?php // likepa_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Нічого не знайдено', 'likepa' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Вибачте, але ніщо не відповідає критеріям пошуку. Будь ласка, спробуйте ще раз з деякими іншими ключовими словами.', 'likepa' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_sidebar("1"); ?>
<?php get_footer(); ?>