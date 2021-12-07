<?php

class CPP11 extends CompilerEngin
{
    public function __construct()
    {
        /*
        - g++ -lm program.cpp
         */
        $this->compile("g++ --std=c++11 -lm " . request()->source_file_name);
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
