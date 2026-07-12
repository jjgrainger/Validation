<?php

namespace Validation\Contracts;

use Validation\Failure;

interface AssertionContract
{
    public function validate(mixed $value): bool;

    public function prepare(AttributeContract $attribute, InputContract $input): void;

    public function message(): MessageContract;

    public function name(): string;

    public function failure(): Failure;
}
