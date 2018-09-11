<?php

namespace Test\Characterization;

use PHPUnit\Framework\TestCase;

class CharacterizationTest extends TestCase
{
    /**
     * @test
     */
    public function v1_OriginalAndActualFilesAreEquals()
    {
        $originalPath = __DIR__ . '/original/';
        $actualPath = __DIR__ . '/actual/';
        $scriptFile = __DIR__ . '/test_capture.php';
        $version = 1;
        foreach (range(1, 10) as $seed) {
            $filename = 'game_' . $seed . '.txt';
            $actualFile = $actualPath . $filename;
            shell_exec(sprintf('php %s %d %d > %s', $scriptFile, $seed, $version, $actualFile));

            $originalFile = $originalPath . $filename;
            $this->assertFileEquals($originalFile, $actualFile);
        }
    }
}