<?php
/*
Plugin Name: File Permissions &#38; Size Check
Plugin URI: http://www.wpsecure.net/
Description: Checks WordPress file permissions, file size and last modified date
Author: Wycks
Author URI: http://wordpress.org/extend/plugins/profile/wycks
Version: 1.0.4
License: GPL2
****/

/*  Copyright 2011  Wycks  (email : info@wpsecure.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define( 'FPC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Iterator classes
 */

require_once( FPC_PLUGIN_PATH . 'classes/FpcRecursiveIterator.class.php' );
require_once( FPC_PLUGIN_PATH . 'classes/FpcRecursiveIteratorIterator.class.php' );
require_once( FPC_PLUGIN_PATH . 'classes/FpcDirFilter.class.php' );

/**
 * Enqueue scripts + styles
 */
add_action( 'admin_enqueue_scripts', 'load_admin_scripts_fpc' );

	function load_admin_scripts_fpc(){
		if( (is_admin() ) && (isset($_GET['page']) == "perm_check") ){
			wp_enqueue_style( 'ui', 'http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css');
                        wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('jquery-ui-widget');

                 add_action( 'admin_footer', 'load_tab_script_Fpc' );
	    }
	}

/**
 * Load tab script
 *
 */
function load_tab_script_Fpc() {
$script_fpc = <<<EOD
<script>
jQuery(document).ready(function() {
jQuery( "#Fpc-tabs" ).tabs();
});
</script>
EOD;
echo $script_fpc;
} 


/**
 * Load menu + function
 *
 */
add_action( 'admin_menu', 'load_file_menu_fpc');

	function load_file_menu_fpc(){
		add_options_page( 'File Checker', 'File Checker', 'activate_plugins', 'perm_check', 'main_file_check_fpc');
	}


/**
 * Main function creates HTML Table
 * @return FpcRecursiveDirectoryReader
 * @return FpcRecursiveDirectoryIteratorReader
 */
function main_file_check_fpc(){ 

    if (!current_user_can('activate_plugins')) { 
        wp_die('You do not have sufficient permissions to access this page.');
        }
     ?>

<!-- HTML part -->
 <div class="wrap">
    <div id="icon-plugins" class="icon32"></div>
	<h2>File Permissions  &#38; Size Checker</h2>
    <p>To read more about permissions check out:  <a href="http://codex.wordpress.org/Changing_File_Permissions">http://codex.wordpress.org/Changing_File_Permissions</a></p>
    <p>This plugin might not return accurate results under IIS or on a WAMP stack due to how Windows handles file permissions.</p>
    <hr />

    <div>
    <ul>
        <li><b>This scan is CPU intensive </b>, especially if you have a lot of plugin and theme files.</li>
        <li>The following files types  are omitted: <i>"jpg", "png", "gif", "jpeg", "ico", "css", "txt", "mo", "po", "svg", "ttf", "woff", "pot".</i></li>
        <li>The following directory is omitted: <i>"cache"</i></li>
        <li>Directories are in <b>Bold</b> - Permissions set to .777 will have a red mark <span style='color:red;'> &#215; </span></li>
    </ul>
 </div>

    
    <form action="<?php echo admin_url( '/options-general.php?page=perm_check'); ?>" method="post">
        <input class='button-primary' type='submit'  name="submity" value='Run File Check'>
        <?php wp_nonce_field('FpcAction','FpcNonceField'); ?>
    </form>
    <br />

    <!--start tabs-->
   <div id="Fpc-tabs">

    <!--tab titles-->
    <ul>
      <li><a href="#fragment-1"><span>Root Folder</span></a></li>
      <li><a href="#fragment-2"><span>WP-Admin</span></a></li>
      <li><a href="#fragment-3"><span>WP-Content</span></a></li>
      <li><a href="#fragment-4"><span>WP-Includes</span></a></li>
    </ul>

    <!--tab one -->
    <div id="fragment-1">
    <table class="widefat">
    <thead>
        <tr>
        <tr>
            <th>File</th>
            <th>Permission</th>
            <th>Size</th>
            <th>Last Modified</th>
        </tr>
    </thead>
    <tbody>

    <?php 

        if(isset($_POST['submity'])) { 

            if (! wp_verify_nonce($_POST['FpcNonceField'],'FpcAction')) wp_die('Security check fail');

            $base = ABSPATH; 
            $directory = new FpcRecursiveDirectoryReader($base);
        }

    ?>

    </tbody>
    </table>
    </div>

    <!--tab two -->
    <div id="fragment-2">
    <table class="widefat">
    <thead>
        <tr>
        <tr>
            <th>File</th>
            <th>Permission</th>
            <th>Size</th>
            <th>Last Modified</th>
        </tr>
    </thead>
    <tbody>

    <?php 

        if(isset($_POST['submity'])) {

            if (! wp_verify_nonce($_POST['FpcNonceField'],'FpcAction')) wp_die('Security check fail');

            $base = ABSPATH . 'wp-admin'; 
            $directory = new FpcRecursiveDirectoryIteratorReader($base);
        }

    ?>

    </tbody>
    </table>
    </div>

    <!--tab three  -->
    <div id="fragment-3">
    <table class="widefat">
    <thead>
        <tr>
        <tr>
            <th>File</th>
            <th>Permission</th>
            <th>Size</th>
            <th>Last Modified</th>
        </tr>
    </thead>
    <tbody>

    <?php 

        if(isset($_POST['submity'])) {

            if (! wp_verify_nonce($_POST['FpcNonceField'],'FpcAction')) wp_die('Security check fail');  

            $base = ABSPATH . 'wp-content'; 
            $directory = new FpcRecursiveDirectoryIteratorReader($base);
        } 

    ?>

    </tbody>
    </table>
    </div>

    <!--tab four    -->
    <div id="fragment-4">
    <table class="widefat">
    <thead>
        <tr>
        <tr>
            <th>File</th>
            <th>Permission</th>
            <th>Size</th>
            <th>Last Modified</th>
        </tr>
    </thead>
    <tbody>

    <?php 

        if(isset($_POST['submity'])) {

            if (! wp_verify_nonce($_POST['FpcNonceField'],'FpcAction')) wp_die('Security check fail');

            $base = ABSPATH . 'wp-includes'; 
            $directory = new FpcRecursiveDirectoryIteratorReader($base);
        } 

    ?>

    </tbody>
    </table>
    </div>

</div> <!-- end tabs -->
</div> <!-- end wrap -->
<?php } 
