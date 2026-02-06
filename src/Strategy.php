<?php

namespace Validation;

use Validation\Contracts\RuleContract;
use Validation\Contracts\StrategyContract;

class Strategy implements StrategyContract
{
    /**
     * Validation plan.
     *
     * @var array<string, RuleContract[]>
     */
    private array $plan = [];

    /**
     * Constructor.
     *
     * @param array<string, RuleContract[]> $plan
     */
    public function __construct(array $plan)
    {
        $this->plan = $plan;
    }

    /**
     * Array of attributes selectors to validate.
     *
     * @return string[]
     */
    public function selectors(): array
    {
        return array_keys($this->plan);
    }

    /**
     * Array of rules for an attribute selector.
     *
     * @param string $selector
     * @return RuleContract[]
     */
    public function rules(string $selector): array
    {
        return $this->plan[$selector] ?? [];
    }
}
