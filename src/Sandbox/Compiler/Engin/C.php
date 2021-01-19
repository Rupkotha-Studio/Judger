<?php

class C extends CompilerEngin
{
    public function __construct()
    {
       	File::create(ff()->c_program,request()->source_code);
       	$sourceCode = ff()->c_program;
       	$runFile = ff()->c_run;

        $this->compile("gcc -lm {$sourceCode} -o {$runFile}");
        $this->run("$runFile");
    }
}
