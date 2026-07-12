<?php

namespace Validation;

use Validation\Contracts\RuleContract;
use Validation\Contracts\SchemaContract;

class Schema implements SchemaContract
{
    /**
     * Schema Rules
     *
     * @var RuleContract[]
     */
    protected $rules = [];

    /**
     * Constructor
     *
     * @param RuleContract[] $rules
     */
    public function __construct(array $rules = [])
    {
        foreach ($rules as $rule) {
            $this->add($rule);
        }
    }

    /**
     * Add a rule to the schema
     *
     * @param RuleContract $rule
     * @return void
     */
    public function add(RuleContract $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * Schema Rules.
     *
     * @return RuleContract[]
     */
    public function rules(): array
    {
        return $this->rules;
    }
}
