<?php

class Compiler
{
    private $compilerList = [
        'C', 'CPP', 'CPP11','JAVA',
    ];
    public function __construct()
    {
        $language = strtoupper(request()->language);

        if (in_array($language, $this->compilerList)) {
            new $language();
        } else {
            response()->status = "LR";
        }
    }
}
