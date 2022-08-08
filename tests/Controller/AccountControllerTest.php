<?php

namespace Controller;

use App\Controller\AccountController;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;

class AccountControllerTest extends TestCase
{

    private Query $query;

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $accountController = new AccountController($this->query);
        $response = $accountController->load($request);

        $this->assertInstanceOf(Response::class, $response);
    }

    protected function setUp(): void
    {
        $this->query = $this->createMock(Query::class);

        parent::setUp();
    }

}