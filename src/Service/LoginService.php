<?php

namespace App\Service;

use App\Helper\TokenHelper;
use App\Model\Authentication\Account;
use App\Model\Authentication\AccountToken;
use App\Table\AccountTable;
use App\Table\AccountTokenTable;
use DateTime;

class LoginService
{

    public function __construct(
        private readonly Account $account,
        private readonly AccountTable $accountTable,
        private readonly TokenHelper $tokenHelper,
        private readonly AccountTokenTable $accountTokenTable
    ) {
    }

    public function login(): array
    {
        $data = $this->accountTable->findByEmail($this->account->getEmail());
        if ($data === false) {
            return ['code' => 404, 'message' => 'account-not-found'];
        }

        if (!password_verify($this->account->getPassword(), $data['password'])) {
            return ['code' => 403, 'message' => 'account-password-wrong'];
        }

        if ($data['active'] === 1) {
            return [
                'code' => 200,
                'message' => 'login-successful',
                'accountInfo' => [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'registered' => $data['registered'],
                    'session' => $this->createToken($data['id'], $this->tokenHelper)
                ]
            ];
        }

        return ['code' => 403, 'message' => 'account-not-activated'];
    }

    private function createToken(int $id, TokenHelper $helper): string
    {
        $token = new AccountToken();
        $token->setUserId($id);
        $token->setToken($helper->generateToken(32));
        $token->setCreated(new DateTime());
        $token->setValidUntil((new DateTime())->modify('+ 30 days'));
        $token->setCreatorIp($_SERVER['REMOTE_ADDR']);

        $this->accountTokenTable->insert($token);

        return $token->getToken();
    }

}