<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;
use Validation\Constraints\Signals\RequiresInput;
use Validation\Constraints\Signals\RequiresAttribute;
use Validation\Constraints\Signals\StopsOnFailure;
use Validation\Constraints\Traits\WithInput;
use Validation\Constraints\Traits\WithAttribute;

class Required extends Constraint implements RequiresAttribute, RequiresInput, StopsOnFailure
{
    use WithAttribute;
    use WithInput;

    public function validate(mixed $value): bool
    {
        if (!$this->input->exists($this->attribute)) {
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
