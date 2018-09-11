<?php

class TestCase
{

    public function run($tests = 10)
    {
        $success = true;
        for ($i = 1; $i <= $tests; $i++) {
            $success = $this->test($i);
            echo $success ? '.' : 'E';
        }
        if($success) {
            echo "\n\033[1;32mOK ({$tests} tests)\033[0m\n";
        } else {
            echo "\n\033[1;41mERROR ({$tests} tests)\033[0m\n";
        }
    }

    public function assertFileEquals($file1, $file2)
    {
        return assert(file_get_contents($file1) === file_get_contents($file2), 'Two file are not equals!');
    }

    public function test($seed, $captureFile = 'test_capture.php')
    {
        $originalPath = 'test/original/';
        $actualPath = 'test/actual/';

        $filename = sprintf('game_%d.txt', $seed);

        shell_exec(sprintf('php %s %d test > %s', $captureFile, $seed, $actualPath . $filename));
        return $this->assertFileEquals($originalPath . $filename, $actualPath . $filename);
    }
}

$test = new TestCase();
$test->run();