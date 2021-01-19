<?php

class CPP extends CompilerEngin
{
    public function __construct()
    {
       	File::create(ff()->cpp_program,request()->source_code);
       	$sourceCode = ff()->cpp_program;
       	$runFile = ff()->cpp_run;

        $this->compile("g++ -lm {$sourceCode} -o {$runFile}");
        $this->run("$runFile");
    }
}
