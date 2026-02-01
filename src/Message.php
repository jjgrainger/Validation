<?php

namespace Validation;

use Validation\Contracts\MessageContract;

class Message implements MessageContract
{
    /**
     * The message template.
     *
     * @var string
     */
    protected $template;

    /**
     * The message template bindings.
     *
     * @var array<string, string>
     */
    protected $bindings;

    /**
     * Constructor.
     *
     * @param string $template
     * @param array<string, mixed> $bindings
     */
    public function __construct(string $template, array $bindings = [])
    {
        $this->template = $template;
        $this->bindings = $bindings;
    }

    /**
     * Return the message template.
     *
     * @return string
     */
    public function template(): string
    {
        return $this->template;
    }

    /**
     * Return the message bindings.
     *
     * @return array<string, mixed>
     */
    public function bindings(): array
    {
        return $this->bindings;
    }
}
