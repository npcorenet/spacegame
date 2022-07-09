<?php declare(strict_types=1);

namespace App\Table;

use App\Model\TokenModel;
use App\Service\TimeService;

class TokenTable extends AbstractTable
{

    public function insert(TokenModel $tokenModel): bool|array
    {
        $values = [
            'token' => $tokenModel->getToken(),
            'validUntil' => $tokenModel->getValidUntil()->format(TimeService::MySQL_Time_Format),
            'type' => $tokenModel->getType(),
            'user' => $tokenModel->getUser()
        ];

        return $this->query->insertInto($this->getTableName())->values($values)->executeWithoutId();
    }

    public function findByToken(string $token): bool|array
    {
        return $this->query->from($this->getTableName())->where('token', $token)->fetch();
    }

    public function findByTokenAndType(string $token, int $type): bool|array
    {
        $condition = [
            'token' => $token,
            'type' => $type
        ];
        return $this->query->from($this->getTableName())->where($condition)->fetch();
    }

    public function setIsUsed(int $status, string $token): bool|array
    {
        return $this->query->update($this->getTableName())->set('isUsed', $status)->where('token', $token)->execute();
    }

}
