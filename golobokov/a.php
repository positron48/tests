<?php
$input = file($argv[1]);
$count = trim($input[0]);
if($count < 1 || $count>10000)
    return;
$res = [];
$fd = fopen($argv[2], 'w');
for ($i = 0; $i<$count; $i++) {
    preg_match_all('/\d+.\d+.\d+_\d+:\d+:\d+ [+-]?\d+/', $input[$i + 1], $dates);
    $del = explode(' ', $dates[0][0]);
    $to_check = explode('.', explode('_', $del[0])[0]);
    if(!checkdate($to_check[1], $to_check[0], $to_check[2]))
    {
        fwrite($fd, 'error'.PHP_EOL);
        continue;
    }
    $date_start = date_create_from_format('d.m.Y_H:i:s', $del[0])->modify('-'.$del[1] . " hours");
    $del = explode(' ', $dates[0][1]);
    $to_check = explode('.', explode('_', $del[0])[0]);
    if(!checkdate($to_check[1], $to_check[0], $to_check[2]))
    {
        fwrite($fd, 'error'.PHP_EOL);
        continue;
    }
    $date_end = date_create_from_format('d.m.Y_H:i:s', $del[0])->modify('-'.$del[1] . " hours");
    $diffInSeconds = $date_end->getTimestamp() - $date_start->getTimestamp();
    fwrite($fd, $diffInSeconds.PHP_EOL);
}
?>