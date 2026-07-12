<?php

use PHPUnit\Framework\TestCase;
use Validation\Assertions\StringType;

class StringTypeTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new StringType;

        $this->assertTrue($assertion->validate(''));
        $this->assertTrue($assertion->validate('string'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new StringType;

        $this->assertFalse($assertion->validate(1));
        $this->assertFalse($assertion->validate([]));
        $this->assertFalse($assertion->validate(true));
    }

    public function test_it_has_messaage(): void
    {
        $assertion = new StringType;

        $message = $assertion->message();

        $this->assertSame(
            ':attribute must be a string.',
            $message->template()
        );
    }

    public function test_it_has_name(): void
    {
        $assertion = new StringType;

        $this->assertSame('string', $assertion->name());
    }
}
