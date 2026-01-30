<?php

namespace Validation\Rules;

use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\StopsOnFailure;

class Required extends Rule implements StopsOnFailure
{
    public function validate(mixed $value): bool
    {
        return ! empty($value);
    }

    public function message(): Message
    {
        return new Message(':attribute is required.');
    }
}
