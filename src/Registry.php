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
    private array $bindings = [];

    /**
     * Add a rule by class.
     *
     * @param string $class
     * @return void
     */
    public function add(string $class): void
    {
        if (!is_subclass_of($class, RuleContract::class)) {
            throw InvalidRuleException::invalidRuleClass($class);
        }

        $this->bindings[$class::name()] = function (...$params) use ($class) {
            return new $class(...$params);
        };
    }

    /**
     * Bind a rule to the Registry.
     *
     * @param string $name
     * @param callable $factory
     * @return void
     */
    public function bind(string $name, callable $factory): void
    {
        $this->bindings[$name] = $factory;
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
        $binding = $this->bindings[$name] ?? throw InvalidRuleException::unknown($name);

        return $binding(...$params);
    }
}
