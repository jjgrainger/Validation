<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresParameters;

class Min extends Rule implements RequiresParameters
{
    private readonly int|float $min;

    public function setParameters(array $parameters): void
    {
        $this->min = $parameters[0] ?? throw InvalidRuleException::missingParameter($this->name(), 'min');
    }

    public function validate(mixed $value): bool
    {
        return $value >= $this->min;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be greater than :min.',
            [
                ':min' => $this->min,
            ]
        );
    }
}
