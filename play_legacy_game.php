<?php

require __DIR__ . '/vendor/autoload.php';

use App\Categories;
use App\Category;

$categories = new Categories();
$categories->addCategory(new Category('Pop', [0, 4, 8], 1));
$categories->addCategory(new Category('Science', [1, 5, 9], 1));
$categories->addCategory(new Category('Sports', [2, 6, 10], 1));
$categories->addCategory(new Category('Rock', [3, 7, 11], 1));
foreach(['Pop', 'Science', 'Sports', 'Rock'] as $category) {
    foreach(range(0, 10000) as $i) {
        $categories->addQuestion($category, new \App\Question($category . ' Question ' . $i));
    }
}
$players = [
    'Chet',
    'Pat',
    'Sue'
];

if(!isset($version)) {
    $version = 1;
}

(new GameRunner())->run($categories, $players, (int)$version);