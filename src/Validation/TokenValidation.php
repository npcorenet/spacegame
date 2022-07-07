<?php

namespace App\Validation;

use App\Model\TokenModel;
use App\Table\AccountTable;

class TokenValidation
{

    public function __construct(
        private TokenModel $tokenModel
    )
    {
    }

    public function validate(): array
    {

        $messages = [];

        if($this->tokenModel->getValidUntil() <= new \DateTime)
        {
            $messages[] = ['type' => 'danger', 'message' => 'Der Aktivierungsschlüssel ist bereits abgelaufen'];
        }

        return $messages;

    }

}