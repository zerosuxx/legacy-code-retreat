<?php


$seed = isset($argv[1]) ? $argv[1] : 1;
$version = isset($argv[2]) ? '_'.$argv[2] : '';

mt_srand($seed);

ob_start();

include __DIR__ . '/GameRunner.php';

$contents = ob_get_clean();

file_put_contents('logs/game_' . $seed . $version . ' .txt', $contents);

