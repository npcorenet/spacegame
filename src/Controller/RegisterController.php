<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegisterController implements ControllerInterface
{

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

        $response->getBody()->write($this->templateEngine->render('pages/authentication/register'));

        return $response;
    }

    public function post(ServerRequestInterface $request)
    {

        if(isset($_POST['companyNameRegister'],
            $_POST['emailRegister'],
            $_POST['passwordRegister'],
            $_POST['passwordRetypeRegister'])
        )
        {



        }

    }
}