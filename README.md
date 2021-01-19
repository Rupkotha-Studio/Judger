# Judger
[![Judger Wallpaper](https://github.com/coderoj-dev/Judger/blob/master/.github/editor.png?raw=true)](https://judger.coderoj.com)
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

CoerOJ Judger provides api for judging solution.

| Url | Method | URI Parameters |
| :---: | :---: |  :---:  |
|```/index.php?api``` | ```POST``` |  &cross;  |

**:arrow_right: Request**
---
| Parameter | Type | Default | Required |Description |
| :---- | :---: | :--: |  :---: | :--- |
| sourceCode | `string` |-|&check; |Program which is need to judge|
| *language* | `string` |-|&check;| Language Code|
| *timeLimit* | `integer` |2 s|&cross;| Maximum time taken this program. Max *timeLimit* is 10s |
| *memoryLimit* | `integer` |128000 kb|&cross;| Maximum memory taken this program. |
| *input* | `string` | NULL|&cross;| Program Input|
| *expectedOutput* | `string` |NULL|&cross;| Program Correct Output|
| *checker* | `string` |-|&cross;| Special Judge Code|
| *apiType* | `string` |-|&check;|Two type are here [compile, checker]. If you need judging a solution then select ```compile``` or if you need to judging your checker code then select ``` checker``` apiType|

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
