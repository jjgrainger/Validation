<?php

namespace Validation\Contracts;

interface ResolverContract
{
    /**
     * Returns the resolved rules array.
     *
     * @param array<string, mixed> $rules
     * @return array<string, RuleContract[]>
     */
    public function resolve(array $rules): array;
}
