<?php

namespace Validation;

class Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules;

    /**
     * Constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validate input.
     *
     * @param array $input
     * @return Result
     */
    public function validate(array $input): Result
    {
        $results = new Result;

        foreach ($this->rules as $attribute => $rules) {
            foreach ($rules as $rule) {
                if ($rule->validate($input[$attribute])) {
                    continue;
                }

                $message = $rule->message();
                $message->setReplacement(':attribute', $attribute);

                $results->add($attribute, $message->build());
            }
        }

        return $results;
    }
}
