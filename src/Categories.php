<?php

namespace App;

class Categories
{
    private $categoriesByPlace = [];
    private $questions = [];

    public function addCategory(Category $category): void
    {
        foreach ($category->getPlaces() as $place) {
            $this->categoriesByPlace[$place] = $category;
        }
    }

    public function getCategoryByPlace(int $place): Category
    {
        return $this->categoriesByPlace[$place];
    }

    public function addQuestion(string $categoryName, Question $question)
    {
        $this->questions[$categoryName][] = $question;
    }

    public function nextQuestionByCategoryName(string $categoryName): Question
    {
        return array_shift($this->questions[$categoryName]);
    }
}