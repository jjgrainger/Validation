<?php

namespace Validation;

use InvalidArgumentException;
use Validation\Contracts\RuleContract;
use Validation\Contracts\SchemaContract;
use Validation\Exceptions\InvalidRuleException;

class Schema implements SchemaContract
{
    /**
     * Validation schema.
     *
     * @var array<string, RuleContract[]>
     */
    private array $schema = [];

    /**
     * Constructor.
     *
     * @param array<string, RuleContract[]> $schema
     */
    public function __construct(array $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Array of attributes to validate.
     *
     * @return string[]
     */
    public function attributes(): array
    {
        return array_keys($this->schema);
    }

    /**
     * Array of rules for an attribute.
     *
     * @param string $attribute
     * @return RuleContract[]
     */
    public function rules($attribute): array
    {
        return $this->schema[$attribute] ?? [];
    }

    /**
     * Make a Schema from an array.
     *
     * @param mixed[] $definition
     * @param Resolver $resolver
     * @return self
     */
    public static function make(array $definition, Resolver $resolver): self
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

                    $rule = $resolver->resolve($name, $params);
                }

                if ($rule instanceof RuleContract) {
                    $schema[$attribute][] = $rule;
                    continue;
                }

                throw InvalidRuleException::invalidType($rule);
            }
        }

        return new Schema($schema);
    }
}
