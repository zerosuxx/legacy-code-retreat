<?php

use App\Categories;
use App\Player;

class GameRunner
{
    private $notAWinner;

    public function run(Categories $categories, array $players, int $version = 1)
    {
        $aGame = new Game($categories, $version);

        foreach($players as $player) {
            $aGame->add(new Player($player));
        }

        $iteration = 0;
        do {
            $aGame->roll(rand(0, 5) + 1);

            if (rand(0, 9) === 7) {
                $this->notAWinner = $aGame->wrongAnswer();
            } else {
                $playersCount = $aGame->howManyPlayers();
                $this->notAWinner = $aGame->wasCorrectlyAnswered();
                $newPlayersCount = $aGame->howManyPlayers();
                if($playersCount !== $newPlayersCount) {
                    $aGame->add(new Player('Random Jozsó ' . mt_rand(1, 1000)));
                }
            }
            $iteration++;
        } while ($iteration !== 300);
    }
}
