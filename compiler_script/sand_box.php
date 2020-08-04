<?php

class SandBox
{

    public $Compiler;
    public $apiData;
    public $compileData;
    public $returnData        = array();
    public $languageError     = 0;
    public $maxOutputFileSize = 8000000;
    protected $file           = array();

    public function __construct($data)
    {
        $this->apiData = $data;
        $this->setCompiler();

        global $file;
        $this->file = $file;

    }

    public function compile()
    {
        if ($this->languageError == 1) {
            $this->returnData['error'] = "language is not support";
            return;
        }

        $this->makeMergeFile();

        $this->Compiler->setData($this->apiData);
        $this->compileData = $this->Compiler->execute();
        $this->processData();
        $this->removeMergeFile();
    }
    public function makeMergeFile()
    {

        exec("mkdir -m 777 -p temp");

        $this->makeFile($this->file['output']);
        $this->makeFile($this->file['input'], $this->apiData['input']);
        $this->makeFile($this->file['expectedOutput'], $this->apiData['expectedOutput']);
        $this->makeFile($this->file['compare']);
    }

    public function makeFile($fileName, $fileVal = "")
    {
        $filePath = $fileName;
        $file     = fopen($filePath, "w+");
        fwrite($file, $fileVal);
        fclose($file);
    }

    public function removeMergeFile()
    {
        exec("rm -R temp");
    }

    public function setCompiler()
    {
        switch ($this->apiData['language']) {
            case "C":
                $this->Compiler = new CPP();
                break;
            case "CPP":
                $this->Compiler = new CPP();
                break;
            case "CPP11":
                $this->Compiler = new CPP();
                break;
            default:
                $this->languageError = 1;
        }
    }

    public function getData()
    {
        return $this->returnData;
    }

    public function compressString($str,$len=100){
        $stringLen = strlen($str);
        if($stringLen<=$len)return $str;
        return substr($str, 0, $len)."...";
    }

    public function processData()
    {
        $compilerMessage                          = $this->compileData['compilerMessage'];
        $status                                   = "";
        $this->compileData['outputLimitExceeded'] = 0;

        if (trim($compilerMessage) != "") {
            if (strpos($compilerMessage, "error")) {
                $status = "CE";
            } else {
                $status = "RTE";
            }

        }

        $outputFilesize = filesize($this->file['output']);

        if ($status == "") {
            if ($outputFilesize >= $this->maxOutputFileSize) {
                $status = "OLE";
            }

        }

        if ($status == "") {
            if ($this->apiData['timeLimit'] < $this->compileData['time']) {
                $status = "TLE";
            }

        }

        if ($status == "") {
            if ($outputFilesize == 0) {
                $status = "RTE";
            }

        }

        $checkerLog = "";

        if ($status == "") {
            $checkerData = $this->compareOutput();
            $status      = $checkerData['checkerVerdict'] ? "AC" : "WA";
            $checkerLog  = $checkerData['checkerLog'];
        }

        $outputVal = file_get_contents($this->file['output']);
        $outputVal = $this->compressString($outputVal,3000);

        $this->returnData['output']           = base64_encode($outputVal);
        $this->returnData['time']             = $this->compileData['time'];
        $this->returnData['memory']           = $this->compileData['memory'];
        $this->returnData['compileMessage']   = base64_encode($this->compileData['compilerMessage']);
        $this->returnData['status']['status'] = $status;
        $this->returnData['checkerLog']       = $checkerLog;
        switch ($status) {
            case "AC":
                $this->returnData['status']['description'] = "Accepted";
                break;
            case "WA":
                $this->returnData['status']['description'] = "Wrong Answer";
                break;
            case "TLE":
                $this->returnData['status']['description'] = "Time Limit Exceeded";
                break;
            case "CE":
                $this->returnData['status']['description'] = "Compilation Error";
                $this->returnData['checkerLog'] = $this->compileData['compilerMessage'];
                break;
            case "RTE":
                $this->returnData['status']['description'] = "Runtime Error";
                $this->returnData['checkerLog'] = $this->compileData['compilerMessage'];
                break;
            case "OLE":
                $this->returnData['status']['description'] = "Output Limit Exceeded";
                break;
            default:
                $this->returnData['status']['description'] = "Internal Error";
        }
    }

    public function trimFile($fileName)
    {
        $ret = shell_exec('perl -pi -e "s/\n$// if(eof)" ' . $fileName . ' && perl -pi -e "s/ $//" ' . $fileName);
        //-perl -pi -e "s/\n$// if(eof)" in.txt && perl -pi -e "s/ $//" output.txt
        //this command for delete last empty line and every line last space
    }

    public function compareOutput()
    {

        $outputFile         = $this->file['output'];
        $expectedOutputFile = $this->file['expectedOutput'];
        $compareFile        = $this->file['compare'];

        $this->trimFile($outputFile);
        $this->trimFile($expectedOutputFile);

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
        $checkerCode = trim($this->apiData['checker']) !=""?$this->apiData['checker']:file_get_contents("lib/checker/lcmp.cpp");
        $this->makeFile($this->file['checker'], $checkerCode);
    }

}
