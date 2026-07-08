<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;
use Validation\Constraints\Signals\RequiresInput;
use Validation\Constraints\Traits\WithInput;

class Different extends Constraint implements RequiresInput
{
    use WithInput;

    private string $other;

    public function __construct(string $other)
    {
        $this->other = $other;
    }

    public function validate(mixed $value): bool
    {
        return $value !== $this->input->get($this->other);
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must not be the same as :other.',
            [
                ':other' => $this->other,
            ]
        );
    }
}
