<?php
declare(strict_types=1);

namespace Controller;

use App\Controller\IndexController;
use App\Software;
use Laminas\Diactoros\Request;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class IndexControllerTest extends TestCase
{

    public function testLoadReturnsResponseInterface()
    {
        $_ENV['SOFTWARE_INDEV'] = true;

        $request = new Request();

        $indexController = new IndexController();
        $this->assertInstanceOf(ResponseInterface::class, $indexController->load($request));
    }

}
