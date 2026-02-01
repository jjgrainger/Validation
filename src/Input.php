<?php

namespace Validation;

use Validation\Contracts\InputContract;

class Input implements InputContract
{
    /**
     * Input data.
     *
     * @var array<string, mixed>
     */
    private array $items;

    /**
     * Constructor.
     *
     * @param array<string, mixed> $input
     */
    public function __construct(array $input)
    {
        $this->items = $input;
    }

    /**
     * Get value from input data.
     *
     * @param string $attribute
     * @param mixed $default
     * @return mixed
     */
    public function get(string $attribute, mixed $default = null): mixed
    {
        return $this->items[$attribute] ?? $default;
    }
}
