<?php declare(strict_types=1);

namespace App\Service;

use App\Model\AccountModel;
use App\Model\TokenModel;
use App\Model\TokenTypeModel;
use App\Software;
use App\Table\AccountTable;
use App\Table\TokenTable;
use League\Plates\Engine;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ActivateAccountService
{

    public function stringToDateTime($string): \DateTime
    {
        return \DateTime::createFromFormat(TimeService::MySQL_Time_Format, $string);
    }

    public function sendActivationMail(PHPMailer $mailer, string $email, string $username, TokenModel $tokenModel, Engine $engine): bool
    {
        try {
            $mailer->addAddress($email, $username);
            $mailer->isHTML(true);
            $mailer->Subject = Software::TITLE . ':: Kontoaktivierung';
            $mailer->Body = $engine->render('email/activation', ['token' => $tokenModel->getToken(), 'username' => $username]);
            $mailer->AltBody = 'Aktivierungscode für dein Konto: ' . \App\Software::WEBPAGE_URI . '/account/activate?token=' . $tokenModel->getToken();
            $mailer->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function generateActivationTokenString(): string
    {
         return(bin2hex(openssl_random_pseudo_bytes(32)));
    }

    public function generateActivationToken(TokenTable $tokenTable, AccountTable $accountTable, AccountModel $accountModel): TokenModel|bool
    {

        $assignUser = $accountTable->findByEmail($accountModel->getEmail())['id'];

        $expiry = new \DateTime('+1 Hour');

        $tokenModel = new TokenModel();
        $tokenModel->setToken($this->generateActivationTokenString());
        $tokenModel->setUser($assignUser);
        $tokenModel->setType(TokenTypeModel::ActivateAccount);
        $tokenModel->setValidUntil($expiry);

        return $tokenTable->insert($tokenModel) ? $tokenModel : false;

    }

}
