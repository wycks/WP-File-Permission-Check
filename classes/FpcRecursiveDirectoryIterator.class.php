<?php
	/**
	 * @package    File Permissions &#38; Size Check
	 * @author     Wycks
	 *
	 *  Main Iterator
	 */
	class FpcRecursiveDirectoryIterator
	{
		/**
		 *  File types to ignore
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
		 * Main Loop
		 * 
		 *  Checks for filetype and loops through, this function is not recursive
		 * 
		 *
		 * @param string $dirname The directory
		 * @param array $fileinfo output of RecursiveDirectoryIterator Class
		 * @throws exceptionclass [Error]
		 * @return  fpcOutput
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

							$this->fpcOutput($fileinfo);								   
						}               
					}

				} catch (Exception $e) {
				  print "Error: " . $e->getMessage();
				}
		}


		/**
		 * Main Output 
		 *
		 * This should probably be refactored into the template file (File-Checker.php) especially if extended.
		 *
		 * @param string $fileinfo 
		 * @return getFilename, fpcPermissions, fpcFilesize, fpcTimestamp
		 */
		protected function fpcOutput($fileinfo)
		{
			if (is_dir($fileinfo )){
				echo "<td><b>" . $fileinfo->getFilename() . "/</b></td>";
			}else{
				echo "<td>" . '-' . $fileinfo->getFilename() . "</td>";
			}

			if($this->fpcPermissions($fileinfo) == '0777'){
				echo "<td>" . $this->fpcPermissions($fileinfo) . "<span class='red' style='color:#FF0000;'> &#215; </span>" . "</td>";
			} else {
				echo "<td>" . $this->fpcPermissions($fileinfo) . "</td>";							 
			}
	
			echo "<td>" . $this->fpcFilesize($fileinfo)  . "</td>"; 
			echo "<td>" . $this->fpcTimestamp($fileinfo) . "</td>";	
		}


		/**
		 * Output file permissions
		 *
		 * @param string $octal human readable octal file format 
		 * @return $octal
		 */
		protected function fpcPermissions($fileinfo)
		{
			$octal = substr(sprintf('%o', $fileinfo->getPerms()), -4);
			return $octal;	
		}


		/**
		 * Output file timestamp for last modified
		 *
		 * @param string $timestamp last modified time
		 * @return $timestamp
		 */
		protected function fpcTimestamp($fileinfo)
		{
			$timestamp = date("F j, Y, g:i a", $fileinfo->getMTime());
			return $timestamp;
		}


		/**
		 * Output file size in KB
		 *
		 * @param string $filesize gets file size
		 * @return $filesize
		 */
		protected function fpcFilesize($fileinfo)
		{
			$filesize = number_format($fileinfo->getSize() / 1024, 2) . " KB";
			return $filesize;		
		}
	}