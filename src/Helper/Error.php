<?php

/**
 *
 */
class ErrorEx
{
    public function __construct($data, $status = 501)
    {
        static::handle($data, $status);
    }
    public static function handle($data, $status)
    {
        echo json_encode($data, true);
        http_response_code($status);
        //when exit function call then api destructor not working file delete.
        if($status != 409) ff()->removeBusy();
        exit();
    }
}
