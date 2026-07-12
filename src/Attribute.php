<?php

namespace Validation;

use Validation\Contracts\AttributeContract;

class Attribute implements AttributeContract
{
    protected mixed $value;
    protected string $key;
    protected bool $exists;

    public function __construct(mixed $value, string $key, bool $exists)
    {
        $this->value = $value;
        $this->key = $key;
        $this->exists = $exists;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function exists(): bool
    {
        return $this->exists;
    }
}
