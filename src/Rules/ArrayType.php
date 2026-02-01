<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class ArrayType extends Rule
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
