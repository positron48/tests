<?php
/**
 * Task C. Семь раз отмерь, один раз отрежь
 * Author: Igor Fedin (iassasin@yandex.ru)
 * Requires php 7.1 to run
 */

require_once 'IO.php';

$io = new IO($argv[1]);

$validators = [
    // string length in range
    'S' => function($matches){
        $len = strlen($matches[1]);
        return !($len < +$matches[3] || $len > +$matches[4]);
    },

    // numeric in range
    'N' => function($matches){
        if (preg_match('/^\d+$/', $matches[1]) !== 1){
            return false;
        }

        $num = +$matches[1];
        return !($num < +$matches[3] || $num > +$matches[4]);
    },

    // phone
    'P' => function($matches){
        return preg_match('/^\+\d \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $matches[1]) === 1;
    },

    // datetime
    'D' => function($matches){
        return date_parse_from_format('d.m.Y H:i', $matches[1]) !== false;
    },

    // email
    'E' => function($matches){
        return preg_match('/^[a-zA-Z\d][a-zA-Z\d_]{3,29}@[a-zA-Z]{2,30}\.[a-z]{2,10}$/', $matches[1]) === 1;
    },
];

while ($line = $io->readLine()){
    if (preg_match('/<([^>]*)> (.)(?: (\d+) (\d+))?/', $line, $matches) === 1){
        $validator = $matches[2];
        if (array_key_exists($validator, $validators)){
            $io->writeLine($validators[$validator]($matches) ? 'OK' : 'FAIL');
        } else {
            $io->writeLine('UNKNOWN VALIDATOR');
        }
    }
}