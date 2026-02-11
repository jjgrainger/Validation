<?php

namespace Validation;

use Validation\Contracts\RegistryContract;
use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Rules\Signals\AcceptsParameters;

class Registry implements RegistryContract
{
    /**
     * Array of callables to create rules.
     *
     * @var array<string, callable>
     */
    private array $bindings = [];

    /**
     * Add a rule to the Registry.
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public function add(string $name, callable $callback): void
    {
        $this->bindings[$name] = $callback;
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
        $factory = $this->bindings[$name] ?? throw InvalidRuleException::unknown($name);

        $rule = $factory();

        if ($rule instanceof AcceptsParameters) {
            $rule->setParameters($params);
        }

        return $rule;
    }
}
