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

// require_once( $_SERVER['HTTP_HOST'] . '../../../wp-load.php' );

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
	elseif ($_REQUEST['action'] == 'post-link')
		PostLink($_REQUEST['start']);
	else
		SelestAction();
}


// Subject //

function ConvertSubject(){

	global $wpdb;

	$subjects = $wpdb->get_results("SELECT * FROM subject", 'ARRAY_A');
/*	
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
*/

	foreach ($subjects as $category) {
		
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
	SelestAction();
}

// End Subject //


// Category //

function ConvertCategory($start=false){

	global $wpdb;
	if (!$start)
		$start = 0;
	$end = 100;
	$count_category = $wpdb->get_var("SELECT COUNT(*) FROM `categories` WHERE status > 0");

	$categories = $wpdb->get_results("SELECT * FROM `categories` WHERE `status` > 0 ORDER BY `parent` ASC LIMIT $start , $end", 'ARRAY_A');
	
	foreach ($categories as $category) {
/*		
		if ( $term_id = category_exists($category['name']) ) {
			
			$wpdb->insert(
				'category_to_terms',
				array( 'category_id' => $category['id'], 'term_id' => $term_id ),
				array( '%d', '%d' )
			);
			
		} else {
*/		
			$parent = $wpdb->get_var("SELECT `term_id` FROM `category_to_terms` WHERE `category_id` = '".$category['parent']."'");
			if( $term_id = wp_create_category($category['name'], $parent) )
				$wpdb->insert(
					'category_to_terms',
					array( 'category_id' => $category['id'], 'term_id' => $term_id ),
					array( '%d', '%d' )
				);
				
				
//		}
		
	}
	$count_added_category = $wpdb->get_var("SELECT COUNT(*) FROM `category_to_terms`");
	
?>
	<div class="cc_title"><h2>Category</h2></div>
	<script>
	var a1 = <?php echo $count_category; ?>;
	var a2 = <?php echo $start; ?>;
	jQuery(function(){
		if (a2 <= a1) {
	   		url = "?page=CC&action=category&start=<?php echo $start+$end; ?>";
	    	jQuery(location).attr("href", url);
		} else {
	   		url = "?page=CC&action=post";
	    	jQuery(location).attr("href", url);	
		}
	});
</script>
	<div class="cc_content">
<?php	
			echo '<div>Total categories: '.($count_category-1).'</div>';
			echo '<div><a href="?page=CC&action=category&start='.($start+$end).'">Next categories >>></a></div>';
?>	
	</div>

<?php
	SelestAction();
}

// End Category //


// Post //

function ConvertPost($start=false){

	global $wpdb;
	if (!$start)
		$start = 0;
	$end = 100;
	$count_data = $wpdb->get_var("SELECT COUNT(*) FROM `data` WHERE status > 0");
	$datas = $wpdb->get_results("SELECT * FROM `data` WHERE `status` > 0 ORDER BY `id` LIMIT $start , $end", 'ARRAY_A');
	
	foreach ($datas as $data) {
			
//		$categories = $wpdb->get_var("SELECT GROUP_CONCAT(`term_id` SEPARATOR ',') as `string` from `category_to_terms` WHERE `category_id` = '".$data['category']."' OR `category_id` = '".$data['subject']."' ");

		$cat1 = $wpdb->get_var("SELECT `term_id` from `category_to_terms` WHERE `category_id` = '".$data['category']."'");
		$cat2 = $wpdb->get_var("SELECT `term_id` from `category_to_terms` WHERE `category_id` = '".$data['subjectsel']."' ");
		
//		echo  $cat1.', ';
//		echo  $cat2.'<br/>';
		
//		$categories = $wpdb->get_var("SELECT GROUP_CONCAT(`term_id` SEPARATOR ',') from `category_to_terms` WHERE `category_id` = '".$data['category']."' OR `category_id` = '".$data['subjectsel']."' ");
//		$tags = $wpdb->get_var("SELECT GROUP_CONCAT(`tag_id` SEPARATOR ',') as string from `subject_to_tag` WHERE subject_id = ".$data['subject']." ");
//		$count = $wpdb->get_var("SELECT COUNT(*) FROM `data` WHERE `status` > 0 AND `category` = ".$data['category']." ");
		$page_id = array(165,191,175,173,171,172,166,167,164,143,3286,1206,1429,1681,1682,3287);		
		$type = 'post';
		if (in_array($data['id'], $page_id)) {
			$type = 'page';
			$categories = '';
		}
		
		$post_content = $data['text'];
		
	    if (!empty($post['small_ico']))
	    	$post_content = '<img src="'.$post['small_ico'].'" align="left" />'.$post_content;
		    	
		$post_data = array(
		  'post_title'    	=> $data['name'],
		  'post_content'  	=> $post_content,
		  'post_date'      	=> $data['date'],
		  'post_date_gmt'  	=> $data['date'],
		  'post_type'      	=> $type,
		  'post_status'   	=> 'publish',
		  'post_author'   	=> 1,
		  'post_excerpt'   	=> $data['description'],
		  'post_category' 	=> (!empty($cat2))? array($cat1,$cat2) : array($cat1)
		  
		);
///*		
		if( $post_id = wp_insert_post( $post_data ) )
		
			$wpdb->insert(
					'data_to_post',
					array( 'data_id' => $data['id'], 'post_id' => $post_id ),
					array( '%d', '%d' )
				);
//*/
	}
	
//	$count_added_data = $wpdb->get_var("SELECT COUNT(*) FROM `data_to_post`");

	
?>
	<div class="cc_title"><h2>Posts</h2></div>
<script>
	var a1 = <?php echo $count_data; ?>;
	var a2 = <?php echo $start; ?>;
	jQuery(function(){
		if (a2 <= a1) {
	   		url = "?page=CC&action=post&start=<?php echo $start+$end; ?>";
	    	jQuery(location).attr("href", url);
		} else {
			url = "?page=CC&action=post-link";
	    	jQuery(location).attr("href", url);
		}
	});
</script>
	
	<div class="cc_content">
<?php	
			echo '<div>Total Posts: '.($count_data).'</div>';
			echo '<div>Total Added Posts: '.($count_added_data).'</div>';
			echo '<div>Posts ID: '.$post_id.'</div>';
			echo '<div><a href="?page=CC&action=post&start='.($start+$end).'" id="aclick">Next post >>></a></div>';
?>	
	</div>

<?php
	SelestAction();
}

// End Post //


// Post Link //	

function postLink($start = false){		
	
	global $wpdb;
	
	if (!$start)
		$start = 0;
	$end = 100;

	$count_post = $wpdb->get_var("SELECT COUNT(*) FROM `wp_posts` WHERE `post_status` = 'publish' ");
	$posts = $wpdb->get_results("SELECT `ID`, `post_title`, `post_content`, `post_excerpt` FROM `wp_posts` WHERE `post_status`  = 'publish' ORDER BY `ID` LIMIT $start , $end", 'ARRAY_A');
?>	
	
	<div class="cc_content">
<?php	
			echo '<div>Total Posts Link: '.($count_post).'</div>';
//			echo '<div>Post ID: '.$post['ID'].'</div>';
			echo '<div><a href="?page=CC&action=post-link&start='.($start+$end).'">Next post >>></a></div>';
?>	
	</div>	
<?php	
	foreach ($posts as $post) {
	  	$input = $post['post_content'];
		$regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>";
		$post_content = $input;
		if(preg_match_all("/$regexp/siU", $input, $matches, PREG_SET_ORDER)) {
			foreach($matches as $match) {
				$parset = parse_url($match[2]);
// 				print_r($parset);
				if (!$parset['host'] || $parset['host'] == 'http://cerkva.if.ua'  || $parset['host'] == 'http://www.cerkva.if.ua' || $parset['host'] == 'www.cerkva.if.ua' || $parset['host'] == 'cerkva.if.ua' ){
					parse_str($parset['query'], $output);
					
					echo '<br /><br />';
					if ($output['category'] > 0) {
						echo 'CATEGORY: '.$output['category']."<br />";
						$term = $wpdb->get_var("SELECT `slug` FROM `wp_terms` `wt`, `category_to_terms` `ct` WHERE `ct`.`category_id` = '".$output['category']."' AND `wt`.`term_id` = `ct`.`term_id`");
						$post_content = str_replace($match[2], '/?cat='.$term.'', $post_content);
		
					}
					elseif ($output['id'] > 0 && $output['id'] > 0) {				
						echo 'LINK POST ID: '.$output['id']."<br />";
						echo 'ACTION: '.$output['amp;action']."<br />";
						
						$post_id = $wpdb->get_var("SELECT `post_id` FROM `data_to_post` WHERE `data_id` = '".$output['id']."' ");
						$post_content = str_replace($match[2], '/?p='.$post_id, $post_content);
						
					}
					echo '<div>Link was: '.$parset['query'].'</div>';
					echo $match[2];
					
		
				}
				
		    }
		    
		    	
			$my_post = array(
				'ID'           => $post['ID'],
			    'post_title'   => $post['post_title'],
			    'post_content' => $post_content,
			);
			
			// Update the post into the database
			wp_update_post( $my_post );

//		    echo $post_content;
		}
	}
	
?>
	<div class="cc_title"><h2>Posts Link</h2></div>
	<script>
	var a1 = <?php echo $count_post; ?>;
	var a2 = <?php echo $start; ?>;
	jQuery(function(){
		if (a2 <= a1) {
	   		url = "?page=CC&action=post-link&start=<?php echo $start+$end; ?>";
	    	jQuery(location).attr("href", url);
		}
	});
</script>
	<div class="cc_content">
<?php	
			echo '<div>Total Posts Link: '.($count_post).'</div>';
			echo '<div>Post ID: '.$post['ID'].'</div>';
			echo '<div><a href="?page=CC&action=post-link&start='.($start+$end).'">Next post >>></a></div>';
?>	
	</div>

<?php
	SelestAction();
}

// End Post Link //	

function SelestAction(){
	?>
	<p></p>
	<p><a href="admin.php?page=CC&action=subject">Subject</a></p>
	<p></p>
	<p><a href="admin.php?page=CC&action=category">Category</a></p>
	<p></p>
	<p><a href="admin.php?page=CC&action=post">Post</a></p>
	<p></p>
	<p><a href="admin.php?page=CC&action=post-link">Post Link</a></p>
<?php
}

function activate() 
{
	global $wpdb;
	
	## Определение версии mysql
	if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') ) {
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
	}
	
	## Структура нашей таблицы для отзывов
	$sql_table_subject_to_tag = "
		CREATE TABLE IF NOT EXISTS `subject_to_tag` (
		  `subject_id` int(10) NOT NULL,
		  `tag_id` int(10) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$sql_table_category_to_terms = "
		CREATE TABLE IF NOT EXISTS `category_to_terms` (
		  `category_id` int(10) DEFAULT NULL,
		  `term_id` int(10) DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	$sql_table_data_to_post = "
		CREATE TABLE IF NOT EXISTS `data_to_post` (
		  `data_id` int(10) NOT NULL,
		  `post_id` int(10) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	dbDelta( $sql_table_subject_to_tag);
	dbDelta( $sql_table_category_to_terms);
	dbDelta( $sql_table_data_to_post);
}

/**
 * Удаление плагина
 */
function uninstall() 
{
	global $wpdb;
	
	$wpdb->query("DROP TABLE IF EXISTS `subject_to_tag`");
	$wpdb->query("DROP TABLE IF EXISTS `category_to_terms`");
	$wpdb->query("DROP TABLE IF EXISTS `data_to_post`");
}

## Функция которая исполняется при активации плагина
register_activation_hook( __FILE__, 'activate');
##  Функция которая исполняется при деактивации плагина
// register_deactivation_hook( __FILE__, 'uninstall' );
##  Функция которая исполняется при удалении плагина
register_uninstall_hook( __FILE__, 'uninstall');

// <-- end PHP part -->



?>
