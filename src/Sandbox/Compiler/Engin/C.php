<?php

class C extends CompilerEngin
{
    public function __construct()
    {
        /*
        - gcc -lm program.c
        */
        $this->compile("gcc -lm ".request()->source_file_name);
        /*
        - ./a.out
        */
        $this->run("./".$this->getBinaryFile());
    }

    public function getBinaryFile()
    {
        return "a.out";
    }
}
