<?php

namespace Validation;

use Validation\Contracts\ConstraintContract;
use Validation\Contracts\RegistryContract;
use Validation\Contracts\SchemaContract;
use Validation\Exceptions\InvalidConstraintException;
use Validation\Exceptions\InvalidConstraintListException;

class Parser
{
    /**
     * Constraint Registry.
     *
     * @var RegistryContract
     */
    protected RegistryContract $registry;

    /**
     * Constructor.
     *
     * @param RegistryContract $registry
     */
    public function __construct(RegistryContract $registry)
    {
        $this->registry = $registry;
    }

    public function parse(array $definition): SchemaContract
    {
        $rules = [];

        foreach ($definition as $selector => $constraints) {
            $rules[] = new Rule(
                selector: $this->parseSelector($selector),
                constraints: $this->parseConstraints($constraints)
            );
        }

        return new Schema($rules);
    }

    private function parseSelector(string $selector): Selector
    {
        return Selector::make($selector);
    }

    private function parseConstraints(mixed $constraints): array
    {
        $constraints = is_string($constraints) ? explode('|', $constraints) : $constraints;

        if (! is_array($constraints)) {
            throw InvalidConstraintListException::invalidType($constraints);
        }

        return array_map(function($constraint) {
            return $this->parseConstraint($constraint);
        }, $constraints);
    }

    /**
     * Resolve rules to ConstraintContract objects.
     *
     * @param mixed $constraint
     * @return ConstraintContract
     */
    private function parseConstraint(mixed $constraint): ConstraintContract
    {
        if (is_string($constraint)) {
            [$name, $params] = array_pad(explode(':', $constraint), 2, null);

            if ($name === null || trim($name) === '') {
                throw InvalidConstraintException::missingName($constraint);
            }

            $params = $params ? explode(',', $params) : [];

            $constraint = $this->registry->resolve($name, $params);
        }

        if ($constraint instanceof ConstraintContract) {
            return $constraint;
        }

        throw InvalidConstraintException::invalidType($constraint);
    }
}
