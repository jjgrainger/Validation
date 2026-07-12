<?php

namespace Validation\Assertions;

use Validation\Message;
use Validation\Assertion;
use Validation\Contracts\MessageContract;

class StringType extends Assertion
{
    public function validate(mixed $value): bool
    {
        return is_string($value);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be a string.');
    }

    public function name(): string
    {
        return 'string';
    }
}
