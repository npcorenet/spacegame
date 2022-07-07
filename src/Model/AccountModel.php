<?php declare(strict_types=1);

namespace App\Model;

class AccountModel
{

    protected int $id;
    protected string $email;
    protected string $password;
    protected string $username;
    protected string $image;
    protected string $banner;
    protected bool $isPublic;
    protected bool $isAdmin;
    protected int $isActivated;

    protected bool $acceptedTerms;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getBanner(): string
    {
        return $this->banner;
    }

    public function setBanner(string $banner): void
    {
        $this->banner = $banner;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }

    public function getAcceptedTerms(): bool
    {
        return $this->acceptedTerms;
    }

    public function setAcceptedTerms(bool $acceptedTerms): void
    {
        $this->acceptedTerms = $acceptedTerms;
    }

    public function getIsActivated(): int
    {
        return $this->isActivated;
    }

    public function setIsActivated(int $isActivated): void
    {
        $this->isActivated = $isActivated;
    }

}