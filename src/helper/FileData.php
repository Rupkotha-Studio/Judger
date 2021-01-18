<?php

$file = [
    'sourceCode'            => "main.cpp",
    'input'                 => "input.txt",
    'expectedOutput'        => "expected_output.txt",
    'output'                => "output.txt",
    'error'                 => "error.txt",
    'C_executableFile'      => "a.out",
    'compare'               => "compare.txt",
    'cppFile'               => "main.cpp",
    'cFile'                 => "main.c",
    'memory'                => "memory.txt",

    'compiler_message'      => 'compiler_message.txt',

    'cpp_program'              => 'program.cpp',
    'cpp_run'               => 'a.out',

    'c_compile'             => 'program.c',
    'c_run'                 => 'a.out',

    //checker file
    'checker'               => "checker.cpp",
    'checkerError'          => "checker_error.txt",
    'checkerExecutableFile' => "checker.out",
    'checkerLog'            => "checker_log.txt",

];

$GLOBALS['file'] = $file;
