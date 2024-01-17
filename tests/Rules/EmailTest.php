<?php declare(strict_types=1);

namespace Valid8\Test\Rules;

use PHPUnit\Framework\TestCase;
use Valid8\Validator;

final class EmailTest extends TestCase
{
    public function testEmailIsValid(): void
    {
        $validator = new Validator(['email' => 'test@test.com'], ['email' => 'email']);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    public function testEmailDomainTldIsTooLong(): void
    {
        $validator = new Validator(['email' => 'test@test.cooooom'], ['email' => 'email']);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
    }

    public function testEmailDomainNameIsTooLong(): void
    {
        $validator = new Validator(['email' => 'test@testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttest.com'], ['email' => 'email']);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
    }

    public function testEmailWithoutDomain(): void
    {
        $validator = new Validator(['email' => 'test@'], ['email' => 'email']);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
    }

    public function testEmailWithoutValidDomain(): void
    {
        $validator = new Validator(['email' => 'test@domain'], ['email' => 'email']);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
    }
}