<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Min;

class MinTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Min;
        $rule->setParameters([3]);

        $this->assertTrue($rule->validate(3));
        $this->assertTrue($rule->validate(4));
        $this->assertTrue($rule->validate(5));
        $this->assertTrue($rule->validate(999));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Min;
        $rule->setParameters([3]);

        $this->assertFalse($rule->validate(0));
        $this->assertFalse($rule->validate(1));

        $this->assertFalse($rule->validate('2'));
        $this->assertFalse($rule->validate(null));
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Min;
        $rule->setParameters([3]);

        $message = $rule->message();

        $this->assertSame(
            [
                ':min' => 3,
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must be greater than :min.',
            $message->template()
        );
    }
}
