<?php

namespace App\Controller\Admin;

use App\Interfaces\ControllerInterface;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class InfoController implements ControllerInterface
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

        $response->getBody()->write($this->templateEngine->render('pages/admin/info'));

        return $response;
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Implement post() method.
    }

}