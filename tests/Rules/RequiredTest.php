<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Required;
use Validation\Rules\Signals\StopsOnFailure;

class RequiredTest extends TestCase
{
    public function test_it_fails_on_null(): void
    {
        $rule = new Required;

        $this->assertFalse($rule->validate(null));
    }

    public function test_it_passes_non_null(): void
    {
        $rule = new Required;

        $this->assertTrue($rule->validate(''));
        $this->assertTrue($rule->validate(0));
        $this->assertTrue($rule->validate(True));
        $this->assertTrue($rule->validate([]));

        $this->assertTrue($rule->validate('value'));
        $this->assertTrue($rule->validate(1));
        $this->assertTrue($rule->validate(1.234));
        $this->assertTrue($rule->validate(true));
        $this->assertTrue($rule->validate(['value']));
    }

    public function test_it_has_stop_signal(): void
    {
        $rule = new Required();

        $this->assertInstanceOf(StopsOnFailure::class, $rule);
    }

    public function test_it_has_a_message(): void
    {
        $rule = new Required();

        $message = $rule->message();

        $this->assertSame(
            ':attribute is required.',
            $message->template()
        );
    }
}
