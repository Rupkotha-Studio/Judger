<?php

class Lib
{
    public static function compressString($str, $len = 100)
    {
        $stringLen = strlen($str);
        if ($stringLen <= $len) {
            return $str;
        }
        return substr($str, 0, $len) . "...";
    }
}
