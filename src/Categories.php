<?php

namespace App;

class Categories
{

    private $categories = [];
    private $categoriesByPlace = [];
    private $questions = [];
    private $lastCategoryName = null;

    public function addCategory(Category $category): void
    {
        $this->categories[$category->getName()] = $category;
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

    public function getQuestionByCategoryName(string $categoryName): Question
    {
        $this->lastCategoryName = $categoryName;
        return array_shift($this->questions[$categoryName]);
    }

    public function getLastCategory(): Category
    {
        return $this->categories[$this->lastCategoryName];
    }
}