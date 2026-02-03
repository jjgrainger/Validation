<?php

namespace Validation\Contracts;

interface ResolverContract
{
    /**
     * Resolve rules array.
     *
     * @param array<string, mixed> $rules
     * @param RegistryContract $registry
     * @return array<string, RuleContract[]>
     */
    public function resolve(array $rules, RegistryContract $registry): array;
}
