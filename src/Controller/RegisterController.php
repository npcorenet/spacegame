<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Model\AccountModel;
use App\Service\AccountService;
use App\Table\AccountTable;
use App\Validation\RegisterFieldValidation;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegisterController implements ControllerInterface
{

    private array $messages = [];

    public function __construct(
        protected Engine $templateEngine,
        protected Query $query
    )
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        if($request->getMethod() === 'POST'){

            $this->post($request);

        }

        $response->getBody()->write($this->templateEngine->render('pages/authentication/register', ['messages' => $this->messages]));

        return $response;
    }

    public function post(ServerRequestInterface $request)
    {

        if(isset($_POST['companyNameRegister'],
            $_POST['emailRegister'],
            $_POST['passwordRegister'])
        )
        {

            $accountService = new AccountService();

            $accountModel = new AccountModel();
            $accountModel->setUsername($_POST['companyNameRegister']);
            $accountModel->setEmail($_POST['emailRegister']);
            $accountModel->setPassword($_POST['passwordRegister']);

            $accountTable = new AccountTable($this->query);

            $validation = new RegisterFieldValidation($accountModel);
            $valid = $validation->validate();
            if(count($valid) > 0)
            {
                $this->messages = array_merge($validation->validate(), $this->messages);
                return;
            }


            if(count($accountTable->findByEmail($accountModel->getEmail())) > 0) {
                $this->messages[] = ['type' => 'danger', 'message' => 'Ein Account mit dieser Email existiert bereits'];
                return;
            }

            $accountModel->setPassword($accountService->hashPassword($accountModel->getPassword()));

            if($accountTable->insert($accountModel))
            {
                $this->messages[] = ['type' => 'success', 'message' => 'Konto wurde angelegt'];
                return;
            }

            $this->messages[] = ['type' => 'danger', 'message' => 'Ein unbekannter Fehler ist aufgetreten'];

        }

    }
}