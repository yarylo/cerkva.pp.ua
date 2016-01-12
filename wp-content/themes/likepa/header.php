<?php
/**
 * The Header for our theme.
 *
 * @since likepa 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]> <html id="ie6" class="no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html id="ie7" class="no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html id="ie8" class="no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<?php global $options;
$options = get_option('likepa_theme_options'); ?>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="shortcut icon" href="/favicon.png" type="image/x-icon" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php
	if ( !empty ($options['likepa_hide_metainfo'])) {
		wp_title('');	/* this is compatible with SEO plugins */
    } else {
	/* Else Print the <title> tag.
	 ----------------------------*/
	global $page, $paged;

	wp_title( '|', true, 'right' );
	bloginfo( 'name' ); // Name.
	$site_description = get_bloginfo( 'description', 'display' ); // Description
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	// Add page number:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'likepa' ), max( $paged, $page ) );
	} ?> </title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<!--link rel="stylesheet" type="text/css" media="all" href="/wp-content/plugins/gecka-submenu/css/widget-custom-menu-accardion.css" />
<script type='text/javascript' src="/wp-content/plugins/gecka-submenu/javascripts/widget-custom-menu-accardion.js" /></script-->


<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* JavaScript for threaded comments.
	 ----------------------------------*/
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* wp_head() before closing </head> tag.
	---------------------------------------*/
	wp_head();
?>
<!--[if IE 8]>
	<style>
		#box {
			border: 1px solid rgb(204, 204, 204);
		}
		#primary {
			width: 100%;
		}
		.content{width: 100%;}
		#main{width: 100%;}
		.two-sidebars #content {
			margin: 0 auto;
			max-width: 100%;
		}
		#my_likepa_gerb{
		  display: none;
		}
    </style>
<![endif]-->
</head>

<body <?php body_class(); ?>>
	<div id="box">
	<div id="head-wrapper">
		<?php /* ======== TOP MENU ======== */
		if ( isset ($options['likepa_show_secondary_menu'])&&  ($options['likepa_show_secondary_menu'] != "") ) {
		get_template_part('top','menu'); } else { echo "";}?>
		<header id="branding" role="banner">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div id="header-group" class="clearfix">
					<div id="header-logo">
						<div id="my_likepa_logo"></div>
						<div id="my_likepa_name"></div>
						<div id="my_likepa_gerb"></div>			
					</div>
				</div>
			</a>
		</header><!-- #branding -->
	</div><!-- #head-wrapper -->
<div id="page" class="hfeed">
	<?php /* ======== BOTTOM MENU ======== */
	get_template_part('bottom','menu'); ?>
	<div id="main">