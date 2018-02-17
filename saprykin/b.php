<?
	$inpFile = file($argv[1], FILE_IGNORE_NEW_LINES );
	$newArr = [];
	for ($k = 0; $k < count($inpFile); $k++) {
        $expl = explode(':', $inpFile[$k]);
	}
	for ($i = 0; $i < count($inpFile); $i++) {
		if ($inpFile[$i] == '') {
			continue;
		}
		if ($inpFile[$i] == '::') {
			$newArr[] = '0000:0000:0000:0000:0000:0000:0000:0000';
		}
		else {
            $expl = explode(':', $inpFile[$i]);
            if (strstr($inpFile[$i], '::')) {
				$maxZero = 8 - count($expl) + 1;
				$zeros = [];
				$zeros = ':'.implode(':' ,array_fill(0, $maxZero, '0000')).':';

				$inpFile[$i] = str_replace('::', $zeros, $inpFile[$i]);
			}
            $expl = explode(':', $inpFile[$i]);
            for ($j = 0; $j < count($expl); $j++) {
            	if (strlen($expl[$j]) < 4) {
					$expl[$j] = str_repeat('0', 4 - strlen($expl[$j])).$expl[$j];
				}
			}
            array_push($newArr, implode(':', $expl));
		}

	}
	$res = '';
	for ($i = 0; $i < count($newArr); $i++) {
		$res .= $newArr[$i]."\r\n";
	}
	file_put_contents('output.txt', $res);
	echo $res;
?>
