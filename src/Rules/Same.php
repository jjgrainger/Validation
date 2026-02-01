<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Message;
use Validation\Rule;
use Validation\Rules\Signals\NeedsInput;
use Validation\Rules\Traits\AcceptsInput;

class Same extends Rule implements NeedsInput
{
    use AcceptsInput;

    private readonly string $other;

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
