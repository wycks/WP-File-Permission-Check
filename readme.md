=== Plugin Name ===
Contributors: wycks
Donate link: http://wordpressfoundation.org
Tags: file, folders, size, permissions, check, 777, last modified
Requires at least: 2.8
Tested up to: 3.6
Stable tag: 1.0.5

Simple plugin that checks your WordPress install and shows your file permissions, size, and last modified date. 

== Description ==

Will add a little "x" next to any files/folders set to 777, since this is inherently insecure. Checks all recursive folders that come with a default WordPress install.

This plugin can be CPU intensive as it iterates over your whole folder/file structure to gather statistics.

Notes :

*   Checks root, wp-admin, wp-content, wp-includes and all sub folders
*   Includes your plugin and theme folders
*   Ignores images, text, CSS , and translation files
*   Will exclude the cache folders since they contain to many files to scan.
*   Requires PHP 5.1.2 or greater
*   Please run this during low traffic.
    
**This plugin will not return accurate results under IIS or WAMP stack due to how windows handles file permissions.**
    
    

== Installation ==

This section describes how to install the plugin and get it working.

1. Activate the plugin through the 'Plugins' menu in WordPress


== Frequently Asked Questions ==

= Will this work on Windows =

Yes but the permissions are not accurate.

== Screenshots ==

1. What it looks like.


== Changelog ==

1.05  - Refactor class to be more effecient, changed menu to tools in admin
1.04  - Completely re-wrote the plugin from scratch
1.03  - Removed Jquery.tools and replaced with jQuery.UI
1.02  - fixed directory problem for loading CSS and

== Upgrade Notice ==

None yet