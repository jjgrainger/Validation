<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresParameters;

class NotIn extends Rule implements RequiresParameters
{
    private array $disallowed;

    public function setParameters(array $parameters): void
    {
        if (empty($parameters)) {
            throw InvalidRuleException::missingParameter($this->name(), 'disallowed');
        }

        $this->disallowed = $parameters;
    }

    public function validate(mixed $value): bool
    {
        return ! in_array($value, $this->disallowed, true);
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must not be one of the following values: :disallowed.',
            [
                ':disallowed' => implode(', ', $this->disallowed),
            ]
        );
    }
}
