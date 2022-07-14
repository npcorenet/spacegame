<?php declare(strict_types=1);

namespace Validation;

use App\Helper\MessageHelper;
use App\Model\AccountModel;
use App\Validation\RegisterFieldValidation;
use PHPUnit\Framework\TestCase;

class RegisterFieldValidationTest extends TestCase
{

    private RegisterFieldValidation $validation;
    private MessageHelper $messageHelper;

    protected function setUp(): void
    {
        $this->validation = new RegisterFieldValidation();
        $this->messageHelper = new MessageHelper();

        parent::setUp();
    }

    public function testCanInvalidateAllEmptyFields()
    {
        $account = new AccountModel();
        $account->setEmail('');
        $account->setUsername('');
        $account->setPassword('');
        $account->setAcceptedTerms(false);

        $this->validation->validate($account, $this->messageHelper);

        $this->assertSame(4, $this->messageHelper->countMessageByType('danger'));
        $this->messageHelper->clearMessageArray();
    }

}
