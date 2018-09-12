<?php

namespace App\Game;

use App\Categories;
use App\Category;
use App\Logger\LoggerInterface;
use App\Player;
use App\Question;

class GameRunner
{
    /**
     * @int
     */
    const VERSION_DEFAULT = 1;

    /**
     * @var bool
     */
    private $notAWinner = false;

    public function runGame(Game $game, array $players)
    {
        foreach ($players as $player) {
            $game->add(new Player($player));
        }

        $randomPlayerNumber = 1;
        do {
            $game->roll(rand(0, 5) + 1);

            if (rand(0, 9) === 7) {
                $this->notAWinner = $game->wrongAnswer();
            } else {
                $playersCount = $game->howManyPlayers();
                $this->notAWinner = $game->wasCorrectlyAnswered();
                $newPlayersCount = $game->howManyPlayers();
                if ($game->getVersion() === Game::VERSION_KICK_AND_ADD && $playersCount !== $newPlayersCount) {
                    $game->add(new Player('Random Player ' . $randomPlayerNumber));
                    $randomPlayerNumber++;
                    if ($randomPlayerNumber > 10) {
                        $this->notAWinner = false;
                    }
                }
            }
        } while ($this->notAWinner);
    }

    public function run(int $version = self::VERSION_DEFAULT, LoggerInterface $logger = null)
    {
        $this->runGame(new Game($this->getDefaultCategories(), $version, $logger), $this->getDefaultPlayers());
    }

    public function runSavedGame(int $savedGame, int $version = self::VERSION_DEFAULT, LoggerInterface $logger = null)
    {
        mt_srand($savedGame);
        $this->run($version, $logger);
    }

    private function getDefaultCategories(): Categories
    {
        $questionsCount = 50;
        $categories = new Categories();
        $categories->addCategory(new Category('Pop', [0, 4, 8], 1));
        $categories->addCategory(new Category('Science', [1, 5, 9], 1));
        $categories->addCategory(new Category('Sports', [2, 6, 10], 1));
        $categories->addCategory(new Category('Rock', [3, 7, 11], 1));

        foreach (['Pop', 'Science', 'Sports', 'Rock'] as $category) {
            foreach (range(0, $questionsCount) as $i) {
                $categories->addQuestion($category, new Question($category . ' Question ' . $i));
            }
        }
        return $categories;
    }

    private function getDefaultPlayers()
    {
        return [
            'Chet',
            'Pat',
            'Sue'
        ];
    }
}
