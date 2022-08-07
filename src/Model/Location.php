<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;

class Location
{

    protected int $id;
    protected int $user;
    protected string $name;
    protected bool $active;
    protected DateTime $completed;
    protected DateTime $lastLaunch;
    protected int $inclinationMin;
    protected int $inclinationMax;
    protected int $fuelLevel;
    protected int $stabilityLevel;
    protected int $sizeLevel;
    protected int $crewLevel;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCompleted(): DateTime
    {
        return $this->completed;
    }

    public function setCompleted(DateTime $completed): void
    {
        $this->completed = $completed;
    }

    public function getLastLaunch(): DateTime
    {
        return $this->lastLaunch;
    }

    public function setLastLaunch(DateTime $lastLaunch): void
    {
        $this->lastLaunch = $lastLaunch;
    }

    public function getInclinationMin(): int
    {
        return $this->inclinationMin;
    }

    public function setInclinationMin(int $inclinationMin): void
    {
        $this->inclinationMin = $inclinationMin;
    }

    public function getInclinationMax(): int
    {
        return $this->inclinationMax;
    }

    public function setInclinationMax(int $inclinationMax): void
    {
        $this->inclinationMax = $inclinationMax;
    }

    public function getFuelLevel(): int
    {
        return $this->fuelLevel;
    }

    public function setFuelLevel(int $fuelLevel): void
    {
        $this->fuelLevel = $fuelLevel;
    }

    public function getStabilityLevel(): int
    {
        return $this->stabilityLevel;
    }

    public function setStabilityLevel(int $stabilityLevel): void
    {
        $this->stabilityLevel = $stabilityLevel;
    }

    public function getSizeLevel(): int
    {
        return $this->sizeLevel;
    }

    public function setSizeLevel(int $sizeLevel): void
    {
        $this->sizeLevel = $sizeLevel;
    }

    public function getCrewLevel(): int
    {
        return $this->crewLevel;
    }

    public function setCrewLevel(int $crewLevel): void
    {
        $this->crewLevel = $crewLevel;
    }

}
