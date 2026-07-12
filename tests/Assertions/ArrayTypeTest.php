<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\ArrayType;

class ArrayTypeTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new ArrayType;

        $this->assertTrue($assertion->validate([]));
        $this->assertTrue($assertion->validate([1,2,3]));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new ArrayType;

        $this->assertFalse($assertion->validate(1));
        $this->assertFalse($assertion->validate('string'));
        $this->assertFalse($assertion->validate(true));
    }

    public function test_it_has_messaage(): void
    {
        $assertion = new ArrayType;

        $message = $assertion->message();

        $this->assertSame(
            ':attribute must be an array.',
            $message->template()
        );
    }

    public function test_it_has_name(): void
    {
        $assertion = new ArrayType;

        $this->assertSame('array', $assertion->name());
    }
}
