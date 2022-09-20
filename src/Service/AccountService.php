<?php

namespace App\Service;

use App\Exception\AccountException;
use App\Model\Authentication\Account;
use App\Table\AccountTable;
use App\Table\AccountTokenTable;

class AccountService
{

    public function __construct(
        private readonly AccountTable $accountTable,
        private readonly SecurityService $securityService,
        private readonly AccountTokenTable $accountTokenTable
    )
    {
    }

    /**
     * @throws AccountException
     */
    public function create(Account $account): bool
    {
        if($this->emailExists($account->getEmail()))
        {
            throw new AccountException('email-used', 400);
        }

        if(!$this->passwordIsValid($account->getPassword()))
        {
            throw new AccountException('password-length', 400);
        }

        $account->setPassword($this->securityService->hashPassword($account->getPassword()));
        return $this->accountTable->insert($account);
    }

    public function findAccountById(int $accountId): ?Account
    {
        $user = $this->accountTable->findById($accountId);
        if($user === FALSE)
        {
            return null;
        }

        return (new Account())->fillFromArray($this->integersToBool($user));
    }

    public function findAccountBySession(string $token): ?Account
    {
        $session = $this->accountTokenTable->findUserByToken($token);
        $accountData = $this->accountTable->findById($session['userId']);
        if(($session === FALSE) || ($accountData === FALSE))
        {
            return null;
        }

        return (new Account())->fillFromArray($this->integersToBool($accountData));
    }

    private function emailExists(string $email): bool
    {
        if($this->accountTable->findByEmail($email) !== FALSE)
        {
            return true;
        }

        return false;
    }

    private function passwordIsValid(string $password): bool
    {
        if(mb_strlen($password) < $_ENV['SOFTWARE_MIN_PASSWORD_LENGTH'])
        {
            return false;
        }

        return true;
    }

    private function integersToBool(array $accountData): array
    {
        if(isset($accountData['active']))
        {
            $accountData['isAdmin'] = $accountData['isAdmin'] === 1;
        }

        if(isset($accountData['active']))
        {
            $accountData['active'] = $accountData['active'] === 1;
        }

        return $accountData;
    }

}