<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class Boolean extends Rule
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
