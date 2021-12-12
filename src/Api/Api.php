<?php

class Api
{
    private $requestClass = [
        'submission' => 'SandBox',
        'checker'    => 'Checker',
    ];
    public function __construct()
    {
        $this->checkCpuLimit();
        $this->_call();
        ff()->removeBusy();
    }

    public function checkCpuLimit(){
        $busyFilesCount = count(glob("*/".ff()->busy));
        $cpuCount = shell_exec("cat /proc/cpuinfo | grep processor | wc -l");
        if ($busyFilesCount >= $cpuCount) {
            new ErrorEx(['All cpu is busy'], 409);
        }
    }
    
    public function _call()
    {
       // new Validation();
        new RequestService();
        new $this->requestClass[request()->api_type]();
        response()->json();
    }
}
