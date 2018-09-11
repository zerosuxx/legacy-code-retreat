<?php

$seed = isset($argv[1]) ? $argv[1] : 1;

mt_srand($seed);

include __DIR__ . '/GameRunner.php';