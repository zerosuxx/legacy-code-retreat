<?php

namespace Test\Characterization;

use App\Game\Game;
use App\Game\GameRunner;
use App\Logger\BufferedLogger;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class CharacterizationTest extends TestCase
{

    /**
     * @test
     */
    public function v1_OriginalCaptureFileAndGameOutputAreEquals()
    {
        $this->assertCaptureEquals(Game::VERSION_DEFAULT);
    }

    /**
     * @test
     */
    public function v2_OriginalCaptureFileAndGameOutputAreEquals()
    {
        $this->assertCaptureEquals(Game::VERSION_IMPROVED);
    }

    /**
     * @test
     */
    public function v3_OriginalCaptureFileAndGameOutputAreEquals()
    {
        $this->assertCaptureEquals(Game::VERSION_KICK_AND_ADD);
    }

    /**
     * @param string $directory
     * @param int $version
     * @param int $seed
     * @return string
     */
    private function getFilePath($directory, $version, $seed)
    {
        return $directory . '/v' . $version . '/game_' . $seed . '.txt';
    }

    private function assertCaptureEquals(int $version, $assetsDir = __DIR__ . '/assets')
    {
        foreach (range(1, 10) as $savedGame) {
            $output = $this->generateOutput($savedGame, $version);
            $captureFile = $this->getFilePath($assetsDir, $version, $savedGame);
            $this->generateCaptureFile($captureFile, $version, $savedGame);
            $this->assertEquals(file_get_contents($captureFile), $output);
        }
    }

    private function generateOutput($savedGame, $version)
    {
        $logger = new BufferedLogger();
        (new GameRunner())->runSavedGame($savedGame, $version, $logger);
        return $logger->getBuffer();
    }

    /**
     * @param string $captureFile
     * @param int $version
     * @param int $savedGame
     */
    private function generateCaptureFile($captureFile, $version, $savedGame)
    {
        if (file_exists($captureFile)) {
            return;
        }
        $dir = dirname($captureFile);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $output = $this->generateOutput($savedGame, $version);
        file_put_contents($captureFile, $output);
    }
}