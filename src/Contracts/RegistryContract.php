<?php

namespace Validation\Contracts;

interface RegistryContract
{
    /**
     * Add a rule factory to the Registry.
     *
     * @param string $name
     * @param callable $callback
     * @return void
     */
    public function add(string $name, callable $callback): void;

    /**
     * Resolve rules to RuleContract object.
     *
     * @param string $name
     * @param mixed[] $params
     * @return RuleContract
     */
    public function resolve(string $name, array $params = []): RuleContract;
}
