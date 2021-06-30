<?php

class PYTHON3 extends CompilerEngin
{
    public function __construct()
    {
       	File::create(ff()->python_program,request()->source_code);
       	$program = ff()->python_program;

        $this->run("python3 {$program}");
    }
}
