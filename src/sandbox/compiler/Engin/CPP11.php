<?php

class CPP11 extends CompilerEngin
{
    public function __construct()
    {
        File::create(ff()->cpp_program,request()->source_code);
        $sourceCode = ff()->cpp_program;
        $runFile = ff()->cpp_run;

        $this->compile("g++ --std=c++11 -lm {$sourceCode} -o {$runFile}");
        $this->run("$runFile");
    }
}
