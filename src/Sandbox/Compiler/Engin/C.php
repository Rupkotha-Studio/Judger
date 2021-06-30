<?php

class C extends CompilerEngin
{
    public function __construct()
    {
        File::create(ff()->c_program, request()->source_code);
        $sourceCode     = ff()->c_program;
        $runFile        = ff()->c_run;
        $compileCommand = "gcc -lm {$sourceCode} -o {$runFile}";

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

        $this->run("$runFile");

        if (isset(request()->delete_compile_file)) {
            $deleteCompileFile = (bool) request()->delete_compile_file;
            if ($deleteCompileFile) {
                File::delete("compile_file/" . request()->compile_file);
            }
        }
    }
}
