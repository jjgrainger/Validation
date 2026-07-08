<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\InputContract;
use Validation\Contracts\ConstraintContract;
use Validation\Constraints\Signals\RequiresAttribute;
use Validation\Constraints\Signals\RequiresInput;
use Validation\Constraints\Signals\SkipsOnFailure;
use Validation\Constraints\Signals\StopsOnFailure;
use Validation\Contracts\SchemaContract;

class Validator
{
    /**
     * Validation Strategy.
     *
     * @var SchemaContract
     */
    protected $schema;

    /**
     * Message Formatter
     *
     * @var FormatterContract
     */
    protected $formatter;

    /**
     * Constructor.
     *
     * @param SchemaContract $schema
     * @param FormatterContract $formatter
     */
    public function __construct(SchemaContract $schema, FormatterContract $formatter)
    {
        $this->schema = $schema;
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
        $result = new Result;

        foreach ($this->schema->rules() as $rule) {
            $selector = $rule->selector();
            $values = $input->values($selector);

            foreach ($values as $attribute => $value) {
                foreach ($rule->constraints() as $constraint) {

                    $constraint->prepare($attribute, $input);

                    if ($constraint->validate($value)) {
                        continue;
                    }

                    if ($constraint instanceof SkipsOnFailure) {
                        break;
                    }

                    $result->add(
                        $attribute,
                        $this->formatter->format($constraint->message(), $constraint->name(), $selector, $value)
                    );

                    if ($constraint instanceof StopsOnFailure) {
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

        $selectors = [];

        foreach ($this->schema->rules() as $rule) {
            $selectors[] = $rule->selector();
        }

        $input->evaluate($selectors);

        return $input;
    }
}
