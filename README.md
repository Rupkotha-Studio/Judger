# Judger
[![Judger Wallpaper](https://github.com/Coder-O-J/Judger/blob/master/public/file/editor.png?raw=true)](https://judger.coderoj.com)
## Introduction
CoderOJ Judeger is a linux based high performance programming problem solution judger that support multiple languages and special judge.
## Overview
* Easily install in linux operation system.
* Easily solution judging by using api.
* Multiple languages support: `C`, `C++`, `C++11`
* Special judge: Use your program to check user's answer.
## Installation
Pre-requirements:
- ``Ubuntu`` Operationg System
- Need ``php`` and ``Apache`` Server Install

Install ``gcc``, ``g++`` compiler
 ```sh
sudo apt update
sudo apt install build-essential
sudo apt-get install manpages-dev
sudo apt install g++
```
Clone Judger Repositories
 ```sh
git clone https://github.com/Coder-O-J/Judger.git
```
Done. Now you can run this judger page and see Judger home page. You go to ide and check code is working or not. If judge working then you can call api easily and get correct result.
## API

##### Submission
###### Request
``POST`` path/index.php?api
 ```sh
{
    sourceCode: "",
    language: "",
    timeLimit: '',
    memoryLimit: '',
    input: "",
    expectedOutput: "",
    checker: "",
    apiType: ""
}
```

###### Response
 ```sh
{
    output: "",
    time: "",
    memory: "",
    compileMessage: "",
    checkerLog: "",
    status:{
        status: "",
        description: ""
    }
}
```
