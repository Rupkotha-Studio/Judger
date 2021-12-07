<?php

class JAVA extends CompilerEngin
{
    public function __construct()
    {
        /*
        - javac program.java
         */
        $this->compile("javac " . request()->source_file_name);

        /*
        - java Main/Class Name
         */
        $path       = trim(shell_exec("realpath $(which java)"));
        $binaryFile = basename($this->getBinaryFile(), ".class");
        $executeCmd = "$path {$binaryFile}";

        $this->run($executeCmd);
    }

    public function getBinaryFile()
    {
        $classFiles = glob("*.class");
        $binaryFile = (count($classFiles) > 0) ? basename($classFiles[0]) : "";
        return $binaryFile;
    }
}
