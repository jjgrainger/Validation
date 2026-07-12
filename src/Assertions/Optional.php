<?php

namespace Validation\Assertions;

use Validation\Assertion;
use Validation\Assertions\Signals\SkipsOnFailure;

class Optional extends Assertion implements SkipsOnFailure
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
