<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;

class Contract extends AbstractModel
{

    protected int $id;
    protected string $name;
    protected string $description;
    protected DateTime $availableFrom;
    protected ?DateTime $availableUntil;
    protected int $maxDuration;
    protected int $minimumLevel;
    protected int $prePayment;
    protected int $reward;
    protected ?int $byUser;
    protected int $userLimit;

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

    public function getAvailableFrom(): DateTime
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(DateTime $availableFrom): void
    {
        $this->availableFrom = $availableFrom;
    }

    public function getAvailableUntil(): ?DateTime
    {
        return $this->availableUntil;
    }

    public function setAvailableUntil(?DateTime $availableUntil): void
    {
        $this->availableUntil = $availableUntil;
    }

    public function getMaxDuration(): int
    {
        return $this->maxDuration;
    }

    public function setMaxDuration(int $maxDuration): void
    {
        $this->maxDuration = $maxDuration;
    }

    public function getMinimumLevel(): int
    {
        return $this->minimumLevel;
    }

    public function setMinimumLevel(int $minimumLevel): void
    {
        $this->minimumLevel = $minimumLevel;
    }

    public function getPrePayment(): int
    {
        return $this->prePayment;
    }

    public function setPrePayment(int $prePayment): void
    {
        $this->prePayment = $prePayment;
    }

    public function getReward(): int
    {
        return $this->reward;
    }

    public function setReward(?int $reward): void
    {
        $this->reward = $reward;
    }

    public function getByUser(): ?int
    {
        return $this->byUser;
    }

    public function setByUser(?int $byUser): void
    {
        $this->byUser = $byUser;
    }

    public function getUserLimit(): int
    {
        return $this->userLimit;
    }

    public function setUserLimit(int $userLimit): void
    {
        $this->userLimit = $userLimit;
    }

}
