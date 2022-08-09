<?php

namespace App\Table;

use App\Model\Finances\BankAccount;

class BankAccountTable extends AbstractTable
{

    public function insert(BankAccount $bankAccount): bool|int
    {
        $values = [
            'user' => $bankAccount->getUser(),
            'address' => $bankAccount->getAddress(),
            'name' => $bankAccount->getName(),
            'created' => $bankAccount->getCreated()->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP']),
            'defaultAccount' => $bankAccount->isDefaultAccount() ? 1 : 0
        ];

        return $this->query->insertInto($this->getTableName())->values($values)->execute();
    }

    public function findAllByUserId(int $userId): bool|array
    {

        return $this->query->from($this->getTableName())->where('user', $userId)->fetchAll();

    }

}