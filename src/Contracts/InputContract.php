<?php

namespace Validation\Contracts;

interface InputContract
{
    /**
     * Get a single value from index data by attribute (not selector).
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Return an array of values for a selector.
     *
     * @param string $selector
     * @return array<string, mixed>
     */
    public function values(string $selector): array;


    /**
     * Check if the attribute existed in the input data.
     *
     * @param string $attribute
     * @return boolean
     */
    public function exists(string $attribute): bool;

    /**
     * Evaluate the input based on the validation selectors.
     *
     * @param string[] $selectors
     * @return void
     */
    public function evaluate(array $selectors): void;
}
