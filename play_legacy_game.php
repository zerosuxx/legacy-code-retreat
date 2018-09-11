<?php

require __DIR__ . '/GameRunner.php';

use App\Categories;
use App\Category;



$categories = new Categories();
$categories->addCategory(new Category('Pop', [0, 4, 8], 1));
$categories->addCategory(new Category('Science', [1, 5, 9], 1));
$categories->addCategory(new Category('Sports', [2, 6, 10], 1));
$categories->addCategory(new Category('Rock', [3, 7, 11], 1));
foreach(['Pop', 'Science', 'Sports', 'Rock'] as $category) {
    foreach(range(0, 50) as $i) {
        $categories->addQuestion($category, new \App\Question($category . ' Question ' . $i));
    }
}
(new GameRunner())->run($categories);