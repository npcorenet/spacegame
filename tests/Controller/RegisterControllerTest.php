<?php

declare(strict_types=1);

namespace Controller;

use App\Controller\RegisterController;
use App\Helper\ResponseHelper;
use App\Software;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RegisterControllerTest extends TestCase
{

    private Query $database;
    private ResponseHelper $responseHelper;

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $registerController = new RegisterController($this->database, $this->responseHelper);
        $this->assertInstanceOf(ResponseInterface::class, $registerController->load($request));
    }

    public function testGetLoadReturnsPostRequired()
    {
        $_POST = null;
        $request = new Request();

        $expected = $this->responseHelper->createResponse(405);

        $registerController = new RegisterController($this->database, $this->responseHelper);
        $response = $registerController->load($request);

        $this->assertSame(405, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadReturnsNotAllRequiredDataSent()
    {
        $_POST = null;
        $request = new Request('', 'POST');

        $expected = $this->responseHelper->createResponse(405);

        $registerController = new RegisterController($this->database, $this->responseHelper);
        $response = $registerController->load($request);

        $this->assertSame(405, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadWithEmptyEmailReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = '';
        $_POST['username'] = 'Test';
        $_POST['password'] = '12345678';

        $expected = $this->responseHelper->createResponse(400, 'email-invalid');

        $registerController = new RegisterController($this->database, $this->responseHelper);
        $response = $registerController->run($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadWithEmptyUsernameReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = 'test@example.com';
        $_POST['username'] = '';
        $_POST['password'] = '12345678';

        $expected = $this->responseHelper->createResponse(400, 'name-empty');

        $registerController = new RegisterController($this->database, $this->responseHelper);
        $response = $registerController->run($request);

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
        $_POST['username'] = 'Test';
        $_POST['password'] = '';

        $expected = $this->responseHelper->createResponse(400, 'password-minimum-length-' . $_ENV['SOFTWARE_MIN_PASSWORD_LENGTH']);

        $registerController = new RegisterController($this->database, $this->responseHelper);
        $response = $registerController->run($request);

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
        $_POST['username'] = 'Test';
        $_POST['password'] = '12345678';

        $expected = $this->responseHelper->createResponse(400, 'email-invalid');

        $registerController = new RegisterController($this->database, $this->responseHelper);
        $response = $registerController->run($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    protected function setUp(): void
    {
        $this->database = $this->createMock(Query::class);
        $this->responseHelper = new ResponseHelper();

        Software::loadEnvironmentFile(__DIR__ . '/../../', '.env.example');

        parent::setUp();
    }

}
