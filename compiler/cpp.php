<?php
	class CPP{
		
		public $compilerName = "g++";
		public $sourceCodeFileName = "main.cpp";
		public $inputFileName = "input.txt";
		public $expectedOutputFileName = "expected_output.txt";
		public $outputFileName = "output.txt";
		public $errorFileName = "error.txt";
		public $executableFile = "a.out";
		
		public $compileCommand;	
		public $commandError;

		public $sourceCode;
		public $out;

		public $executionTotalTime = 0;

		public $compailerError = 0;
		public $runTimeError = 0;

		public $processResultData = array();

		function __construct(){
			
		}

		public function setData($data){
			
			$this->sourceCode = $data['sourceCode'];
			
			$this->setCompiler($data['language']);
			//g++ -lm main.cpp
			$this->compileCommand = $this->compilerName." -lm ".$this->sourceCodeFileName;

			//g++ -lm main.cpp 2> error.txt
			$this->commandError=$this->compileCommand." 2>".$this->errorFileName;

			$maximumTime = $data['timeLimit'] + 0.3;
			$this->out = "timeout ".$maximumTime."s ./a.out";
		}

		public function setCompiler($languageName){

			if($languageName == "CPP11"){
				//g++ --std=c++11 c++14.cpp
				$this->compilerName = "g++ --std=c++11";
			}
			if($languageName == "C"){
				//gcc main.c
				$this->compilerName = "gcc";
				$this->sourceCodeFileName = "main.c";
			}
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
		}

		public function runCode(){
			if(trim($this->processResultData['compilerMessage'])!="")return;
			//head means maximum output file size 5000000 if code is infinite write but output not write infinite
			$out = $this->out." < ".$this->inputFileName." | head -c 5000000 > ".$this->outputFileName;
			
			$executionStartTime = microtime(true);
			shell_exec($out);
			$executionEndTime = microtime(true);

			$this->executionTotalTime = sprintf('%0.3f', $executionEndTime - $executionStartTime);
		}


		public function makeProcessData(){
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
