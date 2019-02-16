<?php

//удаляет \n при чтении из файла
$getLineWithoutBreak = function($handle) {
    $line = fgets($handle);
    if (false === $line) {
        return false;
    } else {
        return rtrim($line);
    }
};

$input = fopen($argv[1], "r");
$output = fopen($argv[2], "w");

if ($input) {
    $counter = $getLineWithoutBreak($input);

    for ($i = 0; $i < $counter; $i++) {
        $string = $getLineWithoutBreak($input);
        $dateSet = explode(' ', $string);

        if ($dateSet[1][0] !== '-') {
            $dateSet[1] = '+' . $dateSet[1];
        }

        if ($dateSet[3][0] !== '-') {
            $dateSet[3] = '+' . $dateSet[3];
        }

        $date1 = DateTime::createFromFormat('d.m.Y_H:i:s', $dateSet[0], new DateTimeZone($dateSet[1]));
        $date2 = DateTime::createFromFormat('d.m.Y_H:i:s', $dateSet[2], new DateTimeZone($dateSet[3]));

        $value = $date2->getTimestamp() - $date1->getTimestamp();
        fwrite($output, $value . "\n");
    }

    fclose($input);
    fclose($output);
} else {
    throw new \Exception('Input file not found');
}
