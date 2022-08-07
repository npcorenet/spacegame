<?php

declare(strict_types=1);

namespace App\Service;


use App\Model\Authentication\Account;
use App\Table\AccountTable;
use JetBrains\PhpStorm\ArrayShape;

class RegisterService
{

    public function __construct(
        private readonly Account $account,
        private readonly AccountTable $accountTable
    ) {
    }

    #[ArrayShape(['code' => "int", 'message' => "string"])]
    public function register(): array
    {
        if ($this->accountTable->findByEmail($this->account->getEmail()) !== false) {
            return ['code' => 400, 'message' => 'account-email-used'];
        }

        $this->account->setPassword(password_hash($this->account->getPassword(), PASSWORD_BCRYPT));

        if ($this->accountTable->insert($this->account)) {
            return ['code' => 200, 'message' => 'account-created'];
        }

        return ['code' => 400, 'message' => 'unknown-error'];
    }

}
