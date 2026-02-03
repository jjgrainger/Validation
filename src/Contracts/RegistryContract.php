<?php

namespace Validation\Contracts;

interface RegistryContract
{
    /**
     * Resolve rules to RuleContract object.
     *
     * @param string $name
     * @param mixed[] $params
     * @return RuleContract
     */
    public function resolve(string $name, array $params = []): RuleContract;
}
