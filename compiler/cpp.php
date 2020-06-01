<?php
	class CPP{
		
		var $compilerName = "g++";
		var $sourceCodeFileName = "main.cpp";
		var $inputFileName = "input.txt";
		var $expectedOutputFileName = "expected_output.txt";
		var $outputFileName = "output.txt";
		var $errorFileName = "error.txt";

		var $executableFile;
		var $compileCommand;	
		var $commandError;

		var $sourceCode;
		var $input;
		var $expectedOutput;
		var $output;
		var $timeLimit;
		var $out;

		
		var $executionStartTime = 0;
		var $executionEndTime = 0;
		var $executionTotalTime = 0;

		var $compailerError = 0;
		var $runTimeError = 0;

		var $processResultData = array();

		function __construct(){
			

		}

		public function setData($data){
			$this->sourceCode = $data['sourceCode'];
			$this->input = $data['input'];
			$this->expectedOutput = $data['expectedOutput'];
			$this->timeLimit = $data['timeLimit'];
			$exeTimeLimit = $this->timeLimit + 0.3;
			$this->out = "timeout ".$exeTimeLimit."s ./a.out";

			$this->executableFile = "a.out";
			$this->compileCommand = $this->compilerName." -lm ".$this->sourceCodeFileName;//g++ -lm main.cpp	
			$this->commandError=$this->compileCommand." 2>".$this->errorFileName;//g++ -lm main.cpp 2> error.txt
		}

		public function execute(){
			$this->prepareFile();
			$this->setPermissionFile();
			$this->compileCode();
			
			
			//$debugStartTime = microtime(true);
			$this->checkCompailerError();
			
			//$debugEndTime = microtime(true);
			//$totalDebugTime = sprintf('%0.3f', $debugEndTime-$debugStartTime);
			//echo "$totalDebugTime";
			
			$this->runCode();
			$this->makeProcessData();
			
			$this->removeAllProcessFile();


			

			return $this->processResultData;
		}

		public function prepareFile(){
			$this->makeFile($this->sourceCodeFileName,$this->sourceCode);
			$this->makeFile($this->errorFileName);
		}

		

		public function compileCode(){
			shell_exec($this->commandError);
		}

		public function checkCompailerError(){
			$error=file_get_contents($this->errorFileName);
			$this->processResultData['compilerMessage'] = $error;
			if(trim($error)!=""){
				if(strpos($error,"error"))$this->compailerError = 1;
				else $this->runTimeError = 1;
			}
		}

		public function runCode(){
			if($this->compailerError==1)return;
			$out = $this->out." < ".$this->inputFileName." | head -c 5000000 > ".$this->outputFileName;
			$this->executionStartTime = microtime(true);
			shell_exec($out);
			$this->executionEndTime = microtime(true);
			$this->executionTotalTime = $this->executionEndTime - $this->executionStartTime;
			$this->executionTotalTime = sprintf('%0.3f', $this->executionTotalTime);
		}


		public function makeProcessData(){
			//$len = $this->compailerError==1?0:filesize("output.txt");
			//$this->processResultData['output'] = $len<=1000000?$this->output:"";
			$this->processResultData['time'] = $this->executionTotalTime;
			$this->processResultData['memory'] = 0;
		}


		public function makeFile($fileName,$fileVal=""){
			$file=fopen($fileName,"w+");
			fwrite($file,$fileVal);
			fclose($file);
		}

		public function setPermissionFile(){
			exec("chmod -R 777 ".$this->sourceCodeFileName);  
			exec("chmod 777 ".$this->errorFileName);
			exec("chmod -R 777 ".$this->executableFile);
		}

		public function removeAllProcessFile(){
			exec("rm ".$this->sourceCodeFileName);
			exec("rm *.o");
			exec("rm ".$this->errorFileName);
			exec("rm ".$this->executableFile);
		}

	}


?>
