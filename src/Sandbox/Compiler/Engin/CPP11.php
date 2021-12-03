<?php

class CPP11 extends CompilerEngin
{
    public function __construct()
    {
        File::create(ff()->cpp_program, request()->source_code);
        $sourceCode     = ff()->cpp_program;
        $runFile        = ff()->cpp_run;
        $compileCommand = "g++ --std=c++11 -lm {$sourceCode} -o {$runFile}";

        request()->program_file = $sourceCode;

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

        if(File::has($runFile))response()->compiler_log = "";

        $this->run("./a.out");

        if (isset(request()->delete_compile_file)) {
            $deleteCompileFile = (bool) request()->delete_compile_file;
            if ($deleteCompileFile) {
                File::delete("compile_file/" . request()->compile_file);
            }
        }
    }
}
