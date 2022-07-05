<?php

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DashboardController implements ControllerInterface
{

    public function __construct(
        protected Engine $templateEngine,
        protected Query $database
    )
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        $response->getBody()->write($this->templateEngine->render('pages/dashboard'));

        return $response;
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Implement post() method.
    }
}