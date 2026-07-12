<?php

namespace Validation\Assertions;

use Validation\Assertion;
use Validation\Failure;

class Optional extends Assertion
{
    public function validate(mixed $value): bool
    {
        return ! is_null($value);
    }

    public function message(): never
    {
        throw new \LogicException('Optional does not produce messages.');
    }

    public function failure(): Failure
    {
        return Failure::SkipRule;
    }
}
