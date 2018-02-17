<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.02.18
 * Time: 12:19
 */

$stdin = fopen($argv[1], 'r');
$stdout = fopen('php://stdout', 'w');

while( $line = fgets( $stdin ) ) {
    $result = validationHelper(substr($line, 0, strlen($line)-1));
    if ($result===true)
        fwrite($stdout, "OK\n");
    else
        fwrite($stdout, "FAIL\n");
}

function validationHelper($line)
{
    $string = substr($line, strpos($line, "<")+1, strpos($line, "> "));
    $parameters = explode(" ",substr($line, strpos($line, "> ")+2));
    $validation_type = $parameters[0];
    $n = null; $m = null;
    if (isset($parameters[1])) $n = $parameters[1];
    if (isset($parameters[2])) $m = $parameters[2];
    return validate($string, $validation_type, $n, $m);
}

function validate($string, $validation_type, $n=null, $m=null)
{
    $supported_types = ["S", "N", "P", "D", "E"];
    if ($validation_type=="S")
    {
        if (isset($n) and isset($m))
            if ((strlen($string) >= $n) and (strlen($string) <= $m)) return true;
    }
    else if ($validation_type=="N")
    {
        $number = intval($string);
        if (isset($n) and isset($m))
            if (($number >= $n) and ($number <= $m)) return true;
    }
    else if ($validation_type=="P")
    {
        if (preg_match("/^\+\d\s\(\d{3}\)\s\d{3}\-\d{2}\-\d{2}/", $string)>0) return true;
       // if (count($output) > 0) return true;
    }
    else if ($validation_type=="D")
    {
        if (preg_match("/^(\d{1,2}+).(\d{1,2}+).(\d{4}+)\s(\d{1,2}+):(\d{1,2}+)/", $string, $matches)>0)
        {
            if (checkdate(intval($matches[2]), intval($matches[1]), intval($matches[3])) and (intval($matches[4]) < 24) and (intval($matches[5]) < 61)) //Проверка, существует ли этот день на самом деле, 60 из-за коррекции времени на серверах
                return true;
        }
        /*if preg_match("/^\d{1,2}.\d{1,2}.\d{1,4}\s\d{1,2}:\d{1,2}/", $string)>0)
            return true;*/
    }
    else if ($validation_type=="E")
    {
       if (preg_match("/^[a-zA-Z0-9_]{4,30}@[a-zA-Z]{2,30}.[a-z]{2,10}/", $string)>0)
        return true;
    }
    return false;
}

fclose($stdin);
fclose($stdout);
