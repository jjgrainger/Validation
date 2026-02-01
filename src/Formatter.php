<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\MessageContract;
use Validation\Contracts\TranslatorContract;

class Formatter implements FormatterContract
{
    /**
     * messages.
     *
     * @var array<string, string>
     */
    protected $messages;

    /**
     * aliases.
     *
     * @var array<string, string>
     */
    protected $aliases;

    /**
     * Translator.
     *
     * @var TranslatorContract
     */
    protected $translator;

    /**
     * Constructor.
     *
     * @param array<string, string> $messages
     * @param array<string, string> $aliases
     * @param TranslatorContract $translator
     */
    public function __construct(array $messages, array $aliases, TranslatorContract $translator)
    {
        $this->messages = $messages;
        $this->aliases = $aliases;
        $this->translator = $translator;
    }

    /**
     * Format the message.
     *
     * @param MessageContract $message
     * @param string $key
     * @param string $attribute
     * @return string
     */
    public function format(MessageContract $message, string $key, string $attribute, mixed $value): string
    {
        $template = $this->translator->translate(
            $this->messages[$attribute . '.' . $key] ?? $this->messages[$key] ?? $message->template()
        );

        $bindings = array_merge(
            $message->bindings(),
            [
                ':attribute' => $this->aliases[$attribute] ?? $attribute,
                ':value' => $value,
            ]
        );

        return str_replace(
            array_keys($bindings),
            array_values($bindings),
            $template
        );
    }
}
