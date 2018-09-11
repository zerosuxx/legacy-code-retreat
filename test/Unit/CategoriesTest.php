<?php

namespace Test\Unit;

use App\Categories;
use App\Category;
use App\Question;
use PHPUnit\Framework\TestCase;

class CategoriesTest extends TestCase
{

    /**
     * @test
     */
    public function getCategoryByPlace_returnsCategory()
    {
        $categories = new Categories();
        $category = new Category('Pop', [1,2,3], 1);
        $categories->addCategory($category);

        $this->assertEquals($category, $categories->getCategoryByPlace(1));
    }

    /**
     * @test
     */
    public function getQuestionByCategoryName_returnsQuestion()
    {
        $q1 = new Question('Pop question 1');
        $q2 = new Question('Pop question 2');
        $categories = new Categories();
        $categories->addQuestion('Pop', $q1);
        $categories->addQuestion('Pop', $q2);

        $this->assertEquals($q1, $categories->getQuestionByCategoryName('Pop'));
        $this->assertEquals($q2, $categories->getQuestionByCategoryName('Pop'));
    }

    /**
     * @test
     */
    public function getLastCategory_returnsLastCategory()
    {
        $question = new Question('Pop question 1');
        $categories = new Categories();
        $category = new Category('Pop', [1,2,3], 1);
        $categories->addCategory($category);
        $categories->addQuestion('Pop', $question);
        $categories->getQuestionByCategoryName('Pop');

        $this->assertEquals($category, $categories->getLastCategory());
    }
}