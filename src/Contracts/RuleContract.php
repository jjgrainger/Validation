<?php

namespace Validation\Contracts;

interface RuleContract
{
    /**
     * The attribute selector for the rule.
     *
     * @return string
     */
    public function selector(): string;

    /**
     * Assertion objects to validate against.
     *
     * @return AssertionContract[]
     */
    public function assertions(): array;
}
