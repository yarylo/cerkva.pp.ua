<?php
/**
 * likepa functions.
 *
 * @since likepa 1.0
 */
	 
// Set the content width.
if ( ! isset( $content_width ) )
	$content_width = '';

add_action( 'after_setup_theme', 'likepa_setup' );

/**
 * Sets up likepa defaults.
 *
 * @since likepa 1.0 
 */
if ( ! function_exists( 'likepa_setup' ) ):

function likepa_setup() {

	// Available for translation.
	load_theme_textdomain( 'likepa', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );	
		
	add_editor_style();   // Style the visual editor.
	add_theme_support( 'automatic-feed-links' );
	register_nav_menus( array(  // Register both nav menus.
	'primary' => __( 'Primary Navigation', 'likepa' ),
	'secondary' => __('Secondary Navigation - Top', 'likepa'),
	) );
	// Post formats
	add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );
	// Custom Backgrounds
	if ( function_exists('get_custom_header')) {
		// WordPress 3.4+	
        add_theme_support('custom-background');
	} else {
		// Backwards Compatibility
        add_custom_background();
	}
	add_theme_support( 'post-thumbnails' );
}
endif; // likepa_setup

//Add Theme Options File
$functions_path = get_template_directory() . '/admin/';
require_once ($functions_path . 'likepa-options.php');
require_once ($functions_path . 'likepa-custom-header.php');

/* Register Assets */
if( ! function_exists( 'likepa_register_assets') ):
	function likepa_register_assets(){
		$options = get_option('likepa_theme_options');
		/*----------------------------------------
		# REGISTER SCRIPTS
		----------------------------------------*/
		/* Register Scripts */
		if(!is_admin()) wp_enqueue_script('jquery');
		
		/* Modernizr */
		wp_register_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.0.6.js', array(), '2.0.6' );
		if( !is_admin() ){ wp_enqueue_script('modernizr'); }
		
		/* Superfish Scripts */
		wp_register_script('likepa-SFhoverIntent', get_template_directory_uri() . '/js/superfish/hoverIntent.js', array());
		if ( empty( $options['likepa_remove_superfish'] ) && !is_admin()) { wp_enqueue_script('likepa-SFhoverIntent'); }
		wp_register_script('likepa-SF', get_template_directory_uri() . '/js/superfish/superfish.js', array());
		if ( empty( $options['likepa_remove_superfish'] ) && !is_admin()) { wp_enqueue_script('likepa-SF'); }
		
	}
endif;
add_action('init','likepa_register_assets');

/**
 * Display pagination when applicable
 *
 * @since likepa 1.0
 */
if (!function_exists('likepa_pagination')):

function likepa_pagination($pages = '', $range = 3) {   /* handle pagination for post pages*/
	$showitems = ($range * 2)+1;  
	 
	global $paged;
	if(empty($paged)) $paged = 1;
	 
		if($pages == '')
		{
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages)
			{
			$pages = 1;
			}
		}   
	 
		if(1 != $pages)
		{
			//echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
			echo "<div class=\"pagination\">";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
			if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
	 
			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				{
					 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
				}
			}
	 
			if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
			echo "</div>\n";
		}
	} //  likepa_pagination
endif;
// Display navigation to next/previous pages.

function likepa_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'likepa' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'likepa' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'likepa' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}

// Clicky Analytics 
function likepa_clicky_script() {
	$options = get_option('likepa_theme_options');

	if ( isset ($options['likepa_clicky_site_id']) &&  ($options['likepa_clicky_site_id']!="") && !is_preview() ) { ?>

	<script type="text/javascript">
	var clicky_site_ids = clicky_site_ids || [];
	clicky_site_ids.push(<?php echo $options['likepa_clicky_site_id']; ?>);
	(function() {
	  var s = document.createElement('script');
	  s.type = 'text/javascript';
	  s.async = true;
	  s.src = '//static.getclicky.com/js';
	  ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
	})();
	</script>
	<noscript><p><img alt="Clicky" width="1" height="1" src="http://in.getclicky.com/<?php echo $options['likepa_clicky_site_id']; ?>ns.gif" /></p></noscript>
	<!-- End Clicky Tracking -->
<?php
	}
}
add_action('wp_footer','likepa_clicky_script',90);


function likepa_scroll_top() {
	$options = get_option('likepa_theme_options');
	
	if ( isset ($options['likepa_remove_scroll_top']) &&  ($options['likepa_remove_scroll_top'] != "")) { echo "";} else { ?>

<script type="text/javascript">
	jQuery('a[href^="#likepa-top"]').live('click',function(event){
		event.preventDefault();
		var target_offset = jQuery(this.hash).offset() ? jQuery(this.hash).offset().top : 0;
		jQuery('html, body').animate({scrollTop:target_offset}, 800);
	});
</script>
<?php
	}
}
add_action('wp_footer','likepa_scroll_top',30);

/**
 * Get wp_page_menu() to show a home link.
 */
