<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\InputContract;
use Validation\Contracts\ResultContract;
use Validation\Contracts\SpecificationContract;
use Validation\Rules\Signals\NeedsInput;
use Validation\Rules\Signals\SkipsOnFailure;
use Validation\Rules\Signals\StopsOnFailure;

class Validator
{
    /**
     * Validation Specification.
     *
     * @var SpecificationContract
     */
    protected $specification;

    /**
     * Message Formatter
     *
     * @var FormatterContract
     */
    protected $formatter;

    /**
     * Constructor.
     *
     * @param SpecificationContract $specification
     * @param FormatterContract $formatter
     */
    public function __construct(SpecificationContract $specification, FormatterContract $formatter)
    {
        $this->specification = $specification;
        $this->formatter = $formatter;
    }

    /**
     * Make a Validator.
     *
     * @param array<string, mixed> $rules
     * @param array<string, mixed> $config
     * @return self
     */
    public static function make(
        array $rules,
        array $config = [],
    ): self {
        return Factory::makeValidator(new Configuration($rules, $config));
    }

    /**
     * Validate input.
     *
     * @param array<string, mixed>|InputContract $input
     * @return ResultContract
     */
    public function validate(array|InputContract $input, ?ResultContract $result = null): ResultContract
    {
        $input = is_array($input) ? new Input($input) : $input;
        $result = $result ?? new Result;

        foreach ($this->specification->attributes() as $attribute) {
            $value = $input->get($attribute);

            foreach ($this->specification->rules($attribute) as $rule) {
                if ($rule instanceof NeedsInput) {
                    $rule->setInput($input);
                }

                if ($rule->validate($value)) {
                    continue;
                }

                if ($rule instanceof SkipsOnFailure) {
                    break;
                }

                $result->add(
                    $attribute,
                    $this->formatter->format($rule->message(), $rule->name(), $attribute, $value)
                );

                if ($rule instanceof StopsOnFailure) {
                    break;
                }
            }
        }

        return $result;
    }
}
