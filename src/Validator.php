<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\InputContract;
use Validation\Contracts\RuleContract;
use Validation\Contracts\StrategyContract;
use Validation\Rules\Signals\RequiresAttribute;
use Validation\Rules\Signals\RequiresInput;
use Validation\Rules\Signals\SkipsOnFailure;
use Validation\Rules\Signals\StopsOnFailure;

class Validator
{
    /**
     * Validation Strategy.
     *
     * @var StrategyContract
     */
    protected $strategy;

    /**
     * Message Formatter
     *
     * @var FormatterContract
     */
    protected $formatter;

    /**
     * Constructor.
     *
     * @param StrategyContract $strategy
     * @param FormatterContract $formatter
     */
    public function __construct(StrategyContract $strategy, FormatterContract $formatter)
    {
        $this->strategy = $strategy;
        $this->formatter = $formatter;
    }

    /**
     * Make a Validator.
     *
     * @param array<string, mixed> $rules
     * @param array<string, mixed> $config
     * @return self
     */
    public static function make(array $rules, array $config = []): self
    {
        return Factory::makeValidator(new Configuration($rules, $config));
    }

    /**
     * Validate input.
     *
     * @param array<string, mixed> $input
     * @return Result
     */
    public function validate(array $input): Result
    {
        $input = $this->prepareInput($input);
        $result = $this->prepareResult();

        foreach ($this->strategy->selectors() as $selector) {
            $values = $input->values($selector);

            foreach ($values as $attribute => $value) {
                foreach ($this->strategy->rules($selector) as $rule) {
                    $this->prepareRule($rule, $input, $attribute);

                    if ($rule->validate($value)) {
                        continue;
                    }

                    if ($rule instanceof SkipsOnFailure) {
                        break;
                    }

                    $result->add(
                        $attribute,
                        $this->formatter->format($rule->message(), $rule->name(), $selector, $value)
                    );

                    if ($rule instanceof StopsOnFailure) {
                        break;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Prepate Input for validation.
     *
     * @param array<string, mixed> $input
     * @return InputContract
     */
    private function prepareInput(array $input): InputContract
    {
        $input = new Input($input);

        $input->evaluate($this->strategy->selectors());

        return $input;
    }

    /**
     * Prepare Result for validation.
     *
     * @return Result
     */
    private function prepareResult(): Result
    {
        return new Result;
    }

    /**
     * Prepare rule for validation.
     *
     * @param RuleContract $rule
     * @return RuleContract
     */
    private function prepareRule(RuleContract $rule, InputContract $input, string $attribute): RuleContract
    {
        if ($rule instanceof RequiresInput) {
            $rule->setInput($input);
        }

        if ($rule instanceof RequiresAttribute) {
            $rule->setAttribute($attribute);
        }

        return $rule;
    }
}
