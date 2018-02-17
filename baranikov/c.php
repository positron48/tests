<?php


function taskC($input)
{
    $output = '';
    for ($i = 0 ; $i < count($input) ; $i++)
    {
        //var_dump($input[$i]);
        //echo '<br><br>';
        $result = '';
        $tmp = explode('>', $input[$i]);
        $text = substr($tmp[0],1);
        //var_dump($text);
        $params = explode(' ', trim($tmp[1]));
        switch (trim($params[0]))
        {
            case 'S':
                if (strlen($text) >= (int)$params[1] && strlen($text) <= (int)$params[2])
                    $result = 'OK';
                else
                    $result = 'FAIL';
                break;
            case 'N':
                if (is_integer($text) && (int)$text >=  (int)$params[1] && (int)$text <=  (int)$params[2])
                    $result = 'OK';
                else
                    $result = 'FAIL';
                break;
            case 'P':
                if(preg_match('!^\+7 \(\d{3}\) \d{3}(-\d{2}){2}$!', $text))
                    $result = 'OK';
                else
                    $result = 'FAIL';
                // $phone is valid

                break;
            case 'D':
                break;
            case 'E':
                break;
        }
        $output .= $result . "\n";
    }
    return $output;

}


// common parts
//$input = file('input_a.txt');
$input = file($argv[1]);
$output = '';

    $output = taskC($input);
    //var_dump($output);

    file_put_contents('output.txt',$output);

    echo $output;

?>