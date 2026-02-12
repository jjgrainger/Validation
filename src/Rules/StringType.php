<?php

namespace Validation\Rules;

use Validation\Message;
use Validation\Rule;
use Validation\Contracts\MessageContract;
use Validation\Rules\Signals\StopsOnFailure;

class StringType extends Rule implements StopsOnFailure
{
    public function validate(mixed $value): bool
    {
        return is_string($value);
    }

    public function message(): MessageContract
    {
        return new Message(':attribute must be a string.');
    }

    public static function name(): string
    {
        return 'string';
    }
}
