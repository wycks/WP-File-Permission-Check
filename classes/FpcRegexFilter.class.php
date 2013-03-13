<?php
class DirnameFilter extends RecursiveRegexIterator  {
    // Filter directories against the regex
    public function accept() {
        return ( ! $this->isDir() || preg_match($this->regex, $this->getFilename()));
    }
}
