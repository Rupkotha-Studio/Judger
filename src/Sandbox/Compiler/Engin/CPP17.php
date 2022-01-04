<?php

class CPP17 extends CompilerEngin
{
    public function __construct()
    {
        /*
        - g++ -lm program.cpp
         */
        $this->compile("g++ --std=c++17 -lm " . request()->source_file_name);
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
