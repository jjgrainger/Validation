<?php

namespace Tests\Fixtures;

use Validation\Assertion;

class SimpleAssertion extends Assertion
{
    public function validate(mixed $value): bool
    {
        if ('valid' === $value) {
            return true;
        }

        return false;
    }
}
