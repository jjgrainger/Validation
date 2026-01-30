<?php

namespace Validation;

use Validation\Contracts\MessageContract;
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
     * @return MessageContract
     */
    public function message(): MessageContract
    {
        return new Message('Invalid :attribute.');
    }
}
