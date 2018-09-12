<?php

namespace App\Logger;

/**
 * Interface LoggerInterface
 * @package App\Logger
 */
interface LoggerInterface
{
    public function log(string $text);
}