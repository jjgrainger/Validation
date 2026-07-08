<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidConstraintException;
use Validation\Message;
use Validation\Constraint;

class In extends Constraint
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
            throw InvalidConstraintException::missingParameter($this->name(), 'allowed');
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
