<?php

namespace App\Service;

class AccountService
{

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

}