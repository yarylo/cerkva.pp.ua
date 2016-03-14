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
</head>

<body <?php body_class(); ?>>
	<div id="head-wrapper">
		<?php /* ======== TOP MENU ======== */
		if ( isset ($options['likepa_show_secondary_menu'])&&  ($options['likepa_show_secondary_menu'] != "") ) {
		get_template_part('top','menu'); } else { echo "";}?>
		<header id="branding" role="banner">
			<div id="header-group" class="clearfix">
				<div id="header-logo">
					<?php
					if ( ! empty( $options['likepa_hide_title_discription'] ) && $options['likepa_header_logo'] ) { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><span id="header-link"> </span></a>
					<?php } ?>
					<hgroup>
						<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
						<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
					</hgroup>
					<?php
					if ( isset ($options['likepa_search_placement'])&&  ($options['likepa_search_placement'] == "Header") ) {
					get_search_form(); } 
					if ( isset ($options['likepa_show_social_icons'])&&  ($options['likepa_show_social_icons'] != "") ) {
					get_template_part('header','social');} else { echo "";}
					?>
				</div>
			</div>
		</header><!-- #branding -->
	</div><!-- #head-wrapper -->
<div id="page" class="hfeed">
	<?php /* ======== BOTTOM MENU ======== */
	get_template_part('bottom','menu'); ?>
	<div id="main">