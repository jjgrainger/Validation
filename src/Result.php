<?php

namespace Validation;

class Result
{
    /**
     * Result messages.
     *
     * @var Messages
     */
    protected Messages $messages;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->messages = new Messages;
    }

    /**
     * Validation passes.
     *
     * @return boolean
     */
    public function passes(): bool
    {
        return $this->messages->isEmpty();
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
     * @param string $message
     * @return void
     */
    public function add(string $key, string $message): void
    {
        $this->messages->add($key, $message);
    }

    /**
     * Returns Messages.
     *
     * @return Messages
     */
    public function messages(): Messages
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
            'messages' => $this->messages->all(),
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
