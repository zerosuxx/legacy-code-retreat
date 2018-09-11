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
                if($version === Game::VERSION_KICK_AND_ADD && $playersCount !== $newPlayersCount) {
                    $aGame->add(new Player('Random Player ' . $iteration));
                }
            }
            if($version === Game::VERSION_KICK_AND_ADD) {
                $iteration++;
                if ($iteration === 300) {
                    $this->notAWinner = false;
                }
            }
        } while ($this->notAWinner);
    }
}
