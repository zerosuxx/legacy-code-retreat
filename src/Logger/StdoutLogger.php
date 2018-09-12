<?php

namespace App\Logger;

/**
 * Class StdoutLogger
 * @package App\Logger
 */
class StdoutLogger implements LoggerInterface
{

    public function log(string $text) {
        echo $text;
    }
}