<?php
/**
 * The template used for displaying page content in page.php
 *
 * @since likepa 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'likepa' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta" style="clear:both;">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'likepa' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'likepa' ) );
			if ( '' != $tag_list ) {
				$utility_text = __( '.', 'likepa' );
			} elseif ( '' != $categories_list ) {
				$utility_text = __( '.', 'likepa' );
			} else {
				$utility_text = __( '.', 'likepa' );
			}

			printf(
				$utility_text,
				$categories_list,
				$tag_list,
				esc_url( get_permalink() ),
				the_title_attribute( 'echo=0' ),
				get_the_author(),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
			);
		?>
		<?php edit_post_link( __( 'Правити', 'likepa' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-meta -->
	
	
</article><!-- #post-<?php the_ID(); ?> -->
