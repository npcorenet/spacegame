<?php declare(strict_types=1);

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use App\Model\AccountModel;
use App\Service\AccountService;
use App\Service\ActivateAccountService;
use App\Table\AccountTable;
use App\Table\TokenTable;
use App\Validation\RegisterFieldValidation;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use PHPMailer\PHPMailer\PHPMailer;
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
            $accountModel->setAcceptedTerms(isset($_POST['termsRegisterAccept']));

            $accountTable = new AccountTable($this->query);

            $validation = new RegisterFieldValidation($accountModel);
            $valid = $validation->validate();
            if(count($valid) > 0)
            {
                $this->messages = array_merge($validation->validate(), $this->messages);
                return;
            }

            if($accountTable->findByEmail($accountModel->getEmail()) !== FALSE) {
                $this->messages[] = ['type' => 'danger', 'message' => 'Ein Account mit dieser Email existiert bereits'];
                return;
            }

            $accountModel->setPassword($accountService->hashPassword($accountModel->getPassword()));
            $activateAccountService = new ActivateAccountService();

            if($accountTable->insert($accountModel))
            {
                $this->messages[] = ['type' => 'success', 'message' => 'Konto wurde angelegt'];
                $activateAccountService->generateActivationToken(new TokenTable($this->query), $accountTable, $accountModel);
                return;
            }

            $this->messages[] = ['type' => 'danger', 'message' => 'Ein unbekannter Fehler ist aufgetreten'];

        }

    }
}
