<?php

namespace Test\Unit;

use App\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /**
     * @var Player
     */
    private $player;
    protected function setUp()
    {
       $this->player = new Player('Test name');
    }


    /**
     * @test
     */
    public function getName_returnsName()
    {
        $this->assertEquals('Test name', $this->player->getName());
    }

    /**
     * @test
     */
    public function getPlace_returnsPlace()
    {
        $this->player->setPlace(1);
        $this->assertEquals(1, $this->player->getPlace());
    }

    /**
     * @test
     */
    public function getPurseAmount_returnsPurse()
    {
        $this->player->setPurseAmount(1);
        $this->assertEquals(1, $this->player->getPurseAmount());
    }

    /**
     * @test
     */
    public function isInPenaltyBox_returnsInPenaltyBox()
    {
        $this->player->setInPenaltyBox(true);
        $this->assertEquals(true, $this->player->isInPenaltyBox());
    }
}