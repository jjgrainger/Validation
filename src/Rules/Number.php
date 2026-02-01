<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class Number extends Rule
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
