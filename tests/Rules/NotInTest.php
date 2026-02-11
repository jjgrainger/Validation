<?php

use PHPUnit\Framework\TestCase;
use Validation\Exceptions\InvalidRuleException;
use Validation\Rules\NotIn;

class NotInTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new NotIn;
        $rule->setParameters(['disallowed', 'values']);

        $this->assertTrue($rule->validate('other'));
        $this->assertTrue($rule->validate('not valid'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new NotIn;
        $rule->setParameters(['disallowed', 'values']);

        $this->assertFalse($rule->validate('disallowed'));
        $this->assertFalse($rule->validate('values'));
    }

    public function test_it_throws_exception_for_missing_parameters(): void
    {
        $this->expectException(InvalidRuleException::class);

        $rule = new NotIn;
        $rule->setParameters([]);
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new NotIn;
        $rule->setParameters(['disallowed', 'values']);

        $message = $rule->message();

        $this->assertSame(
            [
                ':disallowed' => 'disallowed, values',
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must not be one of the following values: :disallowed.',
            $message->template()
        );
    }
}
