<?php

class File
{
    public static $instance;
    private $tempFileFolder = "temp/";

    public function __construct()
    {
        $this->storeFileData();
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new File();
        }

        return self::$instance;
    }

    public function storeFileData()
    {
        $file = $GLOBALS['file'];
        $hsh = rand();
        foreach ($file as $key => $value) {
            $fileName = new SplFileInfo($value);
            $extension = '.'.$fileName->getExtension();
            $fileName = $fileName->getBasename($extension);
            $this->$key = $this->tempFileFolder . $fileName . $extension;
        }
        $this->busy = 'busy.txt';
    }

    public static function createInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new File();
        }
        return self::$instance;
    }

    public static function create($fileName, $fileVal = "")
    {
        $file = fopen($fileName, "w+");
        fwrite($file, $fileVal);
        fclose($file);
        exec("chmod -R 777 " . $fileName);
    }

    public function delete($fileName)
    {
        unlink($fileName);
    }

    public function removeBusy()
    {
        if ($this->has($this->busy)) {
            $this->delete($this->busy);
        }
    }

    public function has($fileName)
    {
        return file_exists($fileName);
    }

    public static function read($fileName)
    {
        return file_get_contents($fileName);
    }

    public static function trim($fileName)
    {
        shell_exec('perl -pi -e "s/\n$// if(eof)" ' . $fileName . ' && perl -pi -e "s/ $//" ' . $fileName);
    }
}

function ff()
{
    return File::getInstance();
}
