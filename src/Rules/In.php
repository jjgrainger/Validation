<?php

namespace Validation\Rules;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidRuleException;
use Validation\Message;
use Validation\Rule;

class In extends Rule
{
    /**
     * Allowed enum.
     *
     * @var mixed[]
     */
    private array $allowed;

    /**
     * Constructor.
     *
     * @param mixed[] $allowed
     */
    public function __construct(array $allowed)
    {
        if (empty($allowed)) {
            throw InvalidRuleException::missingParameter($this->name(), 'allowed');
        }
        $this->allowed = $allowed;
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
