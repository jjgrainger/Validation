<?php

namespace Validation\Contracts;

interface RegistryContract
{
    /**
     * Add a rule to the registry by class.
     *
     * @param string $name
     * @param string $class
     * @return void
     */
    public function add(string $name, string $class): void;

    /**
     * Bing a rule factory to the Registry.
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public function bind(string $name, callable $callback): void;

    /**
     * Resolve rules to RuleContract object.
     *
     * @param string $name
     * @param mixed[] $params
     * @return RuleContract
     */
    public function resolve(string $name, array $params = []): RuleContract;
}
