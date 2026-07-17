<?php

namespace Validation;

use Validation\Contracts\FormatterContract;
use Validation\Contracts\MessageContract;
use Validation\Contracts\TranslatorContract;

class Formatter implements FormatterContract
{
    /**
     * Custom messages.
     *
     * @var array<string, string>
     */
    protected $messages;

    /**
     * Custom aliases.
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
     * @param string $assertion
     * @param string $attribute
     * @return string
     */
    public function format(MessageContract $message, string $assertion, string $attribute, mixed $value): string
    {
        $template = $this->translator->translate(
            $this->message($message, $attribute, $assertion)
        );

        $bindings = array_map(function ($replacement) {
            return $this->alias($replacement);
        }, $message->bindings());

        $bindings = array_merge(
            $bindings,
            [
                ':attribute' => $this->alias($attribute),
                ':value' => $value,
            ]
        );

        return str_replace(
            array_keys($bindings),
            array_values($bindings),
            $template
        );
    }

    /**
     * Resolve message string.
     *
     * @param MessageContract $message
     * @param string $attribute
     * @param string $assertion
     * @return string
     */
    private function message(MessageContract $message, string $attribute, string $assertion): string
    {
        $combined = $attribute . '.' . $assertion;

        if (isset($this->messages[$combined])) {
            return $this->messages[$combined];
        }

        foreach ($this->messages as $selector => $template) {
            if (Selector::make($selector)->matches($combined)) {
                return $template;
            }
        }

        return $this->messages[$assertion] ?? $message->template();
    }

    /**
     * Resolve the attribute alias.
     *
     * @param string $attribute
     * @return string
     */
    private function alias(string $attribute): string
    {
        if (isset($this->aliases[$attribute])) {
            return $this->aliases[$attribute];
        }

        foreach ($this->aliases as $selector => $alias) {
            if (Selector::make($selector)->matches($attribute)) {
                return $alias;
            }
        }

        return $attribute;
    }
}
