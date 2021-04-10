<?php
/**
 *
 */
class Checker
{
    public function __construct()
    {
        if (request()->api_type == 'checker') {
            $this->buildChecker();
        }
    }
    public function buildChecker()
    {
        $this->createCheckerFile();
        $checkerData = $this->runChecker();
        $this->removeMergeFile();
        response()->checkerLog     = $checkerData['checkerLog'];
        response()->checkerVerdict = $checkerData['checkerVerdict'];
        response()->checkerError   = $checkerData['checkerError'];
    }

    public function createCheckerFile()
    {
        exec("mkdir -m 777 -p temp");
        File::create(ff()->input, request()->input);
        File::create(ff()->output, request()->output);
        File::create(ff()->expected_output, request()->expected_output);
        File::create(ff()->checker, request()->checker);
    }

    public function removeMergeFile()
    {
        exec("rm -R temp");
    }

    public function runChecker()
    {
        return !file_exists(ff()->checker) ? $this->runNormalChecker() : $this->runSpjChecker();
    }

    public function runNormalChecker()
    {
        $this->createNormalCheckerScript();
        $checkerLogFile     = ff()->checker_log;
        $outputFile         = ff()->output;
        $expectedOutputFile = ff()->expected_output;
        $compareFile        = ff()->compare;
        $checkerFile        = ff()->bash_checker;
        $input          = ff()->input;

        $cmd                = "./temp/checker {$input} {$outputFile} {$expectedOutputFile} 2> $checkerLogFile";
        
        shell_exec($cmd);
        $checkerLog = file_get_contents($checkerLogFile);
        return [
            'checkerLog'     => $checkerLog,
            'checkerVerdict' => $this->getCheckerVerdict($checkerLog),
            'checkerError'   => "",
        ];
    }

    public function runSpjChecker()
    {
        $this->createTestLib();

        $checkerFileName       = ff()->checker;
        $checkerErrorFile      = ff()->checker_error;
        $checkerExecutableFile = ff()->checker_executable_file;

        $cmd = "g++ --std=c++11 -lm $checkerFileName -o $checkerExecutableFile 2> $checkerErrorFile";
        shell_exec($cmd);
        $checkerError = file_get_contents($checkerErrorFile);

        $ckeckerLog = "";

        if (trim($checkerError) == "") {

            $checkerLogFile = ff()->checker_log;

            $input          = ff()->input;
            $output         = ff()->output;
            $expectedOutput = ff()->expected_output;

            $cmd = "timeout 1s ./$checkerExecutableFile $input $output $expectedOutput 2> $checkerLogFile";
            shell_exec($cmd);
            $checkerLog = file_get_contents($checkerLogFile);
        } else {
            $checkerLog = "checker is not valid";
        }

        return [
            'checkerLog'     => $checkerLog,
            'checkerVerdict' => $this->getCheckerVerdict($checkerLog),
            'checkerError'   => $checkerError,
        ];
    }

    public function createTestLib()
    {
        shell_exec("cp ../src/Sandbox/Checker/Lib/testlib/testlib.h temp");
    }

    public function createNormalCheckerScript()
    {
        shell_exec("cp ../src/Sandbox/Checker/Lib/testlib/default_checker/checker temp");
    }
    public function getCheckerVerdict($checkerLog)
    {
        if (strlen($checkerLog) < 2) {
            return 0;
        }

        $ok = substr($checkerLog, 0, 2);
        return $ok == "ok" ? 1 : 0;
    }
}
