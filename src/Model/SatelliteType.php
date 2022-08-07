<?php declare(strict_types=1);

namespace App\Model;

class SatelliteType
{

    public const WEATHER_TYPE = 1;
    public const COMMUNICATION_TYPE = 2;
    public const INTERNET_TYPE = 3;
    public const COORDINATION_TYPE = 4;
    public const PHOTOGRAPHY_TYPE = 5;
    public const HUMAN_TYPE = 6;

    protected int $id;
    protected string $name;
    protected int $minLevel;
    protected int $height;
    protected int $width;
    protected int $length;
    protected int $weight;
    protected int $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMinLevel(): int
    {
        return $this->minLevel;
    }

    public function setMinLevel(int $minLevel): void
    {
        $this->minLevel = $minLevel;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

}
