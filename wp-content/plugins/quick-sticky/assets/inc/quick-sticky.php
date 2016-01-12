<?php

/***************************************************************
* Function qs_css
* Register and enqueue admin stylesheet
***************************************************************/
	
add_action('admin_enqueue_scripts', 'qs_css');

function qs_css() {
	wp_register_style('qs-admin', QS_CSS_URL.'/qs.css', '', filemtime(QS_PATH . '/assets/css/qs.css'));
	wp_enqueue_style('qs-admin');
}
	
/***************************************************************
* Functions qs_plugin_row_meta
* Add some handy shortcuts to the plugin admin screen
***************************************************************/

add_filter('plugin_row_meta', 'qs_plugin_row_meta', 10, 2);

function qs_plugin_row_meta($links, $file) {
	
	if ($file == QS_BASE) {

		$links[] = '<a href="http://twitter.com/scottsweb">' . __('Twitter','qs') . '</a>';
		
	}

	return $links;
}

/***************************************************************
* Function qs_post_columns
* Add extra column to posts table to quickly sticky a post
***************************************************************/

add_filter('manage_post_posts_columns', 'qs_post_columns');

function qs_post_columns($defaults) {

	if (!current_user_can('edit_posts')) return ;

	global $post_type;
	$defaults['sticky']	= __('Sticky', 'qs');
	return $defaults;
}

/***************************************************************
* Function qs_posts_columns_output
* Make the featured column work
***************************************************************/

add_action('manage_posts_custom_column', 'qs_posts_columns_output', 10);

function qs_posts_columns_output($column) {

	if (!current_user_can('edit_posts')) return ;

	global $post;
	
	switch ($column) {
		case "sticky" :
		
			$sticky_posts = get_option('sticky_posts');
			$url = wp_nonce_url( admin_url('admin-ajax.php?action=qs-sticky-post&post_id=' . $post->ID), 'qs-sticky-post');

			if (in_array($post->ID, $sticky_posts)) {
				echo '<a href="'.$url.'" class="icon-sticky">'.__('Sticky', 'qs').'</a>';
			} else {
				echo '<a href="'.$url.'" class="icon-not-sticky">'.__('Teflon', 'qs').'</a>';
			}
			
		break;
	}
}

/***************************************************************
* Functions qs_sticky_post
* Handle the request from above to sticky a post quickly
***************************************************************/

add_action('wp_ajax_qs-sticky-post', 'qs_sticky_post');

function qs_sticky_post() {
	
	if ( !current_user_can('edit_posts') ) wp_die( __('You do not have sufficient permissions to access this page.', 'qs') );
	
	if ( !check_admin_referer('qs-sticky-post')) wp_die( __('You have taken too long. Please go back and retry.', 'qs') );
	
	$post_id = isset($_GET['post_id']) && (int)$_GET['post_id'] ? (int)$_GET['post_id'] : '';
	
	if (!$post_id) die;
	
	$post = get_post($post_id);
	if (!$post) die;
	
	if ($post->post_type !== 'post') die;
	
	$sticky_posts = get_option('sticky_posts');

	if (in_array($post->ID, $sticky_posts)) {
		unstick_post($post->ID);
		$message = 2;
	} else {
		
		// a filter to impose the sticking of one post only
		if (apply_filters('qs_one_post_only', false)) {
			$stickies = array();
			$stickies[] = $post->ID;
			update_option('sticky_posts', $stickies);
		} else {
			stick_post($post->ID);
			$message = 1;
		}
		
	}

	$sendback = add_query_arg(array('message' => $message), remove_query_arg( array('trashed', 'untrashed', 'deleted', 'ids'), wp_get_referer()));
	wp_safe_redirect( $sendback );
}

/***************************************************************
* Function qs_admin_notice
* Some visiual feedback for when posts are stickied
***************************************************************/

add_action('admin_notices', 'qs_admin_notice');

function qs_admin_notice() {
	
	global $pagenow, $post_type;
	
	// added the newsletter ready for sending
	if ($pagenow == 'edit.php' && $post_type == 'post' && isset($_GET['message'])) {
		switch($_GET['message']) {
			case 1:
				echo '<div class="updated"><p>'.__('Your post has been made sticky.', 'qs').'</p></div>';
			break;
			case 2:
				echo '<div class="updated"><p>'.__('Your post is no longer sticky.', 'qs').'</p></div>';
			break;
		}
	}
}