<?php
	/**
	 *
	 * @package    File Permissions &#38; Size Check
	 * @author     Wycks
	 * @link       
	 *
	 *   Iterator Loops
	 */
	class FpcLoop
	{

		/**
		 * Main Loop
		 * 
		 *  Checks for nonce and $_POST then iterates over root non-recursively
		 * 
		 * @param string $dirname The directory
		 * @param string $directory output of RecursiveDirectoryIterator Class
		 * @throws wp_die
		 * @return fpcScan
		 */       
		public function fpcRoot($dirname)
		{
			if(isset($_POST['submity'])) { 
				if ( !empty($_POST['submity']) && check_admin_referer( 'fpc_action', 'fpc_noncefield' )) {
					$directory = new FpcRecursiveDirectoryIterator();
					$directory->fpcScan($dirname);
				}else{
					wp_die('Security check fail');		
				}
			}
		}


		/**
		 * Main Loop
		 * 
		 *  Checks for nonce and $_POST then iterates over directory recursively
		 * 
		 *
		 * @param string $dirname The directory
		 * @param string $directory output of RecursiveDirectoryIterator Class
		 * @throws wp_die
		 * @return fpcScansub
		 */       
		public function fpcDir($dirname)
		{
			if(isset($_POST['submity'])) { 
				if ( !empty($_POST['submity']) && check_admin_referer( 'fpc_action', 'fpc_noncefield' )) {
					$directory = new FpcRecursiveDirectoryIteratorIterator();
					$directory->fpcScansub($dirname);
				}else{
					wp_die('Security check fail');		
				}
			}
		}
	
	}