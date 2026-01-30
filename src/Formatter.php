<?php

namespace Validation;

use Validation\Contracts\MessageContract;

class Formatter
{
    /**
     * messages.
     *
     * @var array
     */
    protected $messages;

    /**
     * aliases.
     *
     * @var array
     */
    protected $aliases;

    /**
     * Constructor.
     *
     * @param array $messages
     * @param array $aliases
     * @param array $translations
     */
    public function __construct(array $messages, array $aliases)
    {
        $this->messages = $messages;
        $this->aliases = $aliases;
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
        $template = $this->messages[$attribute . '.' . $key] ?? $this->messages[$key] ?? $message->template();

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
