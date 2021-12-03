<?php

class Verdict
{

    public function __construct()
    {
        $this->checkCompilationError();
        $this->checkOutputLimit();
        $this->checkTimeLimit();
        $this->checkMemoryLimit();
        $this->checkRunTimeError();
        $this->checkAc();
        $this->setVerdict();
    }

    public function setVerdict()
    {
        $verdictList = [
            'AC'  => [
                'id'          => 3,
                'description' => 'Accepted',
            ],
            'WA'  => [
                'id'          => 4,
                'description' => 'Wrong Answer',
            ],
            'TLE' => [
                'id'          => 5,
                'description' => 'Time Limit Exceeded',
            ],
            'CE'  => [
                'id'          => 6,
                'description' => 'Compilation Error',
            ],
            'RTE' => [
                'id'          => 7,
                'description' => 'Runtime Error',
            ],
            'MLE' => [
                'id'          => 8,
                'description' => 'Memory Limit Exceeded',
            ],
            'OLE' => [
                'id'          => 10,
                'description' => 'Output Limit Exceeded',
            ],
            'LR'  => [
                'id'          => 11,
                'description' => 'Language Restricted',
            ],
            'IE'  => [
                'id'          => 12,
                'description' => 'Internal Error',
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

        if(response()->exitCode == 1){
            response()->status       = "RTE";
            response()->compiler_log = File::read(ff()->error);
        }
    }

    public function checkOutputLimit()
    {
        if (isset(response()->status)) {
            return;
        }
        $outputFilesize = filesize(ff()->output);
        if ($outputFilesize >= 30000000) {
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
        File::create(ff()->expected_output, request()->expected_output);
        File::create(ff()->compare);
        
        if (isset(response()->status)) {
            return;
        }
        $checkerData = $this->compareOutput();

        if ($checkerData['checkerVerdict'] == -1) {
            response()->status = "IE";
        } else {
            response()->status = $checkerData['checkerVerdict'] ? "AC" : "WA";
        }
        response()->checker_log = $checkerData['checkerLog'];
    }

    public function compareOutput()
    {
        return $this->checker();
    }

    public function checker()
    {
        $Checker = new Checker();
        return $Checker->runChecker();
    }

}
