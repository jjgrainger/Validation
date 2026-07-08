<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;

class Accepted extends Constraint
{
    public function validate(mixed $value): bool
    {
        return in_array($value, [true, 1, 'true', '1', 'yes', 'on'], true);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be accepted.');
    }
}
