<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\InvalidFormatException;

class VehicleType
{

    protected int $id;
    protected string $name;
    protected string $description;
    protected string $image;
    protected int $price;
    protected int $highestOrbit;
    protected int $maximumWeight;
    protected string $vehicleData;
    protected int $failRate;
    protected bool $refreshable;

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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getHighestOrbit(): int
    {
        return $this->highestOrbit;
    }

    public function setHighestOrbit(int $highestOrbit): void
    {
        $this->highestOrbit = $highestOrbit;
    }

    public function getMaximumWeight(): int
    {
        return $this->maximumWeight;
    }

    public function setMaximumWeight(int $maximumWeight): void
    {
        $this->maximumWeight = $maximumWeight;
    }

    public function getVehicleData(): string
    {
        return $this->vehicleData;
    }

    /**
     * @throws InvalidFormatException
     */
    public function setVehicleData(string $vehicleData): void
    {
        if (!is_object(json_decode($vehicleData))) {
            throw new InvalidFormatException('Invalid JSON Format', 1);
        }

        $this->vehicleData = $vehicleData;
    }

    public function getFailRate(): int
    {
        return $this->failRate;
    }

    public function setFailRate(int $failRate): void
    {
        $this->failRate = $failRate;
    }

    public function getRefreshable(): bool
    {
        return $this->refreshable;
    }

    public function setRefreshable(bool $refreshable): void
    {
        $this->refreshable = $refreshable;
    }

}
