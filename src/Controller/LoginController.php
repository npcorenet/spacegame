<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\TokenHelper;
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
        $this->data = $this->responseHelper->createResponse(405);
        return $this->response();
    }

    public function run(): Response
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $this->data = $this->responseHelper->createResponse(400);
            return $this->response();
        }

        $account = new Account();
        $account->setEmail($_POST['email']);
        $account->setPassword($_POST['password']);

        $validateData = (new LoginFields($account))->validate();
        if (!empty($validateData)) {
            $this->data = $this->responseHelper->createResponse($validateData['code'], $validateData['message']);
            return $this->response();
        }

        $loginService = new LoginService(
            $account,
            new AccountTable($this->database),
            new TokenHelper(),
            new AccountTokenTable($this->database)
        );

        $loginResponse = $loginService->login();
        $this->data = $this->responseHelper->createResponse(
            $loginResponse['code'],
            $loginResponse['message'],
            $loginResponse['accountInfo'] ?? null
        );
        return $this->response();
    }

}
