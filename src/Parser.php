<?php

namespace Validation;

use Validation\Contracts\AssertionContract;
use Validation\Contracts\RegistryContract;
use Validation\Contracts\SchemaContract;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Exceptions\InvalidAssertionListException;

class Parser
{
    /**
     * Assertion Registry.
     *
     * @var RegistryContract
     */
    protected RegistryContract $registry;

    /**
     * Constructor.
     *
     * @param RegistryContract $registry
     */
    public function __construct(RegistryContract $registry)
    {
        $this->registry = $registry;
    }

    public function parse(array $definition): SchemaContract
    {
        $rules = [];

        foreach ($definition as $selector => $assertions) {
            $rules[] = new Rule(
                selector: $this->parseSelector($selector),
                assertions: $this->parseAssertions($assertions)
            );
        }

        return new Schema($rules);
    }

    private function parseSelector(string $selector): Selector
    {
        return Selector::make($selector);
    }

    private function parseAssertions(mixed $assertions): array
    {
        $assertions = is_string($assertions) ? explode('|', $assertions) : $assertions;

        if (! is_array($assertions)) {
            throw InvalidAssertionListException::invalidType($assertions);
        }

        return array_map(function($assertion) {
            return $this->parseAssertion($assertion);
        }, $assertions);
    }

    /**
     * Resolve rules to AssertionContract objects.
     *
     * @param mixed $assertion
     * @return AssertionContract
     */
    private function parseAssertion(mixed $assertion): AssertionContract
    {
        if (is_string($assertion)) {
            [$name, $params] = array_pad(explode(':', $assertion), 2, null);

            if ($name === null || trim($name) === '') {
                throw InvalidAssertionException::missingName($assertion);
            }

            $params = $params ? explode(',', $params) : [];

            $assertion = $this->registry->resolve($name, $params);
        }

        if ($assertion instanceof AssertionContract) {
            return $assertion;
        }

        throw InvalidAssertionException::invalidType($assertion);
    }
}
