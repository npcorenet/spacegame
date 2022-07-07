<?php declare(strict_types=1);

namespace App\Service;

class AccountService
{

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password, string $passwordHashed): bool
    {
        return password_verify($password, $passwordHashed);
    }

}
