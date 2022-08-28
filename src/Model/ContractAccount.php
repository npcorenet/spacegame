<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;

class ContractAccount extends AbstractModel
{

    protected int $id;
    protected int $user;
    protected int $vehicle;
    protected int $contract;
    protected DateTime $started;
    protected DateTime $expires;
    protected bool $completed;
    protected bool $success;
    protected int $expenses;
    protected int $expensesLimit;

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

    public function getVehicle(): int
    {
        return $this->vehicle;
    }

    public function setVehicle(int $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    public function getContract(): int
    {
        return $this->contract;
    }

    public function setContract(int $contract): void
    {
        $this->contract = $contract;
    }

    public function getStarted(): DateTime
    {
        return $this->started;
    }

    public function setStarted(DateTime $started): void
    {
        $this->started = $started;
    }

    public function getExpires(): DateTime
    {
        return $this->expires;
    }

    public function setExpires(DateTime $expires): void
    {
        $this->expires = $expires;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): void
    {
        $this->completed = $completed;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function getExpenses(): int
    {
        return $this->expenses;
    }

    public function setExpenses(int $expenses): void
    {
        $this->expenses = $expenses;
    }

    public function getExpensesLimit(): int
    {
        return $this->expensesLimit;
    }

    public function setExpensesLimit(int $expensesLimit): void
    {
        $this->expensesLimit = $expensesLimit;
    }

}
