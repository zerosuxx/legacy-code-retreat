<?php

require __DIR__ . '/Game.php';
require __DIR__ . '/vendor/autoload.php';

class GameRunner
{
    private $notAWinner;

    public function run(\App\Categories $categories)
    {
        $aGame = new Game($categories);

        $aGame->add("Chet");
        $aGame->add("Pat");
        $aGame->add("Sue");

        do {
            $aGame->roll(rand(0, 5) + 1);

            if (rand(0, 9) === 7) {
                $this->notAWinner = $aGame->wrongAnswer();
            } else {
                $this->notAWinner = $aGame->wasCorrectlyAnswered();
            }
        } while ($this->notAWinner);
    }
}
