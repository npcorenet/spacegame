<?php

declare(strict_types=1);

namespace App\Controller;

use App\Helper\TokenHelper;
use App\Model\Authentication\Account;
use App\Service\LoginService;
use App\Table\AccountTable;
use App\Table\AccountTokenTable;
use App\Validation\LoginFields;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class LoginController
{

    private array $data = [];

    public function __construct(private readonly Query $database)
    {
    }

    public function load(RequestInterface $request): Response
    {
        $response = new Response();

        if ($request->getMethod() !== 'POST') {
            $this->data['message'] = 'This requires to be called with POST';
            $this->data['code'] = 400;

            $response->getBody()->write(json_encode($this->data));
            return $response->withStatus($this->data['code'] ?? 500);
        }

        $this->processPost();

        $response->getBody()->write(json_encode($this->data));
        return $response->withStatus($this->data['code'] ?? 500);
    }

    public function processPost(): void
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $this->data = ['code' => 400, 'message' => 'Please make sure, that all required data is sent!'];
            return;
        }

        $account = new Account();
        $account->setEmail($_POST['email']);
        $account->setPassword($_POST['password']);

        $validateData = (new LoginFields($account))->validate();
        if (!empty($validateData)) {
            $this->data = $validateData;
            return;
        }

        $loginService = new LoginService(
            $account,
            new AccountTable($this->database),
            new TokenHelper(),
            new AccountTokenTable($this->database)
        );

        $this->data = $loginService->login();
    }

}
