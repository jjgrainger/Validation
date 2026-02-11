<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class Url extends Rule
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
