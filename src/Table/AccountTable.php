<?php

namespace App\Table;

use App\Model\AccountModel;
use App\Table\AbstractTable;

class AccountTable extends AbstractTable
{

    public function findByEmail(string $email): bool|array
    {
        return $this->query->from($this->getTableName())->where('email', $email)->fetch();
    }

    public function insert(AccountModel $accountModel): bool|array
    {

        $values =
            [
                'email' => $accountModel->getEmail(),
                'password' => $accountModel->getPassword(),
                'username' => $accountModel->getUsername()
            ];

        return $this->query->insertInto($this->getTableName())->values($values)->execute();

    }

}