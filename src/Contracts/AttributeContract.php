<?php

namespace Validation\Contracts;

interface AttributeContract
{
    public function value(): mixed;
    public function exists(): bool;
    public function key(): string;
}
