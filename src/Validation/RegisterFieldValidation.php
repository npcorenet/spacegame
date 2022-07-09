<?php declare(strict_types=1);

namespace App\Validation;

use App\Helper\MessageHelper;
use App\Model\AccountModel;

class RegisterFieldValidation
{

    public function __construct(
        private AccountModel $accountModel,
        private MessageHelper $messageHelper
    )
    {
    }

    public function validate(): self
    {

        if(!filter_var($this->accountModel->getEmail(), FILTER_VALIDATE_EMAIL))
        {
            $this->messageHelper->addMessage('danger', 'Die angegebene E-Mail ist ungültig');
        }

        if(empty($this->accountModel->getUsername())) {
            $this->messageHelper->addMessage('danger', 'Der Unternehmensname darf nicht leer sein');
        }

        if(mb_strlen($this->accountModel->getPassword()) < 8) {
            $this->messageHelper->addMessage('danger', 'Das Passwort muss mindestens 8 Zeichen lang sein');
        }

        if(!$this->accountModel->getAcceptedTerms()) {
            $this->messageHelper->addMessage('danger', 'Die Nutzungsbedingungen müssen akzeptiert werden');
        }

        return $this;

    }

}
