<?php

use App\Categories;
use App\Player;

function echoln($string)
{
    echo $string . "\n";
}

class Game
{
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

        echoln($player->getName() . " was added");
        echoln("They are player number " . count($this->players));
        return true;
    }

    function howManyPlayers()
    {
        return count($this->players);
    }

    function roll($roll)
    {
        echoln($this->getCurrentPlayer()->getName() . " is the current player");
        echoln("They have rolled a " . $roll);

        if ($this->getCurrentPlayer()->isInPenaltyBox()) {
            if ($roll % 2 != 0) {
                if($this->version === 1) {
                    $this->isOutOfPenaltyBox = true;
                } else if($this->version === 2) {
                    $this->getCurrentPlayer()->setInPenaltyBox(false);
                }
                echoln($this->getCurrentPlayer()->getName() . " is getting out of the penalty box");
                $this->changePlayerPlace($roll);

                echoln($this->getCurrentPlayer()->getName()
                    . "'s new location is "
                    . $this->getCurrentPlayer()->getPlace());
                echoln("The category is " . $this->currentCategory());
                $this->askQuestion();
            } else {
                if($this->version === 1) {
                    $this->isOutOfPenaltyBox = false;
                }
                echoln($this->getCurrentPlayer()->getName() . " is not getting out of the penalty box");
            }

        } else {
            $this->changePlayerPlace($roll);

            echoln($this->getCurrentPlayer()->getName()
                . "'s new location is "
                . $this->getCurrentPlayer()->getPlace());
            echoln("The category is " . $this->currentCategory());
            $this->askQuestion();
        }

    }

    function askQuestion()
    {
        $question = $this->categories->nextQuestionByCategoryName($this->currentCategory());
        echoln($question->getName());
    }

    function currentCategory()
    {
        return $this->categories->getCategoryByPlace($this->getCurrentPlayer()->getPlace())->getName();
    }

    function wasCorrectlyAnswered()
    {
        if ($this->getCurrentPlayer()->isInPenaltyBox()) {
            if($this->isOutOfPenaltyBox) {
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
        echoln("Question was incorrectly answered");
        echoln($this->getCurrentPlayer()->getName() . " was sent to the penalty box");
        $this->getCurrentPlayer()->setInPenaltyBox(true);

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) {
            $this->currentPlayer = 0;
        }
        return true;
    }


    function didPlayerWin()
    {
        return !($this->getCurrentPlayer()->getPurseAmount() == 6);
    }

    private function isWin(): bool
    {
        echoln("Answer was correct!!!!");
        $point = $this->categories->getCategoryByPlace($this->getCurrentPlayer()->getPlace())->getPoint();
        $this->getCurrentPlayer()->setPurseAmount($this->getCurrentPlayer()->getPurseAmount() + $point);
        echoln($this->getCurrentPlayer()->getName()
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
}
