<?php
/**
 *
 * @package    File Permissions &#38; Size Check
 * @author     Wycks
 * @link       
 *
 *   Exclude directories
 */
class FpcDirFilter extends RecursiveFilterIterator
{
    public function accept()
    {
        $excludes = array("cache", "objectcache", "pgcache", "dbcache");
        return !($this->isDir() && in_array($this->getFilename(), $excludes));
    }
    
}