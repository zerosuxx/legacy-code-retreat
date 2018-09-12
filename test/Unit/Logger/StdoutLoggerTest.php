<?php

namespace Test\Unit\Logger;

use App\Logger\StdoutLogger;
use PHPUnit\Framework\TestCase;

class StdoutLoggerTest extends TestCase
{
    /**
     * @test
     */
    public function getBuffer_returnsBufferedLogs()
    {
        $logger = new StdoutLogger();
        ob_start();
        $logger->log('a');
        $logger->log('b');
        $buffer = ob_get_clean();
        $this->assertEquals('ab', $buffer);
    }
}