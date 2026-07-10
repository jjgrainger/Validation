<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;

class Same extends Constraint
{
    private string $other;

    public function __construct(string $other)
    {
        $this->other = $other;
    }

    public function validate(mixed $value): bool
    {
        return $value === $this->input->attribute($this->other)->value();
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be the same as :other.',
            [
                ':other' => $this->other,
            ]
        );
    }
}
