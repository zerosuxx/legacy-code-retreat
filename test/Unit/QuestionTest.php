<?php

namespace Test\Unit;

use App\Question;
use PHPUnit\Framework\TestCase;

class QuestionTest extends TestCase
{
    /**
     * @var Question
     */
    private $question;

    protected function setUp()
    {
        $this->question = new Question('Test question');
    }

    /**
     * @test
     */
    public function getName_returnsName()
    {
        $this->assertEquals('Test question', $this->question->getName());
    }
}