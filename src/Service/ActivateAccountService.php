<?php declare(strict_types=1);

namespace App\Service;

use App\Model\AccountModel;
use App\Model\TokenModel;
use App\Model\TokenTypeModel;
use App\Software;
use App\Table\AccountTable;
use App\Table\TokenTable;

class ActivateAccountService
{

    public function stringToDateTime($string): \DateTime
    {
        return \DateTime::createFromFormat(TimeService::MySQL_Time_Format, $string);
    }

    public function sendActivationMail(string $email, string $activationToken): bool
    {
        return false;
    }

    public function generateActivationTokenString(): string
    {
         return(bin2hex(openssl_random_pseudo_bytes(32)));
    }

    public function generateActivationToken(TokenTable $tokenTable, AccountTable $accountTable, AccountModel $accountModel): bool
    {

        $assignUser = $accountTable->findByEmail($accountModel->getEmail())['id'];

        $expiry = new \DateTime('+1 Hour');

        $tokenModel = new TokenModel();
        $tokenModel->setToken($this->generateActivationTokenString());
        $tokenModel->setUser($assignUser);
        $tokenModel->setType(TokenTypeModel::ActivateAccount);
        $tokenModel->setValidUntil($expiry);

        return $tokenTable->insert($tokenModel);

    }

}
