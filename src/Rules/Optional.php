<?php

namespace Validation\Rules;

use Validation\Rule;
use Validation\Rules\Signals\SkipsOnFailure;

class Optional extends Rule implements SkipsOnFailure
{
    public function validate(mixed $value): bool
    {
        return ! is_null($value);
    }

    public function message(): never
    {
        throw new \LogicException('Optional does not produce messages.');
    }
}
