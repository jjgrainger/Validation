<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Assertion;
use Validation\Assertions\Signals\StopsOnFailure;

class Required extends Assertion implements StopsOnFailure
{
    public function validate(mixed $value): bool
    {
        if (!$this->attribute->exists()) {
            return false;
        }

        return !(
            $value === null ||
            (is_string($value) && trim($value) === '') ||
            (is_array($value) && count($value) === 0)
        );
    }

    public function message(): MessageContract
    {
        return new Message(':attribute is required.');
    }
}
