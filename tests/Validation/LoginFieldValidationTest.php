<?php declare(strict_types=1);

namespace Validation;

use App\Helper\MessageHelper;
use App\Model\AccountModel;
use App\Validation\LoginFieldValidation;
use PHPUnit\Framework\TestCase;

class LoginFieldValidationTest extends TestCase
{

    private LoginFieldValidation $validation;
    private MessageHelper $messageHelper;

    protected function setUp(): void
    {
        $this->validation = new LoginFieldValidation();
        $this->messageHelper = new MessageHelper();

        parent::setUp();
    }

    public function testCanValidateWithNoEmail()
    {

        $account = new AccountModel();
        $account->setEmail('');
        $account->setPassword('testpass');

        $this->validation->validate($account, $this->messageHelper);
        $this->assertSame(1, $this->messageHelper->countMessageByType('danger'));

        $this->messageHelper->clearMessageArray();

    }

    public function testCanValidateWithNoPassword()
    {
        $account = new AccountModel();
        $account->setEmail('test@test.com');
        $account->setPassword('');

        $this->validation->validate($account, $this->messageHelper);
        $this->assertSame(1, $this->messageHelper->countMessageByType('danger'));

        $this->messageHelper->clearMessageArray();
    }

    public function testCanValidateWithNoCredentials()
    {
        $account = new AccountModel();
        $account->setEmail('');
        $account->setPassword('');

        $this->validation->validate($account, $this->messageHelper);
        $this->assertSame(2, $this->messageHelper->countMessageByType('danger'));

        $this->messageHelper->clearMessageArray();
    }

}
