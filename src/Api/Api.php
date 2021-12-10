<?php

class Api
{
    private $requestClass = [
        'submission' => 'SandBox',
        'checker'    => 'Checker',
    ];
    public function __construct()
    {
        $this->_call();
        ff()->removeBusy();
    }
    public function _call()
    {
       // new Validation();
        new RequestService();
        new $this->requestClass[request()->api_type]();
        response()->json();
    }
}
