<?php

declare(strict_types=1);

namespace Controller;

use App\Controller\IndexController;
use App\Helper\ResponseHelper;
use App\Software;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class IndexControllerTest extends TestCase
{

    private Query $query;
    private ResponseHelper $responseHelper;

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $indexController = new IndexController($this->query, $this->responseHelper);
        $this->assertInstanceOf(ResponseInterface::class, $indexController->load($request));
    }

    public function testLoadReturnsSoftwareInfo()
    {
        $expected = $this->responseHelper->createResponse(code: 200, data: [
            'version' => Software::VERSION,
            'build' => Software::VERSION_CODE
        ]);

        $request = new Request();
        $indexController = new IndexController($this->query, $this->responseHelper);
        $response = $indexController->load($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
    }

    protected function setUp(): void
    {
        $this->query = $this->createMock(Query::class);
        $this->responseHelper = new ResponseHelper();

        parent::setUp();
    }

}
