<?php
class Api
{

    public $apiId;
    public $busyFileName = "busy";
    public $apiData      = array();
    public $apiError     = array();
    public $processData  = array();
    public $responseData = array();
    public $returnData;
    public $apiStartTime;
    public $createBusyFlag = 0;

    public function __construct($data)
    {
        $this->apiId        = rand();
        $this->apiData      = $data;
        $this->apiStartTime = microtime(true);
    }

    public function response()
    {
        $this->checkBusy();
        $this->createBusy();

        $apiType = isset($this->apiData['apiType']) ? $this->apiData['apiType'] : "";

        if ($apiType == "compile") {
            $this->sandBox();
        } else if ($apiType == "checker") {
            $this->checker();
        }

        $this->processReturnData();
        $this->removeBusy();
        return $this->returnData;
    }

    //busy file

    public function checkBusy()
    {
        if (file_exists($this->busyFileName)) {
            array_push($this->apiError, "Compiler Already Busy Another Process");
        }

    }

    public function createBusy()
    {
        if (!empty($this->apiError)) {
            return;
        }

        $this->createBusyFlag = 1;
        $file                 = fopen($this->busyFileName, "w+");
        fwrite($file, $this->apiId);
        fclose($file);
        exec("chmod -R 777" . $this->busyFileName);
    }

    public function removeBusy()
    {
        if (!$this->createBusyFlag) {
            return;
        }

        exec("rm " . $this->busyFileName);
    }

    //==================

    public function sandBox()
    {
        $this->checkSandBoxParameter();
        $this->processSandBoxData();
        $this->sendSandBox();

    }

    public function checkSandBoxParameter()
    {
        if (!empty($this->apiError)) {
            return;
        }

        if (!isset($this->apiData['sourceCode'])) {
            array_push($this->apiError, "Source Code Can Not Be Empty");
        } else if (!isset($this->apiData['language'])) {
            array_push($this->apiError, "Language Not Selected");
        } else if (!isset($this->apiData['expectedOutput'])) {
            array_push($this->apiError, "Expected Output Is Empty");
        }

    }

    public function processSandBoxData()
    {
        if (!empty($this->apiError)) {
            return;
        }

        $data                   = array();
        $data['sourceCode']     = base64_decode($this->apiData['sourceCode']);
        $data['input']          = isset($this->apiData['input']) ? base64_decode($this->apiData['input']) : "";
        $data['expectedOutput'] = base64_decode($this->apiData['expectedOutput']);
        $data['timeLimit']      = isset($this->apiData['timeLimit']) ? $this->apiData['timeLimit'] : 2;
        $data['language']       = $this->apiData['language'];
        $data['timeLimit']      = min($data['timeLimit'], 10);
        $data['checker']        = isset($this->apiData['checker']) ? $this->apiData['checker'] : "";
        $data['checker']        = base64_decode($data['checker']);
        $this->processData      = $data;

    }

    public function sendSandBox()
    {
        if (!empty($this->apiError)) {
            return;
        }

        $SandBox = new SandBox($this->processData);
        $SandBox->compile();

        $this->responseData = $SandBox->getData();
    }

    //===================

    //start checker

    public function checker()
    {
        $this->processCheckerData();
        $this->sendChecker();
    }

    public function sendChecker(){
        if (!empty($this->apiError)) {
            return;
        }

    	$Checker = new Checker();
        $this->responseData = $Checker->buildChecker($this->processData);
    }

    public function processCheckerData()
    {
        if (!empty($this->apiError)) {
            return;
        }

        $data = array();

        $data['input']          = isset($this->apiData['input']) ? base64_decode($this->apiData['input']) : "";
        $data['expectedOutput'] = isset($this->apiData['expectedOutput']) ? base64_decode($this->apiData['expectedOutput']) : "";

        $data['output']    = isset($this->apiData['output']) ? base64_decode($this->apiData['output']) : "";
        $data['checker']   = isset($this->apiData['checker']) ? $this->apiData['checker'] : "";
        $data['checker']   = base64_decode($data['checker']);
        $this->processData = $data;

    }

    public function processReturnData()
    {
        $apiCallEndTime = microtime(true);
        $apiCallTime    = $apiCallEndTime - $this->apiStartTime;

        $this->returnData['apiCallTime'] = sprintf('%0.3f', $apiCallTime);
        if (!empty($this->apiError)) {
            $this->returnData['error'] = implode('.', $this->apiError);
        } else {
            $this->returnData = $this->responseData;
        }

        $this->returnData = json_encode($this->returnData);
    }

}
