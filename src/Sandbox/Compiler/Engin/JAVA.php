<?php

class JAVA extends CompilerEngin
{
    public function __construct()
    {
        $sourceCode = ff()->java_program;
        File::create($sourceCode, request()->source_code);
        $executeCmd      = "java {$sourceCode}";
        
        $this->run($executeCmd);
    }
}