function likepa_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'likepa_page_menu_args' );

/* Superfish, handle sf-menu for wp_page_menu */
function likepa_page_menu() {
    $menu = wp_page_menu(array('echo' => false));
	if ( isset ($options['likepa_remove_superfish'])) {
	echo $menu;
	}
	else {
	$ulpos = stripos($menu, '<ul>');
	if ($ulpos !== false) {
	    echo substr_replace($menu, '<ul class="sf-menu">',$ulpos, 4);
	}
    }
}

// Where the post has no post title, but must still display a link to the single-page post view.

add_filter('the_title', 'likepa_title');

function likepa_title($title) {
    if ($title == '') {
        //return 'Untitled';
    } else {
        return $title;
    }
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since likepa 1.0
 * @return string|bool URL or false when no link is present.
 */
function likepa_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}
/*
 * Add Widgets File
 *
 * @since likepa 1.0
 */
$widgets_path = get_template_directory() . '/widget/';
require_once($widgets_path . 'widget-functions.php');

/**
 * Adds three classes to the body class.
 *
 * @since likepa 1.0
 */
function likepa_body_classes( $classes ) {

	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( is_page_template( 'tmp-onecolumn.php' ) )
		$classes[] = 'one-column';
		
	if ( is_page_template( 'tmp-threecolumn.php' ) )
		$classes[] = 'two-sidebars';

	return $classes;
}
add_filter( 'body_class', 'likepa_body_classes' );

// Redirect to Theme Options Page on Activation
if ( is_admin() && isset($_GET['activated'] ) && $pagenow =="themes.php" )
	wp_redirect( 'admin.php?page=likepa-options.php' );

/**
 * Template for comments and pingbacks.
 *
 * @since likepa 1.0
 */
if ( ! function_exists( 'likepa_comment' ) ) :

function likepa_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'likepa' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'likepa' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'likepa' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'likepa' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'likepa' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'likepa' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'likepa' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;

if ( ! function_exists( 'likepa_posted_on' ) ) :
/* Posted on-date/time and author.
 *
 * @since likepa 1.0
 */
function likepa_posted_on() {
	printf( __( '<span class="sep">Опубліковано </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'likepa' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'likepa' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}
endif;

// Sets the post excerpt length to 40 words.
function likepa_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'likepa_excerpt_length' );

// Returns a Continue Reading link for excerpts
function likepa_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Читати повністю <span class="meta-nav">&rarr;</span>', 'likepa' ) . '</a>';
}

// Replaces "[...]".
function likepa_auto_excerpt_more( $more ) {
	return ' &hellip;' . likepa_continue_reading_link();
}
add_filter( 'excerpt_more', 'likepa_auto_excerpt_more' );

// Adds Continue Reading link to excerpts.
function likepa_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= likepa_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'likepa_custom_excerpt_more' );
// Add a link to the theme's options page in the admin bar
function likepa_wp_admin_bar_theme_options(){
	global $wp_admin_bar;
	$wp_admin_bar->add_menu(array(
								'parent' => 'appearance',
								'id' => 'likepa_options',
								'title' => 'likepa Options',
								'href' => admin_url('themes.php?page=likepa-options')
							));
}
add_action( 'admin_bar_menu', 'likepa_wp_admin_bar_theme_options', 61 );


/*
Plugin Name: Add X-Autocomplete Fields to Comment Form. by: Samuel �Otto� Wood
*/
add_filter('comment_form_default_fields','likepa_add_x_autocompletetype');
function likepa_add_x_autocompletetype($fields) {
	$fields['author'] = str_replace('<input', '<input x-autocompletetype="name-full"', $fields['author']);
	$fields['email'] = str_replace('<input', '<input x-autocompletetype="email"', $fields['email']);
	return $fields;
}

/* Adding Google Analytics - Thank You Garinungkadol
 * Define the variable for the google analytics user id
 *----------------------------------------------------*/
function likepa_localize_var(){
	$options = get_option('likepa_theme_options');
	   return array(
        'likepa_google_analytics' => $options['likepa_google_analytics']
    );
}

// Enqueue the script
function likepa_ga_enqueue_script() {
	$options = get_option('likepa_theme_options');
	// Only display the javascript if a user id has been defined in theme options page
	if ( isset ($options['likepa_google_analytics']) &&  ($options['likepa_google_analytics']!="") && !is_preview() ) {
		wp_enqueue_script('likepa_ga', get_template_directory_uri() .'/js/ga.js');
		wp_localize_script( 'likepa_ga', 'likepa_var', likepa_localize_var());
	}
}	
// This will produce the javascript in the header of the blog
add_action( 'wp_enqueue_scripts', 'likepa_ga_enqueue_script' );	


function jrh_post_names($classes) {
	$classes = array_diff($classes, array("page", "sticky"));
	return $classes;
}


function turn_off_sticky( $query ) {
	$query->set( 'ignore_sticky_posts', true );
}
add_action( 'pre_get_posts', 'turn_off_sticky' );


?>