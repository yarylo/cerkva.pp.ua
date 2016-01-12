<?php
/**
 * The Sidebar widget area.
 *
 * @since likepa 1.0
*/ 

$options = get_option('likepa_theme_options');
$current_layout = $options['likepa_column'];

if ( 'content' != $current_layout || is_page_template ( 'tmp-twocolumn.php' ) ) :

?>
	<?php 
	// A second sidebar for widgets to make up two column template.
	if ( is_active_sidebar( 'tertiary-widget-area' ) ) : ?>

		<div id="tertiary" class="widget-area two_column_secondary" role="complementary">
			
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			
		</div><!-- #tertiary .widget-area -->
		<?php endif; // end sidebar widget area ?>
<?php endif; // end sidebar widget area ?>
