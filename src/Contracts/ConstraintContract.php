<?php

namespace Validation\Contracts;

interface ConstraintContract
{
    public function validate(mixed $value): bool;

    public function prepare(string $attribute, InputContract $input): void;

    public function message(): MessageContract;

    public function name(): string;
}
