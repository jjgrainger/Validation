<?php

namespace Validation\Contracts;

interface RuleContract
{
    public function validate(mixed $value): bool;

    public function message(): MessageContract;

    public function name(): string;
}
