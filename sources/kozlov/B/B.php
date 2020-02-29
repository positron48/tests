<?php

const REGEXPS = [
    1 => '/0\d{7}/',
    2 => '/110\d{5}10\d{6}/',
    3 => '/1110\d{4}(10\d{6}){2}/',
    4 => '/11110\d{3}(10\d{6}){3}/',
];

function validate(string $bytes, int $bytesAmount): bool
{
    if ($bytesAmount > 4 || $bytesAmount < 1) {
        throw new \InvalidArgumentException();
    }

    return preg_match(REGEXPS[$bytesAmount], $bytes);
}

$input = fopen('input.txt', 'r');
$output = fopen('output.txt', 'w');

$line = trim(fgets($input));

$success = true;

$currentChar = 0;
while ($currentChar < strlen($line)) {
    for ($j = 4; $j >= 1; $j--) {
        if (validate(substr($line, $currentChar, 8 * $j), $j)) {
            $currentChar += 8 * $j;
            continue 2;
        }
    }

    $success = false;

    break;
}

if ($success) {
    fwrite($output, 'Y');
} else {
    fwrite($output, 'N');
}

fclose($input);
fclose($output);
