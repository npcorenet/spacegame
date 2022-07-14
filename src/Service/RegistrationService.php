<?php declare(strict_types=1);

namespace App\Service;

use App\Helper\EmailHelper;
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
        private RegisterFieldValidation $validation,
        private MessageHelper $messageHelper,
        private AccountModel $accountModel,
        private AccountTable $accountTable,
        private AccountService $accountService,
        private ActivateAccountService $activateAccountService,
        private TokenTable $tokenTable,
        private TokenService $tokenService,
        private EmailHelper $mailer
    )
    {
    }

    public function register(): bool
    {

        if($this->verifyFields() === FALSE)
            return false;

        if($this->accountTable->findByEmail($this->accountModel->getEmail()) !== FALSE) {
            $this->messageHelper->addMessage('danger', 'Die angegebene E-Mail wird bereits verwendet');
            return false;
        }

        $this->accountModel->setPassword($this->accountService->hashPassword($this->accountModel->getPassword()));

        if($this->accountTable->insert($this->accountModel))
        {
            $this->messageHelper->addMessage('success', 'Das Konto wurde angelegt');
            $token = $this->activateAccountService->generateActivationToken(
                $this->tokenTable,
                $this->accountTable,
                $this->accountModel,
                $this->tokenService
            );

            if(!$this->activateAccountService->sendActivationMail(
                $this->mailer,
                $this->accountModel->getEmail(),
                $this->accountModel->getUsername(),
                $token)
            )
            {
                $this->messageHelper->addMessage('danger', 'Die Aktivierungs-Email konnte nicht versandt werden. Bitte kontaktiere den Support');
            }

            return true;
        }

        $this->messageHelper->addMessage('danger', 'Ein unbekannter Fehler ist aufgetreten');
        return false;

    }

    private function verifyFields(): bool
    {
        return ($this->validation->validate($this->accountModel, $this->messageHelper)) &&
            ($this->messageHelper->countMessageByType('danger') === 0);
    }

}
