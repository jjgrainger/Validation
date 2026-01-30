<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\StopsOnFailure;

class Required extends Rule implements StopsOnFailure
{
    public function validate(mixed $value): bool
    {
        return ! empty($value);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute is required.');
    }
}
