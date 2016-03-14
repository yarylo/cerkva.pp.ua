<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @since likepa 1.0
 */

get_header(); ?>

<?php get_sidebar(); ?>

	<div id="primary">
		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( "Вибачте, але ніщо не відповідає критеріям пошуку. Будь ласка, спробуйте ще раз з деякими іншими ключовими словами..", 'likepa' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Якщо ви перейшли по посиланню з іншого сайту, можливо, сторінку було видалено або перейменовано. Ви можете спробувати шукати сторінку.', 'likepa' ); ?></p>
					<p><?php _e( 'Приносимо вибачення за незручності.', 'likepa' ); ?></p>
					<?php get_search_form(); ?>
					
					<div style="clear:both;">

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->
	
<?php get_sidebar('1'); ?>
<?php get_footer(); ?>