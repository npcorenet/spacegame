<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper\MessageHelper;
use App\Interfaces\ControllerInterface;
use App\Model\TokenModel;
use App\Service\ActivateAccountService;
use App\Service\ActivationService;
use App\Table\AccountTable;
use App\Table\TokenTable;
use App\Validation\TokenValidation;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ActivateAccountController implements ControllerInterface
{

    public function __construct(protected Query $database, protected MessageHelper $messageHelper)
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        if(!isset($_GET['token']))
        {
            header("Location: login/");
            die();
        }

        $tokenModel = new TokenModel();
        $tokenModel->setToken($_GET['token']);

        $activateAccountService = new ActivateAccountService();
        $tokenTable = new TokenTable($this->database);
        $tokenValidation = new TokenValidation();
        $accountTable = new AccountTable($this->database);

        $activationService = new ActivationService(
            $activateAccountService,
            $tokenModel,
            $tokenTable,
            $tokenValidation,
            $accountTable,
            $this->messageHelper
        );
        $activationService->activate();

        foreach ($this->messageHelper->getMessageArray() as $message)
        {
            $response->getBody()->write($message['message']);
        }

        return $response;
    }

    public function post(ServerRequestInterface $request)
    {
        // TODO: Implement post() method.
    }
}
