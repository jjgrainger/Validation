<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class Max extends Rule
{
    protected int|float $max;

    public function __construct(int|float $max)
    {
        $this->max = $max;
    }

    public function validate(mixed $value): bool
    {
        return $value <= $this->max;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be less than :max.',
            [
                ':max' => $this->max,
            ]
        );
    }
}
