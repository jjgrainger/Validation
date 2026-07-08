<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;

class Url extends Constraint
{
    public function validate(mixed $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_URL);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be a valid url.');
    }
}
