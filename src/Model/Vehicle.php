<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;

class Vehicle
{

    protected int $id;
    protected string $name;
    protected int $type;
    protected int $user;
    protected bool $refurbished;
    protected int $flightAmount;
    protected DateTime $available;

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

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getUser(): int
    {
        return $this->user;
    }

    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    public function isRefurbished(): bool
    {
        return $this->refurbished;
    }

    public function setRefurbished(bool $refurbished): void
    {
        $this->refurbished = $refurbished;
    }

    public function getFlightAmount(): int
    {
        return $this->flightAmount;
    }

    public function setFlightAmount(int $flightAmount): void
    {
        $this->flightAmount = $flightAmount;
    }

    public function getAvailable(): DateTime
    {
        return $this->available;
    }

    public function setAvailable(DateTime $available): void
    {
        $this->available = $available;
    }

}
