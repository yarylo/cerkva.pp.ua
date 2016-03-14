<?php
/**
 * The default template for displaying content
 *
 * @since likepa 1.0
 */
 
global $options;
global $sticky_limit;
$sticky_limit = 1;
$options = get_option('likepa_theme_options');
add_filter('post_class','jrh_post_names');

?>

	<article id="post-<?php the_ID(); ?>" <?php if ( is_sticky() && $sticky_limit<1 && !is_search()) {post_class('one-sticky');} else  post_class('post post-list');?>>
		<?php if ( is_search() ) : ?>
		<div class="entry-summary">
		  <?php
		  if(has_post_thumbnail()) {
    		echo '<span class="thumbnail"><a href="'; the_permalink(); echo '">';the_post_thumbnail('medium'); echo '</a></span>';
    	  }
    	  ?>
    	  <h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'likepa' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
    	  
		  <?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php elseif ( isset ($options['likepa_thumbnail_excerpt']) &&  ($options['likepa_thumbnail_excerpt'] !="") ) : { ?>
		<div class="entry-summary">
			<?php if(has_post_thumbnail()) {
			    if ( is_sticky() && $sticky_limit<1 && !is_search()){
			       echo '<span class="thumbnail"><a href="'; the_permalink(); echo '">';the_post_thumbnail('medium'); echo '</a></span>';
			    }else{
			       echo '<span class="thumbnail"><a href="'; the_permalink(); echo '">';the_post_thumbnail('small'); echo '</a></span>';
			    }
			       
			}
			?>
			
			<header class="entry-header">
			<?php if ( is_sticky() ) : ?>
				<hgroup>
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'likepa' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
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
			<?php endif; // end is_sticky()?>
		</header><!-- .entry-header -->
			
			<?php
			the_excerpt(); } ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'likepa' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'likepa' ) . '</span>', 'after' => '</div>' ) ); ?>			
		</div><!-- .entry-content -->
		<?php endif; //end is_search() ?>
		
			<?php if ( 'post' == get_post_type() or 'page' == get_post_type()) : ?>
			<div class="entry-meta">
			    <?php if ( !is_sticky() or $sticky_limit>=1) : ?>
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
			<?php endif; // End if !is_sticky ?>
			<?php endif; // End if categories ?>
			<?php edit_post_link( __( 'Edit', 'likepa' ), '<span class="edit-link">', '</span>' ); ?>		
			
			
			</div><!-- .entry-meta -->
			<?php endif; ?>
		<div style="clear:both;"></div>
		<footer class="entry-meta" style="clear:both;">

		</footer><!-- #entry-meta -->
	</article><!-- #post-<?php the_ID();  $sticky_limit++;?> -->
