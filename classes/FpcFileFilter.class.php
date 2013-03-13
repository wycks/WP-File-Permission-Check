<?php
/**
 *
 * @package    File Permissions &#38; Size Check
 * @author     Wycks
 * @link       
 *
 *   Exclude directories
 */
class FpcFileFilter extends RecursiveFilterIterator
{
    public function accept()
    {

    	$filetypes = array("jpg", "png", "gif", "jpeg", "ico", "css", "txt", "mo", "po", "svg", "ttf", "woff", "pot");
    	$filetype = pathinfo($this->getFilename(), PATHINFO_EXTENSION);
        //$excludes = array("cache", "objectcache", "pgcache", "dbcache");
        //
       // if (!in_array(strtolower($filetype), $filetypes))
        return !(in_array(strtolower($filetype), $filetypes) && in_array($this->getFilename(), $filetypes));
    }
    
}