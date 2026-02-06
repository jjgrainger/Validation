<?php

namespace Validation;

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
     * Index of values for selectors.
     *
     * @var array<string, mixed>
     */
    private array $index;

    /**
     * Constructor.
     *
     * @param array<mixed> $input
     */
    public function __construct(array $input)
    {
        $this->input = $input;
    }

    /**
     * Get a single value from index data by attribute (not selector).
     *
     * @param string $attribute
     * @param mixed $default
     * @return mixed
     */
    public function get(string $attribute, mixed $default = null): mixed
    {
        return $this->index[$attribute] ?? $default;
    }

    /**
     * Return an array of values for a selector.
     *
     * @param string $selector
     * @return array<string, mixed>
     */
    public function values(string $selector): array
    {
        return Selector::make($selector)->filter($this->index);
    }

    /**
     * Build an flat index of resolved selectors and their values.
     *
     * @param string[] $selectors
     * @return void
     */
    public function index(array $selectors): void
    {
        $result = [];

        foreach ($selectors as $selector) {
            $result = array_merge(
                $result,
                Selector::make($selector)->expand($this->input)
            );
        }

        $this->index = $result;
    }
}
