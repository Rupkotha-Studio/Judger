<?php

class SandBox
{

    public function __construct()
    {
        $this->compile();
    }

    public function compile()
    {
        $this->makeMergeFile();

        new Compiler();
        $this->processData();
        $this->removeMergeFile();
    }

    public function makeMergeFile()
    {
        File::create(ff()->input, request()->input);
        File::create(ff()->output);
        File::create(ff()->memory);
    }

    public function removeMergeFile()
    {
        exec("rm temp/*");
    }

    public function processData()
    {
        new Verdict();

        response()->output     = Lib::compressString(File::read(ff()->output), 3000);

    }
}
