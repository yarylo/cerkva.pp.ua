<?php

/*
	Quick Sticky
	------------
	
	Plugin Name: Quick Sticky
	Plugin URI: http://scott.ee/journal/quick-sticky/
	Description: Quickly toggle your sticky posts from the posts overview screen.
	Author: Scott Evans
	Version: 1.2
	Author URI: http://scott.ee
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html

	Copyright (c) 2013 Scott Evans <http://scott.ee>

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	THIS SOFTWARE AND DOCUMENTATION IS PROVIDED "AS IS," AND COPYRIGHT
	HOLDERS MAKE NO REPRESENTATIONS OR WARRANTIES, EXPRESS OR IMPLIED,
	INCLUDING BUT NOT LIMITED TO, WARRANTIES OF MERCHANTABILITY OR
	FITNESS FOR ANY PARTICULAR PURPOSE OR THAT THE USE OF THE SOFTWARE
	OR DOCUMENTATION WILL NOT INFRINGE ANY THIRD PARTY PATENTS,
	COPYRIGHTS, TRADEMARKS OR OTHER RIGHTS.COPYRIGHT HOLDERS WILL NOT
	BE LIABLE FOR ANY DIRECT, INDIRECT, SPECIAL OR CONSEQUENTIAL
	DAMAGES ARISING OUT OF ANY USE OF THE SOFTWARE OR DOCUMENTATION.

	You should have received a copy of the GNU General Public License
	along with this program. If not, see <http://gnu.org/licenses/>.

*/

	/** define some constants **/
	define('QS_JS_URL',plugins_url('/assets/js',__FILE__));
	define('QS_CSS_URL',plugins_url('/assets/css',__FILE__));
	define('QS_IMAGES_URL',plugins_url('/assets/images',__FILE__));
	define('QS_PATH', dirname(__FILE__));
	define('QS_BASE', plugin_basename(__FILE__));
	define('QS_FILE', __FILE__);

	/** load language files **/
	load_plugin_textdomain('qs', false, dirname(QS_BASE) . '/assets/languages/');
	
	/** load quick sticky **/
	if (is_admin()) { include(QS_PATH . '/assets/inc/quick-sticky.php'); }
		
?>