<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\AccountException;
use App\Http\JsonResponse;
use App\Model\Authentication\Account;
use App\Service\AccountService;
use App\Validation\RegisterFields;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class RegisterController extends AbstractController
{

    public function __construct(Query $database, private readonly AccountService $accountService)
    {
        $this->database = $database;
        parent::__construct($this->database);
    }

    public function load(RequestInterface $request): Response
    {
        return new JsonResponse(405);
    }

    public function run(): Response
    {
        $requestData = json_decode(file_get_contents('php://input'), true);
        if (!isset($requestData['email']) || !isset($requestData['username']) || !isset($requestData['password'])) {
            return new JsonResponse(400);
        }

        $account = new Account();
        $account->setEmail($requestData['email']);
        $account->setName($requestData['username']);
        $account->setPassword($requestData['password']);

        $validateFields = new RegisterFields();
        if (!empty($validateData = $validateFields->validate($account))) {
            return new JsonResponse(code: $validateData['code'], message: $validateData['message']);
        }

        try {
            $this->accountService->create($account);
            return new JsonResponse(200);
        } catch (AccountException $exception)
        {
            return new JsonResponse(code: $exception->getCode(), message: $exception->getMessage());
        }
    }

}
