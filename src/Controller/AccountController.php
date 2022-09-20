<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use App\Model\Authentication\Account;
use http\Client\Curl\User;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class AccountController extends AbstractController
{

    public function load(ServerRequestInterface $request): Response
    {
        /* @var Account $account */
        $account = $request->getAttribute(Account::class);

        $account = $account->generateArrayFromSetVariables();
        unset($account['password']);

        return new JsonResponse(200, $account);
    }

}
