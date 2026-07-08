<?php

namespace Validation;

use Validation\Contracts\RegistryContract;
use Validation\Contracts\ConstraintContract;
use Validation\Exceptions\InvalidConstraintException;

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
     * @param string $name
     * @param string $class
     * @return void
     */
    public function add(string $name, string $class): void
    {
        if (!is_subclass_of($class, ConstraintContract::class)) {
            throw InvalidConstraintException::invalidConstraintClass($class);
        }

        $this->bind($name, function (...$params) use ($class) {
            return new $class(...$params);
        });
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
     * @return ConstraintContract
     */
    public function resolve(string $name, array $params = []): ConstraintContract
    {
        $binding = $this->bindings[$name] ?? throw InvalidConstraintException::unknown($name);

        return $binding(...$params);
    }
}
