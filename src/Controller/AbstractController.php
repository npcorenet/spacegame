<?php
declare(strict_types=1);

namespace App\Controller;

use App\Table\AccountTokenTable;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;

class AbstractController
{

    public const ERROR403 = 'invalid-token';
    public const CODE200 = 'success';

    public array $data = [];

    public function __construct(
        public readonly Query $database
    ) {
    }

    public function isAuthenticatedAndValid(): bool
    {
        if (!isset($_SERVER['HTTP_X_API_KEY'])) {
            return false;
        }

        $token = $_SERVER['HTTP_X_API_KEY'];

        $accountTokenTable = new AccountTokenTable($this->database);
        if ($accountTokenTable->findUserByToken($token) !== false) {
            return true;
        }

        return false;
    }

    public function response(): Response
    {
        $response = new Response();

        $response->getBody()->write(json_encode($this->data));

        return $response;
    }

}
