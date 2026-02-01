<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\StringType;

class StringTypeTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new StringType;

        $this->assertTrue($rule->validate(''));
        $this->assertTrue($rule->validate('string'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new StringType;

        $this->assertFalse($rule->validate(1));
        $this->assertFalse($rule->validate([]));
        $this->assertFalse($rule->validate(true));
    }

    public function test_it_has_messaage(): void
    {
        $rule = new StringType;

        $message = $rule->message();

        $this->assertSame(
            ':attribute must be a string.',
            $message->template()
        );
    }

    public function test_it_has_name(): void
    {
        $rule = new StringType;

        $this->assertSame('string', $rule->name());
    }
}
