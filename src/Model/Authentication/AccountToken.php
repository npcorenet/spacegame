<?php

declare(strict_types=1);

namespace App\Model\Authentication;

use DateTime;

class AccountToken
{

    protected int $id;
    protected int $userId;
    protected string $token;
    protected DateTime $validUntil;
    protected DateTime $created;
    protected string $creatorIp;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getValidUntil(): DateTime
    {
        return $this->validUntil;
    }

    public function setValidUntil(DateTime $validUntil): void
    {
        $this->validUntil = $validUntil;
    }

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created): void
    {
        $this->created = $created;
    }

}
