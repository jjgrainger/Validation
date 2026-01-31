<?php

namespace Validation;

use Validation\Contracts\RuleContract;
use Validation\Exceptions\InvalidRuleException;

class Schema
{
    private array $rules = [];

    /**
     * Constructor.
     *
     * @param array $ruleset
     */
    public function __construct(array $ruleset)
    {
        foreach ($ruleset as $attribute => $rules) {
            $this->rules[$attribute] = $this->parse($rules);
        }
    }

    /**
     * Return the rules array.
     *
     * @return array
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * Parse rules to an array of RuleContract objects.
     *
     * @param string|array $rules
     * @return array
     */
    private function parse(string|array $rules): array
    {
        $parsed = [];
        $rules = is_string($rules) ? explode('|', $rules) : $rules;

        foreach ($rules as $rule) {
            $rule = is_string($rule) ? $this->resolve($rule) : $rule;

            if ($rule instanceof RuleContract) {
                $parsed[] = $rule;
                continue;
            }

            throw InvalidRuleException::invalidType($rule);
        }

        return $parsed;
    }

    /**
     * Resolve named rule to RuleContract object.
     *
     * @param string $rule
     * @return RuleContract
     */
    private function resolve(string $rule): RuleContract
    {
        [$name, $params] = array_pad(explode(':', $rule), 2, null);
        $params = $params ? explode(',', $params) : [];

        return Rules::make($name, $params);
    }
}
