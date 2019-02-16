<?php

$myfile = file($argv[1]);

for ($i = 1; $i <= $myfile[0]; $i++) {
    $fp = fopen($argv[2], 'a');
    fwrite($fp, calcSec($myfile[$i]) . PHP_EOL);    
    fclose($fp);  
}

function calcSec($str) {
    $parsed_string = explode(" ", str_replace("\n", '', $str));
    if ($parsed_string[1] > 0) {
        $parsed_string[1] = "+" . $parsed_string[1];
    }
    if ($parsed_string[3] > 0) {
        $parsed_string[3] = "+" . $parsed_string[3];
    }
    $datetime1 = new DateTime(str_replace("_", " ", $parsed_string[0]), new DateTimeZone($parsed_string[1]));
    $datetime2 = new DateTime(str_replace("_", " ", $parsed_string[2]), new DateTimeZone($parsed_string[3]));
    $seconds = abs($datetime1->getTimestamp()-$datetime2->getTimestamp());
    return $seconds;
}
