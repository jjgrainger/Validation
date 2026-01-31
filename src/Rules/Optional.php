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


// if value is empty - we can't process other rules but we do not fail
// if value exists - we can process other rules
