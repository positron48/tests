
<?php
    $text = file_get_contents($argv[1]);
    $array = str_split($text, '8');

    if(mb_strlen($array[0]) == 0) {
        print_r('Y');
        die();
    }

    if(mb_strlen($array[count($array) - 1]) != 8) {
        print('N');
        die();
    }

    while (!empty($array)) {
        $len = count($array);

        if (preg_match('/^0{1}/', $array[0])) {
            array_shift($array);
        }
        else if($len >= 2 && preg_match('/^110{1}/', $array[0])) {
            print_r($array);
            if(preg_match('/^10{1}/', $array[1])) {
                array_shift($array);
                array_shift($array);
            } else {
                print ('N');
                die();
            }
        }
        else if($len>=3 && preg_match('/^1110{1}/', $array[0])) {

            if(
                preg_match('/^10{1}/', $array[1]) &&
                preg_match('/^10{1}/', $array[2])
            ) {

                array_shift($array);
                array_shift($array);
                array_shift($array);
            } else {
                print ('N');
                die();
            }
        } else if($len>=4 && preg_match('/^11110{1}/', $array[0])) {
            if(
                preg_match('/^10{1}/', $array[1]) &&
                preg_match('/^10{1}/', $array[2]) &&
                preg_match('/^10{1}/', $array[3])
            ) {
                array_shift($array);
                array_shift($array);
                array_shift($array);
                array_shift($array);
            } else {
                print ('N');
                die();
            }
        } else {
            print ('N');
            die();
        }
    }
    print('Y');
?>

