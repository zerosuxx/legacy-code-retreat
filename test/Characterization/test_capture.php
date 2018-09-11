<?php

$seed = isset($argv[1]) ? $argv[1] : 1;
$version = isset($argv[2]) ? $argv[2] : null;

mt_srand($seed);

include __DIR__ . '/../../bin/play_legacy_game.php';