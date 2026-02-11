<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresInput;
use Validation\Rules\Signals\RequiresAttribute;
use Validation\Rules\Signals\StopsOnFailure;
use Validation\Rules\Traits\WithInput;
use Validation\Rules\Traits\WithAttribute;

class Required extends Rule implements RequiresAttribute, RequiresInput, StopsOnFailure
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
