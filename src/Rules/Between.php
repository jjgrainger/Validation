<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;

class Between extends Rule
{
    protected $min;

    protected $max;

    public function __construct(int|float $min, int|float $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function validate($value): bool
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
