<?php

class JAVA extends CompilerEngin
{
    public function __construct()
    {
        $sourceCode = "temp/program.java";
        File::create($sourceCode, request()->source_code);

        $this->compile("javac {$sourceCode}");

        $executeFileName = trim(shell_exec('find -iname *.class | sed "s/.*\///; s/\.class//" | head -n 1'));
        $executeCmd      = "java -cp temp {$executeFileName}";

        $this->run($executeCmd);
    }
}
