<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Game\GameRunner;

$version = isset($argv[1]) ? (int)$argv[1] : GameRunner::VERSION_DEFAULT;

(new GameRunner())
    ->run($version);