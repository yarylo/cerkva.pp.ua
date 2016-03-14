<?php
/**
 * Bottom Primary Menu.
 *
 * @since likepa 1.0
 */ 
global $options;
$options = get_option('likepa_theme_options'); ?>
	<div id="nav-bottom-menu">
		<div id="nav-bottom-wrap">
			<nav id="nav-menu2" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Main menu', 'likepa' ); ?></h3>
				<?php /*  Allow screen readers to skip the navigation. */ ?>
				<div class="skip-link"><a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to primary content', 'likepa' ); ?>"><?php _e( 'Skip to primary content', 'likepa' ); ?></a></div>
				<div class="skip-link"><a class="assistive-text" href="#secondary" title="<?php esc_attr_e( 'Skip to secondary content', 'likepa' ); ?>"><?php _e( 'Skip to secondary content', 'likepa' ); ?></a></div>
				<?php /* Our navigation menu. */ ?>
				<?php if ( isset ($options['likepa_remove_superfish']) &&  ($options['likepa_remove_superfish']!="") )
						//wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary',  ) );
						wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'depth' => 1 ) );
					else
						//wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'menu_class' => 'sf-menu','fallback_cb' => 'likepa_page_menu'  ) );
						wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'menu_class' => 'sf-menu', 'depth' => 1  ) );?>
			<?php /* Search in menu. */ ?>
			<?php if ( isset ($options['likepa_search_placement'])&&  ($options['likepa_search_placement'] != "Menu") ) {
						echo '';
					} else{
						get_search_form(); } ?>
    
						
			</nav><!-- #nav-menu2 -->
		</div>
	</div>