<?
	function findRes($id, $res) {
		for ($i = 0; $i < count($res); $i++) {
			if ($res[$i]['id'] == $id) {
				$c = 0;
				switch ($res[$i]['res']) {
					case 'L':
						$c = $res[$i]['c1'];
						break;
                    case 'R':
                        $c = $res[$i]['c2'];
                        break;
                    case 'D':
                        $c = $res[$i]['c3'];
                        break;
				}
				return [$res[$i]['res'], $c];
			}
		}
	}
	$inpFile = file($argv[1], FILE_IGNORE_NEW_LINES );
	$n = (int)$inpFile[0];
	$m = (int)$inpFile[$n];

	$bet = [];
	for ($i = 1; $i < $n + 1; $i++) {
		$tmp = [];
		$expl = explode(' ', $inpFile[$i]);
        $tmp['id'] = (int)$expl[0];
        $tmp['value'] = (float)$expl[1];
        $tmp['res'] = $expl[2];

        array_push($bet, $tmp);
    }
	$mres = [];
	for ($i = $n + 2; $i < $n + $m + 2 ; $i++) {
        $tmp = [];
        $expl = explode(' ', $inpFile[$i]);
        $tmp['id'] = (int)$expl[0];
        $tmp['c1'] = (float)$expl[1];
        $tmp['c2'] = (float)$expl[2];
        $tmp['c3'] = (float)$expl[3];
        $tmp['res'] = $expl[4];
        array_push($mres, $tmp);
    }

	$res = 0;

	for ($i = 0; $i < count($bet); $i++) {
		$r = findRes($bet[$i]['id'], $mres);
		if ($r[0] == $bet[$i]['res']) {
			$res += ($r[1] - 1) * $bet[$i]['value'];
		}
		else {
			$res -= $bet[$i]['value'];
		}
	}

	file_put_contents('output.txt', $res);
	echo $res;
?>
