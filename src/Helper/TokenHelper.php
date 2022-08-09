<?php

namespace App\Helper;

use App\Model\Finances\BankAccount;
use App\Service\BankAccountService;
use App\Table\AccountTokenTable;
use DateTime;

class TokenHelper
{

    public function generateToken(int $tokenLength): string
    {
        return bin2hex(openssl_random_pseudo_bytes($tokenLength));
    }

    public function verifyAccountTokenAndGetData(mixed $token, AccountTokenTable $tokenTable): array
    {
        if ($token === null) {
            return [];
        }

        $tokenData = $tokenTable->findUserByToken($token);

        if (($tokenData === false) || (new DateTime() > new DateTime($tokenData['validUntil']))) {
            return [];
        }

        return $tokenData;
    }

}