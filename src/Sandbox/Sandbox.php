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
        exec("mkdir -m 777 -p temp");
        File::create(ff()->input, request()->input);
        File::create(ff()->output);
        File::create(ff()->memory);
    }

    public function removeMergeFile()
    {
        exec("rm -R temp");
    }

    public function processData()
    {
        new Verdict();

        response()->output     = Lib::compressString(File::read(ff()->output), 3000);

    }
}
