<?php

use PHPUnit\Framework\TestCase;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Assertions\NotIn;

class NotInTest extends TestCase
{
    public function test_it_passes_valid_value(): void
    {
        $assertion = new NotIn(['disallowed', 'values']);

        $this->assertTrue($assertion->validate('other'));
        $this->assertTrue($assertion->validate('not valid'));
    }

    public function test_it_fails_invalid_value(): void
    {
        $assertion = new NotIn(['disallowed', 'values']);

        $this->assertFalse($assertion->validate('disallowed'));
        $this->assertFalse($assertion->validate('values'));
    }

    public function test_it_throws_exception_for_missing_parameters(): void
    {
        $this->expectException(InvalidAssertionException::class);

        new NotIn([]);
    }

    public function test_message_contains_parameters(): void
    {
        $assertion = new NotIn(['disallowed', 'values']);

        $message = $assertion->message();

        $this->assertSame(
            [
                ':disallowed' => 'disallowed, values',
            ],
            $message->bindings()
        );

        $this->assertSame(
            ':attribute must not be one of the following values: :disallowed.',
            $message->template()
        );
    }
}
