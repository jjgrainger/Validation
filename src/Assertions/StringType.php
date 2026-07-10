<?php

namespace Validation\Assertions;

use Validation\Message;
use Validation\Assertion;
use Validation\Contracts\MessageContract;
use Validation\Assertions\Signals\StopsOnFailure;

class StringType extends Assertion implements StopsOnFailure
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
