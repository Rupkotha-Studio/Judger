<?php

class JAVA extends CompilerEngin
{
    public function __construct()
    {
        /*
        - javac program.java
         */

        if (!$this->compile("javac " . request()->source_file_name)) {
            $this->compileAllClassName();
        }

        /*
        - java Main/Class Name
         */
        $path       = trim(shell_exec("realpath $(which java)"));
        $binaryFile = basename($this->getBinaryFile(), ".class");
        $executeCmd = "$path {$binaryFile}";

        $this->run($executeCmd);
    }

    public function compileAllClassName()
    {
        $classNameList = $this->getClassNameList();
        foreach ($classNameList as $key => $className) {
            $className .= ".java";
            rename(request()->source_file_name, $className);
            request()->source_file_name = $className;

            $ret = $this->compile("javac " . request()->source_file_name);
            if ($ret) {
                break;
            }

        }
    }

    /*
    - filter program.java code and find all 'public class name' the check compile one by one and if one is compilation pass then break
    */
    public function getClassNameList()
    {
        $classList       = shell_exec("awk '/public class/ {print $3}' program.java");
        $classList       = preg_split('/[\s]+/', $classList);
        $filterClassList = [];
        foreach ($classList as $key => $value) {
            $className = trim($value);
            if ($className == "") {
                continue;
            }

            $lastChar = substr($className, -1);
            if ($lastChar == "{") {
                $className = substr_replace($className, "", -1);
            }

            array_push($filterClassList, $className);
        }
        return $filterClassList;
    }

    public function getBinaryFile()
    {
        $classFiles = glob("*.class");
        $binaryFile = (count($classFiles) > 0) ? basename($classFiles[0]) : "";
        return $binaryFile;
    }
}
