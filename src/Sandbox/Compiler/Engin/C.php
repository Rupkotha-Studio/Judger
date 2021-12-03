<?php

class C extends CompilerEngin
{
    protected $sourceFile = "temp/program.c";
    protected $binaryFile = "a.out";

    /*
    - create source file
     */
    public function createFile()
    {
        File::create($this->sourceFile, request()->source_code);
    }

    /*
    -
     */
    public function compileFile()
    {
        $compileCommand = "gcc -lm {$this->sourceFile}";
    }

    public function saveCompileFile()
    {
        if (isset(request()->compile_file)) {
            File::copy($runFile, "compile_file/" . request()->compile_file);
        }
    }

    public function deleteCompileFile()
    {
        if (isset(request()->delete_compile_file)) {
            $deleteCompileFile = (bool) request()->delete_compile_file;
            if ($deleteCompileFile) {
                File::delete("compile_file/" . request()->compile_file);
            }
        }
    }

    public function __construct()
    {
        $this->compileCmd = "gcc -lm {$this->sourceFile}";
        $this->runCmd     = "./a.out";

        //create file
        //has compile file
        /*
        if present then copy compile file
        else compile
         */
        //run compile file

        //resave or delete compile file

        $this->createFile();

        //File::create(ff()->c_program, request()->source_code);
        $sourceCode     = ff()->c_program;
        $runFile        = ff()->c_run;
        $compileCommand = "gcc -lm {$sourceCode} -o {$runFile}";

        //request()->program_file = $sourceCode;

        $hasCompileFile = false;
        if (isset(request()->compile_file)) {
            if (File::has("compile_file/" . request()->compile_file)) {
                $hasCompileFile = true;
            }
        }

        if (!$hasCompileFile) {
            $this->compile($compileCommand);
            if (isset(request()->compile_file)) {
                File::copy($runFile, "compile_file/" . request()->compile_file);
            }
        } else {
            if (request()->compile_file) {
                File::copy("compile_file/" . request()->compile_file, $runFile);
            }
        }

        response()->compiler_log = File::has($runFile) ? "" : response()->compiler_log;
        
        $this->run($this->runCmd);

        $this->deleteCompileFile();
    }
}
