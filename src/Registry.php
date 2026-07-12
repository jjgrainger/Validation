<?php

namespace Validation;

use Validation\Contracts\RegistryContract;
use Validation\Contracts\AssertionContract;
use Validation\Exceptions\InvalidAssertionException;

class Registry implements RegistryContract
{
    /**
     * Array of callables to create assertions.
     *
     * @var array<string, callable>
     */
    private array $bindings = [];

    /**
     * Add a assertion by class.
     *
     * @param string $name
     * @param string $class
     * @return void
     */
    public function add(string $name, string $class): void
    {
        if (!is_subclass_of($class, AssertionContract::class)) {
            throw InvalidAssertionException::invalidAssertionClass($class);
        }

        $this->bind($name, function (...$params) use ($class) {
            return new $class(...$params);
        });
    }

    /**
     * Bind a assertion to the Registry.
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
     * Resolve to assertion with name and params.
     *
     * @param string $name
     * @param mixed[] $params
     * @return AssertionContract
     */
    public function resolve(string $name, array $params = []): AssertionContract
    {
        $binding = $this->bindings[$name] ?? throw InvalidAssertionException::unknown($name);

        return $binding(...$params);
    }
}
