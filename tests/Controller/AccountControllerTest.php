<?php

namespace Controller;

use App\Controller\AccountController;
use App\Helper\ResponseHelper;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;

class AccountControllerTest extends TestCase
{

    private Query $query;
    private ResponseHelper $responseHelper;

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $accountController = new AccountController($this->query, $this->responseHelper);
        $response = $accountController->load($request);

        $this->assertInstanceOf(Response::class, $response);
    }

    protected function setUp(): void
    {
        $this->query = $this->createMock(Query::class);
        $this->responseHelper = new ResponseHelper();

        parent::setUp();
    }

}