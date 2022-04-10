<?php

declare(strict_types=1);

use App\Validation\OptionValidator;
use PHPUnit\Framework\TestCase;

class OptionValidatorTest extends TestCase
{
    public function testValueMustBeNumber()
    {
        $validator = new OptionValidator(1, 10);

        $value = 'some_string_value';
        $this->assertFalse($validator->validate($value));

        $value = 8;
        $this->assertTrue($validator->validate($value));
    }

    public function testValueMustBeBetweenSpecificRange()
    {
        $validator = new OptionValidator(1, 100);

        $value = 0;
        $this->assertFalse($validator->validate($value));

        $value = 1;
        $this->assertTrue($validator->validate($value));

        $value = 77;
        $this->assertTrue($validator->validate($value));

        $value = 100;
        $this->assertTrue($validator->validate($value));

        $value = 101;
        $this->assertFalse($validator->validate($value));
    }

    public function testValueCannotHaveWhitespace()
    {
        $validator = new OptionValidator(1, 100);

        $value = '1 6';
        $this->assertFalse($validator->validate($value));

        $value = '23 23';
        $this->assertFalse($validator->validate($value));
    }

    public function testValueCannotBeNull()
    {
        $validator = new OptionValidator(1, 100);

        $value = null;
        $this->assertFalse($validator->validate($value));
    }

    public function testValidatorReturnCorrectErrorMessage()
    {
        $min = 10;
        $max = 30;

        $validator = new OptionValidator($min, $max);
        $validator->validate('');

        $this->assertEquals("Invalid option (select $min-$max)", $validator->getMessage());
    }
}