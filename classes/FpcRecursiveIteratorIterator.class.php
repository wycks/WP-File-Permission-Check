<?php
	/**
	 *
	 * @package    File Permissions &#38; Size Check
	 * @author     Wycks
	 * @link       
	 *
	 *   Main Iterator - filters out file types
	 */
	class FpcRecursiveDirectoryIteratorIterator extends FpcRecursiveDirectoryIterator
	{
		/**
		 * Main output method for subdirectory
		 * 
		 * This should probably be refactored into the template file (File-Checker.php) especially if extended, for now it will stuff it into a big fat class.
		 * 
		 * @param string $dirname The subdirectory
		 * @param array $directoryIterator uses PHP's RecursiveDirectoryIterator 
		 * @param array $filtered uses FpcDirFilter to filter out cache or heavy folders we don't want to scan
		 * @param array $megaIterator uses PHP's RecursiveIteratorIterator
		 * @throws exceptionclass [Error]
		 * @return  fpcType(), fpcPermissions(), fpcFilesize(), fpcTimestamp()
		 */       
		public function fpcScansub($dirname)
		{    
			try {
				 //::SKIP_DOTS breaks PHP > 5.3
				 //$directoryIterator = new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS);
				
				$directoryIterator = new RecursiveDirectoryIterator($dirname);
				$filtered = new FpcDirFilter($directoryIterator);
				$megaIterator = new RecursiveIteratorIterator($filtered, RecursiveIteratorIterator::SELF_FIRST);

				foreach ($megaIterator as $fileinfo) {

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

	}