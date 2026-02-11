<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class Accepted extends Rule
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
