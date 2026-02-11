<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresParameters;

class Length extends Rule implements RequiresParameters
{
    private readonly int $length;

    public function setParameters(array $parameters): void
    {
        $this->length = $parameters[0] ?? throw InvalidRuleException::missingParameter($this->name(), 'length');
    }

    public function validate(mixed $value): bool
    {
        return strlen($value) === $this->length;
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be less than :length.',
            [
                ':length' => $this->length,
            ]
        );
    }
}
