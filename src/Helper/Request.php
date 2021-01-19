<?php

class Request
{

    public static $instance;

    public function __construct()
    {
        foreach ($_POST as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new Request();
        }
        return self::$instance;
    }
    
    public function all()
    {
        return get_object_vars($this);
    }

}

function request()
{
    return Request::getInstance();
}
