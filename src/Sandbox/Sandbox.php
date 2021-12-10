<?php

class SandBox
{

    public function __construct()
    {
        $this->compile();
    }

    public function compile()
    {
        $this->makeJudgeDir();

        new Compiler();
        $this->processData();
        $this->removeJudgeDir();
    }

    public function makeJudgeDir()
    {
        exec("mkdir -m 777 " . ff()->judgePath);
        chdir(ff()->judgePath);
        $this->busyFlag();
        exec("mkdir -m 777 box");
        exec("mkdir -m 777 checker");
    }

    public function busyFlag(){
        if (File::has(ff()->busy)) {
           new ErrorEx(['Compiler Already Busy Another Process'], 409);
        }
        File::create(ff()->busy, rand());
    }

    public function removeJudgeDir()
    {
        request()->clear_judge_path = isset(request()->clear_judge_path) ? request()->clear_judge_path : 1;
        if (request()->clear_judge_path == 1) {
            exec("rm -rf " . ff()->judgePath);
        } else {
            exec("rm " . ff()->judgePath."*");
        }
    }

    public function processData()
    {
        new Verdict();

        response()->output = Lib::compressString(File::read(ff()->output), 3000);
        chdir("..");
    }
}
