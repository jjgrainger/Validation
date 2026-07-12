<?php

use PHPUnit\Framework\TestCase;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Assertions\In;

class InTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new In(['accepted', 'values']);

        $this->assertTrue($assertion->validate('accepted'));
        $this->assertTrue($assertion->validate('values'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new In(['accepted', 'values']);

        $this->assertFalse($assertion->validate('other'));
        $this->assertFalse($assertion->validate('not valid'));
    }

    public function test_it_throws_exception_for_missing_parameters(): void
    {
        $this->expectException(InvalidAssertionException::class);

        new In([]);
    }

    public function test_message_contains_parameters(): void
    {
        $assertion = new In(['accepted', 'values']);

        $message = $assertion->message();

        $this->assertSame(
            [
                ':allowed' => 'accepted, values',
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must be one of the following values: :allowed.',
            $message->template()
        );
    }
}
