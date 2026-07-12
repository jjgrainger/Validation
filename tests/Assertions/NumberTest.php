<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Number;

class NumberTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Number;

        $this->assertTrue($assertion->validate(0));
        $this->assertTrue($assertion->validate(1));
        $this->assertTrue($assertion->validate(0.1));
        $this->assertTrue($assertion->validate(-1));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Number;

        $this->assertFalse($assertion->validate('0'));
        $this->assertFalse($assertion->validate('string'));
        $this->assertFalse($assertion->validate([]));
        $this->assertFalse($assertion->validate(true));
        $this->assertFalse($assertion->validate(null));
    }

    public function test_it_has_messaage(): void
    {
        $assertion = new Number;

        $message = $assertion->message();

        $this->assertSame(
            ':attribute must be a number.',
            $message->template()
        );
    }
}
