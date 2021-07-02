<?php

/**
 *
 */
class Response
{
    public static $instance;
    public $time         = 0;
    public $memory       = 0;
    public $checker_log  = "";
    public $compiler_log = "";

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Response();
        }
        return self::$instance;
    }

    public function cast()
    {
        $castList = [
            'output' => "base64_encode",
            'memory' => "int",
        ];

        $this->checker_log  = $this->clearGarbaseValue($this->checker_log);
        $this->compiler_log = $this->clearGarbaseValue($this->compiler_log);
        $this->output       = $this->clearGarbaseValue($this->output);

        if (isset(request()->program_file)) {
            if (trim($this->compiler_log) != "") {
                $fileName           = explode('.', request()->program_file);
                $fileName           = $fileName[0];
                $this->compiler_log = str_replace($fileName, 'program', $this->compiler_log);
            }
        }

        foreach ($castList as $key => $value) {
            if (isset($this->$key)) {
                if ($value == "base64_encode") {
                    $this->$key = base64_encode($this->$key);
                }
                if ($value == "int") {
                    $this->$key = (int) ($this->$key);
                }
            }
        }
    }

    public function clearGarbaseValue($text)
    {
        return preg_replace('/[^(\x20-\x7F)]*/', '', $text);
    }

    public function json()
    {
        $this->cast();
        echo json_encode(get_object_vars($this));
    }

    public function all()
    {
        return get_object_vars($this);
    }
}

function response()
{
    return Response::getInstance();
}
