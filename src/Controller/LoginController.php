<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper\MessageHelper;
use App\Interfaces\ControllerInterface;
use App\Model\AccountModel;
use App\Service\AccountService;
use App\Service\LoginService;
use App\Table\AccountTable;
use App\Validation\LoginFieldValidation;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController implements ControllerInterface
{

    private array $messages = [];

    public function __construct(
        protected Engine $engine,
        protected Query $database,
        protected MessageHelper $messageHelper
    )
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        if($request->getMethod() === 'POST')
        {
            $this->post($request);
        }

        $response->getBody()->write($this->engine->render('pages/authentication/login', ['messages' => $this->messageHelper->getMessageArray()]));

        return $response;
    }

    public function post(ServerRequestInterface $request)
    {
        if(isset(
            $_POST['emailLogin'],
            $_POST['passwordLogin'])
        )
        {

            $accountModel = new AccountModel();
            $accountModel->setEmail($_POST['emailLogin']);
            $accountModel->setPassword($_POST['passwordLogin']);

            $accountTable = new AccountTable($this->database);
            $accountService = new AccountService();
            $validation = new LoginFieldValidation();


            $loginService = new LoginService(
                $this->messageHelper,
                $accountModel,
                $accountTable,
                $accountService,
                $validation
            );

            $loginService->login();

        }
    }
}
