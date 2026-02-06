<?php

namespace Validation\Exceptions;

use InvalidArgumentException;

class InvalidSelectorException extends InvalidArgumentException
{
    public static function empty(): self
    {
        return new self('Selector cannot be empty.');
    }

    public static function invalidCharacters(string $selector): self
    {
        return new self(
            sprintf(
                'Selector "%s" contains invalid characters.',
                $selector
            )
        );
    }

    public static function invalidWildcard(string $selector): self
    {
        return new self(
            sprintf(
                'Selector "%s" cannot start or end with "*".',
                $selector
            )
        );
    }

    public static function emptySegments(string $selector): self
    {
        return new self(
            sprintf(
                'Selector "%s" contains empty path segments.',
                $selector
            )
        );
    }
}
