## Judger
![Judger Wallpaper](https://github.com/coderoj-dev/Judger/blob/master/.github/home.png?raw=true)

![screenshot](https://github.com/coderoj-dev/Judger/blob/master/.github/editor.png?raw=true) Ide | ![screenshot](https://github.com/coderoj-dev/Judger/blob/master/.github/editor.png?raw=true) Checker IDE |
|-|-|

## Introduction
CoderOJ Judger is a linux based high performance programming problem solution judger that support multiple languages and special judge.
## Overview
* Easily install in linux operation system.
* Easily solution judging by using api.
* Multiple languages support: `C`, `C++`, `C++11`
* Special judge: Use your program to check user's answer.
## Installation
- Install Docker

## API

CoerOJ Judger provides api for judging solution.

| Url | Method | URI Parameters |
| :---: | :---: |  :---:  |
|```/api/api.php``` | ```POST``` |  &cross;  |

**:arrow_right: Request**
---
| Parameter | Type | Default | Required |Description |
| :---- | :---: | :--: |  :---: | :--- |
| source_code | `string` |-|&check; |Program which is need to judge|
| *language* | `string` |-|&check;| Language Code|
| *time_limit* | `integer` |2 s|&cross;| Maximum time taken this program. Max *timeLimit* is 10s |
| *memory_limit* | `integer` |128000 kb|&cross;| Maximum memory taken this program. |
| *input* | `string` | NULL|&cross;| Program Input|
| *expected_output* | `string` |NULL|&cross;| Program Correct Output|
| *checker* | `string` |-|&cross;| Special Judge Code|
| *api_type* | `string` |-|&check;|Two type are here [compile, checker]. If you need judging a solution then select ```compile``` or if you need to judging your checker code then select ``` checker``` apiType|

