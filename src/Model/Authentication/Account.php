<?php

declare(strict_types=1);

namespace App\Model\Authentication;

use DateTime;

class Account
{

    protected int $id;
    protected string $name;
    protected string $email;
    protected string $password;
    protected int $experience;
    protected int $level;
    protected DateTime $premium;
    protected DateTime $registered;
    protected bool $isAdmin;
    protected bool $active;

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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getMoney(): int
    {
        return $this->money;
    }

    public function setMoney(int $money): void
    {
        $this->money = $money;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): void
    {
        $this->experience = $experience;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getPremium(): DateTime
    {
        return $this->premium;
    }

    public function setPremium(DateTime $premium): void
    {
        $this->premium = $premium;
    }

    public function getRegistered(): DateTime
    {
        return $this->registered;
    }

    public function setRegistered(DateTime $registered): void
    {
        $this->registered = $registered;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

}
