=== Plugin Name ===
Contributors: wycks
Donate link: http://wordpressfoundation.org
Tags: file, folders, size, permissions, check, 777
Requires at least: 2.8
Tested up to: 3.3
Stable tag: 1.0.2

Simple plugin that checks your WordPress install and shows your file permissions and sizes. 

== Description ==

Will add a little "x" next to any files/folders set to 777, since this is inherently insecure. Checks all recursive folders that come with a default WordPress install.

This plugin can be CPU intensive as it iterates over your whole folder/file structure to gather statistics.

# Important, this plugin clashes with jQuery UI tabs (sometimes used by default with WordPress), might redo it to use jQuery UI if I have time.

Notes :

*   Checks root, wp-admin, wp-content, wp-includes and all sub folders
*   Includes your plugin and theme folders
*   Ignores images, text and CSS files
*   Requires PHP 5.1.2 or greater


    Note that this runs on menu load ( when you click "File Permissions") and can be CPU intensive since it scans and gathers data on all your files.
    Please run this during low traffic.
    It will not show image files to reduce scan time and CPU usage ( will make a separate plugin if anyone needs this).
    This plugin will not return accurate results under IIS or WAMP stack due to how windows handles file permissions.
    
    

== Installation ==

This section describes how to install the plugin and get it working.

1. Create a folder in your  `/wp-content/plugins/` called `/file-permission-checker`
1. Upload `file-perm-check.php` and `file-perm-check.css` to the `/wp-content/plugins/file-permission-checker` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

Or just use the Auto Installer.


== Frequently Asked Questions ==

= Why did you make this =

I don't know, sometimes people want to see their permissions I guess.

= Will this work on Windows =

Yes but the permissions are not the same as Linux/Unix.

== Screenshots ==

1. What it looks like.


== Changelog ==

1.0.2 
- Fixed Some issues with broken style/script link
- Updated enqueue script for 3.3

== Upgrade Notice ==

None yet