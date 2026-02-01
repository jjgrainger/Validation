<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Number;

class NumberTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Number;

        $this->assertTrue($rule->validate(0));
        $this->assertTrue($rule->validate(1));
        $this->assertTrue($rule->validate(0.1));
        $this->assertTrue($rule->validate(-1));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Number;

        $this->assertFalse($rule->validate('0'));
        $this->assertFalse($rule->validate('string'));
        $this->assertFalse($rule->validate([]));
        $this->assertFalse($rule->validate(true));
        $this->assertFalse($rule->validate(null));
    }

    public function test_it_has_messaage(): void
    {
        $rule = new Number;

        $message = $rule->message();

        $this->assertSame(
            ':attribute must be a number.',
            $message->template()
        );
    }
}
