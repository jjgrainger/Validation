<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\TranslatorContract;
use Validation\Rules\Signals\NeedsInput;
use Validation\Rules\Signals\SkipsOnFailure;
use Validation\Rules\Signals\StopsOnFailure;
use Validation\Translator;

class Validator
{
    /**
     * Validation schema.
     *
     * @var Schema
     */
    protected $schema;

    /**
     * Message Formatter
     *
     * @var Formatter
     */
    protected $formatter;

    /**
     * Constructor.
     *
     * @param Schema $schema
     * @param FormatterContract $formatter
     */
    public function __construct(Schema $schema, FormatterContract $formatter)
    {
        $this->schema = $schema;
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
            new Schema($rules),
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

        foreach ($this->schema->rules() as $attribute => $rules) {
            $value = $input->get($attribute);

            foreach ($rules as $rule) {
                if ($rule instanceof NeedsInput) {
                    $rule->setInput($input);
                }

                if ($rule->validate($value)) {
                    continue;
                }

                if ($rule instanceof SkipsOnFailure) {
                    break;
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
