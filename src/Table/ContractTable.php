<?php

namespace App\Table;

class ContractTable extends AbstractTable
{

    public function findAllDefault(): array|bool
    {
        return $this->query->from($this->getTableName())->where('byUser', null)->fetchAll();
    }

}