<?php

namespace Validation\Constraints;

use Validation\Message;
use Validation\Constraint;
use Validation\Contracts\MessageContract;
use Validation\Constraints\Signals\StopsOnFailure;

class StringType extends Constraint implements StopsOnFailure
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
