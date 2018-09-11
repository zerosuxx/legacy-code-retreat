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
        $version = 1;
        foreach (range(1, 10) as $seed) {
            $this->generateTestFiles('original', $version, $seed);
            $this->generateTestFiles('actual', $version, $seed);
            $this->assertFileEquals(
                $this->getFilePath('original', $version, $seed),
                $this->getFilePath('actual', $version, $seed)
            );
        }
    }

    /**
     * @test
     */
    public function v2_OriginalAndActualFilesAreEquals()
    {
        $this->markTestIncomplete();
        $version = 2;
        foreach (range(1, 10) as $seed) {
            $this->generateTestFiles('original', $version, $seed);
            $this->generateTestFiles('actual', $version, $seed);
            $this->assertFileEquals(
                $this->getFilePath('original', $version, $seed),
                $this->getFilePath('actual', $version, $seed)
            );
        }
    }

    /**
     * @test
     */
    public function v3_OriginalAndActualFilesAreEquals()
    {
        $version = 3;
        foreach (range(1, 10) as $seed) {
            $this->generateTestFiles('original', $version, $seed);
            $this->generateTestFiles('actual', $version, $seed);
            $this->assertFileEquals(
                $this->getFilePath('original', $version, $seed),
                $this->getFilePath('actual', $version, $seed)
            );
        }
    }

    /**
     * @param string $directory
     * @param int $version
     * @param int $seed
     * @param string|null $scriptFile
     */
    private function generateTestFiles($directory, $version, $seed, $scriptFile = null)
    {
        if (null === $scriptFile) {
            $scriptFile = __DIR__ . '/test_capture.php';
        }
        $outputFile = $this->getFilePath($directory, $version, $seed);
        $dir = dirname($outputFile);
        if(!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        if ($directory === 'original' && file_exists($outputFile)) {
            return;
        }
        shell_exec(sprintf('php %s %d %d > %s', $scriptFile, $seed, $version, $outputFile));
    }

    /**
     * @param string $directory
     * @param int $version
     * @param int $seed
     * @return string
     */
    private function getFilePath($directory, $version, $seed)
    {
        return __DIR__ . '/' . $directory . '/v' . $version . '/game_' . $seed . '.txt';
    }
}