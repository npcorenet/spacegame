<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use App\Model\Finances\BankAccount;
use App\Service\BankAccountService;
use App\Table\BankAccountTable;
use DateTime;
use DateTimeZone;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class BankController extends AbstractController
{

    public function load(): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $accounts = $bankAccountTable->findAllByUserId($userId);

        $bankAccountService = new BankAccountService();
        $bankAccountLimit = $bankAccountService->countMaxBankAccountsByLevel($this->getUserAccountData()['level']);
        $bankAccountCount = count($bankAccountTable->findAllByUserId($this->getUserAccountData()['id']));

        return new JsonResponse(200, [
            'limit' => $bankAccountLimit,
            'count' => $bankAccountCount,
            'accounts' => $accounts
        ]);
    }

    public function create(RequestInterface $request): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        if (!isset($_POST['name'])) {
            return new JsonResponse(400);
        }

        $bankAccountService = new BankAccountService();
        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountLimit = $bankAccountService->countMaxBankAccountsByLevel($this->getUserAccountData()['level']);
        $bankAccountCount = count($bankAccountTable->findAllByUserId($this->getUserAccountData()['id']));

        if ($bankAccountLimit <= $bankAccountCount) {
            return new JsonResponse(200, ['limit' => $bankAccountLimit, 'current' => $bankAccountCount], 'bank-account-limit-reached');
        }

        $bankAccount = new BankAccount();
        $bankAccount->setAddress($bankAccountService->generateBankAddress());
        $bankAccount->setUser($userId);
        $bankAccount->setCreated(new DateTime('', $this->timeZone));
        $bankAccount->setDefaultAccount($bankAccountCount === 0);
        $bankAccount->setName($_POST['name']);
        if ($bankAccountTable->insert($bankAccount) !== false) {
            return new JsonResponse(200, ['address' => $bankAccount->getAddress(), 'name' => $bankAccount->getName()]);
        }

        return new JsonResponse(500);
    }

    public function show(RequestInterface $request, array $args): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        if (!isset($args['address'])) {
            return new JsonResponse(400);
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountData = $bankAccountTable->findByAddressAndUserId($args['address'], $userId);

        if ($bankAccountData === false) {
            return new JsonResponse(404);
        }

        return new JsonResponse(200, $bankAccountData);
    }

    public function delete(RequestInterface $request, array $args): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        if (!isset($args['token']) || !isset($args['address'])) {
            new JsonResponse(400);
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $accountList = $bankAccountTable->findAllByUserId($userId);
        $tokenList = $bankAccountTable->findByAddress($args['address']);
        if (($accountList === false) || ($tokenList === false)) {
            new JsonResponse(404);
        }

        if ($args['token'] !== $this->token) {
            return new JsonResponse(409);
        }

        if (count($accountList) <= 1) {
            return new JsonResponse(code: 200, message: 'one-account-minimum');
        }

        if (!$bankAccountTable->deleteByAddressAndUserId($args['address'], $userId)) {
            return new JsonResponse(500);
        }

        return new JsonResponse(200);
    }

}
