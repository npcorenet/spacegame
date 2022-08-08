<?php

declare(strict_types=1);

namespace Controller;

use App\Controller\IndexController;
use App\Software;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class IndexControllerTest extends TestCase
{

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $indexController = new IndexController();
        $this->assertInstanceOf(ResponseInterface::class, $indexController->load($request));
    }

    public function testLoadReturnsSoftwareInfo()
    {
        $expected =
            json_encode(
                [
                    'version' => Software::VERSION,
                    'build' => Software::VERSION_CODE,
                    'development' => (bool)$_ENV['SOFTWARE_INDEV']
                ]
            );

        $request = new Request();
        $indexController = new IndexController();
        $response = $indexController->load($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($expected, (string)$response->getBody());
    }

    protected function setUp(): void
    {
        $_ENV['SOFTWARE_INDEV'] = true;

        parent::setUp();
    }

}
