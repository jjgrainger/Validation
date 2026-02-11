<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresParameters;

class Between extends Rule implements RequiresParameters
{
    private readonly int|float $min;

    private readonly int|float $max;

    public function setParameters(array $parameters): void
    {
        $this->min = $parameters[0] ?? throw InvalidRuleException::missingParameter($this->name(), 'min');
        $this->max = $parameters[1] ?? throw InvalidRuleException::missingParameter($this->name(), 'max');
    }

    public function validate(mixed $value): bool
    {
        return $value > $this->min && $value < $this->max;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be greater than :min and less than :max.',
            [
                ':min' => $this->min,
                ':max' => $this->max,
            ]
        );
    }
}
