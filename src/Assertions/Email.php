<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Assertion;

class Email extends Assertion
{
    public function validate(mixed $value): bool
    {
        return false !== filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be a valid email.');
    }
}
