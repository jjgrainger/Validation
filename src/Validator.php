<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Assertions\Signals\SkipsOnFailure;
use Validation\Assertions\Signals\StopsOnFailure;
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
                foreach ($rule->assertions() as $assetion) {
                    $assetion->prepare($attribute, $input);

                    if ($assetion->validate($attribute->value())) {
                        continue;
                    }

                    if ($assetion instanceof SkipsOnFailure) {
                        break;
                    }

                    $result->add(
                        $attribute->key(),
                        $this->formatter->format(
                            $assetion->message(),
                            $assetion->name(),
                            $selector,
                            $attribute->value()
                        )
                    );

                    if ($assetion instanceof StopsOnFailure) {
                        break;
                    }
                }
            }
        }

        return $result;
    }
}
