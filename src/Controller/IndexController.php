<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use App\Software;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController extends AbstractController
{

    public function load(RequestInterface $request): ResponseInterface
    {
        return new JsonResponse(200);
    }

}
