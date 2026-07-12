<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\Optional;
use Validation\Assertions\Signals\SkipsOnFailure;

class OptionalTest extends TestCase
{
    public function test_it_fails_on_null(): void
    {
        $assertion = new Optional;

        $this->assertFalse($assertion->validate(null));
    }

    public function test_it_passes_non_null(): void
    {
        $assertion = new Optional;

        $this->assertTrue($assertion->validate(''));
        $this->assertTrue($assertion->validate(0));
        $this->assertTrue($assertion->validate(True));
        $this->assertTrue($assertion->validate([]));

        $this->assertTrue($assertion->validate('value'));
        $this->assertTrue($assertion->validate(1));
        $this->assertTrue($assertion->validate(1.234));
        $this->assertTrue($assertion->validate(true));
        $this->assertTrue($assertion->validate(['value']));
    }

    public function test_it_has_skip_signal(): void
    {
        $assertion = new Optional();

        $this->assertInstanceOf(SkipsOnFailure::class, $assertion);
    }

    public function test_it_has_no_message(): void
    {
        $this->expectException(\LogicException::class);

        (new Optional())->message();
    }
}
