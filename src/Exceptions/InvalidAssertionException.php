<?php

namespace Validation\Exceptions;

use InvalidArgumentException;
use Validation\Contracts\AssertionContract;

class InvalidAssertionException extends InvalidArgumentException
{
    public static function unknown(string $name): self
    {
        return new self(
            sprintf(
                'Assertion "%s" is not known or cannot be resolved.',
                $name
            )
        );
    }

    public static function missingName(string $rule): self
    {
        return new self(
            sprintf(
                'Assertion "%s" is missing a name.',
                $rule
            )
        );
    }

    public static function missingParameter(string $rule, string $parameter): self
    {
        return new self(
            sprintf(
                'Assertion "%1$s" is missing a parameter "%2$s".',
                $rule,
                $parameter
            )
        );
    }

    public static function invalidType(mixed $rule): self
    {
        return new self(
            sprintf(
                'Assertion must be a string or an instance of %s, %s given.',
                AssertionContract::class,
                is_object($rule) ? $rule::class : gettype($rule)
            )
        );
    }

    public static function invalidAssertionClass(string $class): self
    {
        return new self(
            sprintf(
                'Class [%s] must implement %s.',
                $class,
                AssertionContract::class
            )
        );
    }
}
