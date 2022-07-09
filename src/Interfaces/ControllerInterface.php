<?php declare(strict_types=1);

namespace App\Interfaces;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ControllerInterface
{

    public function get(ServerRequestInterface $request): ResponseInterface;

    public function post(ServerRequestInterface $request);

}
