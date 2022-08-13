<?php

declare(strict_types=1);

namespace App\Controller;

use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class AccountController extends AbstractController
{

    public function load(RequestInterface $request): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $this->response();
        }

        $this->getUserAccountData();
        unset($this->userData['password']);

        $this->data = $this->responseHelper->createResponse(
            code: 200,
            data: $this->userData
        );
        return $this->response();
    }

}
