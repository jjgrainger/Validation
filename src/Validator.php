<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\InputContract;
use Validation\Contracts\ResultContract;
use Validation\Contracts\SchemaContract;
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
     * @param array<string, mixed[]> $rules
     * @param array<string, string> $messages
     * @param array<string, string> $aliases
     * @param TranslatorContract|null $translator
     * @return self
     */
    public static function make(
        array $rules,
        array $messages = [],
        array $aliases = [],
        ?TranslatorContract $translator = null
    ): self {
        return new self(
            Schema::make(
                $rules,
                new Resolver
            ),
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
     * @param array<string, mixed>|InputContract $input
     * @return ResultContract
     */
    public function validate(array|InputContract $input, ?ResultContract $result = null): ResultContract
    {
        $input = is_array($input) ? new Input($input) : $input;
        $result = $result ?? new Result;

        foreach ($this->schema->attributes() as $attribute) {
            $value = $input->get($attribute);

            foreach ($this->schema->rules($attribute) as $rule) {
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
