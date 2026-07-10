<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Assertion;

class ArrayType extends Assertion
{
    public function validate(mixed $value): bool
    {
        return is_array($value);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be an array.');
    }

    public function name(): string
    {
        return 'array';
    }
}
