<?php
header('Access-Control-Allow-Origin: *');

if(empty($_POST)){

    echo "Invalid Action";
    return;
}


$includeFileList = [
    'src' => [
        'helper'  => [
            'FileData',
            'File',
            'RequestService',
            'Error',
            'Response',
            'Request',
            'Lib',
            'Validation',
        ],
        'api'     => [
            'api',
        ],
        'sandbox' => [
            'checker'  => [
                'checker',
            ],
            'verdict'  => [
                'verdict',
            ],
            'compiler' => [
                'Compiler',
                'CompilerEngin',
                'Engin' => [
                    'CPP',
                    'CPP11',
                ],
            ],
            'sandbox',
        ],
    ],
];

function includeFile($includeFileData, $path = '')
{
    if (!is_array($includeFileData)) {
        $path = "../".$path . $includeFileData . ".php";
        if (file_exists($path)) {
            include "$path";
        }
        return;
    }
    foreach ($includeFileData as $key => $value) {
        includeFile($value, $path . (is_array($value) ? $key . '/' : ""));
    }
}

includeFile($includeFileList);

$Api = new Api();

