<?php

$input = fopen($argv[1], 'r');

$edges = [];
$vertex = [];

while (!empty($inputLine = fgets($input))) {
    $inputLine = trim($inputLine);
    if (empty($inputLine)) {
        break;
    }

    $inputParts = explode(':', $inputLine);
    $firstId = (int) ($inputParts[0]);
    $vertex[$firstId] = [];

    if (0 === strlen(trim($inputParts[1]))) {
        continue;
    }

    $secondIds = explode(' ', trim($inputParts[1]));

    foreach ($secondIds as $secondId) {
        if (0 === strlen(trim($secondId))) {
            continue;
        }

        $edges[] = [
            'first' => (int) $firstId,
            'last' => (int) $secondId,
        ];
    }
}

foreach ($edges as $edge) {
    $vertex[$edge['last']]['children'][] = $edge['first'];
    $vertex[$edge['first']]['parent'][] = $edge['last'];
}

$roots = [];

foreach ($vertex as $index => $value) {
    if (empty($value['parent']) && !empty($value['children'])) {
        $roots[] = $index;
    }
}

if (empty($roots)) {
    echo 'error';
} else {
    $vertexPainted = [];

    $recursiveWalk = function ($currentId) use (&$recursiveWalk, $vertex, &$vertexPainted) {
        if (empty($vertex[$currentId]['children'])) {
            return true;
        } elseif (in_array($currentId, $vertexPainted)) {
            return false;
        }

        $vertexPainted[] = $currentId;

        foreach ($vertex[$currentId]['children'] as $nextId) {
            if (false === $recursiveWalk($nextId)) {
                return false;
            }
        }

        return true;
    };

    $result = $recursiveWalk($roots[0]);

    if (false === $result) {
        echo 'error';
    } else {
        $vertexAll = array_keys($vertex);
        $vertexPaintedWithoutRoots = array_diff($vertexPainted, $roots);
        $vertexLeft = array_diff($vertexAll, $vertexPainted, $roots);

        $result = array_merge($roots, $vertexPaintedWithoutRoots, $vertexLeft);
        $resultString = implode(' ', $result);
        echo $resultString;
    }
}

fclose($input);
