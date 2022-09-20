<?php

namespace App\Middleware;

use App\Http\JsonResponse;
use App\Model\Authentication\Account;
use App\Service\AccountService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly AccountService $accountService
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $sessionIdentifier = $request->getHeaderLine('x-api-key');

        $account = $this->accountService->findAccountBySession($sessionIdentifier);

        if($account === FALSE)
        {
            return new JsonResponse(403);
        }

        return $handler->handle($request->withAttribute(Account::class, $account));
    }
}