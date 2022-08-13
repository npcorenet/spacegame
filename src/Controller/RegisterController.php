<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Authentication\Account;
use App\Service\RegisterService;
use App\Table\AccountTable;
use App\Validation\RegisterFields;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class RegisterController extends AbstractController
{

    public function load(RequestInterface $request): Response
    {
        $this->data = $this->responseHelper->createResponse(405);
        return $this->response();
    }

    public function run(): Response
    {
        if (!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST['password'])) {
            $this->data = ['code' => 400, 'message' => 'Please make sure, that all required data is sent!'];
            return $this->response();
        }

        $account = new Account();
        $account->setEmail($_POST['email']);
        $account->setName($_POST['username']);
        $account->setPassword($_POST['password']);

        $validateFields = new RegisterFields();

        if (!empty($validateData = $validateFields->validate($account))) {
            $this->data = $validateData;
            return $this->response();
        }

        $service = new RegisterService(
            $account,
            new AccountTable($this->database)
        );

        $registerResponse = $service->register();
        $this->data = $this->responseHelper->createResponse($registerResponse['code'], $registerResponse['message']);
        return $this->response();
    }

}
