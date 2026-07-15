<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\PolicyContract;
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
     * Validation Policy.
     *
     * @var PolicyContract
     */
    protected $policy;

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
    public function __construct(SchemaContract $schema, PolicyContract $policy, FormatterContract $formatter)
    {
        $this->schema = $schema;
        $this->policy = $policy;
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
                foreach ($rule->assertions() as $assertion) {
                    $assertion->prepare($attribute, $input);

                    if ($assertion->validate($attribute->value())) {
                        continue;
                    }

                    $action = $this->policy->onFailure($assertion->onFailure());

                    if ($action === Action::SkipRule) {
                        break;
                    }

                    $result->add(
                        $attribute->key(),
                        $this->formatter->format(
                            $assertion->message(),
                            $assertion->name(),
                            $attribute->key(),
                            $attribute->value()
                        )
                    );

                    if ($action === Action::StopRule) {
                        break;
                    }

                    if ($action === Action::StopValidation) {
                        break 3;
                    }
                }
            }
        }

        return $result;
    }
}
