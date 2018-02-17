<?
	$inpFile = file($argv[1], FILE_IGNORE_NEW_LINES );
	$res = [];
	for ($i = 0; $i < count($inpFile); $i++) {
        preg_match_all("/<(.*?)>/", $inpFile[$i], $r);
		$checkStr = $r[1][0];
		$tmpStr = substr($inpFile[$i], stripos($inpFile[$i], '>') + 2);
        $expl = explode(' ', $tmpStr);
		switch ($expl[0]) {
            case 'S':
                $len = strlen($checkStr);
                if (($len <= (int)$expl[2]) && ($len >= (int)$expl[1])) {
                    array_push($res, 'OK');
                } else {
                    array_push($res, 'FAIL');
                }
                break;
            case 'N':
                $num = (int)$checkStr;
                if (($num <= (int)$expl[2]) && ($num >= (int)$expl[1])) {
                    array_push($res, 'OK');
                } else {
                    array_push($res, 'FAIL');
                }
                break;
            case 'P':
                if (preg_match("~^\+7+ \(+([0-9]{3})+\)+ ([0-9]{3})+\-([0-9]{2})+\-([0-9]{2})$~i", $checkStr)) {
                    array_push($res, 'OK');
                } else {
                    array_push($res, 'FAIL');
                }
                break;
            case 'D':
                if (strtotime($checkStr)) {
                    array_push($res, 'OK');
                } else {
                    array_push($res, 'FAIL');
                }
                break;
            case 'E':
                $checkStr = strtolower($checkStr);
                if (preg_match("~^([a-z0-9]{1})+([a-z0-9_]{3,29})+@([a-z]{2,30})+\.([a-z]{2,10})+$~i", $checkStr)) {
                    array_push($res, 'OK');
                } else {
                    array_push($res, 'FAIL');
                }
                break;
        }
	}
	$r = '';
	for ($i = 0; $i < count($res); $i++) {
		$r .= $res[$i].PHP_EOL;
	}
	file_put_contents('output.txt', $r);
	echo $r;
?>
