<?php

namespace App;

/**
 * Class Player
 * @package App
 */
class Player
{
    private $name;

    private $place = 0;

    private $purse = 0;

    private $inPenaltyBox = false;

    /**
     * Player constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place): void
    {
        $this->place = $place;
    }

    /**
     * @return mixed
     */
    public function getPurseAmount()
    {
        return $this->purse;
    }

    /**
     * @param mixed $amount
     */
    public function setPurseAmount($amount): void
    {
        $this->purse = $amount;
    }

    /**
     * @return bool
     */
    public function isInPenaltyBox(): bool
    {
        return $this->inPenaltyBox;
    }

    /**
     * @param bool $inPenaltyBox
     */
    public function setInPenaltyBox(bool $inPenaltyBox): void
    {
        $this->inPenaltyBox = $inPenaltyBox;
    }

}