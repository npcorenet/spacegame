<?php declare(strict_types=1);

namespace Model;

use App\Model\TokenTypeModel;
use PHPUnit\Framework\TestCase;

class TokenTypeModelTest extends TestCase
{

    private TokenTypeModel $typeModel;

    protected function setUp(): void
    {
        $this->typeModel = new TokenTypeModel();

        parent::setUp();
    }

    public function testCanSetAndGetId()
    {
        $id = random_int(1, 5);
        $this->typeModel->setId($id);

        $this->assertIsInt($this->typeModel->getId());
        $this->assertSame($id, $this->typeModel->getId());
    }

    public function testCanSetAndGetTitle()
    {
        $title = bin2hex(random_bytes(5));
        $this->typeModel->setTitle($title);

        $this->assertIsString($this->typeModel->getTitle());
        $this->assertSame($title, $this->typeModel->getTitle());
    }

}
