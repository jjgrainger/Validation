<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Boolean;

class BooleanTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $rule = new Boolean;

        $this->assertTrue($rule->validate(true));
        $this->assertTrue($rule->validate(false));
    }

    public function test_it_fails_invalid_value(): void
    {
        $rule = new Boolean;

        $this->assertFalse($rule->validate(1));
        $this->assertFalse($rule->validate(0));
        $this->assertFalse($rule->validate('true'));
        $this->assertFalse($rule->validate('false'));
    }

    public function test_it_has_messaage(): void
    {
        $rule = new Boolean;

        $message = $rule->message();

        $this->assertSame(
            ':attribute must be a boolean.',
            $message->template()
        );
    }
}
