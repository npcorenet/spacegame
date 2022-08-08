<?php

namespace App\Helper;

use App\Table\AccountTokenTable;

class TokenHelper
{

    public function generateToken(int $tokenLength): string
    {
        return bin2hex(openssl_random_pseudo_bytes($tokenLength));
    }

    public function verifyAccountToken(string $token, AccountTokenTable $tokenTable): bool|array
    {

        if($token === null)
        {
            return false;
        }

        $tokenData = $tokenTable->findUserByToken($token);
        if($tokenData === FALSE)
        {
            return false;
        }

        return $tokenData;

    }

}