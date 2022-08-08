<?php

namespace App\Validation;

use App\Model\Authentication\Account;

class LoginFields
{

    public function __construct(private readonly Account $account)
    {
    }

    public function validate(): array
    {
        if (!filter_var($this->account->getEmail(), FILTER_VALIDATE_EMAIL)) {
            return ['code' => 400, 'message' => 'email-invalid'];
        }

        if (empty($this->account->getPassword())) {
            return ['code' => 400, 'message' => 'password-empty'];
        }

        return [];
    }

}