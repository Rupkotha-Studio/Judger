<?php

$file = [
    'input'                   => "input",
    'expected_output'         => "expected_output.txt",
    'output'                  => "output",
    'error'                   => "error",
    'meta'                    => "meta",
    'compare'                 => "compare.txt",
    'memory'                  => "memory.txt",
    'busy'                    => "busy",

    'compiler_message'        => 'compiler_message.txt',

    'cpp_program'             => 'program.cpp',
    'cpp_run'                 => 'a.out',

    'java_program'            => 'program.java',

    'python_program'          => 'program.py',

    'c_program'               => 'program.c',
    'c_run'                   => 'a.out',

    'cs_program'              => 'program.cs',
    'cs_run'                  => 'out.exe',

    //checker file
    'checker'                 => "checker.cpp",
    'checker_error'           => "checker_error.txt",
    'checker_executable_file' => "checker.out",
    'checker_log'             => "checker_log.txt",
    'bash_checker'            => 'checker.sh',

];

$GLOBALS['file'] = $file;
