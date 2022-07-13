<?php declare(strict_types=1);

namespace App\Validation;

use App\Helper\MessageHelper;
use App\Model\AccountModel;

class RegisterFieldValidation
{

    public function validate(
        AccountModel $accountModel,
        MessageHelper $messageHelper
    ): self
    {

        if(!filter_var($accountModel->getEmail(), FILTER_VALIDATE_EMAIL))
        {
            $messageHelper->addMessage('danger', 'Die angegebene E-Mail ist ungültig');
        }

        if(empty($accountModel->getUsername())) {
            $messageHelper->addMessage('danger', 'Der Unternehmensname darf nicht leer sein');
        }

        if(mb_strlen($accountModel->getPassword()) < 8) {
            $messageHelper->addMessage('danger', 'Das Passwort muss mindestens 8 Zeichen lang sein');
        }

        if(!$accountModel->getAcceptedTerms()) {
            $messageHelper->addMessage('danger', 'Die Nutzungsbedingungen müssen akzeptiert werden');
        }

        return $this;

    }

}
