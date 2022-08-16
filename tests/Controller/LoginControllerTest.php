<?php

declare(strict_types=1);

namespace Controller;

use App\Controller\LoginController;
use App\Helper\ResponseHelper;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class LoginControllerTest extends TestCase
{

    private Query $database;
    private ResponseHelper $responseHelper;

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $loginController = new LoginController($this->database, $this->responseHelper);
        $this->assertInstanceOf(ResponseInterface::class, $loginController->load($request));
    }

    public function testGetLoadReturnsPostRequired()
    {
        $_POST = null;
        $request = new Request();
        $request->withMethod('GET');

        $expected = $this->responseHelper->createResponse(405);

        $loginController = new LoginController($this->database, $this->responseHelper);
        $response = $loginController->load($request);

        $this->assertSame(405, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadReturnsNotAllRequiredDataSent()
    {
        $_POST = null;
        $request = new Request('', 'POST');

        $expected = json_encode($this->responseHelper->createResponse(400));

        $loginController = new LoginController($this->database, $this->responseHelper);
        $response = $loginController->run($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame($expected, (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadWithEmptyEmailReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = '';
        $_POST['password'] = '12345678';

        $expected = $this->responseHelper->createResponse(400, 'email-invalid');

        $loginController = new LoginController($this->database, $this->responseHelper);
        $response = $loginController->run($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadWithEmptyPasswordReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = 'test@test.de';
        $_POST['password'] = '';

        $expected = $this->responseHelper->createResponse(400, 'password-empty');

        $loginController = new LoginController($this->database, $this->responseHelper);
        $response = $loginController->run($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadWithInvalidEmailReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = 'kekwmail';
        $_POST['password'] = '12345678';

        $expected = $this->responseHelper->createResponse(400, 'email-invalid');

        $loginController = new LoginController($this->database, $this->responseHelper);
        $response = $loginController->run($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    protected function setUp(): void
    {
        $this->database = $this->createMock(Query::class);
        $this->responseHelper = new ResponseHelper();

        parent::setUp();
    }

}
