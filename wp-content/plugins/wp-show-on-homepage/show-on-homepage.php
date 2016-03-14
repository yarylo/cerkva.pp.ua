<?php /*
 * Plugin Name: 	Show On Homepage
 * Plugin URI:		## 
 * Description: 	Show categorieson your homepage.
 * Tags: 			Categories
 * Version: 		1.0
 * Author: 			H_Yar
 * Author URI: 		#
 * Date:			11 May 2015
 * License: 		Free
 * 
 * 
 * 
 * @package WP Show on Homepage
 * @Version 1.0
 * @author 
 * @copyright Copyright (c) 2015
 * @license 
*/

global $wp_version;

$exit_msg = 'wp-assets require WordPress 2.6 or newer.  <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';

if (version_compare($wp_version, "2.6", "<")) {

	exit( $exit_msg );

}

if ( !class_exists('HYomepage') ) : 
 	 
	class HYomepage {
	
		private $plugin_domain = "show-on-homepage"; 
		private $plugin_page_option = "show-on-homepage-settings";
		 
		private $plugin_options_cat = "cat-to-show-on-homepage";
		private $plugin_options_disable = "disable-show-on-homepage"; // To disable options without delete them
		 
		private $plugin_url;
		
		function HYomepage(){
		
			$this->plugin_url = trailingslashit( WP_PLUGIN_URL.'/'. dirname( plugin_basename( __FILE__ ) ) );
				
			add_action('plugins_loaded', array( &$this , 'HYomepage_language' ));
			
			add_action( 'admin_enqueue_scripts', array(&$this,'HYomepage_admin_style'));
			
			add_action('admin_enqueue_scripts', array( &$this, 'HYomepage_admin_script' )); 
 			 
			add_action( 'admin_menu',  array(&$this, 'admin_menu'));
		       
			add_filter('pre_get_posts',array(&$this,'HYchange_home'));
			 
		}
		 
		function admin_menu(){ // Administration Settings Menu
		
			add_options_page(__('Settings | Show On Homepage',$this->plugin_domain),__('Show On Homepage',$this->plugin_domain), 8 , $this->plugin_page_option , array(&$this, 'handle_options'));
		
		}
		
		function handle_options() { // Load Settings Page
				
			if($_POST) $this->HYomepage_settings_forms_action();
				
			include( 'inc/show-on-homepage-settings.php');
		
		}
		
		function HYomepage_language(){ // Load localization file
				 
			load_plugin_textdomain($this->plugin_domain,false,'/'.dirname( plugin_basename( __FILE__ ) ) .'/lang/');
		
		}
  
		function HYomepage_admin_style(){ // Admin CSS
		
			wp_enqueue_style($this->plugin_domain,$this->plugin_url.'css/style.css');
		
		}
		
		function HYomepage_admin_script() { // Admin javasript
			 	
			wp_enqueue_script( $this->plugin_domain , $this->plugin_url.'js/script.js', array( 'jquery'), true);
			
		}
	 
		function HYomepage_settings_form($type){ // Forms ?>
		 
		 	<?php $action_url = "options-general.php?page={$this->plugin_page_option}&_wpnonce=".wp_create_nonce($type);?>
		 	
		 	<form action="<?php echo admin_url($action_url)?>" method="POST">
				 
				<?php if($type=="cat"){ 
					
					$options_recorded = get_option($this->plugin_options_cat);
					 
					if($options_recorded){
						
						$cats_ids_to_show = $options_recorded;
					
					}else{ 
						
						$cats_ids_to_show = array();
					
					}
					
					$args_cat = array ('hide_empty'=> 0);

					$cats = get_categories($args_cat); 
					
					foreach($cats as $cat){ ?>
					
						<input type="checkbox" name="cat[]" value="<?php echo $cat->term_id;?>" <?php if(in_array($cat->term_id, $cats_ids_to_show)){ echo " checked "; }?> /> <?php echo $cat->name;?> <span class="span-count">(<?php echo $cat->count;?> <?php _e("posts",$this->plugin_domain);?>)</span><br />
						 
					<?php } ?>
						 
				<?php }elseif($type=="tag"){
					 
					$options_recorded = get_option($this->plugin_options_tag);
					 
					if($options_recorded){
						
						$tags_ids_to_show = $options_recorded;
					
					}else{ 
						
						$tags_ids_to_show = array();
					
					}
					
					$tags = get_tags(); 
					
					foreach($tags as $tag){ ?>
					
						<input type="checkbox" name="tag[]" value="<?php echo $tag->term_id;?>" <?php if(in_array($tag->term_id, $tags_ids_to_show)){ echo " checked "; }?> /> <?php echo $tag->name;?> <span class="span-count">(<?php echo $tag->count;?> <?php _e("posts",$this->plugin_domain);?>)</span><br />
						 
					<?php } ?>
						 
				<?php }elseif($type=="post"){ 
				
					$options_recorded = get_option($this->plugin_options_post);
					  
					if($options_recorded){
						
						$posts_ids_to_show = $options_recorded;
					
					}else{ 
						
						$posts_ids_to_show = array();
					
					} ?>
					
					<label for="add_posts_ids" ><?php _e("Separate posts id with coma",$this->plugin_domain);?></label> <input type="text" value="" name="add_posts_ids" /> <br />
					
					<?php if(!empty($posts_ids_to_show)){?>
						
						<br /><span class="HYspan-posts-showd"><?php _e('Posts showd',$this->plugin_domain);?> : </span><br /> 
						
						<?php 
						foreach($posts_ids_to_show as $post_id){ ?>
							
								<input type="checkbox" name="post[]" value="<?php echo $post_id;?>"  checked  /> <?php echo get_the_title($post_id)!="" ? get_the_title($post_id) : __("No title",$this->plugin_domain);?> <span class="span-count">(<?php _e("Post ID",$this->plugin_domain);?> : <?php echo $post_id?>)</span><br />
								 
							<?php } ?>
							
					<?php } ?>
					
				<?php }elseif($type=="disable"){ ?>
					
					<input type="checkbox" name="disable" value="1"  <?php if(get_option($this->plugin_options_disable)){ echo "checked";} ?>  /> <?php _e("Disable options",$this->plugin_domain);?> <br />
					
					<input type="hidden" value="1" name="disable_form" />								
					
				<?php }?>
				
					<input type="hidden" value="1" name="add_type_<?php echo $type;?>" />
					
					<br /><input type="submit" value="<?php _e('Save',$this->plugin_domain);?>" class="button-primary"/>
					
				</form>
			
		<?php }
		
		function HYomepage_settings_forms_action(){  // Forms action after submissions
			
			if($_POST){
				
				$nonce=$_REQUEST['_wpnonce'];
				
				if (! (wp_verify_nonce($nonce, 'reset') OR wp_verify_nonce($nonce, 'cat') OR wp_verify_nonce($nonce, 'tag') OR wp_verify_nonce($nonce, 'post') OR wp_verify_nonce($nonce, 'disable') )) die('Security check : you try to open a page without good security key. Are you sure to open a secure link?');
				 
				if(isset($_POST['add_type_cat']) && isset($_POST['cat'])){  // CATEGORIES
					 
					$cats_to_show = $_POST['cat'];
					 
					update_option($this->plugin_options_cat,$cats_to_show);
					 
				}elseif (isset($_POST['add_type_cat']) && !isset($_POST['cat'])){
					
					delete_option($this->plugin_options_cat);
					
				}elseif(isset($_POST['add_type_tag']) && isset($_POST['tag'])){ // TAGS
					
					$cats_to_show = $_POST['tag'];
					
					update_option($this->plugin_options_tag,$cats_to_show);
					 
				}elseif (isset($_POST['add_type_tag']) && !isset($_POST['tag'])){
					
					delete_option($this->plugin_options_tag);
					
				}elseif(isset($_POST['add_type_post'])){ // POSTS AND PAGES
					 
					if(isset($_POST['post'])){ 
						
						$ids_to_show_from_form  = $_POST['post']; 
					
					} else {
	
						$ids_to_show_from_form = array();
	
					}
					
					$ids_input_text = trim($_POST['add_posts_ids']); 
					
					if($ids_input_text!="" && strpos($ids_input_text,',')>0){
	
						$explode_ids_input_text = explode(',',$ids_input_text);
						
						foreach ($explode_ids_input_text as $post_id_form_input){
	
							if($post_id = $this->HYomepage_check_post_id($post_id_form_input)){
	
								$ids_to_show_from_form[] = $post_id;
							
							}
						
						}
					
					}elseif($ids_input_text!=""){
	
						if($post_id = $this->HYomepage_check_post_id($ids_input_text)){
	
							$ids_to_show_from_form[] = $post_id;
						
						}
					
					} 
					
					if(!empty($ids_to_show_from_form)){
	
						$ids_to_show_from_form = array_unique($ids_to_show_from_form);
						
						update_option($this->plugin_options_post,$ids_to_show_from_form);
					
					}else{
	
						delete_option($this->plugin_options_post);
					
					}
					
				}elseif(isset($_POST['disable']) && $_POST['disable_form']){ // DISABLE PLUGIN OPTIONS
					
					update_option($this->plugin_options_disable,1);
	
				}elseif(!isset($_POST['disable']) && $_POST['disable_form']){ 
	
					delete_option($this->plugin_options_disable);
	
				}elseif(isset($_POST['HYreset_options'])){ // RESET OPTIONS
	
					$this->HYomepage_reset_options();
	
				}
				
			}
			
		}
		
		function HYomepage_check_post_id($post_id){ // CHECK IF AN INTEGER IS REALLY A POST ID OR PAGE ID
			
			global $wpdb;

			$post_id = intval(trim($post_id));  

			$post_exists = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID = $post_id AND (post_type = 'post' OR post_type = 'page') ", 'ARRAY_A'));
			
			if ($post_exists) {

				return $post_id;

			}

		}
		
		function HYomepage_disable($disable = 1){ // 1 = disable options ; 0 = able options
				
			if($disable==1){

				update_option($this->plugin_options_disable,1);

			}elseif($disable==0){

				delete_option($this->plugin_options_disable);

			}
		
		}
		
		function HYomepage_reset_options(){ // RESET ALL OPTIONS
		 
			delete_option($this->plugin_options_cat);
			
			delete_option($this->plugin_options_disable);
			  
		}
		
		function HYomepage_has_options(){ // has options and disable_option off
				
			if(get_option($this->plugin_options_disable)){ // If the disable options is not recorded

				return false;
			
			}else{

				if(get_option($this->plugin_options_cat) OR get_option($this->plugin_options_post) OR get_option($this->plugin_options_tag)){

					return true;

				}else{

					return false;

				}

			}
				
		}
	
		function HYchange_home($query) {  // TO INSERT IN HOOK FILTER pre_get_posts
			
			if($query->is_home && $this->HYomepage_has_options()){
			 
				global $wpdb;
				 
				$cats_to_show = get_option($this->plugin_options_cat); 

				if($cats_to_show){  
                    if ($query->is_main_query() && is_home()) {
                        foreach ($cats_to_show as $cat){
                            $cat_list.=$cat;
                            $cat_list.=', ';
                        }
                        $cat_list=substr($cat_list, 0, -1);
                        $query->set('cat', $cat_list);
                    }

				}
			}
			
			return $query;
			
		}
		
		function activate() {
		 
		}
		
		function deactivate() {
		 
		}
		 
	}
	
	
else :

	exit ("Class HYomepage already declared!");
	
endif;

if(!isset($HYomepage)){

	$HYomepage = new HYomepage;
	
}

if (isset($HYomepage)){

	register_activation_hook( __FILE__, array(&$HYomepage, 'activate') );
	
	register_deactivation_hook( __FILE__, array(&$HYomepage,'deactivate' ) );

} ?>