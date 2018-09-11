<?php

namespace App;

class Categories
{

    private $categoriesByPlace = [];

    public function add(string $name, array $places, int $point): void
    {
        foreach ($places as $place) {
            $this->categoriesByPlace[$place] = [$name, $point];
        }
    }

    public function getCategoryByPlace(int $place)
    {
        return $this->categoriesByPlace[$place];
    }

}