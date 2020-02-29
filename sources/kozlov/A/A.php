<?php

$input = fopen('input.txt', 'r');
$output = fopen('output.txt', 'w');

$currentDate = \DateTime::createFromFormat('d.m.Y', trim(fgets($input)));
$currentDate->setTime(0, 0, 0);

while (false !== ($inputLine = fgets($input))) {
    $inputLine = trim($inputLine);
    if (empty($inputLine)) {
        break;
    }

    $inputParts = explode(' ', $inputLine);
    $id = $inputParts[0];

    $dateStart = \DateTime::createFromFormat('d.m.Y', $inputParts[1]);
    $dateStart->setTime(0, 0, 0);
    $dateEnd = \DateTime::createFromFormat('d.m.Y', $inputParts[2]);
    $dateEnd->setTime(0, 0, 0);

    if (($dateStart <= $currentDate) && ($currentDate <= $dateEnd)) {
        fwrite($output, $id . "\n");
    }
}

fclose($input);
fclose($output);
