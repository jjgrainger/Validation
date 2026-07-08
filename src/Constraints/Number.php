<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;

class Number extends Constraint
{
    public function validate(mixed $value): bool
    {
        return is_int($value) || is_float($value);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be a number.');
    }
}
