<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class AccountController extends AbstractController
{

    public function load(RequestInterface $request): Response
    {
        $userId = $this->isAuthenticatedAndValid();
        if ($userId instanceof Response) {
            return $userId;
        }

        $this->getUserAccountData();
        unset($this->userData['password']);

        return new JsonResponse(200, $this->userData);
    }

}
