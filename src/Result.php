<?php

namespace Validation;

class Result
{
    /**
     * Result messages.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * Validation passes.
     *
     * @return boolean
     */
    public function passes(): bool
    {
        return empty($this->messages);
    }

    /**
     * Validation failed.
     *
     * @return boolean
     */
    public function fails(): bool
    {
        return ! $this->passes();
    }

    /**
     * Add validation message.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function add(string $key, string $value): void
    {
        $this->messages[$key][] = $value;
    }

    /**
     * Return the first message for a key.
     *
     * @param string $key
     * @return string|null
     */
    public function first(string $key): ?string
    {
        return $this->messages[$key][0] ?? null;
    }
}
