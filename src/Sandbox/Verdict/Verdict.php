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
        if (strtoupper(request()->language) == "JAVA") {
            //in java program the error area always show error: compilation failed if compiled failed
            if (preg_match("/[a-z]/i", strtolower(response()->memory))) {
                $errors = explode("\n", response()->memory);
                foreach ($errors as $key => $value) {
                    if($value == "error: compilation failed"){
                        response()->compiler_log = response()->memory;
                        response()->status = "CE";
                        break;
                    }
                }
            }
        }
    }

    public function checkRunTimeError()
    {
        if (isset(response()->status)) {
            return;
        }
        if (trim(response()->compiler_log) != "") {
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
