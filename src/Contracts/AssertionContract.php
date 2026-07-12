<?php

namespace Validation\Contracts;

interface AssertionContract
{
    public function validate(mixed $value): bool;

    public function prepare(AttributeContract $attribute, InputContract $input): void;

    public function message(): MessageContract;

    public function name(): string;
}
