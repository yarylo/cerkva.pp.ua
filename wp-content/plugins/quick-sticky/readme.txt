=== Quick Sticky ===
Contributors: scottsweb
Donate link: https://flattr.com/profile/scottsweb/things
Tags: sticky, posts, post, stick, feature, featured, quick, simple
Requires at least: 3.0
Tested up to: 3.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Quick Sticky is a very simple plugin that makes it easier to quickly feature or “sticky” posts from the posts overview screen.

== Description ==

Quick Sticky is a very simple plugin for WordPress that makes it easier to quickly feature or “sticky” posts from the posts overview screen. It is a huge time saver when dealing with sticky posts.

On occasions I have also created sites where I have only wanted one sticky post at a time. The plugin contains a filter which allows you to enable this behaviour. Simply add the following snippet of code to your theme functions.php file:

`add_filter('qs_one_post_only', '__return_true');`

Once enabled, toggling a post as sticky will un-sticky (or un-feature) all of the other posts.

[a plugin by Scott Evans](http://scott.ee/ "Freelance WordPress web development Guildford, Surrey")

== Installation ==

To install this plugin:

1. Upload the `quick-sticky` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. That's it!

== Frequently Asked Questions ==

= Hooks & Filters =

The plugin has one filter that allows you to enforce one sticky post at a time. Add the following to your functions.php file:

`add_filter('qs_one_post_only', '__return_true');`

== Screenshots ==

1. Quick Sticky added to the posts overview screen.

== Changelog ==

= 1.2 = 
* Fix a small bug when searching for posts in wp-admin. Thanks [Phil Middlemass](http://www.leighton.com/)

= 1.1 =
* Uploaded to WordPress.org

= 1.0 =
* Initial release
