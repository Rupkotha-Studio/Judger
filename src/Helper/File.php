<?php

class File
{
    public static $instance;
    public $judgePath    = "temp/";
    public $judgeBoxPath = "temp/box/";

    public function __construct()
    {
        $this->storeFileData();
        $this->createHash();
        $this->judgePath = (isset(request()->judge_path) ? request()->judge_path : $this->createHash(10))."/";
    }

    public function createHash($len = 6)
    {
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyz';
        $randomString = "";
        for ($i = 0; $i < $len; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
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
        foreach ($file as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function createInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new File();
        }
        return self::$instance;
    }

    public static function size($fileName)
    {
        return self::has($fileName) ? filesize($fileName) : 0;
    }

    public static function create($fileName, $fileVal = "")
    {
        self::createDir($fileName);

        $file = fopen($fileName, "w+");
        fwrite($file, $fileVal);
        fclose($file);
        exec("chmod -R 777 " . $fileName);
    }

    public static function createDir($dirLocation)
    {
        if (!file_exists(dirname($dirLocation))) {
            exec("mkdir -m 777 " . dirname($dirLocation));
            return true;
        }
        return false;
    }

    public static function delete($fileName)
    {
        if (!file_exists($fileName)) {
            return;
        }

        unlink($fileName);
    }

    public function removeBusy()
    {
        if ($this->has($this->busy)) {
            $this->delete($this->busy);
        }
    }

    public static function has($fileName)
    {
        return file_exists($fileName);
    }

    public static function read($fileName)
    {
        return self::has($fileName) ? file_get_contents($fileName) : "";
    }

    public static function copy($currFileName, $destinationFileName)
    {
        shell_exec("cp {$currFileName} {$destinationFileName}");
        exec("chmod -R 777 {$destinationFileName}");
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
