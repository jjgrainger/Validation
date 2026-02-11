<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Accepted;

class AcceptedTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Accepted;

        $this->assertTrue($rule->validate(true));
        $this->assertTrue($rule->validate(1));
        $this->assertTrue($rule->validate('true'));
        $this->assertTrue($rule->validate('1'));
        $this->assertTrue($rule->validate('on'));
        $this->assertTrue($rule->validate('yes'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Accepted;

        $this->assertFalse($rule->validate(null));
        $this->assertFalse($rule->validate(false));
        $this->assertFalse($rule->validate(0));
        $this->assertFalse($rule->validate('false'));
        $this->assertFalse($rule->validate('0'));
        $this->assertFalse($rule->validate('off'));
        $this->assertFalse($rule->validate('no'));
    }

    public function test_it_has_a_message(): void
    {
        $rule = new Accepted;

        $message = $rule->message();

        $this->assertSame(
            ':attribute must be accepted.',
            $message->template()
        );
    }
}
