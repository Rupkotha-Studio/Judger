<?php

class Compiler
{
    private $compilerList = [
        'C', 'CPP','CS', 'CPP11','JAVA','PYTHON2','PYTHON3',
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
