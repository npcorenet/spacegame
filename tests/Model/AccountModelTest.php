<?php

namespace Model;

use App\Model\AccountModel;
use PHPUnit\Framework\TestCase;

class AccountModelTest extends TestCase
{

    private AccountModel $accountModel;

    protected function setUp(): void
    {
        $this->accountModel = new AccountModel();

        parent::setUp();
    }

    public function testCanSetAndGetId()
    {
        $userId = random_int(100, 1027);
        $this->accountModel->setId($userId);

        $this->assertIsInt($this->accountModel->getId());
        $this->assertSame($userId, $this->accountModel->getId());
    }

    public function testCanSetAndGetEmail()
    {
        $email = bin2hex(random_bytes(10)) . '@hotmail.de';
        $this->accountModel->setEmail($email);

        $this->assertIsString($this->accountModel->getEmail());
        $this->assertSame($email, $this->accountModel->getEmail());
    }

    public function testCanSetAndGetPassword()
    {
        $password = bin2hex(random_bytes(32));
        $this->accountModel->setPassword($password);

        $this->assertIsString($this->accountModel->getPassword());
        $this->assertSame($password, $this->accountModel->getPassword());
    }

    public function testCanSetAndGetUsername()
    {
        $username = bin2hex(random_bytes(5));
        $this->accountModel->setUsername($username);

        $this->assertIsString($this->accountModel->getUsername());
        $this->assertSame($username, $this->accountModel->getUsername());
    }

    public function testCanSetAndGetImage()
    {
        $image = bin2hex(random_bytes(8)) . '.jpg';
        $this->accountModel->setImage($image);

        $this->assertIsString($this->accountModel->getImage());
        $this->assertSame($image, $this->accountModel->getImage());
    }

    public function testCanSetAndGetBanner()
    {
        $banner = bin2hex(random_bytes(8)) . '.jpg';
        $this->accountModel->setBanner($banner);

        $this->assertIsString($this->accountModel->getBanner());
        $this->assertSame($banner, $this->accountModel->getBanner());
    }

    public function testCanSetAndGetIsPublic()
    {
        $isPublic = false;
        $this->accountModel->setIsPublic($isPublic);

        $this->assertIsBool($this->accountModel->getIsPublic());
        $this->assertSame($isPublic, $this->accountModel->getIsPublic());
    }

    public function testCanSetAndGetIsAdmin()
    {
        $isAdmin = true;
        $this->accountModel->setIsAdmin($isAdmin);

        $this->assertIsBool($this->accountModel->getIsAdmin());
        $this->assertSame($isAdmin, $this->accountModel->getIsAdmin());
    }

    public function testCanSetAndGetIsActivated()
    {
        $isActivated = 1;
        $this->accountModel->setIsActivated($isActivated);

        $this->assertIsInt($this->accountModel->getIsActivated());
        $this->assertSame($isActivated, $this->accountModel->getIsActivated());
    }

}