<?php

class CS extends CompilerEngin
{
    

    public function __construct()
    {
        /*
        - javac program.java
         */
        $this->compile("mcs -out:{$this->getBinaryFile()} " . request()->source_file_name);

        /*
        - java Main/Class Name
         */
        $path       = trim(shell_exec("realpath $(which mono)"));
        $binaryFile = $this->getBinaryFile();
        $executeCmd = "$path {$binaryFile}";

        $this->run($executeCmd);
    }

    public function getBinaryFile()
    {
        return "out.exe";
    }
}
