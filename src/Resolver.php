<?php

namespace Validation;

use Validation\Contracts\RegistryContract;
use Validation\Contracts\ResolverContract;
use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;

class Resolver implements ResolverContract
{
    /**
     * Registry
     *
     * @var RegistryContract
     */
    protected $registry;

    /**
     * Constructor.
     *
     * @param RegistryContract $registry
     */
    public function __construct(RegistryContract $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Resolve rules array for Specification.
     *
     * @param array<string, mixed> $rules
     * @return array<string, RuleContract[]>
     */
    public function resolve(array $rules): array
    {
        $resolved = [];

        foreach ($rules as $attribute => $ruleset) {
            $resolved[$attribute] = [];

            $ruleset = is_string($ruleset) ? explode('|', $ruleset) : $ruleset;

            foreach ($ruleset as $rule) {
                if (is_string($rule)) {
                    [$name, $params] = array_pad(explode(':', $rule), 2, null);

                    if ($name === null || trim($name) === '') {
                        throw InvalidRuleException::missingName($rule);
                    }

                    $params = $params ? explode(',', $params) : [];

                    $rule = $this->registry->resolve($name, $params);
                }

                if ($rule instanceof RuleContract) {
                    $resolved[$attribute][] = $rule;
                    continue;
                }

                throw InvalidRuleException::invalidType($rule);
            }
        }

        return $resolved;
    }
}
