<?php
	class CompilerEnjin{
		
		public $Compiler;
		public $apiData;
		public $compileData;
		public $returnData = array();
		public $languageError = 0;

		function __construct($data){
			$this->apiData = $data;
			$this->setCompiler();
		}
		
		public function setCompiler(){
			switch ($this->apiData['language']) {
  				//case "C":
    			//	$this->Compiler = new C();
    			//	break;
  				case "CPP":
    				$this->Compiler = new CPP();
    				break;
  				//case "CPP11":
   			 	//	$this->Compiler = new CPP11();
   			 	//	break;
   			 	//case "JAVA":
   			 	//	$this->Compiler = new JAVA();
   			 	//	break;	
  				default:
   			 		$this->languageError = 1;
			}
		}

		public function compile(){
			if($this->languageError == 1){
				$this->returnData['error'] = "language is not support";
				return;
			}
			$this->Compiler->setData($this->apiData);
			$this->compileData = $this->Compiler->execute();
			$this->processData();
		}

		public function getData(){
			return $this->returnData;
		}

		public function processData(){
			$compilerMessage = $this->compileData['compilerMessage'];
			$status = "";
			if(trim($compilerMessage)!=""){
				if(strpos($compilerMessage,"error"))$status = "CE";
				else $status = "RTE";
			}
			if($status == ""){
				if($this->compileData['outputLimitExceeded'])$status = "OLE";
			}
			if($status == ""){
				if($this->compileData['timeLimit'] < $this->compileData['time'])$status="TLE";
			}
			
			if($status == ""){
				if(trim($this->compileData['output']) == "")$status="RTE";
			}
			
			
			if($status == ""){
				$status = $this->compareOutput()?"AC":"WA";
			}

			$this->returnData['output'] = base64_encode($this->compileData['output']);
			$this->returnData['time'] = $this->compileData['time'];
			$this->returnData['memory'] = $this->compileData['memory'];
			$this->returnData['compileMessage'] = base64_encode($this->compileData['compilerMessage']);
			$this->returnData['status']['status'] = $status;
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
    				break;	
    			case "RTE":
    				$this->returnData['status']['description'] = "Runtime Error";
    				break;
    			case "OLE":
    				$this->returnData['status']['description'] = "Output Limit Exceeded";
    				break;		
  				default:
   			 		$this->returnData['status']['description'] = "Internal Error";
			}
		}

		public function compareOutput(){
			$output = $this->compileData['output'];
			$exOutput = $this->compileData['expectedOutput'];

			$output = $this->processString($output,"\n");
			$exOutput = $this->processString($exOutput,"\n");

			$outputLst = explode("\n", $output);
			$exOutputLst = explode("\n", $exOutput);

			foreach ($outputLst as $key => $value) {
				$outputLst[$key]=$this->processString($value);
			}

			foreach ($exOutputLst as $key => $value) {
				$exOutputLst[$key]=$this->processString($value);
			}

			return $outputLst==$exOutputLst;
		}

		public function processString($st,$char=" "){
			$lstChar = substr($st, -1);
			if($lstChar==$char)return $this->removeLastChar($st);
			return $st;
		}

		public function removeLastChar($st){
			return substr($st, 0, -1);
		}



		

	}


?>
