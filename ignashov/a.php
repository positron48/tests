<?php

    $text = file_get_contents($argv[1]);

    $array = explode("\n", $text);

    $activeDate = date('d.m.Y', strtotime(array_shift($array)));

    $result = [];
    foreach ($array as $item) {
        $arItems = explode(' ', $item);
        $startDate = $arItems[1];
        $endDate = $arItems[2];

        if($startDate <= $activeDate && $activeDate <= $endDate) {
            $result[] = $arItems[0];
        }
    }

    foreach ($result as $item) {
        print($item."\n");
    }

?>

