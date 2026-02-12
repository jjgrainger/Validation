<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\RequiresInput;
use Validation\Rules\Traits\WithInput;

class Same extends Rule implements RequiresInput
{
    use WithInput;

    private string $other;

    public function __construct(string $other)
    {
        $this->other = $other;
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
