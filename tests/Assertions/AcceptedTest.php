<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Accepted;

class AcceptedTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Accepted;

        $this->assertTrue($assertion->validate(true));
        $this->assertTrue($assertion->validate(1));
        $this->assertTrue($assertion->validate('true'));
        $this->assertTrue($assertion->validate('1'));
        $this->assertTrue($assertion->validate('on'));
        $this->assertTrue($assertion->validate('yes'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Accepted;

        $this->assertFalse($assertion->validate(null));
        $this->assertFalse($assertion->validate(false));
        $this->assertFalse($assertion->validate(0));
        $this->assertFalse($assertion->validate('false'));
        $this->assertFalse($assertion->validate('0'));
        $this->assertFalse($assertion->validate('off'));
        $this->assertFalse($assertion->validate('no'));
    }

    public function test_it_has_a_message(): void
    {
        $assertion = new Accepted;

        $message = $assertion->message();

        $this->assertSame(
            ':attribute must be accepted.',
            $message->template()
        );
    }
}
