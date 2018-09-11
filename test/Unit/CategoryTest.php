<?php

namespace Test\Unit;

use App\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    /**
     * @var Category
     */
    private $category;

    protected function setUp()
    {
        $this->category = new Category('Test name', [0, 1, 2, 3], 5);
    }

    /**
     * @test
     */
    public function getName_returnsName()
    {
        $this->assertEquals('Test name', $this->category->getName());
    }

    /**
     * @test
     */
    public function getPlaces_returnsName()
    {
        $this->assertEquals([0, 1, 2, 3], $this->category->getPlaces());
    }

    /**
     * @test
     */
    public function getPoint_returnsName()
    {
        $this->assertEquals(5, $this->category->getPoint());
    }
}