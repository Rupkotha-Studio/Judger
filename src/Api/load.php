<?php
header('Access-Control-Allow-Origin: *');

if (empty($_POST)) {
    echo "Invalid Action";
    return;
}

$includeFileList = [
    'src' => [
        'Helper'  => [
            'FileData',
            'File',
            'RequestService',
            'Error',
            'Response',
            'Request',
            'Lib',
            'Validation',
        ],
        'Api'     => [
            'Api',
        ],
        'Sandbox' => [
            'Checker'  => [
                'Checker',
            ],
            'Verdict'  => [
                'Verdict',
            ],
            'Compiler' => [
                'Compiler',
                'Engin' => [
                    'CompilerEngin',
                    'CPP',
                    'CPP11',
                    'C',
                    'JAVA',
                    'PYTHON2',
                    'PYTHON3',
                ],
            ],
            'Sandbox',
        ],
    ],
];

function includeFile($includeFileData, $path = '')
{
    if (!is_array($includeFileData)) {
        $path = "../" . $path . $includeFileData . ".php";
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
