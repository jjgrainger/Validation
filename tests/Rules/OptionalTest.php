<?php

use PHPUnit\Framework\TestCase;
use Validation\Rules\Optional;
use Validation\Rules\Signals\SkipsOnFailure;

class OptionalTest extends TestCase
{
    public function test_it_fails_on_null(): void
    {
        $rule = new Optional;

        $this->assertFalse($rule->validate(null));
    }

    public function test_it_passes_non_null(): void
    {
        $rule = new Optional;

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

    public function test_it_has_skip_signal(): void
    {
        $rule = new Optional();

        $this->assertInstanceOf(SkipsOnFailure::class, $rule);
    }

    public function test_it_has_no_message(): void
    {
        $this->expectException(\LogicException::class);

        (new Optional())->message();
    }
}
