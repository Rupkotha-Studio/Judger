<?php
	class SandBox{
		
		public $Compiler;
		public $apiData;
		public $compileData;
		public $returnData = array();
		public $languageError = 0;
		public $maxOutputFileSize = 5000000;

		function __construct($data){
			$this->apiData = $data;
			$this->setCompiler();
		}

		function makeMergeFile(){
			$this->makeFile("output.txt");
			$this->makeFile("input.txt",$this->apiData['input']);
			$this->makeFile("expectedOutput.txt",$this->apiData['expectedOutput']);
			$this->makeFile("compare.txt");
		}

		public function makeFile($fileName,$fileVal=""){
			$filePath = $fileName;
			$file=fopen($filePath,"w+");
			fwrite($file,$fileVal);
			fclose($file);
			$this->setPermissionFile($filePath);
		}

		public function setPermissionFile($fileName){
			exec("chmod -R 777".$fileName);
		}


		public function removeMergeFile(){
			exec("rm *.txt");
		}
		
		public function setCompiler(){
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

			$this->makeMergeFile();
			$this->Compiler->setData($this->apiData);
			$this->compileData = $this->Compiler->execute();
			$this->processData();
			$this->removeMergeFile();
		}

		public function getData(){
			return $this->returnData;
		}

		public function processData(){
			$compilerMessage = $this->compileData['compilerMessage'];
			$status = "";
			$this->compileData['outputLimitExceeded'] = 0;
			
			if(trim($compilerMessage)!=""){
				if(strpos($compilerMessage,"error"))$status = "CE";
				else $status = "RTE";
			}

			$outputFilesize = filesize("output.txt");

			if($status == ""){
				if($outputFilesize>=$this->maxOutputFileSize)$status = "OLE";
			}
			
			if($status == ""){
				if($this->apiData['timeLimit'] < $this->compileData['time'])$status="TLE";
			}
			
			if($status == ""){
				if($outputFilesize == 0)$status="RTE";
			}
				
			if($status == ""){
				$status = $this->compareOutput()?"AC":"WA";
			}

			$outputVal = ($outputFilesize>3000)?"Output Is Large":file_get_contents("output.txt");

			$this->returnData['output'] =base64_encode($outputVal);
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
			
			$this->trimFile("output.txt");
			$this->trimFile("expectedOutput.txt");
			shell_exec("diff output.txt expectedOutput.txt > compare.txt");
			$compareFilesize = filesize("compare.txt");
			return $compareFilesize>0?0:1;
		}

		public function trimFile($fileName){
			$ret = shell_exec('perl -pi -e "s/\n$// if(eof)" '.$fileName.' && perl -pi -e "s/ $//" '.$fileName);
			//-perl -pi -e "s/\n$// if(eof)" in.txt && perl -pi -e "s/ $//" output.txt
			//this command for delete last empty line and every line last space

		}



		

	}


?>
