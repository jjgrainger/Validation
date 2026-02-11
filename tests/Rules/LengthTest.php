<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Length;

class LengthTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Length(5);

        $this->assertTrue($rule->validate('fives'));
        $this->assertTrue($rule->validate('tests'));
        $this->assertTrue($rule->validate('three'));
        $this->assertTrue($rule->validate('     '));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Length(5);

        $this->assertFalse($rule->validate('a'));
        $this->assertFalse($rule->validate('one'));
        $this->assertFalse($rule->validate('too long'));
    }

    public function test_message_contains_parameters(): void
    {
        $rule = new Length(5);

        $message = $rule->message();

        $this->assertSame(
            [
                ':length' => 5,
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must be less than :length.',
            $message->template()
        );
    }
}
