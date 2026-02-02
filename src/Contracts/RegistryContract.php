<?php

namespace Validation\Contracts;

interface RegistryContract
{
    public function resolve(string $name, array $params = []): RuleContract;
}
