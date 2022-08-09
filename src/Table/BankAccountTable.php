<?php declare(strict_types=1);

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

        return $this->query->insertInto($this->getTableName())->values($values)->executeWithoutId();
    }

    public function findAllByUserId(int $userId): bool|array
    {

        return $this->query->from($this->getTableName())->where('user', $userId)->fetchAll();

    }

    public function findByAddress(string $address): bool|array
    {
        $where = ['address' => $address];

        return $this->query->from($this->getTableName())->where($where)->fetch();
    }

    public function findByAddressAndUserId(string $address, int $userId): bool|array
    {
        $where = ['address' => $address, 'user' => $userId];

        return $this->query->from($this->getTableName())->where($where)->fetch();
    }

    public function deleteByAddressAndUserId(string $address, int $userId): bool|array
    {
        $where = ['address' => $address, 'user' => $userId];

        return $this->query->delete($this->getTableName())->where($where)->execute() == 1;
    }

}
