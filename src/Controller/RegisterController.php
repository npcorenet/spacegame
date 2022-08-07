<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\Authentication\Account;
use App\Service\RegisterService;
use App\Table\AccountTable;
use App\Validation\RegisterFields;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class RegisterController
{

    private array $data = [];

    public function __construct(private Query $database)
    {
    }

    public function load(RequestInterface $request)
    {

        $response = new Response();

        if($request->getMethod() !== 'POST')
        {
            $this->data['message'] = 'This requires to be called with POST';
            $this->data['code'] = 400;

            $response->getBody()->write(json_encode($this->data));

            return $response->withStatus($this->data['code'] ?? 500);
        }

        $this->processPost($request, $response);


        $response->getBody()->write(json_encode($this->data));

        return $response->withStatus($this->data['code'] ?? 500);

    }

    public function processPost(RequestInterface $request, ResponseInterface $response): void
    {

        if(!isset($_POST['email']) || !isset($_POST['username']) || !isset($_POST['password']))
        {
            $this->data = ['code' => 400, 'message' => 'Please make sure, that all required data is sent!'];
            return;
        }

        $account = new Account();
        $account->setEmail($_POST['email']);
        $account->setName($_POST['username']);
        $account->setPassword($_POST['password']);

        $validateFields = new RegisterFields();

        if(!empty($validateData = $validateFields->validate($account)))
        {
            $this->data = $validateData;
            return;
        }

        $service = new RegisterService(
            $account,
            new AccountTable($this->database)
        );

        $this->data = $service->register();
        return;

    }

}
