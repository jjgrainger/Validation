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
}
