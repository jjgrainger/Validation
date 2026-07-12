<?php

use PHPUnit\Framework\TestCase;
use Validation\Contracts\AssertionContract;
use Validation\Exceptions\InvalidAssertionException;
use Validation\Registry;
use Validation\Assertion;

class RegistryTest extends TestCase
{
    public function test_it_adds_assertion_with_class(): void
    {
        $assertion = new class extends Assertion {
            public function validate(mixed $value): bool { return true; }
        };

        $registry = new Registry;
        $registry->add('assertion', $assertion::class);

        $resolved = $registry->resolve('assertion', []);

        $this->assertInstanceOf($assertion::class, $resolved);
        $this->assertInstanceOf(AssertionContract::class, $resolved);
    }

    public function test_it_adds_assertion_with_factory(): void
    {
        $assertion = new class extends Assertion {
            public function validate(mixed $value): bool { return true; }
        };

        $class = $assertion::class;

        $registry = new Registry;
        $registry->bind('assertion', fn() => new $class);

        $resolved = $registry->resolve('assertion', []);

        $this->assertInstanceOf($assertion::class, $resolved);
    }

    public function test_it_passes_parameters_to_assertion_constructor(): void
    {
        $registry = new Registry;
        $registry->bind('assertion', fn($first, $second) => new class($first, $second) extends Assertion {
            public array $params;
            public function __construct($first, $second) {
                $this->params = [$first, $second];
            }
            public function validate(mixed $value): bool { return true; }
        });

        $params = ['first', 'second'];
        $resolved = $registry->resolve('assertion', $params);

        $this->assertSame($resolved->params, $params);
    }

    public function test_it_throws_exception_for_invalid_class(): void
    {
        $this->expectException(InvalidAssertionException::class);

        $registry = new Registry;
        $registry->add('assertion', stdClass::class);
    }
}
