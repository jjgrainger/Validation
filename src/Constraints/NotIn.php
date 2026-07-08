<?php

namespace Validation\Constraints;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidConstraintException;
use Validation\Message;
use Validation\Constraint;

class NotIn extends Constraint
{
    /**
     * Disallowed enum.
     *
     * @var mixed[]
     */
    private array $disallowed;

    /**
     * Constructor
     *
     * @param mixed[] $disallowed
     */
    public function __construct(array $disallowed)
    {
        if (empty($disallowed)) {
            throw InvalidConstraintException::missingParameter($this->name(), 'disallowed');
        }

        $this->disallowed = $disallowed;
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
