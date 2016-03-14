<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @since likepa 1.0
 */

get_header(); ?>
<?php get_sidebar(); ?>


		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php
					the_post();
				?>

				<header class="page-header">
					<h1 class="page-title author"><?php printf( __( 'Author Archives: %s', 'likepa' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
				</header>

				<?php
					/* Rewind the loop back.
					 ----------------------*/
					rewind_posts();
				?>

				<?php likepa_content_nav( 'nav-above' ); ?>

				<?php
				if ( get_the_author_meta( 'description' ) ) : ?>
				<div id="author-info">
					<div id="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'likepa_author_bio_avatar_size', 60 ) ); ?>
					</div><!-- #author-avatar -->
					<div id="author-description">
						<h2><?php printf( __( 'About %s', 'likepa' ), get_the_author() ); ?></h2>
						<?php the_author_meta( 'description' ); ?>
					</div><!-- #author-description	-->
				</div><!-- #entry-author-info -->
				<?php endif; ?>

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

<?php get_sidebar('1'); ?>
<?php get_footer(); ?>