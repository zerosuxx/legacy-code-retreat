<?php

use App\Category;

include __DIR__.'/Game.php';
include __DIR__.'/vendor/autoload.php';

$notAWinner;

$categories = new \App\Categories();
$categories->addCategory(new Category('Pop', [0, 4, 8], 1));
$categories->addCategory(new Category('Science', [1, 5, 9], 1));
$categories->addCategory(new Category('Sports', [2, 6, 10], 1));
$categories->addCategory(new Category('Rock', [3, 7, 11], 1));
foreach(['Pop', 'Science', 'Sports', 'Rock'] as $category) {
    foreach(range(0, 50) as $i) {
        $categories->addQuestion($category, new \App\Question($category . ' Question ' . $i));
    }
}

$aGame = new Game($categories);

$aGame->add("Chet");
$aGame->add("Pat");
$aGame->add("Sue");


do {

    $aGame->roll(rand(0,5) + 1);

    if (rand(0,9) == 7) {
        $notAWinner = $aGame->wrongAnswer();
    } else {
        $notAWinner = $aGame->wasCorrectlyAnswered();
    }



} while ($notAWinner);

