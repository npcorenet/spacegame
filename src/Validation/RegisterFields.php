<?php

namespace App\Validation;

use App\Model\Authentication\Account;

class RegisterFields
{

    public function validate(Account $account): array
    {
        if (!filter_var($account->getEmail()) == FILTER_VALIDATE_EMAIL) {
            return ['code' => 400, 'message' => 'email-invalid'];
        }

        if (empty($account->getName())) {
            return ['code' => 400, 'message' => 'name-empty'];
        }

        if (mb_strlen($account->getPassword()) < $_ENV['SOFTWARE_MIN_PASSWORD_LENGTH']) {
            return ['code' => 400, 'message' => 'password-minimum-length-' . $_ENV['SOFTWARE_MIN_PASSWORD_LENGTH']];
        }

        return [];
    }

}