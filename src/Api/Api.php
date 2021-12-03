<?php

class Api
{
    private $requestClass = [
        'submission' => 'SandBox',
        'checker'    => 'Checker',
    ];
    public function __construct()
    {
        
        if (File::has(ff()->busy)) {
           new ErrorEx(['Compiler Already Busy Another Process'], 409);
        }
        File::create(ff()->busy, rand());
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
