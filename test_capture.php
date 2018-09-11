<?php


$seed = isset($argv[1]) ? $argv[1] : 1;

mt_srand($seed);

ob_start();

include __DIR__ . '/GameRunner.php';

$contents = ob_get_clean();

file_put_contents('logs/game_' . $seed . '.txt', $contents);

