<?php
	/**
	 *
	 * @package    File Permissions &#38; Size Check
	 * @author     Wycks
	 * @link       
	 *
	 */
	class FpcDirFilter extends RecursiveFilterIterator
	{
		/**
         *  File Directories to ignore
         * 
         * @param array $excludes
         */
		public $excludes = array("cache", "objectcache", "pgcache", "dbcache");


		/**
	     * Filter some directories that we don't want to scan
	     * 
	     */       
	    public function accept()
	    {
	        return !($this->isDir() && in_array($this->getFilename(), $this->excludes));
	    }

	    
	}