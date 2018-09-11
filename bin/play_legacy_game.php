<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Categories;
use App\Category;
use App\Game\Game;
use App\Game\GameRunner;
use App\Question;

if(!isset($version)) {
    $version = Game::VERSION_DEFAULT;
}

$questionsCount = $version === Game::VERSION_KICK_AND_ADD ? 10000 : 50;

$categories = new Categories();
$categories->addCategory(new Category('Pop', [0, 4, 8], 1));
$categories->addCategory(new Category('Science', [1, 5, 9], 1));
$categories->addCategory(new Category('Sports', [2, 6, 10], 1));
$categories->addCategory(new Category('Rock', [3, 7, 11], 1));

foreach(['Pop', 'Science', 'Sports', 'Rock'] as $category) {
    foreach(range(0, $questionsCount) as $i) {
        $categories->addQuestion($category, new Question($category . ' Question ' . $i));
    }
}

$players = [
    'Chet',
    'Pat',
    'Sue'
];

(new GameRunner())->run($categories, $players, $version);