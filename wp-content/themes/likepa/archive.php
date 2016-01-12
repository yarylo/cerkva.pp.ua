<?php
/**
 * The template for displaying Archive pages.
 *
 * @since likepa 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>

		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php if ( is_day() ) : ?>
							<?php // printf( __( 'Daily Archives: %s', 'likepa' ), '<span>' . get_the_date() . '</span>' ); ?>
							<?php printf( __( 'Архів за день: %s', 'likepa' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php // printf( __( 'Monthly Archives: %s', 'likepa' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'likepa' ) ) . '</span>' ); ?>
							<?php printf( __( 'Архів за місяць: %s', 'likepa' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'likepa' ) ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php // printf( __( 'Yearly Archives: %s', 'likepa' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'likepa' ) ) . '</span>' ); ?>
							<?php printf( __( 'Архів за рік: %s', 'likepa' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'likepa' ) ) . '</span>' ); ?>
						<?php else : ?>
							<?php _e( 'Blog Archives', 'likepa' ); ?>
						<?php endif; ?>
					</h1>
				</header>

				<?php likepa_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 -----------------------------------------------------------*/
						get_template_part( 'loop', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php likepa_content_nav( 'nav-below' ); ?>

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

<?php get_sidebar("1"); ?>
<?php get_footer(); ?>