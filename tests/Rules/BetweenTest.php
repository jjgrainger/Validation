<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Between;

class BetweenTest extends TestCase
{
    public function test_it_passes_value_in_range(): void
    {
        $rule = new Between;
        $rule->setParameters([1, 3]);

        $this->assertTrue($rule->validate(2));
    }

    public function test_it_fails_value_outside_of_range(): void
    {
        $rule = new Between;
        $rule->setParameters([1, 3]);

        $this->assertFalse($rule->validate(0));
        $this->assertFalse($rule->validate(4));
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Between;
        $rule->setParameters([1, 3]);

        $message = $rule->message();

        $this->assertSame(
            [
                ':min' => 1,
                ':max' => 3,
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must be greater than :min and less than :max.',
            $message->template()
        );
    }
}
