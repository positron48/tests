<?php
/**
 * Task B. Размер имеет значение
 * Author: Igor Fedin (iassasin@yandex.ru)
 * Requires php 7.1 to run
 */

require_once 'IO.php';

$io = new IO($argv[1]);

while ($addr = $io->readLine()){
    if ($addr == '::'){
        $io->writeLine("0000:0000:0000:0000:0000:0000:0000:0000");
    } else {
        $addr = preg_replace('/^::|::$/', ':', $addr);
        $addr = explode(':', $addr);

        foreach ($addr as &$part){
            if ($part == ''){
                $tmp = [];
                $fillCount = 9 - count($addr);

                //create array like ['0000', '0000', ...]
                for ($i = 0; $i < $fillCount; ++$i){
                    $tmp[] = '0000';
                }

                $part = join(':', $tmp);
            } else {
                $part = sprintf('%\'04s', $part);
            }
        }
        $io->writeLine(join(':', $addr));
    }
}