<?php

use App\Categories;

class GameRunner
{
    private $notAWinner;

    public function run(Categories $categories, array $players)
    {
        $aGame = new Game($categories);

        foreach($players as $player) {
            $aGame->add($player);
        }

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
