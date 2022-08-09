<?php

namespace App\Table;

use App\Model\Finances\Transaction;

class TransactionTable extends AbstractTable
{

    public function insert(Transaction $transaction): bool|array
    {
        $values = [
            'fromAccount' => $transaction->getFromAccount(),
            'toAccount' => $transaction->getToAccount(),
            'contract' => $transaction->getContract() == 0 ? null : $transaction->getContract(),
            'name' => $transaction->getName(),
            'amount' => $transaction->getAmount(),
            'time' => $transaction->getTime()->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP'])
        ];

        return $this->query->insertInto($this->getTableName())->values($values)->executeWithoutId();
    }

}