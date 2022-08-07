<?php

namespace App\Helper;

class TokenHelper
{

    public function generateToken(int $tokenLength): string
    {
        return bin2hex(openssl_random_pseudo_bytes($tokenLength));
    }

}