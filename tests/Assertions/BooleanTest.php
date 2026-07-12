<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Boolean;

class BooleanTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Boolean;

        $this->assertTrue($assertion->validate(true));
        $this->assertTrue($assertion->validate(false));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Boolean;

        $this->assertFalse($assertion->validate(1));
        $this->assertFalse($assertion->validate(0));
        $this->assertFalse($assertion->validate('true'));
        $this->assertFalse($assertion->validate('false'));
    }

    public function test_it_has_messaage(): void
    {
        $assertion = new Boolean;

        $message = $assertion->message();

        $this->assertSame(
            ':attribute must be a boolean.',
            $message->template()
        );
    }
}
