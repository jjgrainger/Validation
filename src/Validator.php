<?php

namespace Validation;

use Validation\Rules\Signals\StopsOnFailure;

class Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules;

    /**
     * Message Formatter
     *
     * @var Formatter
     */
    protected $formatter;

    /**
     * Constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules, array $messages = [], array $aliases = [])
    {
        $this->rules = $rules;
        $this->formatter = new Formatter($messages, $aliases);
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
            $value = $input[$attribute] ?? null;

            foreach ($rules as $rule) {
                if ($rule->validate($value)) {
                    continue;
                }

                $results->add(
                    $attribute,
                    $this->formatter->format($rule->message(), $rule->name(), $attribute, $value)
                );

                if ($rule instanceof StopsOnFailure) {
                    break;
                }
            }
        }

        return $results;
    }
}
