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
     * Build an flat index of resolved selectors and their values.
     *
     * @param string[] $selectors
     * @return void
     */
    public function index(array $selectors): void;
}
