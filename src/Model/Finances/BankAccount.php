<?php

declare(strict_types=1);

namespace App\Model\Finances;

use DateTime;

class BankAccount
{

    protected int $id;
    protected int $user;
    protected string $address;
    protected int $dailyMaximum;
    protected DateTime $created;
    protected bool $defaultAccount;
    protected bool $debtAllowed;
    protected int $amount;

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

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getDailyMaximum(): int
    {
        return $this->dailyMaximum;
    }

    public function setDailyMaximum(int $dailyMaximum): void
    {
        $this->dailyMaximum = $dailyMaximum;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

    public function isDefaultAccount(): bool
    {
        return $this->defaultAccount;
    }

    public function setDefaultAccount(bool $defaultAccount): void
    {
        $this->defaultAccount = $defaultAccount;
    }

    public function isDebtAllowed(): bool
    {
        return $this->debtAllowed;
    }

    public function setDebtAllowed(bool $debtAllowed): void
    {
        $this->debtAllowed = $debtAllowed;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

}
