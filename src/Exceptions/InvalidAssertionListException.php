<?php

namespace Validation\Exceptions;

use InvalidArgumentException;

class InvalidAssertionListException extends InvalidArgumentException
{
    public static function invalidType(mixed $assertions): self
    {
        return new self(
            sprintf(
                'Assertion list must be a pipe deliminated string or an array, %s given.',
                gettype($assertions)
            )
        );
    }
}
