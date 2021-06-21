<?php

class CPP extends CompilerEngin
{
    public function __construct()
    {
        File::create(ff()->cpp_program, request()->source_code);
        $sourceCode     = ff()->cpp_program;
        $runFile        = ff()->cpp_run;
        $compileCommand = "g++ -lm {$sourceCode} -o {$runFile}";

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

        $this->run("$runFile");
        
        if (isset(request()->delete_compile_file)) {
            $deleteCompileFile = (bool) request()->delete_compile_file;
            if ($deleteCompileFile) {
                File::delete("compile_file/" . request()->compile_file);
            }
        }
    }
}
