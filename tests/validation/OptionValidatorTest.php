<?php

declare(strict_types=1);

use App\Validation\OptionValidator;
use PHPUnit\Framework\TestCase;

class OptionValidatorTest extends TestCase
{
    private OptionValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new OptionValidator(1, 10);
    }

    public function testValueMustBeNumber()
    {
        $value = 'some_string_value';
        $this->assertFalse($this->validator->validate($value));

        $value = 8;
        $this->assertTrue($this->validator->validate($value));
    }

    public function testValueMustBeBetweenSpecificRange()
    {
        $value = 0;
        $this->assertFalse($this->validator->validate($value));

        $value = 1;
        $this->assertTrue($this->validator->validate($value));

        $value = 3;
        $this->assertTrue($this->validator->validate($value));

        $value = 7;
        $this->assertTrue($this->validator->validate($value));

        $value = 11;
        $this->assertFalse($this->validator->validate($value));
    }

    public function testValueCannotHaveWhitespace()
    {
        $value = '1 6';
        $this->assertFalse($this->validator->validate($value));

        $value = '23 23';
        $this->assertFalse($this->validator->validate($value));
    }

    public function testValueCannotBeNull()
    {
        $value = null;

        $this->assertFalse($this->validator->validate($value));
    }

    public function testValidatorReturnCorrectErrorMessage()
    {
        $this->validator->validate('');
        
        $this->assertEquals("Invalid option (select 1-10)", $this->validator->getMessage());
    }
}