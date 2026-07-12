<?php

namespace Validation;

use Validation\Contracts\AssertionContract;
use Validation\Contracts\RuleContract;

class Rule implements RuleContract
{
    /**
     * Rule selector.
     *
     * @var string
     */
    protected string $selector;

    /**
     * Assertions for the rule.
     *
     * @var AssertionContract[]
     */
    protected array $assertions;

    /**
     * Constructor
     *
     * @param string $selector
     * @param AssertionContract[] $assertions
     */
    public function __construct(string $selector, array $assertions = [])
    {
        $this->selector = $selector;
        $this->assertions = $assertions;
    }

    /**
     * Rule selector.
     *
     * @return string
     */
    public function selector(): string
    {
        return $this->selector;
    }

    /**
     * Rule Assertions
     *
     * @return AssertionContract[]
     */
    public function assertions(): array
    {
        return $this->assertions;
    }
}
