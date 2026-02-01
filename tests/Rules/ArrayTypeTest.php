<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\ArrayType;

class ArrayTypeTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new ArrayType;

        $this->assertTrue($rule->validate([]));
        $this->assertTrue($rule->validate([1,2,3]));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new ArrayType;

        $this->assertFalse($rule->validate(1));
        $this->assertFalse($rule->validate('string'));
        $this->assertFalse($rule->validate(true));
    }

    public function test_it_has_messaage(): void
    {
        $rule = new ArrayType;

        $message = $rule->message();

        $this->assertSame(
            ':attribute must be an array.',
            $message->template()
        );
    }

    public function test_it_has_name(): void
    {
        $rule = new ArrayType;

        $this->assertSame('array', $rule->name());
    }
}
