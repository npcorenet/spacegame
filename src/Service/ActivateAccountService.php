<?php declare(strict_types=1);

namespace App\Service;

use App\Helper\EmailHelper;
use App\Model\AccountModel;
use App\Model\TokenModel;
use App\Model\TokenTypeModel;
use App\Software;
use App\Table\AccountTable;
use App\Table\TokenTable;

class ActivateAccountService
{

    public function sendActivationMail(
        EmailHelper $mailer,
        string $email,
        string $username,
        TokenModel $tokenModel,
    ): bool
    {

        return $mailer->sendMail('activation', $email, $_ENV['SOFTWARE_TITLE'] . ':: Kontoaktivierung', ['token' => $tokenModel->getToken(), 'username' => $username]);

    }

    public function generateActivationToken(
        TokenTable $tokenTable,
        AccountTable $accountTable,
        AccountModel $accountModel,
        TokenService $tokenService
    ): TokenModel|bool
    {

        $assignUser = $accountTable->findByEmail($accountModel->getEmail())['id'];

        $expiry = new \DateTime('+1 Hour');

        $tokenModel = new TokenModel();
        $tokenModel->setToken($tokenService->generateTokenString());
        $tokenModel->setUser($assignUser);
        $tokenModel->setType(TokenTypeModel::ActivateAccount);
        $tokenModel->setValidUntil($expiry);

        return $tokenTable->insert($tokenModel) ? $tokenModel : false;

    }

    public function stringToDateTime($string): \DateTime
    {
        return \DateTime::createFromFormat(TimeService::MySQL_Time_Format, $string);
    }

}
