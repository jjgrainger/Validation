<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Assertion;

class Length extends Assertion
{
    private int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function validate(mixed $value): bool
    {
        return strlen($value) === $this->length;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be less than :length.',
            [
                ':length' => $this->length,
            ]
        );
    }
}
