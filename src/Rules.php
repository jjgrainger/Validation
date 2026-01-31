<?php

namespace Validation;

use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;

final class Rules
{
    const REQUIRED = 'required';
    const OPTIONAL = 'optional';
    const SAME = 'same';
    const BETWEEN = 'between';

    const MAP = [
        self::REQUIRED => Rules\Required::class,
        self::OPTIONAL => Rules\Optional::class,
        self::SAME => Rules\Same::class,
        self::BETWEEN => Rules\Between::class,
    ];

    public static function make(string $name, array $params = []): RuleContract
    {
        $class = self::MAP[$name] ?? null;

        if (! $class) {
            throw InvalidRuleException::unknown($name);
        }

        return new $class(...$params);
    }
}
