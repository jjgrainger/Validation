<?php

namespace Validation\Exceptions;

use InvalidArgumentException;
use Validation\Contracts\ConstraintContract;

class InvalidConstraintException extends InvalidArgumentException
{
    public static function unknown(string $name): self
    {
        return new self(
            sprintf(
                'Constraint "%s" is not known or cannot be resolved.',
                $name
            )
        );
    }

    public static function missingName(string $rule): self
    {
        return new self(
            sprintf(
                'Constraint "%s" is missing a name.',
                $rule
            )
        );
    }

    public static function missingParameter(string $rule, string $parameter): self
    {
        return new self(
            sprintf(
                'Constraint "%1$s" is missing a parameter "%2$s".',
                $rule,
                $parameter
            )
        );
    }

    public static function invalidType(mixed $rule): self
    {
        return new self(
            sprintf(
                'Constraint must be a string or an instance of %s, %s given.',
                ConstraintContract::class,
                is_object($rule) ? $rule::class : gettype($rule)
            )
        );
    }

    public static function invalidConstraintClass(string $class): self
    {
        return new self(
            sprintf(
                'Class [%s] must implement %s.',
                $class,
                ConstraintContract::class
            )
        );
    }
}
