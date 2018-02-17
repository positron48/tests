<?php
/**
 * Task A. Казино
 * Author: Igor Fedin (iassasin@yandex.ru)
 * Requires php 7.1 to run
 */

require_once 'IO.php';

$io = new IO();

$tSum = 0;
$sums = [];

$n = $io->readIntLine();
for ($i = 0; $i < $n; ++$i){
    // result = [L]eft, [R]ight, [D]raw
    [$gid, $sum, $result] = $io->scanf('%d %d %s');
    $sums[$gid] = [$result, (float) $sum];
}

$m = $io->readIntLine();
for ($i = 0; $i < $m; ++$i){
    [$gid, $cWinLeft, $cWinRight, $cNoWin, $result] = $io->scanf('%d %f %f %f %s');
    $winsC = [
        'L' => $cWinLeft,
        'R' => $cWinRight,
        'D' => $cNoWin,
    ];

    [$pWinner, $wSum] = $sums[$gid];

    if ($pWinner == $result){
        $tSum += $wSum * ($winsC[$result] - 1);
    } else {
        $tSum -= $wSum;
    }
}

$io->write($tSum);
