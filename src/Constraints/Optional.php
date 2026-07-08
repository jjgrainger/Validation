<?php

namespace Validation\Constraints;

use Validation\Constraint;
use Validation\Constraints\Signals\SkipsOnFailure;

class Optional extends Constraint implements SkipsOnFailure
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
