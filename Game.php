<?php

use App\Categories;
use App\Player;

class Game
{
    const VERSION_DEFAULT = 1;
    const VERSION_IMPROVED = 2;
    const VERSION_KICK_AND_ADD = 3;

    /**
     * @var Player[]
     */
    private $players;

    /**
     * @var int
     */
    private $currentPlayer = 0;

    /**
     * @var bool
     */
    private $isOutOfPenaltyBox = false;

    /**
     * @var Categories
     */
    private $categories;

    /**
     * @var int
     */
    private $version;

    function __construct(Categories $categories, int $version)
    {
        $this->players = [];
        $this->categories = $categories;
        $this->version = $version;
    }

    function isPlayable()
    {
        return ($this->howManyPlayers() >= 2);
    }

    function add(Player $player)
    {
        array_push($this->players, $player);

        $this->log($player->getName() . " was added");
        $this->log("They are player number " . count($this->players));
        return true;
    }

    function howManyPlayers()
    {
        return count($this->players);
    }

    function roll($roll)
    {
        $this->log($this->getCurrentPlayerName() . " is the current player");
        $this->log("They have rolled a " . $roll);

        if ($this->getCurrentPlayer()->isInPenaltyBox()) {
            if ($roll % 2 != 0) {
                if ($this->version === self::VERSION_DEFAULT) {
                    $this->isOutOfPenaltyBox = true;
                } elseif ($this->version === self::VERSION_IMPROVED) {
                    $this->getCurrentPlayer()->setInPenaltyBox(false);
                }
                $this->log($this->getCurrentPlayerName() . " is getting out of the penalty box");
                $this->changePlayerPlace($roll);

                $this->log($this->getCurrentPlayerName()
                    . "'s new location is "
                    . $this->getCurrentPlayer()->getPlace());
                $this->log("The category is " . $this->currentCategory());
                $this->askQuestion();
            } else {
                if ($this->version === self::VERSION_DEFAULT) {
                    $this->isOutOfPenaltyBox = false;
                }
                $this->log($this->getCurrentPlayerName() . " is not getting out of the penalty box");
            }

        } else {
            $this->changePlayerPlace($roll);

            $this->log($this->getCurrentPlayerName()
                . "'s new location is "
                . $this->getCurrentPlayer()->getPlace());
            $this->log("The category is " . $this->currentCategory());
            $this->askQuestion();
        }

    }

    function askQuestion()
    {
        $question = $this->categories->nextQuestionByCategoryName($this->currentCategory());
        $this->log($question->getName());
    }

    function currentCategory()
    {
        return $this->categories->getCategoryByPlace($this->getCurrentPlayer()->getPlace())->getName();
    }

    function wasCorrectlyAnswered()
    {
        if ($this->getCurrentPlayer()->isInPenaltyBox()) {
            if ($this->isOutOfPenaltyBox) {
                return $this->isWin();
            } else {
                $this->currentPlayer++;
                if ($this->currentPlayer == count($this->players)) {
                    $this->currentPlayer = 0;
                }
                return true;
            }
        } else {
            return $this->isWin();
        }
    }

    function wrongAnswer()
    {
        $this->log("Question was incorrectly answered");
        $this->log($this->getCurrentPlayerName() . " was sent to the penalty box");
        $this->getCurrentPlayer()->setInPenaltyBox(true);

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) {
            $this->currentPlayer = 0;
        }
        return true;
    }


    function didPlayerWin()
    {
        $isWin = !($this->getCurrentPlayer()->getPurseAmount() == 6);
        if ($this->version === self::VERSION_KICK_AND_ADD && !$isWin) {
            $this->log('------KICKED ' . $this->getCurrentPlayerName());
            array_splice($this->players, $this->currentPlayer, 1);
            $this->currentPlayer = 0;
        }
        return $isWin;
    }

    private function isWin(): bool
    {
        $this->log("Answer was correct!!!!");
        $point = $this->categories->getCategoryByPlace($this->getCurrentPlayer()->getPlace())->getPoint();
        $this->getCurrentPlayer()->setPurseAmount($this->getCurrentPlayer()->getPurseAmount() + $point);
        $this->log($this->getCurrentPlayerName()
            . " now has "
            . $this->getCurrentPlayer()->getPurseAmount()
            . " Gold Coins.");

        $winner = $this->didPlayerWin();
        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) {
            $this->currentPlayer = 0;
        }

        return $winner;
    }

    private function getCurrentPlayer()
    {
        return $this->players[$this->currentPlayer];
    }

    private function getCurrentPlayerName()
    {
        return $this->getCurrentPlayer()->getName();
    }

    /**
     * @param $roll
     */
    private function changePlayerPlace($roll): void
    {
        $this->getCurrentPlayer()->setPlace($this->getCurrentPlayer()->getPlace() + $roll);
        if ($this->getCurrentPlayer()->getPlace() > 11) {
            $this->getCurrentPlayer()->setPlace($this->getCurrentPlayer()->getPlace() - 12);
        }
    }

    private function log($string)
    {
        echo $string . "\n";
    }
}
