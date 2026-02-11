<?php

use PHPUnit\Framework\TestCase;
use Validation\Exceptions\InvalidRuleException;
use Validation\Rules\In;

class InTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new In;
        $rule->setParameters(['accepted', 'values']);

        $this->assertTrue($rule->validate('accepted'));
        $this->assertTrue($rule->validate('values'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new In;
        $rule->setParameters(['accepted', 'values']);

        $this->assertFalse($rule->validate('other'));
        $this->assertFalse($rule->validate('not valid'));
    }

    public function test_it_throws_exception_for_missing_parameters(): void
    {
        $this->expectException(InvalidRuleException::class);

        $rule = new In;
        $rule->setParameters([]);
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new In;
        $rule->setParameters(['accepted', 'values']);

        $message = $rule->message();

        $this->assertSame(
            [
                ':allowed' => 'accepted, values',
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must be one of the following values: :allowed.',
            $message->template()
        );
    }
}
