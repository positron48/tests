<?
    function findPath($start, $end, $g, $n) {
        $d = [];
        $u = [];
        $p = [];
        for ($i = 0; $i < $n; $i++) {
            $u[$i] = false;
            if ($i == $start) {
                $d[$i] = 0;
            }
            else {
                $d[$i] = INF;
            }
        }

        for ($i = 0; $i < $n; ++$i) {
            $v = -1;
            for ($j = 0; $j < $n; ++$j) {
                if (!$u[$j] && ($v == -1 || $d[$j] < $d[$v])) {
                    $v = $j;
                }
            }
            if ($d[$v] == INF) {
                break;
            }
            $u[$v] = true;
            for ($j = 0; $j < count($g[$v]); ++$j) {
                $to = $g[$v][$j][0];
                $len = $g[$v][$j][1];
                if ($d[$v] + $len < $d[$to]) {
                    $d[$to] = $d[$v] + $len;
                    $p[$to] = $v;
                }
            }
        }
        return $d[$end];
    }
    function deletePath($start1, $end1, $g, $n, $inpFile) {
        $newG = [];
        for ($j = 1; $j < $n + 1; $j++) {
            $expl = explode(' ', $inpFile[$j]);
            $start = (int)$expl[0];
            $end = (int)$expl[1];
            $weight = (int)$expl[2];

            if (($start != $start1) || ($end != $end1) ) {
                $newG[$start][] = [$end, $weight];
                $newG[$end][] = [$start, $weight];
            }
        }
        return $newG;
    }
    function changePath($start, $end, $weight, $g, $n) {
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < count($g[$i]); $j++) {
                if ($start == $i && $g[$i][$j][0] == $end) {
                   $g[$i][$j][1] = $weight;
                }
                if ($end == $i && $g[$i][$j][0] == $start) {
                    $g[$i][$j][1] = $weight;
                }
            }
        }
        return $g;
    }
	$inpFile = file('input.txt', FILE_IGNORE_NEW_LINES );
	$res = [];

    $n = (int)explode(' ', $inpFile[0])[0];
    $m = (int)explode(' ', $inpFile[0])[1];

    $g = [];
    for ($j = 1; $j < $n + 1; $j++) {
        $expl = explode(' ', $inpFile[$j]);
        $start = (int)$expl[0];
        $end = (int)$expl[1];
        $weight = (int)$expl[2];

        $g[$start][] = [$end, $weight];
        $g[$end][] = [$start, $weight];
    }

    for ($j = $n + 2; $j < count($inpFile); $j++) {
        $expl = explode(' ', $inpFile[$j]);
        if ($expl[2] == '-1') {
            $g = deletePath((int)$expl[0], (int)$expl[1], $g, $n, $inpFile);
        }
        elseif ($expl[2] == '?') {
            array_push($res, findPath((int)$expl[0], (int)$expl[1], $g, $n));
        }
        else {
            $g = changePath((int)$expl[0], (int)$expl[1], $expl[2], $g, $n);
        }
    }

    $r = '';
	for ($i = 0; $i < count($res); $i++) {
		$r .= $res[$i]."\r\n";
	}
	file_put_contents('output.txt', $r);
?>
