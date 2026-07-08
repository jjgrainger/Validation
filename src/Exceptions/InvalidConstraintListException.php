<?php

namespace Validation\Exceptions;

use InvalidArgumentException;

class InvalidConstraintListException extends InvalidArgumentException
{
    public static function invalidType(mixed $constraints): self
    {
        return new self(
            sprintf(
                'Constraint list must be a pipe deliminated string or an array, %s given.',
                gettype($constraints)
            )
        );
    }
}
