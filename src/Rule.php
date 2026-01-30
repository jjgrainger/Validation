<?php

namespace Validation;

abstract class Rule
{
    /**
     * Validate input.
     *
     * @param mixed $value
     * @return boolean
     */
    abstract public function validate(mixed $value): bool;

    /**
     * Return the rule name.
     *
     * @return string
     */
    public function name(): string
    {
        $parts = explode('\\', static::class);
        return lcfirst(end($parts));
    }

    /**
     * Return the rule message.
     *
     * @return Message
     */
    public function message(): Message
    {
        return new Message('Invalid :attribute.');
    }
}
