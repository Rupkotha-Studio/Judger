<?php

/*
|--------------------------------------------------------------------------
| C and CPP File Execute In Linux Terminal
|--------------------------------------------------------------------------
|
| This class compile and run code and return output.
|
| Language: C, CPP, CPP11
|
 */

class CPP
{

    private $compilerName = "g++";
    private $compilerData = array();

    /**
     * A list of the all file name that are use for execution code.
     *
     * @var array
     */
    protected $file = [
        'sourceCodeFileName'     => "main.cpp",
        'inputFileName'          => "input.txt",
        'expectedOutputFileName' => "expected_output.txt",
        'outputFileName'         => "output.txt",
        'errorFileName'          => "error.txt",
        'executableFile'         => "a.out",
    ];

    /**
     * Process Result Array.
     *
     * @var array
     */
    protected $processResultData = [
        'time'   => 0,
        'memory' => 0,
    ];

    /**
     * Set code data and compiler
     *
     * @param array $compilerData
     *
     * @return void
     */
    public function setData($compilerData)
    {

        /*
        |--------------------------------------------------------------------------
        | Compiler Data Key List
        |--------------------------------------------------------------------------
        |
        | sourceCode, input, expectedOutput, timeLimit, language
        |
         */

        $this->compilerData = $compilerData;
        $this->setCompiler();

    }

    /**
     * Define compiler prefix command and source code file name
     *
     * @return void
     */
    public function setCompiler()
    {

        /*
        |--------------------------------------------------------------------------
        | Compiler prefix linux command
        |--------------------------------------------------------------------------
        |
        | Here the prefix command of all compiler.This command use for compiler code in linux environment.
        |
        | C     : gcc
        | C++   : g++
        | C++11 : g++ --std=c++11
        |
         */

        $languageName = $this->compilerData['language'];

        if ($languageName == "CPP11") {
            $this->compilerName = "g++ --std=c++11";
        }
        if ($languageName == "C") {
            $this->compilerName               = "gcc";
            $this->file['sourceCodeFileName'] = "main.c";
        }
    }

    /**
     * Execute code step by step
     *
     * @return array
     */
    public function execute()
    {
        $this->prepareFile();
        $this->setPermissionFile();

        $compileSuccess = $this->compileCode();
        if ($compileSuccess) {
            $this->runCode();
        }

        $this->removeAllProcessFile();
        return $this->processResultData;
    }

    /**
     * Prepare Source Code File and Error File
     *
     * @return array
     */
    public function prepareFile()
    {
        $this->makeFile($this->file['sourceCodeFileName'], $this->compilerData['sourceCode']);
        $this->makeFile($this->file['errorFileName']);
    }

    /**
     * Set file read write permission
     *
     * @return array
     */
    public function setPermissionFile()
    {
        exec("chmod -R 777 " . $this->file['sourceCodeFileName']);
        exec("chmod 777 " . $this->file['errorFileName']);
        exec("chmod -R 777 " . $this->file['executableFile']);
    }

    /**
     * Compiler Code
     *
     * @return bool
     */
    public function compileCode()
    {
        /*
        |--------------------------------------------------------------------------
        | Compile Command
        |--------------------------------------------------------------------------
        |
        | This is compiler code in linux environment.
        |
        | Command Structure: compilerPrefix -lm fileName 2> errorFileName
        |
        | C     : gcc -lm fileName.c 2> errorFileName
        | C++   : g++ -lm fileName.cpp 2> errorFileName
        | C++11 : g++ --std=c++11 -lm fileName.cpp 2> errorFileName
        |
         */

        $compilerName = $this->compilerName;
        $sourceFile   = $this->file['sourceCodeFileName'];
        $errorFile    = $this->file['errorFileName'];

        $compileCmd = "$compilerName -lm $sourceFile 2> $errorFile";

        shell_exec($compileCmd);

        $this->processResultData['compilerMessage'] = file_get_contents($this->file['errorFileName']);

        return trim($this->processResultData['compilerMessage']) == "";
    }

    /**
     * Run code when compile passed
     *
     * @return void
     */
    public function runCode()
    {
        /*
        |--------------------------------------------------------------------------
        | Run executableFile
        |--------------------------------------------------------------------------
        |
        | This is executableFile run function. We set timeout time. This timeout
        | time increase 0.1 second then code time out time. Make command look like.
        |
        | Command: timeout 2s ./a.out < inputFileName | head -c 5000000 > outputFileName
        |
        | [head means maximum output file size 5000000 if code is infinite write but
        | output not write infinite]
        |
         */

        $timeOut = $this->compilerData['timeLimit'] + 0.1;
        $runCmd  = "timeout " . $timeOut . "s ./a.out";
        $runCmd .= " < " . $this->file['inputFileName'] . " | head -c 5000000 > " . $this->file['outputFileName'];

        $executionStartTime = microtime(true);
        shell_exec($runCmd);
        $executionEndTime = microtime(true);

        $executionTotalTime              = sprintf('%0.3f', $executionEndTime - $executionStartTime);
        $this->processResultData['time'] = $executionTotalTime;
    }

    /**
     * Make File
     *
     * @return void
     */
    public function makeFile($fileName, $fileVal = "")
    {
        $file = fopen($fileName, "w+");
        fwrite($file, $fileVal);
        fclose($file);
    }

    /**
     * Remove all process file
     *
     * @return void
     */
    public function removeAllProcessFile()
    {
        exec("rm " . $this->file['sourceCodeFileName']);
        exec("rm *.o");
        exec("rm " . $this->file['errorFileName']);
        exec("rm " . $this->file['executableFile']);
    }

}
