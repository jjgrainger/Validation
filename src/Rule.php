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
     * Return the rule message.
     *
     * @return Message
     */
    public function message(): Message
    {
        return new Message('Invalid :attribute.');
    }
}
