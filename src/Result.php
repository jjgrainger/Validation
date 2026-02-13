<?php

namespace Validation;

class Result
{
    /**
     * Result messages.
     *
     * @var array<string, array<int, string>>
     */
    protected array $messages = [];

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
     * Get messages for a key.
     *
     * @param string $key
     * @return string[]
     */
    public function get(string $key): array
    {
        $selector = Selector::make($key);
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
     * @param string $key
     * @return string|null
     */
    public function first(string $key): ?string
    {
        return $this->get($key)[0] ?? null;
    }

    /**
     * Returns all messages.
     *
     * @return array<string, array<int, string>>
     */
    public function all(): array
    {
        return $this->messages;
    }

    /**
     * Return Results as an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'passes' => $this->passes(),
            'fails' => $this->fails(),
            'messages' => $this->messages,
        ];
    }

    /**
     * Return Results as JSON.
     *
     * @param int $flag
     * @param int<1, max> $depth
     * @return string|false
     */
    public function toJson(int $flag = 0, int $depth = 512): string|false
    {
        return json_encode($this->toArray(), $flag, $depth);
    }
}
