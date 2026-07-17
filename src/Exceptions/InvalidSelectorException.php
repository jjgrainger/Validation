<?php

namespace Validation\Exceptions;

use InvalidArgumentException;

class InvalidSelectorException extends InvalidArgumentException
{
    public static function empty(): self
    {
        return new self('Selector cannot be empty.');
    }
}
