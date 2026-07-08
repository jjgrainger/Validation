<?php

namespace Validation;

use Validation\Contracts\RuleContract;

class Rule implements RuleContract
{
    protected string $selector;

    protected array $constraints;

    public function __construct(string $selector, array $constraints = [])
    {
        $this->selector = $selector;
        $this->constraints = $constraints;
    }

    public function selector(): string
    {
        return $this->selector;
    }

    public function constraints(): array
    {
        return $this->constraints;
    }
}
