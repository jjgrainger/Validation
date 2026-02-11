<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\AcceptsParameters;
use Validation\Rules\Signals\NeedsInput;
use Validation\Rules\Traits\AcceptsInput;

class Same extends Rule implements NeedsInput, AcceptsParameters
{
    use AcceptsInput;

    private readonly string $other;

    public function setParameters(array $parameters): void
    {
        $this->other = $parameters[0] ?? throw InvalidRuleException::missingParameter($this->name(), 'other');
    }

    public function validate(mixed $value): bool
    {
        return $value === $this->input->get($this->other);
    }

    public function message(): MessageContract
    {
        return new Message(
            ':attribute must be the same as :other.',
            [
                ':other' => $this->other,
            ]
        );
    }
}
