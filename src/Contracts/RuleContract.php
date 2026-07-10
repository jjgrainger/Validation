<?php

namespace Validation\Contracts;

interface RuleContract
{
    public function selector(): string;

    public function assertions(): array;
}
