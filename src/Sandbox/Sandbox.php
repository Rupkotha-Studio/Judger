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
        exec("mkdir -m 777 box");
        exec("mkdir -m 777 checker");
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
