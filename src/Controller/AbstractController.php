<?php
declare(strict_types=1);

namespace App\Controller;

use App\Table\AccountTable;
use App\Table\AccountTokenTable;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;
use phpDocumentor\Reflection\Types\This;

class AbstractController
{

    public const ERROR403 = 'invalid-token';
    public const CODE200 = 'success';

    private int $userId = 0;
    public array $data = [];
    private array $userData = [];

    public function __construct(
        public readonly Query $database
    ) {
    }

    public function isAuthenticatedAndValid(): bool|int
    {
        if (!isset($_SERVER['HTTP_X_API_KEY'])) {
            return false;
        }

        $token = $_SERVER['HTTP_X_API_KEY'];

        $accountTokenTable = new AccountTokenTable($this->database);
        $accountTokenData = $accountTokenTable->findUserByToken($token);
        if ($accountTokenData !== FALSE) {
            $this->userId = $accountTokenData['userId'];
            return $accountTokenData['userId'];
        }

        return false;
    }

    public function response(): Response
    {
        $response = new Response();

        $response->getBody()->write(json_encode($this->data));

        return $response;
    }

    public function getUserAccountData(): array
    {
        if($this->userId === 0)
        {
            return [];
        }

        if(empty($this->userData))
        {
            $accountTable = new AccountTable($this->database);
            return $accountTable->findById($this->userId);
        }

        return $this->userData;

    }

}
