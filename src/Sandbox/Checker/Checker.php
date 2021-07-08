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

    }

    public function removeMergeFile()
    {
        exec("rm -R temp");
    }

    public function runChecker()
    {

        if (request()->checker_type == "custom") {
            File::create(ff()->checker, request()->custom_checker);
            //compile checker file

            $hasCompileFile = false;
            if (isset(request()->checker_compile_file)) {
                if (File::has("compile_file/" . request()->checker_compile_file)) {
                    $hasCompileFile = true;
                }
            }
            $checkerCompilerLog = "";
            if (!$hasCompileFile) {
                $checkerCompilerLog = $this->compileCheckerFile();
                if (isset(request()->checker_compile_file)) {
                    File::copy(ff()->checker_executable_file, "compile_file/" . request()->checker_compile_file);
                }
            } else {
                if (request()->checker_compile_file) {
                    File::copy("compile_file/" . request()->checker_compile_file, ff()->checker_executable_file);
                }
            }

            $retData = [
                'checkerLog'     => "Checker is not valid",
                'checkerVerdict' => -1,
                'checkerError'   => $checkerCompilerLog,
            ];

            if ($checkerCompilerLog == "") {
                $retData = $this->runCheckerFile();
            }
            if (isset(request()->delete_checker_compile_file)) {
                $deleteCompileFile = (bool) request()->delete_checker_compile_file;
                if ($deleteCompileFile) {
                    File::delete("compile_file/" . request()->checker_compile_file);
                }
            }

            return $retData;
        } else {
            $dafaultCheckersList = [
                'lcmp', 'yesno','fcmp','rcmp4','rcmp6','rcmp9',
            ];
            $checkerPos = array_search(request()->default_checker, $dafaultCheckersList);
            $checkerPos = $checkerPos ? $checkerPos : 0;
            $checker    = $dafaultCheckersList[$checkerPos];
            File::copy("../src/Sandbox/Checker/Lib/testlib/default_checker/{$checker}", ff()->checker_executable_file);
            return $this->runCheckerFile();
        }
    }

    public function compileCheckerFile()
    {
        $this->createTestLib();
        $checkerFileName       = ff()->checker;
        $checkerErrorFile      = ff()->checker_error;
        $checkerExecutableFile = ff()->checker_executable_file;

        $cmd = "g++ --std=c++11 -lm $checkerFileName -o $checkerExecutableFile 2> $checkerErrorFile";
        shell_exec($cmd);
        $checkerCompileLog = file_get_contents($checkerErrorFile);

        return trim($checkerCompileLog);
    }

    public function runCheckerFile()
    {
        $checkerLogFile        = ff()->checker_log;
        $outputFile            = ff()->output;
        $expectedOutputFile    = ff()->expected_output;
        $compareFile           = ff()->compare;
        $checkerFile           = ff()->bash_checker;
        $input                 = ff()->input;
        $checkerExecutableFile = ff()->checker_executable_file;

        $cmd = "timeout 1s ./{$checkerExecutableFile} {$input} {$outputFile} {$expectedOutputFile} 2> $checkerLogFile";
        shell_exec($cmd);
        $checkerLog = file_get_contents($checkerLogFile);

        return [
            'checkerLog'     => $checkerLog,
            'checkerVerdict' => $this->getCheckerVerdict($checkerLog),
            'checkerError'   => "",
        ];
    }

    public function createTestLib()
    {
        shell_exec("cp ../src/Sandbox/Checker/Lib/testlib/testlib.h temp");
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
