<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\TokenHelper;
use App\Http\JsonResponse;
use App\Model\Authentication\Account;
use App\Service\LoginService;
use App\Table\AccountTable;
use App\Table\AccountTokenTable;
use App\Validation\LoginFields;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class LoginController extends AbstractController
{

    public function load(RequestInterface $request): Response
    {
        return new JsonResponse(405);
    }

    public function run(): Response
    {
        $requestData = json_decode(file_get_contents('php://input'), true);
        if (!isset($requestData['email']) || !isset($requestData['password'])) {
            return new JsonResponse(400);
        }

        $account = new Account();
        $account->setEmail($requestData['email']);
        $account->setPassword($requestData['password']);

        $validateData = (new LoginFields($account))->validate();
        if (!empty($validateData)) {
            return new JsonResponse(code: $validateData['code'], message: $validateData['message']);
        }

        $loginService = new LoginService(
            $account,
            new AccountTable($this->database),
            new TokenHelper(),
            new AccountTokenTable($this->database)
        );

        $loginResponse = $loginService->login();
        return new JsonResponse($loginResponse['code'], $loginResponse['accountInfo'] ?? null, $loginResponse['message']);
    }

}
