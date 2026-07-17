<?php

namespace Validation\Assertions;

use Validation\Contracts\MessageContract;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Message;
use Validation\Assertion;

class NotIn extends Assertion
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
            throw InvalidAssertionException::missingParameter($this->name(), 'disallowed');
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

    public function name(): string
    {
        return 'not_in';
    }
}
