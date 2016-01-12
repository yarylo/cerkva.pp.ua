<?php
/**
 * The Sidebar widget area.
 *
 * @since likepa 1.0
*/ 

$options = get_option('likepa_theme_options');
$current_layout = $options['likepa_column'];

if ( 'content' != $current_layout || is_page_template ( 'tmp-threecolumn.php' ) ) :

?>
	<?php 
	// A second sidebar for widgets to make up three column template.
	if ( is_active_sidebar( 'tertiary-widget-area' ) ) : ?>

		<div id="tertiary" class="widget-area" role="complementary">
			
				<?php dynamic_sidebar( 'tertiary-widget-area' ); ?>
			
		</div><!-- #tertiary .widget-area -->
		<?php endif; // end sidebar widget area ?>
<?php endif; // end sidebar widget area ?>
