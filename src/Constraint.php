<?php

namespace Validation;

use Validation\Contracts\AttributeContract;
use Validation\Contracts\MessageContract;
use Validation\Contracts\ConstraintContract;
use Validation\Contracts\InputContract;

abstract class Constraint implements ConstraintContract
{
    /**
     * Attribute being validated.
     *
     * @var AttributeContract
     */
    protected AttributeContract $attribute;

    /**
     * Input being validated.
     *
     * @var InputContract
     */
    protected InputContract $input;

    /**
     * Validate input.
     *
     * @param mixed $value
     * @return boolean
     */
    abstract public function validate(mixed $value): bool;

    /**
     * Prepare the constraint.
     *
     * @param AttributeContract $attribute
     * @param InputContract $input
     * @return void
     */
    public function prepare(AttributeContract $attribute, InputContract $input): void {
        $this->attribute = $attribute;
        $this->input = $input;
    }

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
