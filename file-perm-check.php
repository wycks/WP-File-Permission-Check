<?php
/*
Plugin Name: File Permissions &#38; Size Check
Plugin URI: http://www.wpsecure.net/
Description: Checks wp file permissions and sizes
Author: Wycks
Author URI: http://wordpress.org/extend/plugins/profile/wycks
Version: 1.0.2
License: GPL2
****/

/*  Copyright 2011  Wyckss  (email : info@wpsecure.net)

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


//register jquery tools and tab styles
add_action('init', 'fpc_load_custom_perm_scripts');
function fpc_load_custom_perm_scripts() {
	 wp_register_script('my-jquery-ui', 'http://cdn.jquerytools.org/1.2.5/jquery.tools.min.js');
	 wp_register_script('my-perm-js', plugins_url('/file-perm.js', __FILE__) );
         wp_register_style('jquery-style', plugins_url('/file-perm-check.css', __FILE__) );
         }



//load stuff only on plugin page
//add_action( 'admin_print_styles',  'load_admin_perm_styles' );
add_action( 'init',  'fpc_load_admin_perm_styles' );
function fpc_load_admin_perm_styles(){

	if( (is_admin() ) && (isset($_GET['page']) == "perm_check") ){
	  wp_enqueue_style('jquery-style');
	  wp_enqueue_script('my-jquery-ui');
	  wp_enqueue_script('my-perm-js');

	  }
    }

// load menu
add_action( 'admin_menu', 'fpc_wp_fileperm_show');
function fpc_wp_fileperm_show(){

       $menu_label = "File Permission Checker";
       add_options_page( 'show perm', $menu_label, 'activate_plugins', 'perm_check', 'fpc_permy_file_check');
}


//main function lot's of tables and tabs ;)

function fpc_permy_file_check(){

	//global base root dir
	$base = ABSPATH; ?>
	
	
    <div class="wrap">
     <?php screen_icon('plugins'); ?>
     
     <h2>File Permissions  &#38; Size Checker</h2>
     <h4>To read more about permissions check out
     <a href="http://codex.wordpress.org/Changing_File_Permissions">http://codex.wordpress.org/Changing_File_Permissions</a>
     <br>Files set to .777 will have a red mark <span class='red'> &#215; </span> as they can compromise your security, especially for directories.
     </h4>
     <p></p>
     <p><b>General rule of thumb:</b>| &#8226; Folders set to  755 or 750 | &#8226; Files set to 644 or 640 | &#8226; Important files (wp-config.php) should have more strict permissions like 600<p>
     
     <!--tab title-->
    <ul class="tabs-perm">
	  <li><a href="#">Root Folder</a></li>
	  <li><a href="#">WP-Admin</a></li>
	  <li><a href="#">WP-Content</a></li>
	  <li><a href="#">WP-Includes</a></li>
	  <li><a href="#">Info</a></li>
      </ul>

   <!--start of jquery tools tabs-->
   <div class="panes">
	
  <!--TAB ONE	-->

     <div>
       <table class="widefat">
         <thead>
          <tr>
            <tr>
              <th>File</th>
	      <th>Permission</th>
	      <th>Size</th>
            </tr>
         </thead>
       <tbody>
   
<?php  // ----  Root folder

      
       $iterator = new DirectoryIterator($base);
       
       // don't scan for these files types
       $filetypes = array("jpg", "png", "gif", "jpeg", "ico", "css", "txt");
       
      
        foreach ($iterator as $fileinfo) {
	       if (!$fileinfo->isDot()) {
     
                    //get file extension
                    $filetype = pathinfo($fileinfo, PATHINFO_EXTENSION);

		    // get permissions in octal
		    $stringy = substr(sprintf('%o', $fileinfo->getPerms()), -4);
		    ?>

                    </tr>
                   <?php if (!in_array(strtolower($filetype), $filetypes)) {

			  //output file name
			echo "<td>" . $fileinfo . "</td>";


		          //check for 777 ! and outputs perms

		           if  ($stringy == '0777'){
		                echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .
				"<span class='red'> &#215; </span>" . "</td>" ;
		           }else{
			        echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .  "</td>" ;
		           }


			     //output file sizes
		             echo "<td>" . number_format($fileinfo->getSize()/1024, 2) . " KB" . "</td>";


		   }
		}
	}?>

        </tbody>
      </table>
    </div>
   
  <!--TAB TWO	-->

  <div>
   <table class="widefat">
    <thead>
      <tr>
        <tr>
         <th>File</th>
         <th>Permission</th>
	 <th>Size</th>
        </tr>
    </thead>
  <tbody>
   
<?php  // ----  wp-admin folder

      $it = new RecursiveDirectoryIterator($base . "wp-admin");
      
           foreach(new RecursiveIteratorIterator($it) as $file) {

	    $filetype = pathinfo($file, PATHINFO_EXTENSION);
	    $stringy = substr(sprintf('%o', $fileinfo->getPerms()), -4);
	    ?>
    
            </tr>
      
              <?php if (!in_array(strtolower($filetype), $filetypes)) {

                 echo "<td>" . $file . "</td>";

		 //check for 777 !

		           if  ($stringy == '0777'){
		                echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .
				"<span class='red'> &#215; </span>" . "</td>" ;
		           }else{
			        echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .  "</td>" ;
		           }

		                echo "<td>" . number_format($file->getSize()/1024, 2) . " KB" . "</td>";

	      }
	   }?>
    
           
    </tbody>
   </table>
 </div>
	
  <!--TAB THREE-->

 <div>
   <table class="widefat">
     <thead>
       <tr>
        <tr>
         <th>File</th>
         <th>Permission</th>
	 <th>Size</th>
        </tr>
    </thead>
 <tbody>
   
<?php  // ----  wp-content folder

      $it = new RecursiveDirectoryIterator($base . "wp-content");
      
           foreach(new RecursiveIteratorIterator($it) as $file) {

	    $filetype = pathinfo($file, PATHINFO_EXTENSION);
	    $stringy = substr(sprintf('%o', $fileinfo->getPerms()), -4);
	    ?>
    
            </tr>
      
              <?php if (!in_array(strtolower($filetype), $filetypes)) {

                 echo "<td>" . $file . "</td>";

		 //check for 777 !

		           if  ($stringy == '0777'){
		                echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .
				"<span class='red'> &#215; </span>" . "</td>" ;
		           }else{
			        echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .  "</td>" ;
		           }

		                echo "<td>" . number_format($file->getSize()/1024, 2) . " KB" . "</td>";

	      }
	   }?>

   </tbody>
  </table>
 </div>

  <!--TAB FOUR-->
  
 <div>
  <table class="widefat">
   <thead>
     <tr>
        <tr>
         <th>File</th>
         <th>Permission</th>
	 <th>Size</th>
        </tr>
    </thead>
  <tbody>
   
   <?php  // ----  wp-includes folder

      $it = new RecursiveDirectoryIterator($base . "wp-includes");
      
           foreach(new RecursiveIteratorIterator($it) as $file) {

	    $filetype = pathinfo($file, PATHINFO_EXTENSION);
	    $stringy = substr(sprintf('%o', $fileinfo->getPerms()), -4); ?>
    
            </tr>
      
              <?php if (!in_array(strtolower($filetype), $filetypes)) {

                 echo "<td>" . $file . "</td>";

		 //check for 777 !

		           if  ($stringy == '0777'){
		                echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .
				"<span class='red'> &#215; </span>" . "</td>" ;
		           }else{
			        echo "<td>" . substr(sprintf('%o', $fileinfo->getPerms()), -4) .  "</td>" ;
		           }


		 echo "<td>" . number_format($file->getSize()/1024, 2) . " KB" . "</td>";

	      }
	   }?>

    </tbody>
   </table>
 </div>

  <!--TAB FIVE +-->
<div>
	<ul>
	<li>This plugin will not return accurate results under IIS or on a WAMP stack due to how windows handles file permissions.</li>
	<li>This scan is CPU intensive, images are ommited.</li>
	<li>If this is deemed useful I can optimize it better by re-writing some of the code</li>
	<li>Follow wpsecure.net's twitter feed for security updates <a href="https://twitter.com/#!/wpsecurenet">https://twitter.com/#!/wpsecurenet</a></li>
        <li>Important, this plugin clashes with jQuery UI tabs (sometimes used by default with WordPress), might redo it to use jQuery UI if I have time.</li>
	</ul>
	
</div>
  <!--END TABS -->
</div>

<!--end wrap-->
</div>

<?php 

}
?>