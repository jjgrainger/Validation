<?php

namespace Validation;

use InvalidArgumentException;
use Validation\Contracts\RegistryContract;
use Validation\Contracts\RuleContract;
use Validation\Contracts\SpecificationContract;
use Validation\Exceptions\InvalidRuleException;

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

    /**
     * Make a Schema from an array.
     *
     * @param mixed[] $definition
     * @param RegistryContract $resolver
     * @return self
     */
    public static function make(array $definition, RegistryContract $registry): self
    {
        $schema = [];

        foreach ($definition as $attribute => $rules) {
            if (! is_string($attribute)) {
                throw new InvalidArgumentException("Schema attribute keys must be strings, got " . gettype($attribute));
            }

            $schema[$attribute] = [];

            $rules = is_string($rules) ? explode('|', $rules) : $rules;

            foreach ($rules as $rule) {
                if (is_string($rule)) {
                    [$name, $params] = array_pad(explode(':', $rule), 2, null);

                    if ($name === null || trim($name) === '') {
                        throw InvalidRuleException::missingName($rule);
                    }

                    $params = $params ? explode(',', $params) : [];

                    $rule = $registry->resolve($name, $params);
                }

                if ($rule instanceof RuleContract) {
                    $schema[$attribute][] = $rule;
                    continue;
                }

                throw InvalidRuleException::invalidType($rule);
            }
        }

        return new Specification($schema);
    }
}
