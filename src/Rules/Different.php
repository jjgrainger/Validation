<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresParameters;
use Validation\Rules\Signals\RequiresInput;
use Validation\Rules\Traits\WithInput;

class Different extends Rule implements RequiresInput, RequiresParameters
{
    use WithInput;

    private readonly string $other;

    public function setParameters(array $parameters): void
    {
        $this->other = $parameters[0] ?? throw InvalidRuleException::missingParameter($this->name(), 'other');
    }

    public function validate(mixed $value): bool
    {
        return $value !== $this->input->get($this->other);
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must not be the same as :other.',
            [
                ':other' => $this->other,
            ]
        );
    }
}
