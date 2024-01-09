<?php declare(strict_types=1);

namespace Valid8\Test\Rules;

use PHPUnit\Framework\TestCase;
use Valid8\Validator;

final class RequiredTest extends TestCase
{
    public function testRequiredFieldIsValid(): void
    {
        $validator = new Validator(['name' => 'xoesae'], ['name' => 'required']);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testRequiredFieldIsNull(): void
    {
        $validator = new Validator(['name' => null], ['name' => 'required']);
        $result = $validator->validate();
        $errors = $validator->errors();
        $this->assertFalse($result);
        $this->assertNotEmpty($errors);
        $this->assertSame($errors['name'], "name is required.");
    }

    public function testRequiredFieldIsEmptyString(): void
    {
        $validator = new Validator(['name' => ''], ['name' => 'required']);
        $result = $validator->validate();
        $errors = $validator->errors();
        $this->assertFalse($result);
        $this->assertNotEmpty($errors);
        $this->assertSame($errors['name'], "name is required.");
    }

    public function testRequiredFieldIsEmptyArray(): void
    {
        $validator = new Validator(['name' => []], ['name' => 'required']);
        $result = $validator->validate();
        $errors = $validator->errors();
        $this->assertFalse($result);
        $this->assertNotEmpty($errors);
        $this->assertSame($errors['name'], "name is required.");
    }
}