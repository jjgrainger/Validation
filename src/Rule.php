<?php

namespace Validation;

use Validation\Contracts\RuleContract;

abstract class Rule implements RuleContract
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
