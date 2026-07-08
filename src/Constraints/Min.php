<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Constraint;

class Min extends Constraint
{
    private int|float $min;

    public function __construct(int|float $min)
    {
        $this->min = $min;
    }

    public function validate(mixed $value): bool
    {
        return $value >= $this->min;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be greater than :min.',
            [
                ':min' => $this->min,
            ]
        );
    }
}
