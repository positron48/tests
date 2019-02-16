<?php

$input_handle = fopen('input.txt', 'r');
$count = (int) fgets($input_handle);    // count of routes
$stops = 2;     // count of stops in each route

$date = array();
$diff = array();
$c = '';


for ($i = 0; $i < $count; $i++) {
    $time_zone[$i] = array();
    $date[$i] = array();
    $diff[$i] = array();
    $diff[$i][0] = 0;
    $k = 0;
    $string = fgets($input_handle);
    // for bug fixing 
    $string .= " ";
    for ($j = 0; $j < $stops; $j++) {

        // get date
        $date[$i][$j] = "";
        while (($c = $string[$k++]) != ' ') {
            $date[$i][$j] .= $c;
        }

        // get timezone
        // add + (for DateTime to formatting well)
        if ($string[$k] != '-') {
            $date[$i][$j] .= "+";
        }
        // complete timezone info (too many checks -_-)
        while (($k < strlen($string)) && ($c = $string[$k++]) != ' '  && $c != PHP_EOL && $c != "\r") {
            $date[$i][$j] .= $c;
        }
        // create date object from specified format
        $date[$i][$j] = DateTime::createFromFormat('d.m.Y_H:i:sP', $date[$i][$j]);

        // equate the time in seconds
        $date[$i][$j]->time = date_timestamp_get($date[$i][$j]);

        // equate the time of route between this 2 stops
        if ($j > 0) {
            $diff[$i][$j] = $date[$i][$j]->time - $date[$i][$j - 1]->time;
        }
    }
}

// equate sum of routes' time and save it to file
$output = fopen('output.txt', 'w');

foreach ($diff as $key => $route) {
    $route_time = 0;
    // equate time of whole route
    foreach ($route as $key => $stop) {
        $route_time += $stop;
    }
    fwrite($output,(string)$route_time . PHP_EOL);
}
fclose($output);

echo file_get_contents('output.txt');
