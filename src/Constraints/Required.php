<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;
use Validation\Constraints\Signals\StopsOnFailure;

class Required extends Constraint implements StopsOnFailure
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
