<?php

namespace Validation;

use Validation\Contracts\RegistryContract;
use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;

class Registry implements RegistryContract
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
            'array' => fn () => new Rules\ArrayType(),
            'between' => fn ($min, $max) => new Rules\Between($min, $max),
            'boolean' => fn () => new Rules\Boolean(),
            'email' => fn () => new Rules\Email(),
            'number' => fn () => new Rules\Number(),
            'optional' => fn () => new Rules\Optional(),
            'required' => fn () => new Rules\Required(),
            'same' => fn ($other) => new Rules\Same($other),
            'string' => fn () => new Rules\StringType(),
        ];
    }

    /**
     * Resolve to rule with name and params.
     *
     * @param string $name
     * @param mixed[] $params
     * @return RuleContract
     */
    public function resolve(string $name, array $params = []): RuleContract
    {
        $factory = $this->factories[$name] ?? throw InvalidRuleException::unknown($name);

        return $factory(...$params);
    }
}
