<?php

namespace Validation;

use Validation\Contracts\AttributeContract;
use Validation\Contracts\InputContract;

class Input implements InputContract
{
    /**
     * Input data.
     *
     * @var array<mixed>
     */
    private array $input;

    /**
     * Index of all available attributes and their values.
     *
     * @var array<string, mixed>
     */
    private array $index;

    /**
     * Constructor.
     *
     * @param mixed[] $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
        $this->index = $this->index($input);
    }

    /**
     * Index data to flat map of attributes and values.
     *
     * @param array<string, mixed> $input
     * @param string $path
     * @return array<string, mixed>
     */
    private function index(array $input, string $path = ''): array
    {
        $index = [];

        foreach ($input as $key => $value) {
            $attribute = $path === '' ? (string) $key : "{$path}.{$key}";
            $index[$attribute] = $value;

            if (is_array($value)) {
                $index += $this->index($value, $attribute);
            }
        }

        return $index;
    }

    /**
     * Get attributes for a selector.
     *
     * @param string $selector
     * @return AttributeContract[]
     */
    public function attributes(string $selector): array
    {
        $selector = Selector::make($selector);
        $attributes = [];

        foreach ($this->index as $attribute => $value) {
            if ($selector->matches($attribute)) {
                $attributes[] = new Attribute(
                    key: $attribute,
                    value: $value,
                    exists: true,
                );
            }
        }

        if (empty($attributes) && !$selector->hasWildcard()) {
            $attributes[] = new Attribute(
                key: $selector->toString(),
                value: null,
                exists: false
            );
        }

        return $attributes;
    }

    /**
     * Get an attribute for a selector.
     *
     * @param string $attribute
     * @return AttributeContract
     */
    public function attribute(string $attribute): AttributeContract
    {
        return new Attribute(
            key: $attribute,
            value: $this->index[$attribute] ?? null,
            exists: array_key_exists($attribute, $this->index),
        );
    }

    /**
     * Return the raw input.
     *
     * @return array<string, mixed>
     */
    public function input(): array
    {
        return $this->input;
    }
}
