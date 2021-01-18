<?php

/**
 *
 */
class Response
{
    public static $instance;
    public $time       = 0;
    public $memory     = 0;
    public $checkerLog = "";

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
