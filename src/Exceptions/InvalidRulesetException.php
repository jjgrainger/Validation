<?php

namespace Validation\Exceptions;

use InvalidArgumentException;
use Validation\Contracts\RuleContract;

class InvalidRulesetException extends InvalidArgumentException
{
    public static function invalidType(mixed $ruleset): self
    {
        return new self(
            sprintf(
                'Validation ruleset must be a pipe deliminated string or an array, %s given.',
                gettype($ruleset)
            )
        );
    }
}
