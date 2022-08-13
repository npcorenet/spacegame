<?php

declare(strict_types=1);

namespace App\Controller;

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
            return $this->response();
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $accounts = $bankAccountTable->findAllByUserId($userId);

        $bankAccountService = new BankAccountService();
        $bankAccountLimit = $bankAccountService->countMaxBankAccountsByLevel($this->getUserAccountData()['level']);
        $bankAccountCount = count($bankAccountTable->findAllByUserId($this->getUserAccountData()['id']));

        $data = [
            'limit' => $bankAccountLimit,
            'count' => $bankAccountCount,
            'accounts' => $accounts
        ];

        $this->data = $this->responseHelper->createResponse(code: 200, data: $data);

        return $this->response();
    }

    public function create(RequestInterface $request): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        if (!isset($_POST['name'])) {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
        }

        $bankAccountService = new BankAccountService();
        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountLimit = $bankAccountService->countMaxBankAccountsByLevel($this->getUserAccountData()['level']);
        $bankAccountCount = count($bankAccountTable->findAllByUserId($this->getUserAccountData()['id']));

        if ($bankAccountLimit <= $bankAccountCount) {
            $this->data = $this->responseHelper->createResponse(
                code: 200,
                message: 'bank-account-limit-reached',
                data: ['limit' => $bankAccountLimit, 'current' => $bankAccountCount]
            );
            return $this->response();
        }

        $bankAccount = new BankAccount();
        $bankAccount->setAddress($bankAccountService->generateBankAddress());
        $bankAccount->setUser($userId);
        $bankAccount->setCreated(new DateTime('', new DateTimeZone($_ENV['SOFTWARE_TIMEZONE'])));
        $bankAccount->setDefaultAccount($bankAccountCount === 0);
        $bankAccount->setName($_POST['name']);
        if ($bankAccountTable->insert($bankAccount) !== false) {
            $this->data = $this->responseHelper->createResponse(
                code: 200, data: ['address' => $bankAccount->getAddress(), 'name' => $bankAccount->getName()]
            );

            return $this->response();
        }

        $this->data = $this->responseHelper->createResponse(500);
        return $this->response();
    }

    public function show(RequestInterface $request, array $args): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        if (!isset($args['address'])) {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $bankAccountData = $bankAccountTable->findByAddressAndUserId($args['address'], $userId);

        if ($bankAccountData === false) {
            $this->data = $this->responseHelper->createResponse(code: 400, message: 'bank-account-not-found');
            return $this->response();
        }

        $this->data = $this->responseHelper->createResponse(code: 200, data: $bankAccountData);

        return $this->response();
    }

    public function delete(RequestInterface $request, array $args): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        if (!isset($args['token']) || !isset($args['address'])) {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
        }

        $bankAccountTable = new BankAccountTable($this->database);
        $accountList = $bankAccountTable->findAllByUserId($userId);
        $tokenList = $bankAccountTable->findByAddress($args['address']);
        if (($accountList === false) || ($tokenList === false)) {
            $this->data = $this->responseHelper->createResponse(404);
            return $this->response();
        }

        if ($args['token'] !== $this->token) {
            $this->data = $this->responseHelper->createResponse(409, 'confirmation-required');
            return $this->response();
        }

        if (count($accountList) <= 1) {
            $this->data = $this->responseHelper->createResponse(401, 'one-account-minimum');
            return $this->response();
        }

        if (!$bankAccountTable->deleteByAddressAndUserId($args['address'], $userId)) {
            $this->data = $this->responseHelper->createResponse(500);
            return $this->response();
        }

        $this->data = $this->responseHelper->createResponse(200);
        return $this->response();
    }

}
