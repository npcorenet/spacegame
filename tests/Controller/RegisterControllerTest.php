<?php

namespace Controller;

use App\Controller\LoginController;
use App\Controller\RegisterController;
use App\Software;
use Envms\FluentPDO\Query;
use Laminas\Diactoros\Request;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class RegisterControllerTest extends TestCase
{

    private Query $database;

    protected function setUp(): void
    {
        $this->database = $this->createMock(Query::class);

        Software::loadEnvironmentFile(__DIR__.'/../../', '.env.example');

        parent::setUp();
    }

    public function testLoadReturnsResponseInterface()
    {
        $request = new Request();

        $registerController = new RegisterController($this->database);
        $this->assertInstanceOf(ResponseInterface::class, $registerController->load($request));
    }

    public function testGetLoadReturnsPostRequired()
    {
        $_POST = null;
        $request = new Request();
        $request->withMethod('GET');

        $expected['message'] = 'This requires to be called with POST';
        $expected['code'] = 400;

        $registerController = new RegisterController($this->database);
        $response = $registerController->load($request);

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

        $registerController = new RegisterController($this->database);
        $response = $registerController->load($request);

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
        $_POST['username'] = 'Test';
        $_POST['password'] = '12345678';

        $expected = json_encode(['code' => 400, 'message' => 'email-invalid']);

        $registerController = new RegisterController($this->database);
        $response = $registerController->load($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame($expected, (string)$response->getBody());
        $_POST = null;
    }


    public function testPostLoadWithEmptyUsernameReturnsError()
    {
        $_POST = null;
        $request = new Request('', 'POST');
        $_POST['email'] = 'test@example.com';
        $_POST['username'] = '';
        $_POST['password'] = '12345678';

        $expected = json_encode(['code' => 400, 'message' => 'name-empty']);

        $registerController = new RegisterController($this->database);
        $response = $registerController->load($request);

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
        $_POST['username'] = 'Test';
        $_POST['password'] = '';

        $expected = json_encode(['code' => 400, 'message' => 'password-minimum-length-'.$_ENV['SOFTWARE_MIN_PASSWORD_LENGTH']]);

        $registerController = new RegisterController($this->database);
        $response = $registerController->load($request);

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
        $_POST['username'] = 'Test';
        $_POST['password'] = '12345678';

        $expected = json_encode(['code' => 400, 'message' => 'email-invalid']);

        $registerController = new RegisterController($this->database);
        $response = $registerController->load($request);

        $this->assertSame(400, $response->getStatusCode());
        $this->assertJson((string)$response->getBody());
        $this->assertSame($expected, (string)$response->getBody());
        $_POST = null;
    }

}