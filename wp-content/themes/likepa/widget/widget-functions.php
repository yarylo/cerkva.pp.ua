<?php
/**
 * Register our widgets and sidebars.
 *
 * @since likepa 1.0
 */
function likepa_widgets_init() {


	register_sidebar( array(
		'name' => __( 'Ліва колонка', 'likepa' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Права колонка', 'likepa' ),
		'id' => 'tertiary-widget-area',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Права колонка "Головна"', 'likepa' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'likepa' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'likepa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'likepa' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'likepa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'likepa' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'likepa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'likepa_widgets_init' );

// Add Widget Files
$widgets_path = get_template_directory() . '/widget/';
require_once($widgets_path . 'flickr.php');
require_once($widgets_path . 'twitter.php');
require_once($widgets_path . 'two-column-text.php');
require_once($widgets_path . 'google-translate.php');

function likepa_load_widgets() {
	register_widget('likepa_flickr_widget');
	register_widget('likepa_widget_twitter');
	register_widget("likepa_widget_text");
	register_widget("likepa_translate_widget");
}
add_action('widgets_init', 'likepa_load_widgets');


// Enable dynamic classes for the footer
function likepa_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = 'one';
			break;
		case '2':
			$class = 'two';
			break;
		case '3':
			$class = 'three';
			break;
	}

	if ( $class )
		echo 'class="' . $class . '"';
}
// If Google Translate widget active add script
function likepa_include_google_translate_js() {
	if ( !is_admin() && is_active_widget('likepa_translate_widget', false, 'likepa_translate_widget', true)) {

        wp_enqueue_script('google-translate', 'http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', array(), null, true);
	    wp_enqueue_script('google-translate-settings', get_template_directory_uri() . '/js/googletranslate.js');
    }
}    
add_action('init', 'likepa_include_google_translate_js');
?>