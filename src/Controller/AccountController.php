<?php declare(strict_types=1);

namespace App\Controller;

use App\Helper\TokenHelper;
use App\Table\AccountTable;
use App\Table\AccountTokenTable;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use Psr\Http\Message\RequestInterface;

class AccountController
{

    private array $data = [];

    public function __construct(private readonly Query $query)
    {
    }

    public function load(RequestInterface $request): Response
    {
        $token = $request->getHeaderLine('x-api-key') ?? null;

        $tokenTable = new AccountTokenTable($this->query);

        $tokenData = (new TokenHelper())->verifyAccountToken($token, $tokenTable);

        $userData = (new AccountTable($this->query))->findById($tokenData['userId']);
        $userData['tokenValidUntil'] = $tokenData['validUntil'];

        $userData['isAdmin'] = $userData['isAdmin'] === 1;
        $userData['active'] = $userData['active'] === 1;

        unset($userData['password']);

        $this->data['code'] = 200;
        $this->data['data'] = $userData;

        return $this->response();
    }

    private function response(): Response
    {
        $response = new Response();

        $response->getBody()->write(json_encode($this->data));

        return $response->withStatus($this->data['code'] ?? 500);
    }

}
