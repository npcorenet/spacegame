<?php

declare(strict_types=1);

namespace App\Controller;

use App\Software;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController extends AbstractController
{

    public function load(RequestInterface $request): ResponseInterface
    {
        $this->data = $this->responseHelper->createResponse(
            code: 200,
            data: [
            'version' => Software::VERSION,
            'build' => Software::VERSION_CODE,
            ]
        );

        return $this->response();
    }

}
