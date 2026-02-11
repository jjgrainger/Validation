<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Max;

class MaxTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Max;
        $rule->setParameters([3]);

        $this->assertTrue($rule->validate(0));
        $this->assertTrue($rule->validate(1));
        $this->assertTrue($rule->validate(2));
        $this->assertTrue($rule->validate(3));
        $this->assertTrue($rule->validate(-999));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Max;
        $rule->setParameters([3]);

        $this->assertFalse($rule->validate(4));
        $this->assertFalse($rule->validate(5));
        $this->assertFalse($rule->validate(999));
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Max;
        $rule->setParameters([3]);

        $message = $rule->message();

        $this->assertSame(
            [
                ':max' => 3,
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must be less than :max.',
            $message->template()
        );
    }
}
