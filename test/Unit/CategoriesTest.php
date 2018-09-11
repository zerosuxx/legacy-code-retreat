<?php

namespace Test\Unit;

use PHPUnit\Framework\TestCase;

class CategoriesTest extends TestCase
{

    /**
 * @test
 */
    public function getCategoryByPlace_returnsCategory()
    {
        $categories = new \App\Categories();
        $categories->add('Pop', [1,2,3], 1);

        $this->assertEquals(['Pop', 1], $categories->getCategoryByPlace(1));
    }
}