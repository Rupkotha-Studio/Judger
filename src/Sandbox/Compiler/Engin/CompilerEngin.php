<?php

class CompilerEngin
{

    public function compile($cmd = null)
    {
        shell_exec("{$cmd} 2> " . ff()->compiler_message);
        response()->compiler_log = trim(File::read(ff()->compiler_message));
        
        File::delete(ff()->compiler_message);
    }

    public function run($cmd = null)
    {
        if (response()->compiler_log != "") {
            response()->status = 'CE';
            return;
        }

        $input   = ff()->input;
        $memory  = ff()->memory;
        $output  = ff()->output;
        $timeout = request()->time_limit + 0.1;

        $cmd = "timeout {$timeout}s /usr/bin/time -f '%M' {$cmd} < {$input} 2> {$memory} | head -c 20000000 > {$output}";

        $start = microtime(true);
        shell_exec($cmd);
        $end = microtime(true);

        response()->memory = File::read(ff()->memory);
        response()->time   = sprintf('%0.3f', $end - $start);
    }
}
