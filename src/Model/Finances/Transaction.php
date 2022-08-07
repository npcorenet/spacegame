<?php

declare(strict_types=1);

namespace App\Model\Finances;

use DateTime;

class Transaction
{

    protected int $id;
    protected int $fromAccount;
    protected int $toAccount;
    protected int $contract;
    protected string $name;
    protected int $amount;
    protected DateTime $time;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFromAccount(): int
    {
        return $this->fromAccount;
    }

    public function setFromAccount(int $fromAccount): void
    {
        $this->fromAccount = $fromAccount;
    }

    public function getToAccount(): int
    {
        return $this->toAccount;
    }

    public function setToAccount(int $toAccount): void
    {
        $this->toAccount = $toAccount;
    }

    public function getContract(): int
    {
        return $this->contract;
    }

    public function setContract(int $contract): void
    {
        $this->contract = $contract;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getTime(): DateTime
    {
        return $this->time;
    }

    public function setTime(DateTime $time): void
    {
        $this->time = $time;
    }

}
