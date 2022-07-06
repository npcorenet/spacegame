<?php declare(strict_types=1);

namespace App\Validation;

use App\Model\AccountModel;

class RegisterFieldValidation
{

    public function __construct(
        private AccountModel $accountModel
    )
    {
    }

    public function validate(): array
    {

        $messages = [];

        if(!filter_var($this->accountModel->getEmail(), FILTER_VALIDATE_EMAIL))
        {
            $messages[] = ['type' => 'danger', 'message' => 'Die angegebene Email ist ungültig'];
        }

        if(empty($this->accountModel->getUsername())) {
            $messages[] = ['type' => 'danger', 'message' => 'Der Unternehmensname darf nicht leer sein'];
        }

        if(mb_strlen($this->accountModel->getPassword()) < 8) {
            $messages[] = ['type' => 'danger', 'message' => 'Das Passwort muss mindestens 8 Zeichen lang sein'];
        }

        return $messages;

    }

}