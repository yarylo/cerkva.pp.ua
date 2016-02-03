<?php
/*
Plugin Name: Cerkva.if.ua Convertation
Plugin URI: *
Description: Cerkva.if.ua Convertation
Version: 1.1
Author: H_Yar
Author URI: *
*/
?>
<?php
/*  Copyright 2016 H_yar */


add_action('admin_menu', 'register_CC');

require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

function register_CC() {
	add_menu_page('CC', 'C Convertation', 'manage_options','CC', 'CC_function');
	
//	add_options_page('Donation', 'Donation', 'administrator', 'dfwr', 'dfwr_function', WP_PLUGIN_URL.'/donation-form-with-reminder/images/don.png');
}

function CC_function() {
	if ($_REQUEST['action'] == 'subject')
		ConvertSubject();
	elseif ($_REQUEST['action'] == 'category')
		ConvertCategory($_REQUEST['start']);
	elseif ($_REQUEST['action'] == 'post')
		ConvertPost($_REQUEST['start']);
	else
		SelestAction();
}


// Subject //

function ConvertSubject(){

	global $wpdb;

	$subjects = $wpdb->get_results("SELECT * FROM subject", 'ARRAY_A');
	
	foreach ($subjects as $subject) {
		$tag_id = '';

		$tag_id = term_exists($subject['name']);
		if ($tag_id == 0){
			$tag_id = wp_create_term($subject['name'],'post_tag' );
			$tag_id = $wpdb->get_var("SELECT MAX(`term_id`) FROM $wpdb->terms");
			
			$wpdb->insert(
				'subject_to_tag',
				array( 'subject_id' => $subject['id'], 'tag_id' => $tag_id ),
				array( '%d', '%d' )
			);
		}



	}
	
	$count = $wpdb->get_var("SELECT COUNT(*) FROM `subject_to_tag`");
	
	?>
	
	<html>
	<head>
		<meta charset='UTF-8' />
	</head>
	<body>
		<?php	
		echo $count;
		?>	
	</body>
	</html>
	<!-- end HTML part -->

<?php
}

// End Subject //


// Category //

function ConvertCategory($start=false){

	global $wpdb;
	$end = 100;
	$count_category = $wpdb->get_var("SELECT COUNT(*) FROM `categories` WHERE status > 0");

	$categories = $wpdb->get_results("SELECT * FROM `categories` WHERE `status` > 0 ORDER BY `parent` ASC LIMIT $start , $end", 'ARRAY_A');
	
	foreach ($categories as $category) {
		
		if ( $term_id = category_exists($category['name']) ) {
			
			$wpdb->insert(
				'category_to_terms',
				array( 'category_id' => $category['id'], 'term_id' => $term_id ),
				array( '%d', '%d' )
			);
			
		} else {
			$parent = $wpdb->get_var("SELECT `term_id` FROM `category_to_terms` WHERE `category_id` = '".$category['parent']."'");
			if( $term_id = wp_create_category($category['name'], $parent) )
				$wpdb->insert(
					'category_to_terms',
					array( 'category_id' => $category['id'], 'term_id' => $term_id ),
					array( '%d', '%d' )
				);
				
				
		}
		
	}
	
	
?>
	<div class="cc_title"><h2>Category</h2></div>
	
	<div class="cc_content">
<?php	
			echo '<div>Total categories: '.($count_category-1).'</div>';
			echo '<div><a href="?page=CC&action=category&start='.($start+$end+1).'">Next categories >>></a></div>';
?>	
	</div>

<?php
}

// End Category //


// Post //
function ConvertPost(){

	global $wpdb;

	$count_category = $wpdb->get_var("SELECT COUNT(*) FROM `categories`");
//	$subjects = $wpdb->get_results("SELECT * FROM `categories` ORDER BY `categories`.`parent` ASC LIMIT 1 , 31", 'ARRAY_A');
	$subjects = $wpdb->get_results("SELECT * FROM subject", 'ARRAY_A');
	
	foreach ($subjects as $subject) {
		$tag_id = '';

		$tag_id = term_exists($subject['name']);
		if ($tag_id == 0){
			$tag_id = wp_create_term($subject['name'],'post_tag' );
			$tag_id = $wpdb->get_var("SELECT MAX(`term_id`) FROM $wpdb->terms");
			
			$wpdb->insert(
				'subject_to_tag',
				array( 'subject_id' => $subject['id'], 'tag_id' => $tag_id ),
				array( '%d', '%d' )
			);
		}



	}
	
	$count = $wpdb->get_var("SELECT COUNT(*) FROM `subject_to_tag`");
	
	?>
	
	<html>
	<head>
		<meta charset='UTF-8' />
	</head>
	<body>
		<?php	
		echo $count;
		?>	
	</body>
	</html>
	<!-- end HTML part -->

<?php
}

// End Post //

function SelestAction(){
	?>
	<p></p>
	<p><a href="admin.php?page=CC&action=subject">Subject</a></p>
	<p></p>
	<p><a href="admin.php?page=CC&action=category&start=1">Category</a></p>
	<p></p>
	<p><a href="admin.php?page=CC&action=post">Post</a></p>
<?php
}

## Функция которая исполняется при активации плагина
register_activation_hook( __FILE__, 'activate');
##  Функция которая исполняется при деактивации плагина
//register_deactivation_hook( __FILE__, 'uninstall' );
##  Функция которая исполняется при удалении плагина
register_uninstall_hook( __FILE__, 'uninstall');

// <-- end PHP part -->



?>
