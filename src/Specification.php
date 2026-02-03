<?php

namespace Validation;

use Validation\Contracts\RuleContract;
use Validation\Contracts\SpecificationContract;

class Specification implements SpecificationContract
{
    /**
     * Validation specification.
     *
     * @var array<string, RuleContract[]>
     */
    private array $specification = [];

    /**
     * Constructor.
     *
     * @param array<string, RuleContract[]> $specification
     */
    public function __construct(array $specification)
    {
        $this->specification = $specification;
    }

    /**
     * Array of attributes to validate.
     *
     * @return string[]
     */
    public function attributes(): array
    {
        return array_keys($this->specification);
    }

    /**
     * Array of rules for an attribute.
     *
     * @param string $attribute
     * @return RuleContract[]
     */
    public function rules(string $attribute): array
    {
        return $this->specification[$attribute] ?? [];
    }
}
