<?php

declare(strict_types=1);

namespace App\Service;

class BankAccountService
{

    public function countMaxBankAccountsByLevel(int $level): int
    {
        if ($level < 25) {
            return 1;
        }

        return (int)($level / 25) + 1;
    }

    public function generateBankAddress(): string
    {
        $address = 'SG';

        $loopsLeft = 5;
        while ($loopsLeft !== 0) {
            $address .= '-' . bin2hex(openssl_random_pseudo_bytes(2));

            $loopsLeft--;
        }


        return $address;
    }

}
