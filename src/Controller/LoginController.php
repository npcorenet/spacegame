<?php declare(strict_types=1);

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Model\AccountModel;
use App\Service\AccountService;
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
        protected Query $database
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

        $response->getBody()->write($this->engine->render('pages/authentication/login', ['messages' => $this->messages]));

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

            $validation = new LoginFieldValidation($accountModel);
            $valid = $validation->validate();

            if(count($valid) > 0)
            {
                $this->messages[] = array_merge($valid, $this->messages);
                return;
            }

            $accountTable = new AccountTable($this->database);
            $accountData = $accountTable->findByEmail($accountModel->getEmail());

            if($accountData === FALSE || count($accountData) === 0)
            {
                $this->messages[] = ['type' => 'danger', 'message' => 'Es wurde kein Konto mit den angegebenen Daten gefunden'];
                return;
            }

            $accountService = new AccountService();

            if($accountService->verifyPassword($accountModel->getPassword(), $accountData['password']))
            {
                $_SESSION['spacegame_loginId'] = $accountData['id'];
                $this->messages[] = ['type' => 'success', 'message' => 'Die Anmeldung war erfolgreich.'];
                // header("Location: /dashboard/");
                return;
            }

            $this->messages[] = ['type' => 'danger', 'message' => 'Es wurde kein Konto mit den angegebenen Daten gefunden'];

        }
    }
}