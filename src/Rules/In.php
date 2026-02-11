<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\AcceptsParameters;

class In extends Rule implements AcceptsParameters
{
    private array $allowed;

    public function setParameters(array $parameters): void
    {
        if (empty($parameters)) {
            throw InvalidRuleException::missingParameter($this->name(), 'allowed');
        }

        $this->allowed = $parameters;
    }

    public function validate(mixed $value): bool
    {
        return in_array($value, $this->allowed, true);
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be one of the following values: :allowed.',
            [
                ':allowed' => implode(', ', $this->allowed),
            ]
        );
    }
}
