<?php

namespace Validation;

use Validation\Contracts\RegistryContract;
use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Exceptions\InvalidRulesetException;

class Interpreter
{
    /**
     * Rule Registry.
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

    /**
     * Create an executable plan array for Validation.
     *
     * @param array<string, mixed> $rules
     * @return array<string, RuleContract[]>
     */
    public function createPlan(array $rules): array
    {
        $plan = [];

        foreach ($rules as $selector => $ruleset) {
            $selector = $this->parseSelector($selector);

            $plan[$selector] = [];

            $ruleset = $this->parseRuleset($ruleset);

            foreach ($ruleset as $rule) {
                $plan[$selector][] = $this->parseRule($rule);
            }
        }

        return $plan;
    }

    /**
     * Parse the attribute selector to ensure it's valid.
     *
     * @param string $selector
     * @return string
     */
    private function parseSelector(string $selector): string
    {
        return Selector::make($selector)->toString();
    }

    /**
     * Expand string rulesets to array.
     *
     * @param mixed $ruleset
     * @return mixed[]
     */
    private function parseRuleset(mixed $ruleset): array
    {
        if (is_string($ruleset)) {
            $ruleset = explode('|', $ruleset);
        }

        if (is_array($ruleset)) {
            return $ruleset;
        }

        throw InvalidRulesetException::invalidType($ruleset);
    }

    /**
     * Resolve rules to RuleContract objects.
     *
     * @param mixed $rule
     * @return RuleContract
     */
    private function parseRule(mixed $rule): RuleContract
    {
        if (is_string($rule)) {
            [$name, $params] = array_pad(explode(':', $rule), 2, null);

            if ($name === null || trim($name) === '') {
                throw InvalidRuleException::missingName($rule);
            }

            $params = $params ? explode(',', $params) : [];

            $rule = $this->registry->resolve($name, $params);
        }

        if ($rule instanceof RuleContract) {
            return $rule;
        }

        throw InvalidRuleException::invalidType($rule);
    }
}
