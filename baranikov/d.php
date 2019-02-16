<?php

$input = file_get_contents($argv[1]);

$patterns = array(
    '/([ ]{2,})/i',     // replace more than 2 spaces
    '#<!--.*-->#sUi',   // delete comments

);

$replace = array(
    ' ',
    ''
);

// $del_spaces_tag = '/(?<=>)\s\t\n+(?=<)/i';
// $del = '/!(<.+>)(.+)</';
// $input = (preg_replace($del, '>< ', $input));
// var_dump($input);


var_dump($input);
$input = (preg_replace($patterns, $replace, $input));

var_dump($input);

file_put_contents($argv[2],$input);