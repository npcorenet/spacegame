<?php

declare(strict_types=1);

namespace App\Model;

class Satellite
{

    protected int $id;
    protected int $user;
    protected int $planet;
    protected int $solarSystem;
    protected int $type;
    protected string $title;
    protected bool $inOrbit;
    protected int $inclination;
    protected int $periapsis;
    protected int $apoapsis;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    public function getPlanet(): int
    {
        return $this->planet;
    }

    public function setPlanet(int $planet): void
    {
        $this->planet = $planet;
    }

    public function getSolarSystem(): int
    {
        return $this->solarSystem;
    }

    public function setSolarSystem(int $solarSystem): void
    {
        $this->solarSystem = $solarSystem;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function isInOrbit(): bool
    {
        return $this->inOrbit;
    }

    public function setInOrbit(bool $inOrbit): void
    {
        $this->inOrbit = $inOrbit;
    }

    public function getInclination(): int
    {
        return $this->inclination;
    }

    public function setInclination(int $inclination): void
    {
        $this->inclination = $inclination;
    }

    public function getPeriapsis(): int
    {
        return $this->periapsis;
    }

    public function setPeriapsis(int $periapsis): void
    {
        $this->periapsis = $periapsis;
    }

    public function getApoapsis(): int
    {
        return $this->apoapsis;
    }

    public function setApoapsis(int $apoapsis): void
    {
        $this->apoapsis = $apoapsis;
    }

}
