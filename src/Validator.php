<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\TranslatorContract;
use Validation\Rules\Signals\NeedsInput;
use Validation\Rules\Signals\StopsOnFailure;
use Validation\Translator;

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
     * @param FormatterContract $formatter
     */
    public function __construct(array $rules, FormatterContract $formatter)
    {
        $this->rules = $rules;
        $this->formatter = $formatter;
    }

    /**
     * Make a Validator.
     *
     * @param array $rules
     * @param array $messages
     * @param array $aliases
     * @param TranslatorContract|null $translator
     * @return self
     */
    public static function make(array $rules, array $messages = [], array $aliases = [], ?TranslatorContract $translator = null): self
    {
        return new self(
            $rules,
            new Formatter(
                $messages,
                $aliases,
                $translator ?? new Translator
            )
        );
    }

    /**
     * Validate input.
     *
     * @param array $input
     * @return Result
     */
    public function validate(array $input): Result
    {
        $input = new Input($input);
        $results = new Result;

        foreach ($this->rules as $attribute => $rules) {
            $value = $input->get($attribute);

            foreach ($rules as $rule) {
                if ($rule instanceof NeedsInput) {
                    $rule->setInput($input);
                }

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
