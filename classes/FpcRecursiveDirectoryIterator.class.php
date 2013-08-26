<?php
    /**
     * @package    File Permissions &#38; Size Check
     * @author     Wycks
     *
     *  Used to get root info only since we don't want to recursively iterate from whole root
     */
    class FpcRecursiveDirectoryIterator
    {
        /**
         *  File types to ignore by extension
         * 
         * @param array $fileTypes
         */
        public $fileTypes = array("jpg", "png", "gif", "jpeg", "ico", "css", "txt", "mo", "po", "svg", "ttf", "woff", "pot", "eot");


        /**
         * Only run if user has privileges
         *
         * @return void
         */
        public function __construct()
        {
            
            if (!current_user_can("activate_plugins")) { 
            die("You do not have sufficient permissions to access this.");
            }
        }


        /**
         * Main output method 
         * 
         * This should probably be refactored into the template file (File-Checker.php) especially if extended, for now 
         * I will stuff it into a big fat class.
         *
         * @param string $dirname The directory
         * @param array $directoryIterator uses PHP's RecursiveDirectoryIterator 
         * @param string $fileinfo output of $directoryIterator array
         * @throws exceptionclass [Error]
         * @return  fpcType(), fpcPermissions(), fpcFilesize(), fpcTimestamp()
         */       
        public function fpcScan($dirname)
        {
     
            try {

                $directoryIterator = new RecursiveDirectoryIterator($dirname);

                    foreach ($directoryIterator as $fileinfo) {
                                         
                        echo '</tr>';
                        $filetype = pathinfo($fileinfo, PATHINFO_EXTENSION);

                        //remove images and other non important files
                        if (!in_array(strtolower($filetype), $this->fileTypes)) {                   

                            $this->fpcType($fileinfo);
                            $this->fpcPermissions($fileinfo);
                            $this->fpcFilesize($fileinfo);
                            $this->fpcTimestamp($fileinfo);

                        }               
                    }

                } catch (Exception $e) {
                  print "Error: " . $e->getMessage();
                }
        }


        /**
         * Output file permissions
         *
         * @param string $octal human readable octal file format 
         * @param string $someString This parameter should contain some string
         * @param string $fileinfo output of $directoryIterator array
         * @return $octal
         */
        public function fpcPermissions($fileinfo)
        {

            $octal = substr(sprintf('%o', $fileinfo->getPerms()), -4);

            if ($octal == '0777') {
                echo "<td>" . $octal . "<span class='red' style='color:#FF0000;'> &#215; </span>" . "</td>";
            } else {
                echo "<td>" . $octal . "</td>";
            } 
        }

        /**
         * Output file timestamp for last modified
         *
         * @param string $fileinfo output of $directoryIterator array
         * @param string $timestamp last modified time
         * @return $timestamp
         */
        public function fpcTimestamp($fileinfo)
        {
            //outout last modified time
            $timestamp = date("F j, Y, g:i a", $fileinfo->getMTime());

            echo "<td>" . $timestamp . "</td>";
        }


        /**
         * Output file size in KB
         *
         * @param string $fileinfo output of $directoryIterator array
         * @param string $filesize gets file size
         * @return $filesize
         */
        public function fpcFilesize($fileinfo)
        {
            //output file sizes
            $filesize = number_format($fileinfo->getSize() / 1024, 2) . " KB";

            echo "<td>" . $filesize . "</td>";
        }


        /**
         * Output file name and checks for type (dir or file)
         *
         *
         * @param string $fileinfo output of $directoryIterator array
         * @return getFilename()
         */
         public function fpcType($fileinfo)
        {
             //check if it's a dir or a file
            if (is_dir($fileinfo )){
                echo "<td><b>" . $fileinfo->getFilename() . "/</b></td>";
            }else{
                echo "<td>" . $fileinfo->getFilename() . "</td>";
            }
        }

    }