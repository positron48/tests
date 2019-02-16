<?php


$document = file_get_contents('input.html');
$document = preg_replace('/>\s+<+/', '><', $document);
$document = preg_replace('/<!--[^(skip=delete)].*?-->/', '', $document);

$scriptFragments = [];

preg_match_all('/<script.*?>[^$]*?<\/script>/', $document, $scriptFragments);
foreach ($scriptFragments[0] as $scriptFragment) {
    if (!preg_match('/data-skip-moving.*?=.*?true/', $scriptFragment)) {
        $document = substr($document, 0, strpos($document, $scriptFragment))
            . substr($document, strpos($document, $scriptFragment) + strlen($scriptFragment));

        $document = substr($document, 0, strpos($document, '</html>')) . $scriptFragment . '</html>';
    }
}

file_put_contents('output.html', $document);