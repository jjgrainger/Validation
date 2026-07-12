<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Length;

class LengthTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Length(5);

        $this->assertTrue($assertion->validate('fives'));
        $this->assertTrue($assertion->validate('tests'));
        $this->assertTrue($assertion->validate('three'));
        $this->assertTrue($assertion->validate('     '));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Length(5);

        $this->assertFalse($assertion->validate('a'));
        $this->assertFalse($assertion->validate('one'));
        $this->assertFalse($assertion->validate('too long'));
    }

    public function test_message_contains_parameters(): void
    {
        $assertion = new Length(5);

        $message = $assertion->message();

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
