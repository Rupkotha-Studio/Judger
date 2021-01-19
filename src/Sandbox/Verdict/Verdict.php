<?php

class Verdict
{

    public function __construct()
    {
        $this->checkCompilationError();
        $this->checkRunTimeError();
        $this->checkOutputLimit();
        $this->checkTimeLimit();
        $this->checkMemoryLimit();
        $this->checkAc();
        $this->setVerdict();
    }

    public function setVerdict()
    {
        $verdictList = [
            'AC'  => [
                'description' => 'Accepted',
            ],
            'WA'  => [
                'description' => 'Wrong Answer',
            ],
            'TLE' => [
                'description' => 'Time Limit Exceeded',
            ],
            'CE'  => [
                'description' => 'Compilation Error',
            ],
            'RTE' => [
                'description' => 'Runtime Error',
            ],
            'OLE' => [
                'description' => 'Output Limit Exceeded',
            ],
            'MLE' => [
                'description' => 'Memory Limit Exceeded',
            ],
            'LE'  => [
                'description' => 'Language Error',
            ],
        ];
        $status                      = response()->status;
        response()->status           = $verdictList[response()->status];
        response()->status['status'] = $status;
    }

    public function checkCompilationError()
    {
        
    }

    public function checkRunTimeError()
    {
        if (isset(response()->status)) {
            return;
        }
        if (trim(response()->compilerMessage) != "") {
            response()->status = "RTE";
        }
        if (preg_match("/[a-z]/i", strtolower(response()->memory))) {
            response()->status = "RTE";
        }
    }

    public function checkOutputLimit()
    {
        if (isset(response()->status)) {
            return;
        }
        $outputFilesize = filesize(ff()->output);
        if ($outputFilesize >= 8000000) {
            response()->status = "OLE";
        }
    }

    public function checkMemoryLimit()
    {
        if (isset(response()->status)) {
            return;
        }

        if (request()->memory_limit < (int) response()->memory) {
            response()->status = "MLE";
        }

    }
    public function checkTimeLimit()
    {
        if (isset(response()->status)) {
            return;
        }
        if (request()->time_limit < response()->time) {
            response()->status = "TLE";
        }
    }

    public function checkAc()
    {
        if (isset(response()->status)) {
            return;
        }
        $checkerData = $this->compareOutput();

        response()->status     = $checkerData['checkerVerdict'] ? "AC" : "WA";
        response()->checkerLog = $checkerData['checkerLog'];
    }

    public function compareOutput()
    {
        File::trim(ff()->output);
        File::trim(ff()->expected_output);
        return $this->checker();
    }

    public function checker()
    {
        $this->createCheckerFile();
        $Checker = new Checker();
        return $Checker->runChecker();
    }

    public function createCheckerFile()
    {
        if (trim(request()->checker) != "") {
            File::create(ff()->checker, request()->checker);
        }
    }
}
