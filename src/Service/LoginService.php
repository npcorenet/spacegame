<?php declare(strict_types=1);

namespace App\Service;

use App\Helper\MessageHelper;
use App\Model\AccountModel;
use App\Table\AccountTable;
use App\Validation\LoginFieldValidation;

class LoginService
{

    public function __construct(
        protected MessageHelper $messageHelper,
        protected AccountModel $accountModel,
        protected AccountTable $accountTable,
        protected AccountService $accountService,
        protected LoginFieldValidation $validation
    )
    {
    }

    public function login(): bool
    {

        if($this->verifyFields() === FALSE)
            return false;

        $accountData = $this->accountTable->findByEmail($this->accountModel->getEmail());

        if($accountData === FALSE || count($accountData) === 0)
        {
            $this->messageHelper->addMessage('danger', 'Es wurde kein Konto mit den angegeben Daten gefunden');
            return false;
        }

        if($accountData['isActivated'] === 0)
        {
            $this->messageHelper->addMessage('danger', 'Das Konto wurde noch nicht aktiviert.');
            return false;
        }

        if($this->accountService->verifyPassword($this->accountModel->getPassword(), $accountData['password']))
        {
            $_SESSION['spacegame_loginId'] = $accountData['id'];
            $this->messageHelper->addMessage('success', 'Das Anmeldung war erfolgreich');
            header("Location: /dashboard/");
            return true;
        }

        $this->messageHelper->addMessage('danger', 'Es wurde kein Konto mit den angegeben Daten gefunden');
        return false;

    }

    private function verifyFields(): bool
    {
        if(
            ($this->validation->validate($this->accountModel, $this->messageHelper)) &&
            ($this->messageHelper->countMessageByType('danger') == 0)
        )
            return true;

        return false;
    }

}
