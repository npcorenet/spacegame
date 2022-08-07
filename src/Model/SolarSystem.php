<?php

namespace App\Model;

class SolarSystem
{

    protected int $id;
    protected string $name;
    protected int $starMass;
    protected int $starRadius;
    protected int $temperature;

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

    public function getStarMass(): int
    {
        return $this->starMass;
    }

    public function setStarMass(int $starMass): void
    {
        $this->starMass = $starMass;
    }

    public function getStarRadius(): int
    {
        return $this->starRadius;
    }

    public function setStarRadius(int $starRadius): void
    {
        $this->starRadius = $starRadius;
    }

    public function getTemperature(): int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): void
    {
        $this->temperature = $temperature;
    }

}