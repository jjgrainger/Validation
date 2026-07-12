<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Min;

class MinTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Min(3);

        $this->assertTrue($assertion->validate(3));
        $this->assertTrue($assertion->validate(4));
        $this->assertTrue($assertion->validate(5));
        $this->assertTrue($assertion->validate(999));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Min(3);

        $this->assertFalse($assertion->validate(0));
        $this->assertFalse($assertion->validate(1));

        $this->assertFalse($assertion->validate('2'));
        $this->assertFalse($assertion->validate(null));
    }

    public function test_message_contains_parameters(): void
    {
        $assertion = new Min(3);

        $message = $assertion->message();

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
