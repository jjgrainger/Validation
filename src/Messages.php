<?php

namespace Validation;

class Messages
{
    /**
     * Messages.
     *
     * @var array<string, string[]>
     */
    protected $messages = [];

    /**
     * Add validation message.
     *
     * @param string $attribute
     * @param string $value
     * @return void
     */
    public function add(string $attribute, string $value): void
    {
        $this->messages[$attribute][] = $value;
    }

    /**
     * Get messages for a selector.
     *
     * @param string $selector
     * @return string[]
     */
    public function get(string $selector): array
    {
        $selector = Selector::make($selector);
        $matched = [];

        foreach ($this->messages as $attribute => $message) {
            if ($selector->matches($attribute)) {
                $matched[$attribute] = $message;
            }
        }

        return array_merge(...array_values($matched)) ?: [];
    }

    /**
     * Return the first message for a key.
     *
     * @param string $selector
     * @return string|null
     */
    public function first(string $selector): ?string
    {
        return $this->get($selector)[0] ?? null;
    }

    /**
     * Returns all messages.
     *
     * @return array<string, string[]>
     */
    public function all(): array
    {
        return $this->messages;
    }

    /**
     * Return if messages are empty.
     *
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return empty($this->messages);
    }
}
