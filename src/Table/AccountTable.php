<?php declare(strict_types=1);

namespace App\Table;

use App\Model\Authentication\Account;

class AccountTable extends AbstractTable
{

    public function insert(Account $account): bool|array
    {
        $values = [
            'email' => $account->getEmail(),
            'name' => $account->getName(),
            'password' => $account->getPassword()
        ];

        return $this->query->insertInto($this->getTableName())->values($values)->executeWithoutId();
    }

    public function findByEmail(string $email): bool|array
    {

        return $this->query->from($this->getTableName())->where('email', $email)->fetch();

    }

}
