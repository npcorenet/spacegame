<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Model\TokenModel;
use App\Model\TokenTypeModel;
use App\Service\ActivateAccountService;
use App\Table\AccountTable;
use App\Table\TokenTable;
use App\Validation\TokenValidation;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ActivateAccountController implements ControllerInterface
{

    public function __construct(protected Query $database)
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        $activateAccountService = new ActivateAccountService();

        if(!isset($_GET['token']))
        {
            header("Location: login/");
            die();
        }

        $tokenModel = new TokenModel();
        $tokenModel->setToken($_GET['token']);

        $tokenTable = new TokenTable($this->database);
        $tokenData = $tokenTable->findByTokenAndType($tokenModel->getToken(), TokenTypeModel::ActivateAccount);
        if($tokenData === FALSE) {
            header("Location: login/");
            return $response;
        }

        $tokenModel->setUser($tokenData['user']);
        $tokenModel->setId($tokenData['id']);
        $tokenModel->setValidUntil($activateAccountService->stringToDateTime($tokenData['validUntil']));

        $validation = new TokenValidation($tokenModel);
        $valid = $validation->validate();

        if(count($valid) > 0)
        {
            foreach ($valid as $message)
            {
                $response->getBody()->write($message['message'] . '<br>');
            }

            return $response;
        }

        $accountTable = new AccountTable($this->database);
        if($accountTable->setActivated(1, $tokenModel->getUser()))
        {
            $tokenTable->setIsUsed(1, $tokenModel->getToken());
            $response->getBody()->write('Das Konto wurde erfolgreich aktiviert. <a href="/login">Anmelden</a>');
            return $response;
        }

        $response->getBody()->write('Das Konto konnte nicht aktiviert werden. <a href="/login">Anmelden</a>');

        return $response;
    }

    public function post(ServerRequestInterface $request)
    {
        // TODO: Implement post() method.
    }
}