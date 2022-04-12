<?php

declare(strict_types=1);

use App\Validation\WordValidator;
use PHPUnit\Framework\TestCase;

class WordValidatorTest extends TestCase
{
    private WordValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new WordValidator();    
    }

    public function testValueMustBeString()
    {
        $value = 'someStringValue';
        $this->assertTrue($this->validator->validate($value));

        $value = 8;
        $this->assertFalse($this->validator->validate($value));
    }

    public function testValueCannotBeEmpty()
    {
        $value = '';
        $this->assertFalse($this->validator->validate($value));

        $value = ' ';
        $this->assertFalse($this->validator->validate($value));

        $value = '    ';
        $this->assertFalse($this->validator->validate($value));
    }

    public function testValueCanHaveOnlyAlphaSymbols()
    {
        // alpha('-', ' ', '\')

        $value = 'foo-bar';
        $this->assertTrue($this->validator->validate($value));

        $value = 'foo bar';
        $this->assertTrue($this->validator->validate($value));

        $value = 'foo\'bar';
        $this->assertTrue($this->validator->validate($value));

        $value = 'foo_bar';
        $this->assertFalse($this->validator->validate($value));

        $value = 'foo&bar';
        $this->assertFalse($this->validator->validate($value));
    }

    public function testValueCanHaveWhitespace()
    {
        $value = 'some string with white space';

        $this->assertTrue($this->validator->validate($value));
    }

    public function testValueCannotBeNull()
    {
        $value = null;
     
        $this->assertFalse($this->validator->validate($value));
    }

    public function testValidatorReturnCorrectErrorMessage()
    {
        $this->validator->validate('');

        $this->assertEquals('Invalid answer', $this->validator->getMessage());
    }
}