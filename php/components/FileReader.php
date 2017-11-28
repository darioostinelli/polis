<?php
namespace php\components;

class FileReader
{
    private $file;
    private $path;
    public function __construct($path)
    {
        if(!file_exists($path))
            $this->file = false;
        else
            $this->file = fopen($path, "r");
        $this->path = $path;
    }
    public function exists(){
        if($this->file == false)
            return false;
        return true;
    }
    public function read(){
        return fread($this->file, filesize($this->path));
    }
    function __destruct()
    {
        fclose($this->file);
    }
}

