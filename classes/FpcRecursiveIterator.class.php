<?php
/**
 * @package    File Permissions &#38; Size Check
 * @author     Wycks
 *
 *  Used to get root info since we don't want to recursively iterate from whole root
 */
class FpcRecursiveDirectoryReader
{
    /**
     * @param $dirname
     */
    public function __construct($dirname)
    {
        
        if (!current_user_can("activate_plugins")) { 
        die("You do not have sufficient permissions to access this.");
        }

        $filetypes = array("jpg", "png", "gif", "jpeg", "ico", "css", "txt", "mo", "po", "svg", "ttf", "woff", "pot");

        try {
            $directoryIterator = new RecursiveDirectoryIterator($dirname);

            foreach ($directoryIterator as $fileinfo) {
                
                    /**
                    * @var  $filetype
                    * @var  $octal
                    * @var  $timestamp
                    * @var  $filesize
                    * 
                    */
                    
                    $filetype = pathinfo($fileinfo, PATHINFO_EXTENSION);
                    $octal = substr(sprintf('%o', $fileinfo->getPerms()), -4);
                    $timestamp = date("F j, Y, g:i a", $fileinfo->getMTime());
                    $filesize = number_format($fileinfo->getSize() / 1024, 2) . " KB";

                    echo '</tr>';

                    //remove images and other non important files
                    if (!in_array(strtolower($filetype), $filetypes)) {

                        //check if it's a dir or a file
                        if (is_dir($fileinfo )){
                            echo "<td><b>" . $fileinfo . "</b></td>";
                        }else{
                            echo "<td>" . $fileinfo . "</td>";
                        }
                        
                        //check for 777
                        if ($octal == '0777') {
                            echo "<td>" . $octal . "<span class='red' style='color:#FF0000;'> &#215; </span>" . "</td>";
                        } else {
                            echo "<td>" . $octal . "</td>";
                        }

                        //output file sizes
                        echo "<td>" . $filesize . "</td>";
                        //outout last modified time
                        echo "<td>" . $timestamp . "</td>";
                    }
                
            }

        } catch (Exception $e) {
            print "Error: " . $e->getMessage();
        }
    }
}