<?php

namespace Validation\Contracts;

interface SchemaContract
{
    /**
     * Array of attributes to validate.
     *
     * @return string[]
     */
    public function attributes(): array;

    /**
     * Array of rules for an attribute.
     *
     * @param string $attribute
     * @return RuleContract[]
     */
    public function rules(string $attribute): array;
}
