<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class Min extends Rule
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
