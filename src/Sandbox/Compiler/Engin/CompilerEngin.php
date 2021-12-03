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

        $input     = ff()->input;
        $memory    = ff()->memory;
        $output    = ff()->output;
        $timeLimit = request()->time_limit;

        $cmd = "bash run.sh {$timeLimit} {$cmd}";
        echo shell_exec($cmd);

        $metaData = $this->getMetaData();

        response()->memory = $metaData['max-rss'];
        response()->time   = $metaData['time'];
        /*
        - if divide by 0 then not get exit code and this time provide run time
        */
        response()->exitCode = isset($metaData['exitcode'])? $metaData['exitcode'] : 1;
    }
    
    public function getMetaData()
    {
        $meta = File::read(ff()->meta);
        $meta     = explode(PHP_EOL, $meta);
        $metaData = [];
        foreach ($meta as $key => $value) {
            $tmpMeta = explode(':', $value);
            if (empty($tmpMeta[0])) {
                continue;
            }

            $metaData[$tmpMeta[0]] = $tmpMeta[1];
        }

        return $metaData;
    }
}
