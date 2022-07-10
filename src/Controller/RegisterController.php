<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper\MessageHelper;
use App\Interfaces\ControllerInterface;
use App\Model\AccountModel;
use App\Service\AccountService;
use App\Service\ActivateAccountService;
use App\Service\RegistrationService;
use App\Service\TokenService;
use App\Software;
use App\Table\AccountTable;
use App\Table\TokenTable;
use App\Validation\RegisterFieldValidation;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegisterController implements ControllerInterface
{

    public function __construct(
        protected Engine $templateEngine,
        protected Query $query,
        protected PHPMailer $mailer,
        protected MessageHelper $messageHelper
    )
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        if($request->getMethod() === 'POST'){

            $this->post($request);

        }

        $response->getBody()->write($this->templateEngine->render('pages/authentication/register', ['messages' => $this->messageHelper->getMessageArray()]));

        return $response;
    }

    public function post(ServerRequestInterface $request)
    {

        if(isset($_POST['companyNameRegister'],
            $_POST['emailRegister'],
            $_POST['passwordRegister'])
        )
        {

            $accountModel = new AccountModel();
            $accountModel->setUsername($_POST['companyNameRegister']);
            $accountModel->setEmail($_POST['emailRegister']);
            $accountModel->setPassword($_POST['passwordRegister']);
            $accountModel->setAcceptedTerms(isset($_POST['termsRegisterAccept']));

            $accountTable = new AccountTable($this->query);
            $accountService = new AccountService();

            $registrationService = new RegistrationService(
                $this->messageHelper,
                $accountModel,
                $accountTable,
                $accountService
            );

            $validation = new RegisterFieldValidation();
            $activateAccountService = new ActivateAccountService();
            $tokenTable = new TokenTable($this->query);
            $tokenService = new TokenService();

            $registrationService->register(
                $validation,
                $activateAccountService,
                $tokenTable,
                $tokenService,
                $this->mailer,
                $this->templateEngine
            );
        }

    }
}
