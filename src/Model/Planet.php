<?php declare(strict_types=1);

namespace App\Model;

class Planet
{

    protected int $id;
    protected int $solarSystem;
    protected int $moon;
    protected string $name;
    protected int $mass;
    protected int $radius;
    protected int $distance;
    protected int $atmosphereHeight;
    protected int $atmosphereDensity;
    protected bool $oxygen;
    protected bool $solidSurface;
    protected int $coreTemperature;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSolarSystem(): int
    {
        return $this->solarSystem;
    }

    public function setSolarSystem(int $solarSystem): void
    {
        $this->solarSystem = $solarSystem;
    }

    public function getMoon(): int
    {
        return $this->moon;
    }

    public function setMoon(int $moon): void
    {
        $this->moon = $moon;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMass(): int
    {
        return $this->mass;
    }

    public function setMass(int $mass): void
    {
        $this->mass = $mass;
    }

    public function getRadius(): int
    {
        return $this->radius;
    }

    public function setRadius(int $radius): void
    {
        $this->radius = $radius;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): void
    {
        $this->distance = $distance;
    }

    public function getAtmosphereHeight(): int
    {
        return $this->atmosphereHeight;
    }

    public function setAtmosphereHeight(int $atmosphereHeight): void
    {
        $this->atmosphereHeight = $atmosphereHeight;
    }

    public function getAtmosphereDensity(): int
    {
        return $this->atmosphereDensity;
    }

    public function setAtmosphereDensity(int $atmosphereDensity): void
    {
        $this->atmosphereDensity = $atmosphereDensity;
    }

    public function isOxygen(): bool
    {
        return $this->oxygen;
    }

    public function setOxygen(bool $oxygen): void
    {
        $this->oxygen = $oxygen;
    }

    public function getSolidSurface(): bool
    {
        return $this->solidSurface;
    }

    public function setSolidSurface(bool $solidSurface): void
    {
        $this->solidSurface = $solidSurface;
    }

    public function getCoreTemperature(): int
    {
        return $this->coreTemperature;
    }

    public function setCoreTemperature(int $coreTemperature): void
    {
        $this->coreTemperature = $coreTemperature;
    }

}
