<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.02.18
 * Time: 10:19
 */

$stdin = fopen($argv[1], 'r');
$stdout = fopen('php://stdout', 'w');

while( $line = fgets( $stdin ) ) {
    try
    {
        fwrite($stdout, restoreIP(substr($line,0, strlen($line)-1))."\n"); //thanks to \n at the end of readline
    }
    catch(Exception $e)
    {
        fwrite($stdout, $e->getMessage(). "\n");
    }
}

fclose($stdin);
fclose($stdout);



//Функция восстанавливает строку с IP из свернутого вида
function restoreIP($string)
{
    $blocks = explode(":", $string);
    if (substr_count($string, "::") > 1) throw new Exception("Неверный формат адреса");
    if (count($blocks)>8) throw new Exception("Неверный формат адреса");
    else if (count($blocks) < 8)
    {
        $blocks_length = count($blocks)-1;
        for ($i = 0; $i < $blocks_length; $i++)
        {
            if ((strlen($blocks[$i]==0) and (strlen($blocks[$i+1])==0)))
            {
                array_splice($blocks, $i+1, 0,
                    explode(":", str_repeat(":", 8-$blocks_length-2))
                );
                break;
            }
        }

    }
    foreach($blocks as &$block)
    {
        if (strlen($block) < 4)
        {
            $block = str_repeat("0", 4-strlen($block)).$block;
        }
    }
    return implode(":", $blocks);
}