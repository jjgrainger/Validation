<?php

namespace Validation;

use Validation\Contracts\InputContract;

class Input implements InputContract
{
    private array $items;

    public function __construct(array $input)
    {
        $this->items = $input;
    }

    public function get(string $attribute, $default = null): mixed
    {
        return $this->items[$attribute] ?? $default;
    }
}
