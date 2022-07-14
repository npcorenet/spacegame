<?php

namespace Validation;

use App\Validation\RegisterFieldValidation;
use PHPUnit\Framework\TestCase;

class RegisterFieldValidationTest extends TestCase
{

    private RegisterFieldValidation $validation;

    protected function setUp(): void
    {
        $this->validation = new RegisterFieldValidation();

        parent::setUp();
    }

}