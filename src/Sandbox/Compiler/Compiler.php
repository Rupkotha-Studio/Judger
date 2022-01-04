<?php

class Compiler
{
    private $compilerList = [
        'C', 'CPP', 'CS', 'CPP11', 'CPP14','CPP17','JAVA', 'PYTHON2', 'PYTHON3',
    ];
    public function __construct()
    {
        $language = strtoupper(request()->language);

        if (in_array($language, $this->compilerList)) {
            $this->processFile();
            new $language();
        } else {
            response()->status = "LR";
        }
    }

    public function processFile()
    {
        $this->createInputFile();
        $this->createSourceFile();
    }

    public function createSourceFile()
    {
        $fileExtensions = [
            'C'       => 'c',
            'CPP11'   => 'cpp',
            'CPP14'   => 'cpp',
            'CPP17'   => 'cpp',
            'CS'      => 'cs',
            'JAVA'    => 'java',
            'PYTHON2' => 'py',
            'PYTHON3' => 'py',
        ];
        $language       = strtoupper(request()->language);
        $extension      = $fileExtensions[$language];
        request()->source_file_name = "program.{$extension}";

        File::create(request()->source_file_name, request()->source_code);  
    }

    public function createInputFile()
    {
        File::create(ff()->input, request()->input);
    }
}
