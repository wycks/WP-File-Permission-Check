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
		 * Main output method for recursive subdirectory iteration
		 * 
		 * 
		 * @param string $dirname The subdirectory
		 * @param array $directoryIterator uses PHP's RecursiveDirectoryIterator Class
		 * @param array $filteredIterator uses FpcDirFilter Class to filter out cache or heavy folders we don't want to scan
		 * @param array $megaIterator uses PHP's RecursiveIteratorIterator
		 * @throws exceptionclass [Error]
		 * @return  fpcOutput
		 */       
		public function fpcScansub($dirname)
		{    
			try {
				 //::SKIP_DOTS breaks PHP > 5.3
				 //$directoryIterator = new RecursiveDirectoryIterator($dirname, RecursiveDirectoryIterator::SKIP_DOTS);
				
				$directoryIterator = new RecursiveDirectoryIterator($dirname);
				$filteredIterator = new FpcDirFilter($directoryIterator);
				$megaIterator = new RecursiveIteratorIterator($filteredIterator, RecursiveIteratorIterator::SELF_FIRST);

				foreach ($megaIterator as $fileinfo) {

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
	}