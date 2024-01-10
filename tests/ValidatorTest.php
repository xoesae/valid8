<?php

namespace Valid8\Test;

use PHPUnit\Framework\TestCase;
use Valid8\Test\Examples\CustomMessageRule;
use Valid8\Test\Examples\CustomRule;
use Valid8\Test\Examples\RequiredValidator;
use Valid8\Validator;

class ValidatorTest extends TestCase
{
    public function testAcceptUniqueRule(): void
    {
        $validator = new Validator(
            ['name' => 'xoesae'],
            ['name' => 'required'],
        );

        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testAcceptManyRules(): void
    {
        $validator = new Validator(
            ['name' => 'xoesae'],
            ['name' => ['required']],
        );

        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testCallErrorsBeforeValidate(): void
    {
        $validator = new Validator(
            ['name' => null],
            ['name' => 'required'],
        );
        $errors = $validator->errors();
        $this->assertNotEmpty($errors);
        $this->assertFalse($validator->validate());
    }

    public function testClassExtendsValidator(): void
    {
        $validator = new RequiredValidator(['name' => 'xoesae']);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());

        $validator = new RequiredValidator(['name' => null]);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
    }

    public function testCustomRuleClass(): void
    {
        $validator = new Validator(
            ['amount' => 12],
            ['amount' => [new CustomRule()]]
        );
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testCustomUniqueRuleClass(): void
    {
        $validator = new Validator(
            ['amount' => 12],
            ['amount' => new CustomRule()]
        );
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testValidatorWithoutRules(): void
    {
        $validator = new Validator(['name' => null]);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testValidatorWithDefaultAndCustomRules(): void
    {
        $validator = new Validator(
            ['amount' => 12],
            ['amount' => ['required', new CustomRule()]]
        );
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testCustomErrorMessage(): void
    {
        $validator = new Validator(['name' => null], ['name' => 'required'], ['required' => '{field} is missing.']);
        $this->assertSame($validator->errors()['name'], 'name is missing.');
    }

    public function testCustomErrorMessageWithCustomRule(): void
    {
        $validator = new Validator(
            ['amount' => 'test'],
            ['amount' => new CustomMessageRule()],
            [CustomMessageRule::class => 'custom message.']
        );
        $this->assertSame($validator->errors()['amount'], 'custom message.');
    }

    public function testTranslateFile(): void
    {
        $validator = new Validator(
            ['name' => null],
            ['name' => 'required'],
            lang: 'pt-br',
            langDirectory: 'lang',
        );
        $this->assertFalse($validator->validate());
        $this->assertSame($validator->errors()['name'], 'name é obrigatório.');
    }
}