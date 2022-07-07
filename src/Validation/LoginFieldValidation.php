<?php declare(strict_types=1);

namespace App\Validation;

use App\Model\AccountModel;

class LoginFieldValidation
{

    public function __construct(
        private AccountModel $accountModel
    )
    {
    }

    public function validate(): array
    {

        $messages = [];

        if(empty($this->accountModel->getEmail()))
        {
            $messages[] = ['type' => 'danger', 'message' => 'Das E-Mail Feld darf nicht leer sein'];
        }

        if(empty($this->accountModel->getPassword()))
        {
            $messages[] = ['type' => 'danger', 'message' => 'Das Password Feld darf nicht leer sein'];
        }

        return $messages;

    }

}
