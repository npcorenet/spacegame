<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Finances\BankAccount;
use App\Service\BankAccountService;
use App\Table\BankAccountTable;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class BankController extends AbstractController
{

    public function load(): Response
    {

        $userId = $this->isAuthenticatedAndValid();
        if ($userId === FALSE) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $accounts = $bankAccountTable->findAllByUserId($userId);

        $bankAccountService = new BankAccountService();
        $bankAccountLimit = $bankAccountService->countMaxBankAccountsByLevel($this->getUserAccountData()['level']);
        $bankAccountCount = count($bankAccountTable->findAllByUserId($this->getUserAccountData()['id']));


        $this->data = ['code' => 200, 'message' => self::CODE200, 'data' =>
            ['limit' => $bankAccountLimit,
                'count' => $bankAccountCount,
                'accounts' => $accounts]];

        return $this->response();
    }

    public function create(RequestInterface $request): Response
    {

        $userId = $this->isAuthenticatedAndValid();
        if ($userId === FALSE) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        if($request->getMethod() !== "POST")
        {
            $this->data = ['code' => 400, 'message' => 'request-post'];
            return $this->response();
        }

        if(!isset($_POST['name']))
        {
            $this->data = ['code' => 400, 'message' => 'data-missing'];
            return $this->response();
        }

        $bankAccountService = new BankAccountService();
        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountLimit = $bankAccountService->countMaxBankAccountsByLevel($this->getUserAccountData()['level']);
        $bankAccountCount = count($bankAccountTable->findAllByUserId($this->getUserAccountData()['id']));

        if($bankAccountLimit <= $bankAccountCount)
        {
            $this->data = ['code' => 200, 'message' => 'bank-account-limit-reached', 'data' =>
                ['limit' => $bankAccountLimit, 'current' => $bankAccountCount]];
            return $this->response();
        }

        $bankAccount = new BankAccount();
        $bankAccount->setAddress($bankAccountService->generateBankAddress());
        $bankAccount->setUser($userId);
        $bankAccount->setCreated(new \DateTime('', new \DateTimeZone($_ENV['SOFTWARE_TIMEZONE'])));
        $bankAccount->setDefaultAccount($bankAccountCount === 0 ? 1 : 0);
        $bankAccount->setName($_POST['name']);
        if($bankAccountTable->insert($bankAccount) !==  FALSE) {
            $this->data = ['code' => 200, 'message' => self::CODE200, 'data' =>
                ['address' => $bankAccount->getAddress(),
                    'name' => $bankAccount->getName()]];

            return $this->response();
        }


        $this->data = ['code' => 500, 'message' => 'unknown-error'];

        return $this->response();

    }

    public function show(RequestInterface $request, array $args): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId === FALSE) {
            $this->data = ['code' => 403, 'message' => parent::ERROR403];
            return $this->response();
        }

        if(!isset($args['address']))
        {
            $this->data = ['code' => 400, 'message' => 'missing-arguments'];
            return $this->response();
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountData = $bankAccountTable->findByAddressAndUserId($args['address'], $userId);

        if($bankAccountData === FALSE)
        {
            $this->data = ['code' => 404, 'message' => 'bank-account-not-found'];
            return $this->response();
        }

        $this->data = ['code' => 200, 'message' => self::CODE200, 'data' => $bankAccountData];

        return $this->response();
    }

}
