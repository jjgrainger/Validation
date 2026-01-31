<?php

namespace Validation;

use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;

class Resolver
{
    /**
     * Array of callables to create rules.
     *
     * @var array<string, callable>
     */
    private array $factories;

    public function __construct()
    {
        $this->factories = [
            'required' => fn () => new Rules\Required(),
            'optional' => fn () => new Rules\Optional(),
            'same' => fn ($other) => new Rules\Same($other),
            'between' => fn ($min, $max) => new Rules\Between($min, $max),
        ];
    }

    /**
     * Resolve to rule with name and params.
     *
     * @param string $name
     * @param array $params
     * @return RuleContract
     */
    public function resolve(string $name, array $params = []): RuleContract
    {
        $factory = $this->factories[$name] ?? throw InvalidRuleException::unknown($name);

        return new $factory(...$params);
    }
}
