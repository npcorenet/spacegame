<?php

namespace App\Table;

use App\Model\ContractAccount;

class ContractAccountTable extends AbstractTable
{

    public function insert(ContractAccount $contractAccount): int|bool
    {

        $values = $contractAccount->generateArrayFromSetVariables();

        return $this->query->insertInto($this->getTableName())->values($values)->executeWithoutId();

    }

    public function findAllByUserId(int $userId): array|bool
    {
        return $this->query->from($this->getTableName())->where('user', $userId)->fetchAll();
    }

    public function findByContractAndUserId(int $contract, int $userId): array|bool
    {
        $where =
            [
                'contract' => $contract,
                'user' => $userId
            ];

        return $this->query->from($this->getTableName())->where($where)->fetchAll();
    }

    public function findAllByContractId(int $contractId): array|bool
    {
        $where =
            [
                'contract' => $contractId
            ];

        return $this->query->from($this->getTableName())->where($where)->fetchAll();
    }

}