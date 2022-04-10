<?php

declare(strict_types=1);

use App\Validation\WordValidator;
use PHPUnit\Framework\TestCase;

class WordValidatorTest extends TestCase
{
    public function testValueMustBeString()
    {
        $validator = new WordValidator();

        $value = 'someStringValue';
        $this->assertTrue($validator->validate($value));

        $value = 8;
        $this->assertFalse($validator->validate($value));
    }

    public function testValueCannotBeEmpty()
    {
        $validator = new WordValidator();

        $value = '';
        $this->assertFalse($validator->validate($value));

        $value = ' ';
        $this->assertFalse($validator->validate($value));

        $value = '    ';
        $this->assertFalse($validator->validate($value));
    }

    public function testValueCanHaveOnlyAlphaSymbols()
    {
        // alpha('-', ' ', '\')
        $validator = new WordValidator();

        $value = 'foo-bar';
        $this->assertTrue($validator->validate($value));

        $value = 'foo bar';
        $this->assertTrue($validator->validate($value));

        $value = 'foo\'bar';
        $this->assertTrue($validator->validate($value));

        $value = 'foo_bar';
        $this->assertFalse($validator->validate($value));

        $value = 'foo&bar';
        $this->assertFalse($validator->validate($value));
    }

    public function testValueCanHaveWhitespace()
    {
        $validator = new WordValidator();

        $value = 'some string with white space';
        $this->assertTrue($validator->validate($value));
    }

    public function testValueCannotBeNull()
    {
        $validator = new WordValidator();

        $value = null;
        $this->assertFalse($validator->validate($value));
    }

    public function testValidatorReturnCorrectErrorMessage()
    {
        $validator = new WordValidator();
        $validator->validate('');

        $this->assertEquals('Invalid answer', $validator->getMessage());
    }
}