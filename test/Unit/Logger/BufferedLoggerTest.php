<?php

namespace Test\Unit\Logger;

use App\Logger\BufferedLogger;
use PHPUnit\Framework\TestCase;

class BufferedLoggerTest extends TestCase
{
    /**
     * @test
     */
    public function getBuffer_returnsBufferedLogs()
    {
        $logger = new BufferedLogger();
        $logger->log('a');
        $logger->log('b');
        $this->assertEquals('ab', $logger->getBuffer());
    }
}