<?php declare(strict_types=1);

namespace App\Service;

use App\Helper\MessageHelper;
use App\Model\AccountModel;
use App\Table\AccountTable;
use App\Table\TokenTable;
use App\Validation\RegisterFieldValidation;
use League\Plates\Engine;
use PHPMailer\PHPMailer\PHPMailer;

class RegistrationService
{

    public function __construct(
        private MessageHelper $messageHelper,
        private AccountModel $accountModel,
        private AccountTable $accountTable,
        private AccountService $accountService,
    )
    {
    }

    public function register(
        RegisterFieldValidation $validation,
        ActivateAccountService $activateAccountService,
        TokenTable $tokenTable,
        TokenService $tokenService,
        PHPMailer $mailer,
        Engine $templateEngine
    ): bool
    {

        if($this->verifyFields($validation, $this->accountModel) === FALSE)
            return false;

        if($this->accountTable->findByEmail($this->accountModel->getEmail()) !== FALSE) {
            $this->messageHelper->addMessage('danger', 'Die angegebene E-Mail wird bereits verwendet');
            return false;
        }

        $this->accountModel->setPassword($this->accountService->hashPassword($this->accountModel->getPassword()));

        if($this->accountTable->insert($this->accountModel))
        {
            $this->messageHelper->addMessage('success', 'Das Konto wurde angelegt');
            $token = $activateAccountService->generateActivationToken($tokenTable, $this->accountTable, $this->accountModel, $tokenService);

            if(!$activateAccountService->sendActivationMail($mailer, $this->accountModel->getEmail(), $this->accountModel->getUsername(), $token, $templateEngine))
            {
                $this->messageHelper->addMessage('danger', 'Die Aktivierungs-Email konnte nicht versandt werden. Bitte kontaktiere den Support');
            }

            return true;
        }

        $this->messageHelper->addMessage('danger', 'Ein unbekannter Fehler ist aufgetreten');
        return false;

    }

    public function verifyFields(
        RegisterFieldValidation $validation,
        AccountModel $accountModel
    ): bool
    {
        $validation->validate($accountModel, $this->messageHelper);
        if($this->messageHelper->countMessageByType('danger') > 0)
            return false;

        return true;
    }

}
