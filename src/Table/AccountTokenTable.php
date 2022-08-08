<?php
declare(strict_types=1);

namespace App\Table;

use App\Model\Authentication\AccountToken;

class AccountTokenTable extends AbstractTable
{

    public function insert(AccountToken $token): bool|array
    {
        $values =
            [
                'userId' => $token->getUserId(),
                'token' => $token->getToken(),
                'validUntil' => $token->getValidUntil()->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP']),
                'created' => $token->getCreated()->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP']),
                'ip' => $token->getCreatorIp()
            ];

        return $this->query->insertInto($this->getTableName())->values($values)->executeWithoutId();
    }

    public function findUserByToken(string $token): bool|array
    {
        return $this->query->from($this->getTableName())->where('token', $token)->fetch();
    }

}
