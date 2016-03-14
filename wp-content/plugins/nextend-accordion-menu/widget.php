<?php

class NextendAccordionMenuWidget extends WP_Widget {

    function __construct() {
        $widget_ops = array('classname' => 'NextendAccordionMenuWidget', 'description' => 'Displays an Accordion Menu');
        parent::__construct('NextendAccordionMenuWidget', 'Nextend Accordion Menu', $widget_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'test' => 'bsd'));
        $title = $instance['title'];
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title: 
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('accordionmenu'); ?>">
                Accordion Menu: 
                <select class="widefat" id="<?php echo $this->get_field_id('accordionmenu'); ?>" name="<?php echo $this->get_field_name('accordionmenu'); ?>">
                    <?php
                    $accordionmenu = $instance['accordionmenu'];
                    $menus = new WP_Query(array(
                        'posts_per_page' => 1000,
                        'post_type' => 'accordion_menu'
                    ));
                    foreach ($menus->posts AS $menu) {
                        ?>
                        <option <?php if ($menu->ID == $accordionmenu) { ?>selected="selected" <?php } ?>value="<?php echo $menu->ID; ?>"><?php echo $menu->post_title; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </label>
        </p>
        <p>You can creates Accordion Menus in the left sidebar.</p>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['accordionmenu'] = $new_instance['accordionmenu'];
        return $instance;
    }


    function hideNextendAccordionMenu($ID) {

    	if (is_search() || is_date() || is_tag() )
			return false;
			
		global $wpdb;
		
	    $m_name = $wpdb->get_var("SELECT `post_title` FROM `wp_posts` WHERE `ID` = '".$ID."' ");
		$items = wp_get_nav_menu_items($m_name);
		foreach ($items as $item) {
			$menu_ids[]=$item->object_id;
			$menu_parents[]=$item->post_parent;
		}
		$category_id = get_query_var('cat');
		
		if (!empty($category_id))
			$category_ids = array($category_id);
		else {
			$category_id = get_the_category( get_the_ID() );
			foreach ($category_id as $category) {
				$category_ids[]=$category->term_id;
			}
		}
		
		if(!is_array($category_ids)) {

			// Has children
			$child = array_uintersect(array(get_the_ID()), $menu_parents, "strcasecmp");
			$parents = get_queried_object();
			
			if (empty($child) && $parents->post_parent <= 0) 
				return false;
				
			$category_ids = array(get_the_ID());
		}
			
		$inMenu = array_uintersect($category_ids, $menu_ids, "strcasecmp");

		if (!empty($inMenu)) return true;
		else return false;

    }
    

    function widget($args, $instance) {
		
		if($this->hideNextendAccordionMenu($instance['accordionmenu'])){
			
	        $title = apply_filters( 'widget_title', $instance['title'] );
	
	
	
	    		echo $args['before_widget'];
	
	    		if ( ! empty( $title ) )
	
	    			echo $args['before_title'] . $title . $args['after_title'];
	
	
	
	        require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . 'accordionmenu'. DIRECTORY_SEPARATOR . 'wordpress' . DIRECTORY_SEPARATOR . 'menu.php' );
	
	
	
	        $menu = new NextendMenuWordpress($args, $instance, dirname(__FILE__));
	
	        $menu->render();
	
	
	
	        echo $args['after_widget'];

    	}
    }
    
}
add_action('widgets_init', create_function('', 'return register_widget("NextendAccordionMenuWidget");'));
?>