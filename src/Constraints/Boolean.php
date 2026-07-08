<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;

class Boolean extends Constraint
{
    public function validate(mixed $value): bool
    {
        return is_bool($value);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be a boolean.');
    }
}
