<?php

namespace Validation\Exceptions;

use InvalidArgumentException;
use Validation\Contracts\RuleContract;

class InvalidRuleException extends InvalidArgumentException
{
    public static function unknown(string $name): self
    {
        return new self(
            sprintf(
                'Validation rule "%s" is not known or cannot be resolved.',
                $name
            )
        );
    }

    public static function missingName(string $rule): self
    {
        return new self(
            sprintf(
                'Validation rule "%s" is missing a name.',
                $rule
            )
        );
    }

    public static function missingParameter(string $rule, string $parameter): self
    {
        return new self(
            sprintf(
                'Validation rule "%1$s" is missing a parameter "%2$s".',
                $rule,
                $parameter
            )
        );
    }

    public static function invalidType(mixed $rule): self
    {
        return new self(
            sprintf(
                'Validation rule must be a string or an instance of %s, %s given.',
                RuleContract::class,
                is_object($rule) ? $rule::class : gettype($rule)
            )
        );
    }

    public static function invalidRuleClass(string $class): self
    {
        return new self(
            sprintf(
                'Class [%s] must implement %s.',
                $class,
                RuleContract::class
            )
        );
    }
}
