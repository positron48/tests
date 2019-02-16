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

$input = fopen("input.txt", "r");

$eventTypes = [];
$eventCounters = [];

//цветов не более 10
$colorList = [
    [255, 0, 0],
    [0, 255, 0],
    [0, 0, 255],
    [255, 255, 0],
    [0, 255, 255],
    [255, 0, 255],
    [0, 0, 0],
    [127, 127, 127],
    [127, 255, 127],
    [255, 127, 127],
    [127, 127, 255],
];

if ($input) {
    //обработка типов событий
    $counter = $getLineWithoutBreak($input);

    for ($i = 0; $i < $counter; $i++) {
        $string = $getLineWithoutBreak($input);
        $eventTypes[] = $string;
        $eventCounters[$string] = 0;
    }

    //обработка потока событий
    $counter = $getLineWithoutBreak($input);

    for ($i = 0; $i < $counter; $i++) {
        $string = $getLineWithoutBreak($input);
        $dataSet = explode(' ', $string);

        $event = $dataSet[1];
        $eventCounters[$event]++;
    }
    fclose($input);

    if ($counter > 0) {
        //отрисовка воронки
        $canvas = imagecreatetruecolor(600, 600);
        $whiteColor = imagecolorallocate($canvas, 255, 255, 255);
        imagefilledrectangle($canvas, 0, 0, 600, 600, $whiteColor);

        $baseTrianglePoints = [
            -300, -600,
            300, -600,
            0, 0
        ];

        $totalEvents = array_values($eventCounters)[0];

        //треугольник отрисовывается из нижней точки и затем масштабируется
        foreach ($eventTypes as $index => $value) {
            $percent = $eventCounters[$value] / $totalEvents;
            $areaPoints = [];
            foreach ($baseTrianglePoints as $pointIndex => $point) {
                $shift = ($pointIndex % 2 == 0) ? 300 : 600;
                $areaPoints[] = $point * $percent + $shift;
            }

            $color = imagecolorallocate($canvas, $colorList[$index][0], $colorList[$index][1], $colorList[$index][2]);
            imagefilledpolygon($canvas, $areaPoints, 3, $color);
        }

        imagepng($canvas, 'output.png');
    }
} else {
    throw new \Exception('Input file not found');
}