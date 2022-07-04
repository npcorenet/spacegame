<?php declare(strict_types=1);

namespace App\Controller;

use App\Interfaces\ControllerInterface;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IndexController implements ControllerInterface
{

    public function __construct(protected Engine $engine, protected Query $database)
    {
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        echo 'Dev';

        $response->getBody()->write($this->engine->render('pages/home', ['name' => 'Jonathan']));

        return $response;
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Implement post() method.
    }
}