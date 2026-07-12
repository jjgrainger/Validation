<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Assertion;

class Url extends Assertion
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
