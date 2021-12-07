<?php

class PYTHON3 extends CompilerEngin
{
    public function __construct()
    {
    	File::copy(request()->source_file_name, "box"); 
       	$sourceFile = request()->source_file_name;
        $this->run("$(which python3) {$sourceFile}");
    }
}
