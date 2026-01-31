<?php

namespace Validation\Rules;

use Validation\Rule;
use Validation\Rules\Signals\SkipsOnFailure;

class Optional extends Rule implements SkipsOnFailure
{
    public function validate(mixed $value): bool
    {
        return ! empty($value);
    }
}
