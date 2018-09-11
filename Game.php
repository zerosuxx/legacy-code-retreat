<?php

use App\Categories;

function echoln($string)
{
    echo $string . "\n";
}

class Game
{
    var $players;
    var $places;
    var $purses;
    var $inPenaltyBox;

    var $currentPlayer = 0;
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
        $this->players = array();
        $this->places = array(0);
        $this->purses = array(0);
        $this->inPenaltyBox = array(0);

        $this->categories = $categories;
        $this->version = $version;
    }

    function isPlayable()
    {
        return ($this->howManyPlayers() >= 2);
    }

    function add($playerName)
    {
        array_push($this->players, $playerName);
        $this->places[$this->howManyPlayers()] = 0;
        $this->purses[$this->howManyPlayers()] = 0;
        $this->inPenaltyBox[$this->howManyPlayers()] = false;

        echoln($playerName . " was added");
        echoln("They are player number " . count($this->players));
        return true;
    }

    function howManyPlayers()
    {
        return count($this->players);
    }

    function roll($roll)
    {
        echoln($this->players[$this->currentPlayer] . " is the current player");
        echoln("They have rolled a " . $roll);

        if ($this->inPenaltyBox[$this->currentPlayer]) {
            if ($roll % 2 != 0) {
                if($this->version === 1) {
                    $this->isOutOfPenaltyBox = true;
                } else if($this->version === 2) {
                    $this->inPenaltyBox[$this->currentPlayer] = false;
                }
                echoln($this->players[$this->currentPlayer] . " is getting out of the penalty box");
                $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
                if ($this->places[$this->currentPlayer] > 11) {
                    $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;
                }

                echoln($this->players[$this->currentPlayer]
                    . "'s new location is "
                    . $this->places[$this->currentPlayer]);
                echoln("The category is " . $this->currentCategory());
                $this->askQuestion();
            } else {
                if($this->version === 1) {
                    $this->isOutOfPenaltyBox = false;
                }
                echoln($this->players[$this->currentPlayer] . " is not getting out of the penalty box");
            }

        } else {

            $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] + $roll;
            if ($this->places[$this->currentPlayer] > 11) {
                $this->places[$this->currentPlayer] = $this->places[$this->currentPlayer] - 12;
            }

            echoln($this->players[$this->currentPlayer]
                . "'s new location is "
                . $this->places[$this->currentPlayer]);
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
        return $this->categories->getCategoryByPlace($this->places[$this->currentPlayer])->getName();
    }

    function wasCorrectlyAnswered()
    {
        if ($this->inPenaltyBox[$this->currentPlayer]) {
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
        echoln($this->players[$this->currentPlayer] . " was sent to the penalty box");
        $this->inPenaltyBox[$this->currentPlayer] = true;

        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) {
            $this->currentPlayer = 0;
        }
        return true;
    }


    function didPlayerWin()
    {
        return !($this->purses[$this->currentPlayer] == 6);
    }

    private function isWin(): bool
    {
        echoln("Answer was correct!!!!");
        $point = $this->categories->getCategoryByPlace($this->places[$this->currentPlayer])->getPoint();
        $this->purses[$this->currentPlayer] += $point;
        echoln($this->players[$this->currentPlayer]
            . " now has "
            . $this->purses[$this->currentPlayer]
            . " Gold Coins.");

        $winner = $this->didPlayerWin();
        $this->currentPlayer++;
        if ($this->currentPlayer == count($this->players)) {
            $this->currentPlayer = 0;
        }

        return $winner;
    }
}
