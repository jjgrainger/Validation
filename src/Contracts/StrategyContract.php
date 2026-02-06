<?php

namespace Validation\Contracts;

interface StrategyContract
{
    /**
     * Array of attributes selectors to validate.
     *
     * @return string[]
     */
    public function selectors(): array;

    /**
     * Array of rules for an attribute selector.
     *
     * @param string $selector
     * @return RuleContract[]
     */
    public function rules(string $selector): array;
}
