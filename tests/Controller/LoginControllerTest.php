<?php

declare(strict_types=1);

namespace Controller;

use App\Controller\LoginController;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class LoginControllerTest extends TestCase
{

    private Query $database;

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $loginController = new LoginController($this->database);
        $this->assertInstanceOf(ResponseInterface::class, $loginController->load($request));
    }

    public function testGetLoadReturnsPostRequired()
    {
        $_POST = null;
        $request = new Request();
        $request->withMethod('GET');

        $expected['message'] = 'This requires to be called with POST';
        $expected['code'] = 400;

        $loginController = new LoginController($this->database);
        $response = $loginController->load($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame(json_encode($expected), (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadReturnsNotAllRequiredDataSent()
    {
        $_POST = null;
        $request = new Request('', 'POST');

        $expected = json_encode(['code' => 400, 'message' => 'Please make sure, that all required data is sent!']);

        $loginController = new LoginController($this->database);
        $response = $loginController->load($request);

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

        $expected = json_encode(['code' => 400, 'message' => 'email-invalid']);

        $loginController = new LoginController($this->database);
        $response = $loginController->load($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame($expected, (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadWithEmptyPasswordReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = 'test@test.de';
        $_POST['password'] = '';

        $expected = json_encode(['code' => 400, 'message' => 'password-empty']);

        $loginController = new LoginController($this->database);
        $response = $loginController->load($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame($expected, (string)$response->getBody());
        $_POST = null;
    }

    public function testPostLoadWithInvalidEmailReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = 'kekwmail';
        $_POST['password'] = '12345678';

        $expected = json_encode(['code' => 400, 'message' => 'email-invalid']);

        $loginController = new LoginController($this->database);
        $response = $loginController->load($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame($expected, (string)$response->getBody());
        $_POST = null;
    }

    protected function setUp(): void
    {
        $this->database = $this->createMock(Query::class);

        parent::setUp();
    }

}
