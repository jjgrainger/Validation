<?php

namespace Validation\Contracts;

interface MessageContract
{
    /**
     * Return the message template.
     *
     * @return string
     */
    public function template(): string;

    /**
     * Return the message bindings.
     *
     * @return array<string, mixed>
     */
    public function bindings(): array;
}
