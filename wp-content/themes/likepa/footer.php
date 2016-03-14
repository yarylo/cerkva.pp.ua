<?php
/**
 * The template for displaying the footer.
 *
 * @since likepa 1.0
 */
global $options;
$options = get_option('likepa_theme_options'); ?>

	</div><!-- #main -->
	
</div><!-- #page -->
<footer id="footer" class="clearfix" role="contentinfo">
	<section id="colophon" class="clearfix">
		<?php if ( isset ($options['likepa_remove_scroll_top']) &&  ($options['likepa_remove_scroll_top'] != "")) { echo "";} else { ?>
		<div id="top-scroll">
			<a href="#likepa-top" class="scroll" title="Scroll to Top"><div id="scroll-top"></div></a>
		</div>
			<?php }
				//if ( ! is_404() ) get_sidebar( 'footer' );
				$date = getdate();
	            $year = $date['year']; ?>
			<div id="footer-html">
				<?php if ( isset($options['likepa_footer_opts']) && ($options['likepa_footer_opts']!="") ){ ?>
				<?php echo(stripslashes ($options['likepa_footer_opts']));?>
				<?php } ?>
			</div><!-- #footer-html -->
			<div id="footer-info">
				<?php if ( isset($options['likepa_add_custom_copyright']) && ($options['likepa_add_custom_copyright']!="") ) { ?>
					<div id="site-info">
						<?php echo(stripslashes ($options['likepa_add_custom_copyright']));?>
					</div>
				<?php } else { ?>
				<div id="site-info">&copy; <?php echo("$year"); ?>
					<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						<?php bloginfo( 'name' ); ?>
					</a>
				</div><!-- #site-info -->
				<?php } ?>
				<div id="site-generator">
					<?php do_action( 'likepa_credits' ); ?>
					<a href="<?php echo esc_url( __( 'http://wp-ultra.com/', 'likepa' ) ); ?>" rel="generator"><?php printf( __( 'likepa Theme', 'likepa' )); ?></a>
				</div>
			</div>
	</section>
</footer><!-- #footer -->

<?php wp_footer(); ?>
	</div>
</body>
</html>