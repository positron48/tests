<?php
error_reporting(E_ERROR);

$users = [
    'baranikov',
    'golobokov',
    'gridnev',
    'kozlov',
    'stegancev',
];

//файл => каталог с данными
$sources = [
    "a.php" => "a",
    "b.php" => "b",
    "c.php" => "c",
    "d.php" => "d"
];

$count = [
    'a' => 4,
    'b' => 6,
    'c' => 4,
    'd' => 4
];

$inputs = [
    'a' => ['.dat'],
    'b' => ['_sections.xml', '_products.xml'],
    'c' => ['.dat'],
    'd' => ['.html']
];
$outputs = [
    'a' => '_output.ans',
    'b' => '_output.xml',
    'c' => '_output.png',
    'd' => '_output.html',
];

foreach ($users as $user) {
    echo "-- ".$user.": ".PHP_EOL;
    foreach ($sources as $source => $taskId) {
        echo "-- task ".$taskId.": ".PHP_EOL;
        $srcOrig = $source;
        $source = $user."/".$source;
        $source = realpath($source);
        $testsFolder = realpath("tests/" . $taskId);

        if (!file_exists($source)) {
            echo "file {$srcOrig} not found\n";
            continue;
        }

        if (!is_dir($testsFolder)) {
            echo "Каталог {$testsFolder} не найден\n";
            continue;
        }

        $testsCount = $count[$taskId];

        $resultFolder = realpath("result/".$user."/");
        if (!is_dir($resultFolder)) {
            if (!mkdir($resultFolder)) {
                echo "error creating catalog {$resultFolder}\n";
                continue;
            }
        }

        $okTest = 0;
        for ($i = 1; $i <= $testsCount; $i++) {
            $id = getId($i);

            $input = $inputs[$taskId];
            $command = "php {$source}";
            foreach ($input as $item) {
                $command .= " {$testsFolder}/{$id}".$item;
            }
            $command .= " {$resultFolder}/{$taskId}/{$id}" . $outputs[$taskId];

            echo $command . PHP_EOL;

            $time = microtime(true);
            $result = execute($command, 90);
            $timeCount = round(microtime(true) - $time, 2);

//            file_put_contents("{$resultFolder}/{$taskId}/{$id}.ans", $result);
            echo " {$resultFolder}/{$taskId}/{$id}" . $outputs[$taskId].PHP_EOL;
//            $result = explode("\n", $result);
//            $standart = explode("\n", trim(file_get_contents("{$testsFolder}/{$id}.ans")));
//            $okCount = 0;
//            //echo "#{$i} {$testsFolder}/input{$i}.txt\n";
//            foreach ($standart as $lineId => $line) {
//                $ok = false;
//                if (trim($line) == trim($result[$lineId])) {
//                    $ok = true;
//                    $okCount++;
//                }
//            }
//
//            $results[$user][$taskId][$id] = ($okCount == count($standart));
//            echo "test $id: " . ($okCount == count($standart) ? "OK  " : "FAIL") . " $timeCount\n";
//            if ($okCount == count($standart)) {
//                $okTest++;
//            }
        }
//        echo "result - {$okTest} из " . $testsCount . "\n";

        echo "Результаты сохранены в каталог {$resultFolder}\n";
    }
}
function getId($i) {
    $i = (string) $i;
    while(strlen($i) < 3){
        $i = '0' . $i;
    }
    return $i;
}

function execute($command, $timeout = 5) {
    $handle = proc_open($command, [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipe);

    $startTime = microtime(true);

    /* Read the command output and kill it if the proccess surpassed the timeout */
    $read = '';
    while(!feof($pipe[1])) {
        $read .= fread($pipe[1], 8192);
        if($startTime + $timeout < microtime(true)) {
            $kill = true;
            break;
        }
    }

    if($kill) {
        kill(proc_get_status($handle)['pid']);
        echo " timeout ";
    }
    proc_close($handle);

    return $read;
}

/* The proc_terminate() function doesn't end proccess properly on Windows */
function kill($pid) {
    return strstr(PHP_OS, 'WIN') ? exec("taskkill /F /T /PID $pid") : exec("kill -9 $pid");
}
/*
foreach (['a', 'b', 'c', 'd'] as $task) {
    echo "task $task:".PHP_EOL;
    foreach ($users as $user) {
        echo substr($user, 0, 4)."\t";
    }
    echo PHP_EOL;

    foreach ($results['kozlov'][$task] as $key => $tests) {
        foreach ($users as $user) {
            echo ($results[$user][$task][$key] ? "OK  ":"FAIL")."\t";
        }
        echo PHP_EOL;
    }
    echo PHP_EOL;
}
