<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Email;

class EmailTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Email;

        $this->assertTrue($rule->validate('test@example.test'));
        $this->assertTrue($rule->validate('test.suffix@example.test'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Email;

        $this->assertFalse($rule->validate(0));
        $this->assertFalse($rule->validate('not an email'));
        $this->assertFalse($rule->validate('invalid@example'));
        $this->assertFalse($rule->validate('example.test'));
    }

    public function test_it_has_messaage(): void
    {
        $rule = new Email;

        $message = $rule->message();

        $this->assertSame(
            ':attribute must be a valid email.',
            $message->template()
        );
    }
}
