<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
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
        $input = new Input($input);
        $result = new Result;

        foreach ($this->schema->rules() as $rule) {
            $selector = $rule->selector();

            foreach ($input->attributes($selector) as $attribute) {
                foreach ($rule->constraints() as $constraint) {

                    $constraint->prepare($attribute, $input);

                    if ($constraint->validate($attribute->value())) {
                        continue;
                    }

                    if ($constraint instanceof SkipsOnFailure) {
                        break;
                    }

                    $result->add(
                        $attribute->key(),
                        $this->formatter->format(
                            $constraint->message(),
                            $constraint->name(),
                            $selector,
                            $attribute->value()
                        )
                    );

                    if ($constraint instanceof StopsOnFailure) {
                        break;
                    }
                }
            }
        }

        return $result;
    }
}
