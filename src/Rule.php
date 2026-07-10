<?php

namespace Validation;

use Validation\Contracts\RuleContract;

class Rule implements RuleContract
{
    protected string $selector;

    protected array $assertions;

    public function __construct(string $selector, array $assertions = [])
    {
        $this->selector = $selector;
        $this->assertions = $assertions;
    }

    public function selector(): string
    {
        return $this->selector;
    }

    public function assertions(): array
    {
        return $this->assertions;
    }
}
