<?php

namespace Tests\Fixtures;

use Validation\Action;
use Validation\Assertion;
use Validation\Contracts\MessageContract;
use Validation\Message;

class ExtendedAssertion extends Assertion
{
    private array $includes;

    public function __construct(array $args)
    {
        $this->includes = $args;
    }

    public function validate(mixed $value): bool
    {
        if (in_array($value, $this->includes)) {
            return true;
        }

        return false;
    }

    public function name(): string
    {
        return 'extended';
    }

    public function message(): MessageContract
    {
        return new Message('Extended assertion failed for :attribute.');
    }

    public function onFailure(): Action
    {
        return Action::StopRule;
    }
}
