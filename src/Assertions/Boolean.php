<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Assertion;

class Boolean extends Assertion
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
