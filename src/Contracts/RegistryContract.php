<?php

namespace Validation\Contracts;

interface RegistryContract
{
    /**
     * Add a assertion to the registry by class.
     *
     * @param string $name
     * @param string $class
     * @return void
     */
    public function add(string $name, string $class): void;

    /**
     * Bing a assertion factory to the Registry.
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public function bind(string $name, callable $callback): void;

    /**
     * Resolve assertions to AssertionContract object.
     *
     * @param string $name
     * @param mixed[] $params
     * @return AssertionContract
     */
    public function resolve(string $name, array $params = []): AssertionContract;
}
