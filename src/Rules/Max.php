<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresParameters;

class Max extends Rule implements RequiresParameters
{
    private readonly int|float $max;

    public function setParameters(array $parameters): void
    {
        $this->max = $parameters[0] ?? throw InvalidRuleException::missingParameter($this->name(), 'max');
    }

    public function validate(mixed $value): bool
    {
        return $value <= $this->max;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be less than :max.',
            [
                ':max' => $this->max,
            ]
        );
    }
}
