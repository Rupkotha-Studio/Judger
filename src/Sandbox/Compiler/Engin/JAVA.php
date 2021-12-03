<?php

class JAVA extends CompilerEngin
{
    public function __construct()
    {
        $sourceCode = ff()->java_program;
        File::create($sourceCode, request()->source_code);

        $this->compileCmd = "javac temp/program.java";

        $this->compile($this->compileCmd);

        $binaryFile = $this->getBinaryFileName();

        if($binaryFile != "")response()->compiler_log = "";

        $path       = trim(shell_exec("realpath $(which java)"));
        $executeCmd = "$path {$binaryFile}";

        $this->run($executeCmd);
    }

    public function getBinaryFileName()
    {
        $classFile = trim(shell_exec('find temp -name "*.class"'));
        $binaryFile = $classFile != "" ? pathinfo($classFile)['filename'] : "";
        return $binaryFile;
    }
}
