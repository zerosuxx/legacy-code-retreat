<?php

namespace App\Logger;

/**
 * Class BufferedLogger
 * @package App\Logger
 */
class BufferedLogger implements LoggerInterface
{
    private $buffer = '';

    public function log(string $text) {
        $this->buffer .= $text;
    }

    /**
     * @return string
     */
    public function getBuffer(): string
    {
        return $this->buffer;
    }
}