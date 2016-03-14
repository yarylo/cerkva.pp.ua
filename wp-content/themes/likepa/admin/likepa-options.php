<?php

$likepa_themename = "likepa";
$likepa_shortname = "likepa";
$likepa_option_group = $likepa_shortname.'_theme_option_group';
$likepa_option_name = $likepa_shortname.'_theme_options';

// Create custom settings menu
add_action('admin_menu', 'likepa_create_menu');

function likepa_create_menu() {

	global $likepa_themename;
	//create new top-level menu
	$page = add_theme_page( __( $likepa_themename.' likepa Options' ), __( 'likepa Options','likepa' ), 'edit_theme_options', basename(__FILE__), 'likepa_settings_page' );
	/* Using registered $page handle to hook script load */
	add_action('admin_print_styles-' . $page, 'likepa_add_init');
}

// Load stylesheet and jscript
function likepa_add_init() {

    $file_dir = get_template_directory_uri();
	wp_enqueue_style('thickbox');
	wp_enqueue_style("likepa-Opt-Css", $file_dir."/admin/likepa-options.css");
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script("likepa-jq-cookie", $file_dir."/admin/js/jquery-cookie.js");
	wp_enqueue_script('likepa-jq-checkboxs', $file_dir.'/admin/js/jquery.Checkbox.js');
	wp_enqueue_script('likepa-jq-select', $file_dir.'/admin/js/jquery.selectBox.js');
	wp_enqueue_script("likepa-color-Script", $file_dir."/admin/js/jquery.colorpicker.js");
	wp_enqueue_script("likepa-Opt-Script", $file_dir."/admin/js/likepa-options.js");
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
}

// Register settings
add_action( 'admin_init', 'register_settings' );

function register_settings() {

   global $likepa_themename, $likepa_shortname, $version, $likepa_settings, $likepa_option_group, $likepa_option_name;
	//register our settings
	register_setting( $likepa_option_group, $likepa_option_name, 'likepa_theme_options_validate');
}

// Create theme options
global $likepa_settings;

