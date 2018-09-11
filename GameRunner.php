<?php

include __DIR__.'/Game.php';
include __DIR__.'/vendor/autoload.php';

$notAWinner;

$categories = new \App\Categories();
$categories->add('Pop', [0, 4, 8], 1);
$categories->add('Science', [1, 5, 9], 1);
$categories->add('Sports', [2, 6, 10], 1);
$categories->add('Rock', [3, 7, 11], 1);

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

