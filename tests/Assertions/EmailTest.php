<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Email;

class EmailTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new Email;

        $this->assertTrue($assertion->validate('test@example.test'));
        $this->assertTrue($assertion->validate('test.suffix@example.test'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new Email;

        $this->assertFalse($assertion->validate(0));
        $this->assertFalse($assertion->validate('not an email'));
        $this->assertFalse($assertion->validate('invalid@example'));
        $this->assertFalse($assertion->validate('example.test'));
    }

    public function test_it_has_messaage(): void
    {
        $assertion = new Email;

        $message = $assertion->message();

        $this->assertSame(
            ':attribute must be a valid email.',
            $message->template()
        );
    }
}