$likepa_settings = array (
	// ***************************  Skin & Layout  ***********************************
	array("name" => __( "",'likepa'), "id" =>"", "type" => "header",
			"desc" => __( "",'likepa'),
			"std" => ""),
			
	array( "id" => $likepa_shortname."-tab-1",
	"type" => "open-tab"),		
			
		
	array("name" => __('<font size=4 color=#464646>Skin & Layout</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Settings that change the look of your site.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),

	array("name" => __("Skin Style",'likepa'),
        "id" => $likepa_shortname."_skins",
        "type" => "radio1",
        "desc" => __("Which skin would you like to use?",'likepa'),
		"std" => "default",
        "options" => array("default" => "Default", "charcoal" => "Charcoal", "light" => "Light", "metal" => "Heavy Metal", "orange" => "Kiss of Orange",
					"blue" => "Blue Diamond", "redline" => "Redline", "white" => "Simple White"),
    	),
	
	array("name" => __("Sidebar Position",'likepa'),
        "id" => $likepa_shortname."_column",
        "type" => "radio1",
        "desc" => __("Where would you like your sidebar to be?",'likepa'),
		"std" => "content-sidebar",
        "options" => array("content-sidebar" => __('Right Sidebar','likepa'), "sidebar-content" => __('Left Sidebar','likepa'), "sidebar-content-sidebar" => __('Three Column','likepa'), "content" => __('One Column','likepa')),
		),
	
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),
				
	// ***************************  General Appearance Options  ***********************************		
	array( "id" => $likepa_shortname."-tab-2",
	"type" => "open-tab"),	
		
	array("name" => __('<font size=4 color=#464646>General Appearance</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Settings that change the look of your content.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
	
	array("name" => __( "Post Excerpt with Thumbnail",'likepa'), "id" => $likepa_shortname."_thumbnail_excerpt", "type" => "checkbox",
			"desc" => __( "Show thumbnail and excerpt on post. Uses the featured image.",'likepa')),

	array(  'name' => __('Standard Link','likepa'), 'id' => $likepa_shortname.'_link_color', 'type' => 'ctext',
			"desc" => __( 'Color for most links. (#1982d1)','likepa'),
			'std' => '#1982d1'),
			
    array(  'name' => __('Standard Link Visited','likepa'), 'id' => $likepa_shortname.'_link_visited_color', 'type' => 'ctext',
			"desc" => __( 'Color for links that have been visited. (#11598F)','likepa'),
			'std' => '#11598F'),
			
    array(  'name' => __('Standard Link Hover','likepa'), 'id' => $likepa_shortname.'_link_hover_color', 'type' => 'ctext',
			"desc" => __( 'Color for links when hovered over. (#1982d1)','likepa'),
			'std' => '#1982d1'),
	
	array(  "name" => __( 'Content Title Color','likepa'), 'id' => $likepa_shortname.'_content_title_link_color', 'type' => 'ctext',
			"desc" => __( 'Color for the content title links. (#222222)','likepa'),
			'std' => '#222222'),
			
    array(  "name" => __( 'Content Title Color on Hover','likepa'), 'id' => $likepa_shortname.'_content_title_hover_color', 'type' => 'ctext',
			"desc" => __( 'Color for the content title links when hovered over. (#1982d1)','likepa'),
			'std' => '#1982d1'),
	 		
	array(  "name" => __( 'Content List Bullet','likepa'), 'id' => $likepa_shortname.'_content_bullet_color', 'type' => 'select',
			"desc" => __( 'Bullet used for Unorderd Lists in content area.','likepa'),
			'std' => 'default',
			'value' => array( __('default','likepa'), __('circle','likepa'), 'disc', 'square', 'circle-black', 'circle-blue', 'circle-white', 'star-black', 'star-blue', 'star-yellow', 'square-black', 'square-blue',
						'square-white', 'check-black', 'check-blue', 'check-green', 'check-white', 'heart-red', 'paw-print', 'radiation-black')),
	
	array(  "name" => __( 'Remove Post Calendar','likepa'), 'id' => $likepa_shortname.'_remove_post_calendar', 'type' => 'checkbox',
			"desc" => __( 'Removes the calendar next to post titles.','likepa')),
	
	array(  "name" => __( 'Calendar Border Color','likepa'), 'id' => $likepa_shortname.'_calendar_border_color', 'type' => 'ctext',
			"desc" => __( 'Color of the border around the calendar. (#A0A0A0)','likepa'),
			'std' => '#A0A0A0'),
			
	array(  "name" => __( 'Calendar Month BG Color','likepa'), 'id' => $likepa_shortname.'_calendar_month_BG_color', 'type' => 'ctext',
			"desc" => __( 'Color of the calendar month background. (#BABABA)','likepa'),
			'std' => '#BABABA'),
			
	array("name" => __( "Calendar Month Text Color",'likepa'), "id" => $likepa_shortname."_calendar_month_text_color", "type" => "ctext",
			"desc" => __( "Color of the calendar text displaying the month. (#FFFFFF)",'likepa'),
			"std" => "#FFFFFF"),
			
	array(  "name" => __( 'Calendar Day BG Color','likepa'), 'id' => $likepa_shortname.'_calendar_day_BG_color', 'type' => 'ctext',
			"desc" => __( 'Color of the calendar day background. (#BABABA)','likepa'),
			'std' => '#BABABA'),
			
	array("name" => __( "Calendar Day Text Color",'likepa'), "id" => $likepa_shortname."_calendar_day_text_color", "type" => "ctext",
			"desc" => __( "Color of the calendar text displaying the day. (#FFFFFF)",'likepa'),
			"std" => "#FFFFFF"),
			
	array(  "name" => __( 'Sicky Post Background','likepa'), 'id' => $likepa_shortname.'_sticky_post_BG_color', 'type' => 'ctext',
			"desc" => __( 'Color of the sicky post background. (#E5E5E5)','likepa'),
			'std' => '#E5E5E5'),
			
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),

	// *********************************** Fonts **************************************************

	array( "id" => $likepa_shortname."-tab-3",
			"type" => "open-tab"),
	
	array("name" => __('<font size=4 color=#464646>Font Options</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Settings that change your font styles.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
	
	array("name" => __("Title and Description Fonts",'likepa'),
			"id" => $likepa_shortname."_head_font_select",
			"type" => "radio2",
			"desc" => __("Pick the font and type you would like to use for the header.",'likepa'),
			"std" => "google",
			"options" => array("web-safe" => "Standard Font", "google" => "Google Font")),

	array ( 'name' => __('Standard Fonts','likepa'), 'id' => $likepa_shortname.'_title_description_font', 'type' => 'select',
			'desc' => __('Font used for the title and Description.','likepa'),
			'std' => 'Garamond, serif',
			'value' => array( __('Garamond, serif','likepa'),
			'Bitstream Charter, serif', 'Arial, sans-serif', 'Verdana, sans-serif', 
			'Arial Black, sans-serif', 'Avant Garde, sans-serif','Helvetica Neue, sans' ,'Courier New, mono',
			'Impact, sans-serif', 'Trebuchet, sans-serif', 'Century Gothic, sans-serif', 'Tahoma, sans-serif',
			'Lucida Grande, sans-serif', 'Univers, sans-serif','Times New Roman, serif', 'Georgia, serif', 'Palatino, serif',
			'Bookman, serif','Tahoma,Arial,Helvetica,sans-serif','Andale Mono, mono', 'Comic Sans MS, sans-serif')),
			
	array ( 'name' => __('Google Fonts','likepa'), 'id' => $likepa_shortname.'_head_font', 'type' => 'select',
			'desc' => __('Google Font for the title and description.','likepa'),
			'std' => 'Raleway',
			'value' => array( __('Raleway','likepa'),
			'Arvo', 'Caesar Dressing', 'Calligraffitti','Copse','Covered By Your Grace','Crafty Girls', 'Diplomata SC', 'Droid Sans','Droid Serif', 'Flavors', 'Fredericka the Great', 'Lobster',
			'Macondo Swash Caps', 'Monoton', 'Nobile','Old Standard TT','Open Sans','Oswald','Pacifico','Permanent Marker','PT Sans','Quattrocento',
			'Redressed','Reenie Beanie','Rock Salt', 'Shadows Into Light', 'Shojumaru', 'Slackey','Sniglet','Special Elite','Tangerine',
			'Ubuntu','UnifrakturCook','Vollkorn','Yanone Kaffeesatz','Yellowtail')),

	array("name" => __("Content Font Type",'likepa'),
			"id" => $likepa_shortname."_content_font_select",
			"type" => "radio2",
			"desc" => __("Pick the font and type you would like to use for the content.",'likepa'),
			"std" => "web-safe",
			"options" => array("web-safe" => "Standard Font", "google" => "Google Font")),
	
	
	array ( 'name' => __('Standard Fonts','likepa'), 'id' => $likepa_shortname.'_content_area_font', 'type' => 'select',
			'desc' => __('Font used for the content','likepa'),
			'std' => 'Arial, sans-serif',
			'value' => array( __('Arial, sans-serif','likepa'),
			'Bitstream Charter, serif', 'Courier New, mono', 'Verdana, sans-serif', 'Tahoma, sans-serif',
			'Arial Black, sans-serif', 'Avant Garde, sans-serif','Helvetica Neue, sans' ,
			'Impact, sans-serif', 'Trebuchet, sans-serif', 'Century Gothic, sans-serif',
			'Lucida Grande, sans-serif', 'Univers, sans-serif',
			'Times New Roman, serif', 'Georgia, serif', 'Palatino, serif',
			'Bookman, serif', 'Garamond, serif',
			'Andale Mono, mono', 'Comic Sans MS, sans-serif')),

	// Google Font
	array ( 'name' => __('Google Fonts','likepa'), 'id' => $likepa_shortname.'_body_font', 'type' => 'select',
			'desc' => __('Google Font used for the content','likepa'),
			'std' => 'Lobster',
			'value' => array( __('Lobster','likepa'),
			'Arvo', 'Caesar Dressing', 'Calligraffitti','Copse','Covered By Your Grace','Crafty Girls', 'Diplomata SC', 'Droid Sans','Droid Serif', 'Flavors', 'Fredericka the Great', 'Macondo Swash Caps',
			'Monoton', 'Nobile','Old Standard TT','Open Sans','Oswald','Pacifico','Permanent Marker','PT Sans','Quattrocento','Raleway',
			'Redressed','Reenie Beanie','Rock Salt', 'Shadows Into Light', 'Shojumaru', 'Slackey','Sniglet','Special Elite','Tangerine',
			'Ubuntu','UnifrakturCook','Vollkorn','Yanone Kaffeesatz','Yellowtail')),
		
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),

	// ************************************  Header Options  *********************************************

	array( "id" => $likepa_shortname."-tab-4",
	"type" => "open-tab"),
	
	
	array("name" => __('<font size=4 color=#464646>Header Options</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Settings that change the look of your header and menus.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
	
	array( "name" => __( 'Custom Logo','likepa'),
			"desc" => __( "Add a custom logo to the header. Click on Choose Image and upload a logo or select one out of your Media Library and click insert into post. Max: 1010px X 105px",'likepa'),
			"id" => $likepa_shortname."_header_logo",
			"type" => "upload",
			"std" => ""),
	
	array("name" => __( 'Main Menu Bar','likepa'), "id" => $likepa_shortname."_main_menubar_color", "type" => "ctext",
			"desc" => __( 'Color of the Primary menu bar. (#0281D4)','likepa'),
			"std" => '#0281D4'),
			
    array("name" => __( "Main Menu Bar hover BG",'likepa'), "id" => $likepa_shortname."_main_menubar_hoverbg_color", "type" => "ctext",
			"desc" => __( "Color of the Primary menu item background when hovering over item. (#026BB0)",'likepa'),
			"std" => "#026BB0"),
			
	array("name" => __( "Main Menu Bar dropdown BG",'likepa'), "id" => $likepa_shortname."_main_menubar_dropbg_color", "type" => "ctext",
			"desc" => __( "Color of the Primary menu drop down background. (#0281D4)",'likepa'),
			"std" => "#0281D4"),
			
	array("name" => __( "Main Menu Bar dropdown Hover",'likepa'), "id" => $likepa_shortname."_main_menubar_dropbg_color_hover", "type" => "ctext",
			"desc" => __( "Color of the Primary menu drop down background on hover. (#026BB0)",'likepa'),
			"std" => "#026BB0"),
			
    array("name" => __( "Main Menu Bar text",'likepa'), "id" => $likepa_shortname."_main_menubar_text_color", "type" => "ctext",
			"desc" => __( "Color of the Primary menu bar text item when not hovering. (#FFFFFF)",'likepa'),
			"std" => "#FFFFFF"),

	array("name" => __( "Show Secondary Menu",'likepa'), "id" => $likepa_shortname."_show_secondary_menu", "type" => "checkbox",
			"desc" => __( "Shows a extra menu at the top of the header. Set up using <u>Appearance</u>=><u>Menus</u>.",'likepa')),
	
    array("name" => __( 'Top Menu Bar','likepa'), "id" => $likepa_shortname."_menubar_color", "type" => "ctext",
			"desc" => __( 'Color of the secondary menu bar (#292929)','likepa'),
			"std" => '#292929'),
			
    array("name" => __( "Top Menu Bar Hover BG",'likepa'), "id" => $likepa_shortname."_menubar_hoverbg_color", "type" => "ctext",
			"desc" => __( "Color of the secondary menu item background when hovering over item. (#EFEFEF)",'likepa'),
			"std" => "#EFEFEF"),
			
	array("name" => __( "Top Menu Bar dropdown BG",'likepa'), "id" => $likepa_shortname."_menubar_dropbg_color", "type" => "ctext",
			"desc" => __( "Color of the secondary menu drop down background. (#EFEFEF)",'likepa'),
			"std" => "#EFEFEF"),
			
	array("name" => __( "Top Menu Bar dropdown Hover",'likepa'), "id" => $likepa_shortname."_menubar_dropbg_color_hover", "type" => "ctext",
			"desc" => __( "Color of the secondary menu drop down background on hover. (#F9F9F9)",'likepa'),
			"std" => "#F9F9F9"),
			
    array("name" => __( "Top Menu Bar text",'likepa'), "id" => $likepa_shortname."_menubar_text_color", "type" => "ctext",
			"desc" => __( "Color of the secondary menu bar text item when not hovering. (#EEEEEE)",'likepa'),
			"std" => "#EEEEEE"),
			
    array("name" => __( "Normal Menu Text",'likepa'), "id" => $likepa_shortname."_normal_menu_text", "type" => "checkbox",
			"desc" => __( "Check to use normal font style for menu text instead of bold.",'likepa')),
	
	array( "name" => __( 'Disable Superfish Menu Effects','likepa'), 'id' => $likepa_shortname.'_remove_superfish', 'type' => 'checkbox',
			"desc" => __( 'Removes the arrows next to your menu items.','likepa')),
			
	array( "name" => __( 'Superfish Colors','likepa'), 'id' => $likepa_shortname.'_superfish_arrow_color', 'type' => 'select',
			"desc" => __( 'Color of the Superfish arrows on the menu bar.','likepa'),
			'std' => 'White',
			'value' => array( 'White', 'Silver', 'Blue', 'Red', 'Black')),
	
	array( "name" => __( 'Site Title','likepa'), 'id' => $likepa_shortname.'_title_color', 'type' => 'ctext',
			"desc" => __( "Color of the blog's main title in header. (#F7F7F7)",'likepa'),
			'std' => '#F7F7F7'),
			
	array( "name" => __( 'Site Title Hover','likepa'), 'id' => $likepa_shortname.'_title_hover_color', 'type' => 'ctext',
			"desc" => __( "Color of the blog's main title in header on mouse hover. (#1982D1)",'likepa'),
			'std' => '#1982D1'),
			
	array( "name" => __( 'Site Description','likepa'), 'id' => $likepa_shortname.'_description_color', 'type' => 'ctext',
			"desc" => __( "Color of the blog's description in header. (#C4C4C4)",'likepa'),
			'std' => '#C4C4C4'),
	
	array( "name" => __( 'Hide Title and Discription','likepa'), 'id' => $likepa_shortname.'_hide_title_discription', 'type' => 'checkbox',
			"desc" => __( 'Hides the site title and discription from the header.','likepa')),

	array( "name" => __( 'Search Bar Placement','likepa'), 'id' => $likepa_shortname.'_search_placement', 'type' => 'select',
			"desc" => __( 'Where would you like the search bar? Menu, header, or none at all.','likepa'),
			'std' => 'Menu',
			'value' => array( __('Menu','likepa'), __('Header','likepa'), __('None','likepa'))),		
			
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),
	
	// *****************************  Sidebar Options  **********************************
	
	array( "id" => $likepa_shortname."-tab-5",
			"type" => "open-tab"),
	
	array("name" => __('<font size=4 color=#464646>Sidebar Options</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Settings that change the look of your sidebar.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
			
	array( "name" => __( 'Widget Title Background Color','likepa'), 'id' => $likepa_shortname.'_widget_title_bgcolor', 'type' => 'ctext',
			"desc" => __( 'This will change the background color of the widget title. (#0969A3)','likepa'),
			'std' => '#0969A3'),
			
	array( "name" => __( 'Widget Title Text Color','likepa'), 'id' => $likepa_shortname.'_widget_title_txtcolor', 'type' => 'ctext',
			"desc" => __( 'This will change the text color of the widget title. (#FFFFFF)','likepa'),
			'std' => '#FFFFFF'),
			
	array( "name" => __( 'widget List Bullet','likepa'), 'id' => $likepa_shortname.'_widget_bullet_color', 'type' => 'select',
			"desc" => __( 'Bullet used for Unorderd Lists in sidebar area.','likepa'),
			'std' => 'default',
			'value' => array( __('default','likepa'), __('circle','likepa'), __('disc','likepa'), __('square','likepa'), __('circle-black','likepa'), __('circle-blue','likepa'), __('circle-white','likepa'), __('star-black','likepa'), __('star-blue','likepa'), __('star-yellow','likepa'), __('square-black','likepa'), __('square-blue','likepa'),
						__('square-white','likepa'), __('check-black','likepa'), __('check-blue','likepa'), __('check-green','likepa'), __('check-white','likepa'), __('heart-red','likepa'), __('paw-print','likepa'), __('radiation-black','likepa'))),
						
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),
	
	array( "id" => $likepa_shortname."-tab-6",
		"type" => "open-tab"),
	
	// ************************************  Comment Options  ******************************
	array("name" => __('<font size=4 color=#464646>Comment Options</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Settings that change the look of your comments.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
			
	array( "name" => __( 'Guest Comment BG','likepa'), 'id' => $likepa_shortname.'_guest_comment_color', 'type' => 'ctext',
			"desc" => __( 'Changes the background color of the guest comments. (#F6F6F6)','likepa'),
			'std' => '#F6F6F6'),

	array(  "name" => __( 'Author Comment BG','likepa'), 'id' => $likepa_shortname.'_author_comment_color', 'type' => 'ctext',
			"desc" => __( 'Changes the background color of the author comments. (#DDDDDD)','likepa'),
			'std' => '#DDDDDD'),
			
	array(  "name" => __( 'Leave A Reply Form BG','likepa'), 'id' => $likepa_shortname.'_leave_reply_color', 'type' => 'ctext',
			"desc" => __( 'Changes the background color of the leave a reply form. (#DDDDDD)','likepa'),
			'std' => '#DDDDDD'),
			
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),
	
	array( "id" => $likepa_shortname."-tab-7",
	"type" => "open-tab"),
	
	// **********************************  Footer Options  **************************************
	array("name" => __('<font size=4 color=#464646>Footer Options</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Settings that change the look of your footer.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
	 
	array(  "name" => __( 'Remove Scroll to Top','likepa'), 'id' => $likepa_shortname.'_remove_scroll_top', 'type' => 'checkbox',
			"desc" => __( 'Removes the scroll to top button in the footer.','likepa')),
			
	array( "name" => __( 'Remove likepa Link','likepa'), 'id' => $likepa_shortname.'_hide_wp_link', 'type' => 'checkbox',
			"desc" => __( 'It is completely optional, but if you like the Theme I would appreciate it if you keep the credit link at the bottom, or else consider making a contribution to help future development of this Theme.','likepa')),
		
	array(  "name" => __( 'Site Copyright','likepa'), 'id' => $likepa_shortname.'_add_custom_copyright', 'type' => 'text',
			"desc" => __( 'If you enter anything here, the default copyright notice in the footer will be replaced with the text here. It will not automatically update from year to year. Use <code>&amp;copy;</code> to display &copy;. You can use other HTML as well.','likepa'),
			'std' => ''),
			
	array( "name" => __( 'Footer HTML','likepa'),		
			"desc" => '<a href="http://www.w3schools.com/html/html_links.asp" TARGET="_blank"><div class="likepa-help-img" title="'
					. __('Help with HTML links','likepa') .'"></div></a>' .
					__( 'This code will be inserted into the footer area, right after the Footer widgets, but right before the before the Site Copyright. This could include extra information, Links, visit counters, etc.','likepa'),	
			'id' => $likepa_shortname.'_footer_opts',
			'type' => 'textarea'),
			
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
		array( "type" => "close-tab"),
	
	array( "id" => $likepa_shortname."-tab-8",
	"type" => "open-tab"),
	
	// *****************************  Pagination Options  *****************************
	array("name" => __('<font size=4 color=#464646>Pagination</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Numbered post pages.</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
			
	array( "name" => __( 'Text Color','likepa'), 'id' => $likepa_shortname.'_pagination_text_color', 'type' => 'ctext',
			"desc" => __( 'Changes the text color of the text and page numbers. (#FFFFFF)','likepa'),
			'std' => '#FFFFFF'),
			
	array( "name" => __( 'Background Color','likepa'), 'id' => $likepa_shortname.'_pagination_bg_color', 'type' => 'ctext',
			"desc" => __( 'Changes the Pagination background color. (#878A92)','likepa'),
			'std' => '#878A92'),
			
	array( "name" => __( 'Text Color on Hover','likepa'), 'id' => $likepa_shortname.'_pagination_hover_text_color', 'type' => 'ctext',
			"desc" => __( 'Changes the text color of the text and page numbers when hovered over. (#FFFFFF)','likepa'),
			'std' => '#FFFFFF'),
			
	array( "name" => __( 'BackGround Color on Hover','likepa'), 'id' => $likepa_shortname.'_pagination_hover_bg_color', 'type' => 'ctext',
			"desc" => __( 'Changes the background color when hovered over. (#686A71)','likepa'),
			'std' => '#686A71'),
			
	array( "name" => __( 'Text Color on Current Page','likepa'), 'id' => $likepa_shortname.'_pagination_current_text_color', 'type' => 'ctext',
			"desc" => __( 'Changes the text color of the text and page numbers on current page. (#333333)','likepa'),
			'std' => '#333333'),
			
	array( "name" => __( 'BackGround Color on Current Page','likepa'), 'id' => $likepa_shortname.'_pagination_current_bg_color', 'type' => 'ctext',
			"desc" => __( 'Changes the background color on current page. (#686A71)','likepa'),
			'std' => '#686A71'),
			
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),
	
	// ***************************** Social Icons *****************************************
	array( "id" => $likepa_shortname."-tab-9",
			"type" => "open-tab"),
	
	array("name" => __('<font size=4 color=#464646>Social Icons</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Display social icons in the header</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
	
	array( "name" => __( 'Show Social Icons','likepa'), 'id' => $likepa_shortname.'_show_social_icons', 'type' => 'checkbox',
			"desc" => __( 'Shows social follow me icons in the header.','likepa')),
	
			
	array(  "name" => __( 'RSS','likepa'), 'id' => $likepa_shortname.'_rss_feed', 'type' => 'checkbox',
			"desc" => __( 'RSS Feed.','likepa')),
			
	array(  "name" => __( 'Facebook','likepa'), 'id' => $likepa_shortname.'_facebook_id', 'type' => 'text',
			"desc" => __( 'Place your Facebook page ID in the textbox.','likepa'),
			'std' => ''),
			
	array(  "name" => __( 'Twitter','likepa'), 'id' => $likepa_shortname.'_twitter_id', 'type' => 'text',
			"desc" => __( 'Place your Twitter ID in the textbox.','likepa'),
			'std' => ''),
			
	array(  "name" => __( 'Google Plus','likepa'), 'id' => $likepa_shortname.'_google_plus_id', 'type' => 'text',
			"desc" => __( 'Place your Google Plus ID in the textbox.','likepa'),
			'std' => ''),
			
	array(  "name" => __( 'Vimeo','likepa'), 'id' => $likepa_shortname.'_vimeo_id', 'type' => 'text',
			"desc" => __( 'Place your Vimeo ID in the textbox.','likepa'),
			'std' => ''),
			
	array(  "name" => __( 'Youtube','likepa'), 'id' => $likepa_shortname.'_youtube_id', 'type' => 'text',
			"desc" => __( 'Place your Youtube ID in the textbox.','likepa'),
			'std' => ''),
			
	array(  "name" => __( 'Pinterest','likepa'), 'id' => $likepa_shortname.'_pinterest_id', 'type' => 'text',
			"desc" => __( 'Place your Pinterest ID in the textbox.','likepa'),
			'std' => ''),
			
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),
	
	array( "id" => $likepa_shortname."-tab-10",
			"type" => "open-tab"),
	
	// *****************************  Advanced Options  ***********************************
	array("name" => __('<font size=4 color=#464646>Advanced Options</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Custom CSS and SEO Plugin Support</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
	
	array( "name" => __( '! Use SEO Plugin Instead','likepa'), 'id' => $likepa_shortname.'_hide_metainfo', 'type' => 'checkbox',
			"desc" => __( 'Check this box if using an SEO plugin to stop from getting duplicate META tags. Recommended:', 'likepa') . 
					'<a href="http://wordpress.org/extend/plugins/wordpress-seo/" TARGET="_blank"><div class="wp-seo-img" title="' . __('WordPress SEO by Yoast', 'likepa') . '"></div></a>'),
	
	array( "name" => __( 'Custom CSS ','likepa'),
			"desc" => '<a href="http://www.w3schools.com/css/default.asp" TARGET="_blank"><div class="likepa-help-img" title="'
					. __('Help with CSS','likepa') .'"></div></a>' .
					__( 'This input area is one of the most important options in likepa for customizing your site. Code entered into this box is included right before the &lt;/HEAD&gt; tag on each page of your site. The most important use for this area is to enter custom CSS rules to control the look of your site. <strong>!Do Not Use</strong> &lt;style&gt; tags. If you need to style something for Internet Explorer, simply add <code>#ie6</code>, <code>#ie7</code>, or <code>#ie8</code> before the selector your styling. ( eg. <code>#ie7 #site-title { margin-top: 0px;}</code> )','likepa'),
			'id' => $likepa_shortname.'_header_css',
			'type' => 'textarea'),
	
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
	array( "type" => "close-tab"),
	
	array( "id" => $likepa_shortname."-tab-11",
	"type" => "open-tab"),
	
	// ************************************ Analytics  ************************************
	array("name" => __('<font size=4 color=#464646>Google Analytics</font>','likepa'),
			"type" => "section"),

	array("name" => __('<font size=2 color=#464646>Google Analytics Tracking Code</font>','likepa'),
			"type" => "section-desc"),
			
	array("type" => "open"),
	
	array( "name" => __( 'Google Analytics- Web Property ID','likepa'),			
			"desc" => '<a href="http://www.google.com/analytics/" TARGET="_blank"><div class="google-analytics-img" title="'
					. __('Google Analytics','likepa') .'"></div></a>' .
					__( '<font color=#444>Note:</font> the Google Analytics script now goes in the &lt;head&gt; element to better support the new Google Analytics script. Only put the Web Property ID (eg. "<b>UA-XXXXXXXX-X</b>") in the textbox.','likepa'),		
			'id' => $likepa_shortname.'_google_analytics',
			'type' => 'text',
			'std' => ''),
			
	array(  "name" => __( 'Clicky Analytics- Site ID','likepa'), 'id' => $likepa_shortname.'_clicky_site_id', 'type' => 'text',
			"desc" => '<a href="http://getclicky.com/" TARGET="_blank"><div class="clicky-analytics-img" title="'
					. __('Clicky Analytics','likepa') .'"></div></a>' .
					__( 'What is your site ID? Go to your Clicky dashboard and look at the URL. You should see a "?site_id=123" (example) on the end. In this case, 123 would be your site ID.','likepa'),
			'std' => ''),
	
	array("type" => "close"),
	
	array( "type" => "save-opts"),
	
);

function likepa_settings_page() {

   global $likepa_themename, $likepa_shortname, $version, $likepa_settings, $likepa_option_group, $likepa_option_name;
?>

	<div class="wrap">
		<div class="options_wrap">
			<?php screen_icon(); ?><h2><?php echo $likepa_themename; ?> <?php _e('Theme Options','likepa'); ?></h2>
			<p class="top-notice"><?php _e('Customize the look of your theme with these settings. ','likepa'); ?></p>
			<?php if ( isset ( $_POST['reset'] ) ): ?>
			<?php // Delete Settings

			global $wpdb, $likepa_themename, $likepa_shortname, $version, $likepa_settings, $likepa_option_group, $likepa_option_name;

			delete_option('likepa_theme_options');

			wp_cache_flush(); ?>

			<div class="updated fade"><p><strong><?php _e( 'likepa options reset.','likepa' ); ?></strong></p></div>
			<?php elseif ( isset ( $_REQUEST['updated'] ) ): ?>
			<div class="updated fade"><p><strong><?php _e( 'likepa options saved.','likepa' ); ?></strong></p></div>
			<?php endif; ?>

			<div id="ultra-header"><div id="ultra-logo"></div></div>
			<div id="tabs" style="clear:both;">   
				<ul class="tabNavigation">
					<li><a href="#likepa-tab-1"><span><?php _e('Layout','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-2"><span><?php _e('General','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-3"><span><?php _e('Fonts','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-4"><span><?php _e('Header','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-5"><span><?php _e('Sidebar','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-6"><span><?php _e('Comments','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-7"><span><?php _e('Footer','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-8"><span><?php _e('Pagination','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-9"><span><?php _e('Social','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-10"><span><?php _e('Advanced','likepa'); ?></span></a></li>
					<li><a href="#likepa-tab-11"><span><?php _e('Analytics','likepa'); ?></span></a></li>
				</ul>
		
				<div class="tabContainer">
						<script type="text/javascript">
							jQuery(document).ready(function($){
								// Enable selectBox control and bind events
								
								$("#create").click( function() {
									$("SELECT").selectBox();
								});
									
								$("#serialize").click( function() {
									$("#console").append('<br />-- Serialized data --<br />' + $("FORM").serialize().replace(/&/g, '<br />') + '<br /><br />');
									$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
								});
									
								$("SELECT")
									.selectBox()
									.focus( function() {
										$("#console").append('Focus on ' + $(this).attr('name') + '<br />');
										$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
									})
									.blur( function() {
										$("#console").append('Blur on ' + $(this).attr('name') + '<br />');
										$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
									})
									.change( function() {
										$("#console").append('Change on ' + $(this).attr('name') + ': ' + $(this).val() + '<br />');
										$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
									});
									
							});
							// CheckBox - Show standard CheckBox to IE8 and under.
							jQuery(document).ready(function($){
								if ($.browser.msie && $.browser.version.substr(0,1)<9) {
								} else {
									$('input[type=checkbox]').Checkbox({labels:['Enable','Disable']});
								}
							});
							// Media Uploader
							jQuery(document).ready(function() {
							window.formfield = '';

							jQuery('.upload_image_button').live('click', function() {
								window.formfield = jQuery('.upload_field',jQuery(this).parent());
								tb_show('', 'media-upload.php?type=image&TB_iframe=true');
								return false;
							});

							window.original_send_to_editor = window.send_to_editor;
							window.send_to_editor = function(html) {
								if (window.formfield) {
									imgurl = jQuery('img',html).attr('src');
									window.formfield.val(imgurl);
									tb_remove();
								}
								else {
									window.original_send_to_editor(html);
								}
								window.formfield = '';
								window.imagefield = false;
							}
							});
							
						</script>

					<form method="post" action="options.php">
						<?php settings_fields( $likepa_option_group ); ?>
						<?php $options = get_option( $likepa_option_name ); ?>
						<?php foreach ($likepa_settings as $value) {
							if ( isset($value['id']) ) { $valueid = $value['id'];}
							switch ( $value['type'] ) {
								case "section": ?>

								<div class="section_wrap">
									<h3 class="section_title"><?php echo $value['name']; ?>
										<?php break;
										case "section-desc": ?>
										<span><?php echo $value['name']; ?></span>
									</h3>
									<div class="section_body">
										<?php
										break;
										
										
										case "open-tab": ?>

										<div id="<?php echo $value['id']; ?>">

										<?php break;
										 
										case "close-tab": ?>

										</div>
										 
										<?php break;
										
										case 'text':    // Text Box
										?>
										<div class="options_input options_text">
											<div class="options_desc"><?php echo $value['desc']; ?></div>
											<span class="labels"><label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
											<input name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" id="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e( stripslashes($options[$valueid])); } else { esc_attr_e( stripslashes($value['std'])); } ?>" />
										</div>
										<?php
										break;

										case 'ctext':    // Color Picker  
										?>
										<div class="options_input options_text">
											<div class="options_desc"><?php echo $value['desc']; ?></div>
											<span class="labels"><label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
											<input class="ctext-color" style="background-color:<?php if ( isset( $options[$valueid]) ){ esc_attr_e (stripslashes($options[$valueid])); } else { esc_attr_e($value['std']); } ?>;" name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" id="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" type="<?php echo $value['type']; ?>" maxlength="7" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e (stripslashes($options[$valueid])); } else { esc_attr_e($value['std']); } ?>" />
										</div>
										<?php
										break;

										case 'textarea':	// Textarea
										?>
										<div class="options_input options_textarea">
											<div class="textarea_desc"><?php echo $value['desc']; ?></div>
											<span class="labels"><label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
											<textarea name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" type="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" cols="" rows=""><?php if ( isset( $options[$valueid]) ){ esc_attr_e( stripslashes($options[$valueid])); }?></textarea>
										</div>
										<?php
										break;

										case 'select':		// Select Drop downs
										?>
										<div class="options_input options_select">
											<div class="options_desc"><?php echo $value['desc']; ?></div>
											<span class="labels"><label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
											<select name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" id="<?php echo $likepa_option_name.'['.$valueid.']'; ?>">
									
											<?php foreach ($value['value'] as $option) { ?>
												<option<?php selected($options[$valueid] == $option ) ?>><?php echo $option; ?></option>
											<?php } ?>
											</select>
										</div>
										<?php
										break;

										case "radio1":		// Radio Buttons 
										?>

										<div class="options_input options_select">
											<div class="options_desc"><?php echo $value['desc']; ?></div>
											<span class="radio-labels"><label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
											<div style="width:700px; clear:both;"></div>
											<?php  foreach ($value['options'] as $key=>$option) {
												$radio_setting = $options[$valueid]; ?>
												<div style="width:150px; float:left; margin-top: 15px;">
												<img src="<?php echo esc_url( get_template_directory_uri() . '/admin/images/'.$key ); ?>.png" width="136" height="122" style="border: 1px solid #888;" alt="" />
												<input type="radio" id="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" value="<?php echo $key; ?>" <?php
													if($radio_setting != '') { checked($key, $options[$valueid]); } else { checked($key, $value['std']); } ?> /><?php echo $option; ?><br />
												</div>
											<?php } ?>
										</div>

										<?php
										break;
										
										case "radio2":		// Radio Buttons 
										?>

										<div class="font_options_input options_select">
											<div class="options_desc"><?php echo $value['desc']; ?></div>
											<span class="radio-labels"><label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
											<div style="width:700px; clear:both;"></div>
											<?php  foreach ($value['options'] as $key=>$option) {
												$radio_setting = $options[$valueid]; ?>
												<div style="width:230px; float:left; margin-top: 15px;">
												<input type="radio" id="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" value="<?php echo $key; ?>" <?php
													if($radio_setting != '') { checked($key, $options[$valueid]); } else { checked($key, $value['std']); } ?> /><?php echo $option; ?><br />
												</div>
											<?php } ?>
										</div>

										<?php
										break;
										
										case "upload":			
										?>
								
										<div class="options_input options_text">
											<div class="options_desc"><?php if ( isset( $options[$valueid])&& $options[$valueid] !="" ){ ?>
											<img src="<?php echo $options[$valueid]; ?>" alt="logo" height="80" width="120" style="float:left; margin: 0 7px 7px 0;" />
											<?php } ?><?php echo $value['desc']; ?></div>
											<span class="labels"><label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
											<input name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" class="upload_field" type="<?php echo $value['type']; ?>" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e( stripslashes($options[$valueid])); } else { esc_attr_e( stripslashes($value['std'])); } ?>" />
											<input class="upload_image_button button-secondary" type="button" value="Choose Image" />
										</div>
										
										<?php break;
										
										case "checkbox":		// Check Boxes
										?>
										<div class="options_input options_checkbox">
											<div class="options_desc"><?php echo $value['desc']; ?></div>
											<label for="<?php echo $likepa_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label><br />
											<input type="checkbox" name="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" id="<?php echo $likepa_option_name.'['.$valueid.']'; ?>" value="1" <?php if( isset( $options[$valueid] ) ){checked($options[$valueid]);} ?> data-on="ON" data-off="<font color=#555>OFF</font>" />
										</div>

										<?php
										break;
										
										case "save-opts": ?>
									
										<div style=" height:40px; padding:5px;">
											<span class="submit">
												<input class="button button-primary" type="submit" name="save" value="<?php _e('Save All Changes', 'likepa') ?>" />
											</span>
										</div>	
									
										<?php break;

										case "close":			
										?>
									</div><!--#section_body-->
								</div><!--#section_wrap-->
								<?php
								break;
							}
						}?>
					</form>
				</div><!--.tabContainer-->	
			</div><!--#tabs-->
		</div><!--#options-wrap-->
	</div><!--#wrap-->
		<div class="info-box-bottom">
			<?php // likepa support Forum   ?>
			<div class="support-box">
				<form action="http://wp-ultra.com/forum/" TARGET="_blank" method="post">
					<input class="button" style="background: #483FFC; border-color:#241E94; color:#FFF; font-weight: bold;text-shadow: rgba(0, 0, 0, 0.3) 0 -1px 0;
					"type="submit" name="forum" value="Support Forum" />
				</form>
				<p style="color: #777; margin-top: 5px;"><?php _e('Need Help? Got a Suggestion? Let me help you.','likepa'); ?><p>
				<p style="color: #555; margin-top: -8px;"><?php _e('Forum password is:','likepa'); ?><p>
				<p style="color: #483FFC; margin-top: -10px; font-size:14px;"><b> WordPress </b></p>
			</div>
	
			<?php // likepa Donate Button   ?>
			<div class="donate-box">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="FJA4KZTFMXQG8">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				<p style="color: #777; margin-top: -5px;"><?php _e('Like the Theme? Help it stay up to date.','likepa'); ?><p>
			</div>
					
			<?php // Reset likepa Options   ?>
			<div class="reset-box">
				<form method="post" action="" onSubmit="return confirm('Are you sure you want to reset all likepa settings?');">
					<span class="button-right" class="submit">
						<input class="button" style="background:#FF6E21; border-color:#D45515; color:#FFF; font-weight: bold;text-shadow: rgba(0, 0, 0, 0.3) 0 -1px 0;
						"type="submit" name="reset" value="<?php _e('Reset / Delete Settings', 'likepa') ?>" />
						<input type="hidden" name="action" value="reset" />
						<span><?php _e('<font color#222><b>Caution:</b></font> All entries will be deleted from database.','likepa') ?></span>
					</span>
				</form>
			</div>
		</div>
					
<?php
} // --likepa_settings_page 

/* Validates the theme's options upon submission.
 ------------------------------------------------*/
function likepa_theme_options_validate( $input ) {
	global $likepa_settings;
	foreach ( $likepa_settings as $value ) {
		switch ( $value['type'] ) {
			case 'select':
				$input[$value['id']] = wp_filter_nohtml_kses( $input[$value['id']] );
				break;
			case 'ctext':
				$input[$value['id']] = wp_filter_nohtml_kses( $input[$value['id']] );
				break;
			case 'text':
				$input[$value['id']] = wp_filter_post_kses( $input[$value['id']] );
				break;
			case 'textarea':
				$input[$value['id']] = wp_filter_post_kses( $input[$value['id']] );
				break;
			case 'checkbox':
				if (!isset($input[$value['id']])) {  
                        $input[$value['id']] = null;  
                    }  
                    // Our checkbox value is either 0 or 1  
                    $input[$value['id']] = ( $input[$value['id']] == 1 ? 1 : 0 );
				break;
			case 'upload':
				$input[$value['id']] = wp_filter_post_kses( $input[$value['id']] );
				break;
		}
	}
	return $input;
} 
	
/* Enqueue color skins.
 ------------------------------------------------*/
function likepa_enqueue_skin_scheme() {
	$options = get_option('likepa_theme_options');
	$skin_scheme = $options['likepa_skins'];

	if ( 'charcoal' == $skin_scheme )
		wp_enqueue_style( 'charcoal', get_template_directory_uri() . '/skins/charcoal.css', array(), null );
		
	if ( 'light' == $skin_scheme )
		wp_enqueue_style( 'light', get_template_directory_uri() . '/skins/light.css', array(), null );
		
	if ( 'metal' == $skin_scheme )
		wp_enqueue_style( 'metal', get_template_directory_uri() . '/skins/metal.css', array(), null );
		
	if ( 'orange' == $skin_scheme )
		wp_enqueue_style( 'orange', get_template_directory_uri() . '/skins/orange.css', array(), null );
		
	if ( 'blue' == $skin_scheme )
		wp_enqueue_style( 'blue', get_template_directory_uri() . '/skins/blue.css', array(), null );
		
	if ( 'redline' == $skin_scheme )
		wp_enqueue_style( 'redline', get_template_directory_uri() . '/skins/redline.css', array(), null );
		
	if ( 'white' == $skin_scheme )
		wp_enqueue_style( 'white', get_template_directory_uri() . '/skins/white.css', array(), null );

	do_action( 'likepa_enqueue_color_scheme', $skin_scheme );
}
add_action( 'wp_enqueue_scripts', 'likepa_enqueue_skin_scheme' );	
	
/* Add layout classes.
 ------------------------------------------------*/	
function likepa_layout_classes( $existing_classes ) {
	$options = get_option('likepa_theme_options');
	$current_layout = $options['likepa_column'];

	if ( in_array( $current_layout, array( 'content-sidebar', 'sidebar-content' ) ) )
		$classes = array( 'two-column' );
	elseif ( in_array( $current_layout, array( 'sidebar-content-sidebar' ) ) )
		$classes = array( 'three-column' );
	elseif ( in_array( $current_layout, array( 'content' ) ) && !is_page_template ( 'tmp-threecolumn.php' ) )
		$classes = array( 'one-column' );
	else 
		$classes = array( 'two-column' );

	if ( 'content-sidebar' == $current_layout )
		$classes[] = 'right-sidebar';
	elseif ( 'sidebar-content' == $current_layout && !is_page_template ( 'tmp-onecolumn.php' ))
		$classes[] = 'left-sidebar';
	elseif ( 'sidebar-content-sidebar' == $current_layout )
		$classes[] = 'two-sidebars';
	else
		$classes[] = $current_layout;

	$classes = apply_filters( 'likepa_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'likepa_layout_classes' );
?>