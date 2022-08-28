<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\AccountException;
use App\Helper\ResponseHelper;
use App\Model\Authentication\Account;
use App\Service\AccountService;
use App\Service\RegisterService;
use App\Table\AccountTable;
use App\Validation\RegisterFields;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class RegisterController extends AbstractController
{

    public function __construct(Query $database, ResponseHelper $responseHelper, private readonly AccountService $accountService)
    {
        $this->database = $database;
        $this->responseHelper = $responseHelper;
        parent::__construct($this->database, $this->responseHelper);
    }

    public function load(RequestInterface $request): Response
    {
        $this->data = $this->responseHelper->createResponse(405);
        return $this->response();
    }

    public function run(): Response
    {
        if (!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST['password'])) {
            $this->data = $this->responseHelper->createResponse(400);
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

        try {
            $this->accountService->create($account);
            $this->data = $this->responseHelper->createResponse(200);
            return $this->response();
        } catch (AccountException $exception)
        {
            $this->data = $this->responseHelper->createResponse($exception->getCode(), $exception->getMessage());
            return $this->response();
        }
    }

}
