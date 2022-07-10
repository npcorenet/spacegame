<?php

namespace App\Service;

class TokenService
{

    public function generateTokenString(): string
    {
        return(bin2hex(openssl_random_pseudo_bytes(32)));
    }

}