<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\JsonResponse;
use App\Table\AccountTable;
use App\Table\AccountTokenTable;
use DateTime;
use DateTimeZone;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Response;

abstract class AbstractController
{

    public string $token;
    public array $userData = [];
    private int $userId = 0;
    private DateTime $tokenValidUntil;
    public DateTimeZone $timeZone;

    public function __construct(
        public Query $database
    ) {
        $this->timeZone = new DateTimeZone($_ENV['SOFTWARE_TIMEZONE']);
    }

    public function isAuthenticatedAndValid(): Response|int
    {
        if (!isset($_SERVER['HTTP_X_API_KEY'])) {
            return new JsonResponse(403);
        }

        $token = $_SERVER['HTTP_X_API_KEY'];

        $accountTokenTable = new AccountTokenTable($this->database);
        $accountTokenData = $accountTokenTable->findUserByToken($token);
        if ($accountTokenData !== false) {
            $this->userId = $accountTokenData['userId'];
            $this->tokenValidUntil = new DateTime(
                $accountTokenData['validUntil'],
                new DateTimeZone($_ENV['SOFTWARE_TIMEZONE'])
            );
            $this->token = $token;
            return $accountTokenData['userId'];
        }

        return new JsonResponse(403);
    }

    public function getUserAccountData(): array
    {
        if ($this->userId === 0) {
            return [];
        }

        if (empty($this->userData)) {
            $accountTable = new AccountTable($this->database);
            $this->userData = $accountTable->findById($this->userId);
            $this->userData['sessionValidUntil'] = $this->tokenValidUntil->format($_ENV['SOFTWARE_FORMAT_TIMESTAMP']);
            return $this->userData;
        }

        return $this->userData;
    }

}
