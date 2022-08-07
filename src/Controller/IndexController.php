<?php declare(strict_types=1);

namespace App\Controller;

use App\Software;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{

    public function __construct()
    {
    }

    public function load(RequestInterface $request): ResponseInterface
    {

        $response = new Response();

        $response->getBody()->write(json_encode(
            ['version' => Software::VERSION, 'build' => Software::VERSION_CODE, 'development' => (bool)$_ENV['SOFTWARE_INDEV']]
        ));

        return $response->withStatus(200);

    }

}
