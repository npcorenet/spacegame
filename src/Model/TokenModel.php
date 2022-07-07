<?php declare(strict_types=1);

namespace App\Model;

class TokenModel
{

    protected int $id;
    protected string $token;
    protected \DateTime $validUntil;
    protected \DateTime $created;
    protected int $type;
    protected int $user;
    protected int $isUsed;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getValidUntil(): \DateTime
    {
        return $this->validUntil;
    }

    public function setValidUntil(\DateTime $validUntil): void
    {
        $this->validUntil = $validUntil;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
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

    public function getIsUsed(): int
    {
        return $this->isUsed;
    }

    public function setIsUsed(int $isUsed): void
    {
        $this->isUsed = $isUsed;
    }

}
