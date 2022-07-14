<?php declare(strict_types=1);

namespace Model;

use App\Model\TokenModel;
use DateTime;
use PHPUnit\Framework\TestCase;

class TokenModelTest extends TestCase
{

    private TokenModel $tokenModel;

    protected function setUp(): void
    {
        $this->tokenModel = new TokenModel();

        parent::setUp();
    }

    public function testCanSetAndGetId()
    {
        $id = random_int(256, 2048);
        $this->tokenModel->setId($id);

        $this->assertIsInt($this->tokenModel->getId());
        $this->assertSame($id, $this->tokenModel->getId());
    }

    public function testCanSetAndGetToken()
    {
        $token = bin2hex(random_bytes(32));
        $this->tokenModel->setToken($token);

        $this->assertIsString($this->tokenModel->getToken());
        $this->assertSame($token, $this->tokenModel->getToken());
    }

    public function testCanSetAndGetValidUntil()
    {
        $validUntil = new DateTime();
        $this->tokenModel->setValidUntil($validUntil);

        $this->assertInstanceOf(DateTime::class, $this->tokenModel->getValidUntil());
        $this->assertSame($validUntil, $this->tokenModel->getValidUntil());
    }

    public function testCanSetAndGetCreated()
    {
        $created = new DateTime();
        $this->tokenModel->setCreated($created);

        $this->assertInstanceOf(DateTime::class, $this->tokenModel->getCreated());
        $this->assertSame($created, $this->tokenModel->getCreated());
    }

    public function testCanSetAndGetType()
    {
        $type = 1;
        $this->tokenModel->setType($type);

        $this->assertIsInt($this->tokenModel->getType());
        $this->assertSame($type, $this->tokenModel->getType());
    }

    public function testCanSetAndGetUser()
    {
        $userId = random_int(100, 1027);
        $this->tokenModel->setUser($userId);

        $this->assertIsInt($this->tokenModel->getUser());
        $this->assertSame($userId, $this->tokenModel->getUser());
    }

    public function testCanSetAndGetIsUsed()
    {
        $isUsed = random_int(0, 1);
        $this->tokenModel->setIsUsed($isUsed);

        $this->assertIsInt($this->tokenModel->getIsUsed());
        $this->assertSame($isUsed, $this->tokenModel->getIsUsed());
    }

}
