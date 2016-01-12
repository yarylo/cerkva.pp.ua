<?php
/**
 * The default template for displaying content
 *
 * @since likepa 1.0
 */
 
global $options;
$options = get_option('likepa_theme_options');
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_sticky() ) : ?>
				<hgroup>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'likepa' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<h3 class="entry-format"><?php _e( 'Featured', 'likepa' ); ?></h3>
				</hgroup>
			<?php else : 
			if ( isset ($options['likepa_remove_post_calendar']) &&  ($options['likepa_remove_post_calendar']!="") )
				{echo' ';}
			else { ?>
				<div class="calendar">
					<span class="month"><?php the_time("M", get_option('date_format')); ?></span>
					<span class="day"><?php the_time("d", get_option('date_format')); ?></span>
				</div><!-- calendar --><?php
			} ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'likepa' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<?php endif; ?>

			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php likepa_posted_on(); ?>

			
				
				
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'likepa' ) );
				if ( $categories_list ):
			?>
				<span class="cat-links">
					<?php printf( __( '<span class="%1$s"> </span> %2$s', 'likepa' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
					$show_sep = true; ?>
				</span>
			<?php endif; // End if categories ?>
			<?php edit_post_link( __( 'Edit', 'likepa' ), '<span class="edit-link">', '</span>' ); ?>		
			
			
			</div><!-- .entry-meta -->
			<?php endif; ?>

		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php elseif ( isset ($options['likepa_thumbnail_excerpt']) &&  ($options['likepa_thumbnail_excerpt'] !="") ) : { ?>
		<div class="entry-summary">
			<?php if(has_post_thumbnail()) {
			echo '<span class="thumbnail"><a href="'; the_permalink(); echo '">';the_post_thumbnail(array(100,100)); echo '</a></span>';
			}
			the_excerpt(); } ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'likepa' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'likepa' ) . '</span>', 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>
		<div style="clear:both;"></div>
		<footer class="entry-meta" style="clear:both;">
		</footer><!-- #entry-meta -->
	</article><!-- #post-<?php the_ID(); ?> -->
