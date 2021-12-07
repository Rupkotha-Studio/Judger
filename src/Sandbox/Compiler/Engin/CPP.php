<?php

class CPP extends CompilerEngin
{
    public function __construct()
    {
        /*
        - g++ -lm program.cpp
         */
        $this->compile("g++ -lm " . request()->source_file_name);
        /*
        - ./a.out
         */
        $this->run("./" . $this->getBinaryFile());
    }

    public function getBinaryFile()
    {
        return "a.out";
    }

}
