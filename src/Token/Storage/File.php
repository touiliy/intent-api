<?php
namespace BIMData\Intent\Token\Storage;

class File implements TokenInterface{
    protected $filename_suffix = '';

    function __construct($filename_suffix)
    {
        $this->filename_suffix = $filename_suffix;
    }

    public function fetch($var)
    {
        $content = (is_file($this->filename_suffix.$var))?@file_get_contents($this->filename_suffix.$var):false;
        return ($content)?unserialize($content):false;
    }

    public function save($var, $data)
    {
        @file_put_contents($this->filename_suffix.$var, serialize($data));
    }

}