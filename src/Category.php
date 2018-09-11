<?php

namespace App;

class Category
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $places;
    /**
     * @var int
     */
    private $point;

    public function __construct(string $name, array $places, int $point)
    {
        $this->name = $name;
        $this->places = $places;
        $this->point = $point;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getPlaces(): array
    {
        return $this->places;
    }

    /**
     * @return int
     */
    public function getPoint(): int
    {
        return $this->point;
    }
}