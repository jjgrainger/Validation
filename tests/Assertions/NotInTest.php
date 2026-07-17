<?php

use PHPUnit\Framework\TestCase;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Assertions\NotIn;
use Validation\Validator;

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

    public function test_it_can_validate_values_through_the_validator(): void
    {
        $validator = Validator::make([
            'status' => 'not_in:draft,publish',
        ]);

        $result = $validator->validate([
            'status' => 'draft',
        ]);

        $this->assertSame(
            'status must not be one of the following values: draft, publish.',
            $result->messages()->first('status')
        );
    }
}
