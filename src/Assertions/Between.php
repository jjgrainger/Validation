<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Assertion;

class Between extends Assertion
{
    private int|float $min;

    private int|float $max;

    public function __construct(int|float $min, int|float $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function validate(mixed $value): bool
    {
        return $value > $this->min && $value < $this->max;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be greater than :min and less than :max.',
            [
                ':min' => $this->min,
                ':max' => $this->max,
            ]
        );
    }
}
