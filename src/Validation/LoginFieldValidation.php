<?php declare(strict_types=1);

namespace App\Validation;

use App\Helper\MessageHelper;
use App\Model\AccountModel;

class LoginFieldValidation
{

    public function validate(
        AccountModel $accountModel,
        MessageHelper $messageHelper
    ): self
    {

        if(empty($accountModel->getEmail()))
        {
            $messageHelper->addMessage('danger', 'Das E-Mail Feld darf nicht leer sein');
        }

        if(empty($accountModel->getPassword()))
        {
            $messageHelper->addMessage('danger', 'Das Passwort Feld darf nicht leer sein');
        }

        return $this;

    }

}
