<?php

namespace Validation\Contracts;

interface InputContract
{
    /**
     * Return an array of values for a selector.
     *
     * @param string $selector
     * @return array<string, AttributeContract>
     */
    public function attributes(string $selector): array;

    /**
     * Check if the attribute existed in the input data.
     *
     * @param string $attribute
     * @return AttributeContract
     */
    public function attribute(string $attribute): AttributeContract;
}
