<?php

class Compiler
{
    private $compilerList = [
        'C', 'CPP', 'CPP11',
    ];
    public function __construct()
    {
        
        new CPP();
    	return;
        if (in_array(request()->language, $this->compilerList)) {
            //new request()->language();
        } else {
            response()->status = "LE";
        }
    }
}
